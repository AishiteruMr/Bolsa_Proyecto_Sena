<?php

namespace App\Http\Controllers;

use App\Events\PostulacionEvent;
use App\Events\ProyectoEvent;
use App\Http\Requests\ActualizarPerfilRequest;
use App\Http\Requests\GestionarPostulacionRequest;
use App\Http\Requests\GestionarProyectoRequest;
use App\Mail\PostulacionEstadoCambiado;
use App\Models\Aprendiz;
use App\Models\AuditLog;
use App\Models\Empresa;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Services\PerfilService;
use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    public function __construct(private PerfilService $perfilService) {}

    public function dashboard(): View|RedirectResponse
    {
        $nit = session('nit');
        $empresa = Empresa::where('nit', $nit)->first();

        if (! $empresa) {
            return redirect()->route('login')->with('error', 'Perfil de empresa no encontrado.');
        }

        // Obtener proyectos de la empresa (una sola consulta)
        $empresaProyectos = $empresa->proyectos();
        $proyectoIds = $empresaProyectos->pluck('id');

        // Optimizado: usar una sola colección para todos los conteos
        $todosProyectos = $empresaProyectos->get();
        $totalProyectos = $todosProyectos->count();
        $proyectosActivos = $todosProyectos->whereIn('estado', ['aprobado', 'en_progreso'])->count();

        // Proyectos recientes con eager loading y conteo de postulaciones
        $proyectosRecientes = $empresa->proyectos()
            ->with(['instructor', 'postulaciones.aprendiz'])
            ->withCount('postulaciones')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Optimizado: una sola consulta para postulaciones
        $postulacionCounts = Postulacion::whereIn('proyecto_id', $proyectoIds)
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN estado = "pendiente" THEN 1 ELSE 0 END) as pendientes')
            ->first();

        $totalPostulaciones = $postulacionCounts->total ?? 0;
        $postulacionesPendientes = $postulacionCounts->pendientes ?? 0;

        return view('empresa.dashboard', compact(
            'totalProyectos', 'proyectosActivos', 'totalPostulaciones',
            'postulacionesPendientes', 'proyectosRecientes'
        ));
    }

    public function proyectos(Request $request): View|RedirectResponse
    {
        $nit = session('nit');
        $empresa = Empresa::where('nit', $nit)->first();

        if (! $empresa) {
            return redirect()->route('login')->with('error', 'Perfil de empresa no encontrado.');
        }

        $proyectos = $empresa->proyectos()
            ->with('instructor')
            ->withCount(['postulaciones', 'etapas', 'postulaciones as postulaciones_pendientes' => fn($q) => $q->where('estado', 'pendiente')])
            ->orderByDesc('id')
            ->paginate($this->getPerPage($request, 10, 5, 30));

        return view('empresa.proyectos', compact('proyectos'));
    }

    public function crearProyecto(): View
    {
        $empresa = Empresa::where('nit', session('nit'))->first();
        return view('empresa.crear-proyecto', compact('empresa'));
    }

    public function guardarProyecto(GestionarProyectoRequest $request): RedirectResponse
    {
        $nit = session('nit');
        $empresa = Empresa::where('nit', $nit)->first();
        if (!$empresa || $empresa->activo != 1) {
            return back()->with('error', 'Tu empresa debe estar activa para crear proyectos.')->withInput();
        }

        $calidad = (new Proyecto([
            'empresa_nit' => $nit,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'requisitos_especificos' => $request->requisitos,
            'habilidades_requeridas' => $request->habilidades,
            'duracion_estimada_dias' => 183,
            'oferta' => $request->oferta,
            'oferta_otro' => $request->oferta === 'otro' ? $request->oferta_otro : null,
        ]))->calidadProyecto();

        $fallos = array_filter($calidad['detalles'], fn($d) => !$d['ok'] && !($d['opcional'] ?? false));
        if (count($fallos) > 0) {
            $mensajes = array_column($fallos, 'descripcion');
            return back()->with('error', 'El proyecto no cumple los requisitos mínimos de calidad.')->withInput();
        }

        $imagenUrl = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $maxSizeKb = 2048;
            $maxSizeBytes = $maxSizeKb * 1024;

            if ($file->getSize() > $maxSizeBytes) {
                return back()->with('error', "La imagen excede el tamaño máximo permitido ({$maxSizeKb}KB).")->withInput();
            }

            $mime = $file->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de imagen no permitido.')->withInput();
            }

            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'proyecto_'.$nit.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('proyectos', $safeFilename, 'public');
            $imagenUrl = $path;
        }

        if ($request->hasFile('metodologia')) {
            if ($empresa->metodologia_url) {
                Storage::disk('public')->delete($empresa->metodologia_url);
            }
            $file = $request->file('metodologia');
            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'metodologia_'.$nit.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('metodologias', $safeFilename, 'public');
            $empresa->metodologia_url = $path;
            $empresa->save();
        } elseif ($request->boolean('eliminar_metodologia') && $empresa->metodologia_url) {
            Storage::disk('public')->delete($empresa->metodologia_url);
            $empresa->metodologia_url = null;
            $empresa->save();
        }

        // Calcular fecha de publicación automática y duración (183 días = 6 meses)
        $fechaPublicacion = Carbon::now();
        $duracion = 183;
        $fechaFinalizacion = $fechaPublicacion->copy()->addDays($duracion);

        $proyecto = Proyecto::create([
            'empresa_nit' => $nit,
            'titulo' => $request->titulo,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'requisitos_especificos' => $request->requisitos,
            'habilidades_requeridas' => $request->habilidades,
            'fecha_publicacion' => $fechaPublicacion->format('Y-m-d'),
            'duracion_estimada_dias' => $duracion,
            'estado' => 'pendiente',
            'imagen_url' => $imagenUrl,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'oferta' => $request->oferta,
            'oferta_otro' => $request->oferta === 'otro' ? $request->oferta_otro : null,
        ]);

        AuditLog::registrar(session('usr_id'), 'publicar', 'proyectos', 'proyectos', $proyecto->id, null, ['nombre_objetivo' => $proyecto->titulo, 'empresa' => $empresa->nombre], "La empresa {$empresa->nombre} ha publicado un nuevo proyecto: {$proyecto->titulo}. Está pendiente de revisión administrativa.");

        event(new ProyectoEvent('creado', [
            'message' => "Nuevo proyecto creado: {$proyecto->titulo}",
            'proyecto' => $proyecto->titulo,
            'empresa' => $empresa->nombre,
            'url' => route('admin.proyectos.revisar', $proyecto->id),
        ]));

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto enviado para revisión.');
    }

    public function verDetalle(Request $request, int $id): View
    {
        $nit = session('nit');
        $proyecto = Proyecto::with(['instructor', 'empresa', 'etapas' => fn($q) => $q->orderBy('orden')])
            ->withCount([
                'postulaciones',
                'etapas',
                'postulaciones as postulaciones_pendientes' => fn($q) => $q->where('estado', 'pendiente'),
                'postulaciones as postulaciones_aceptadas' => fn($q) => $q->where('estado', 'aceptada'),
            ])
            ->where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        $postulantes = $proyecto->postulaciones()
            ->with(['aprendiz.usuario'])
            ->orderByDesc('fecha_postulacion')
            ->limit(5)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'id' => $p->id,
                    'estado' => $p->estado,
                    'fecha' => $p->fecha_postulacion,
                    'nombre' => $p->aprendiz->nombres ?? '',
                    'apellido' => $p->aprendiz->apellidos ?? '',
                    'programa' => $p->aprendiz->programa_formacion ?? '',
                    'correo' => optional($p->aprendiz->usuario)->correo ?? '',
                ];
            });

        $etapas = $proyecto->etapas;

        $evidenciasAprobadas = Evidencia::with(['aprendiz.usuario', 'etapa'])
            ->where('proyecto_id', $id)
            ->aprobadas()
            ->orderBy('etapa_id')
            ->orderByDesc('fecha_envio')
            ->get()
            ->groupBy('etapa_id');

        return view('empresa.detalle', compact('proyecto', 'postulantes', 'etapas', 'evidenciasAprobadas'));
    }

    public function editarProyecto(int $id): View
    {
        $nit = session('nit');
        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        $empresa = Empresa::where('nit', $nit)->first();

        return view('empresa.editar-proyecto', compact('proyecto', 'empresa'));
    }

    public function actualizarProyecto(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'categoria' => ['required', 'string', Rule::in(array_keys(config('programas')))],
            'descripcion' => 'required|string|min:80|max:5000',
            'requisitos' => 'required|string|max:400',
            'habilidades' => 'required|string|max:200',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'metodologia' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'oferta' => 'required|string|in:pasantias,contrato_aprendizaje,auxilio_transporte,otro',
            'oferta_otro' => 'required_if:oferta,otro|nullable|string|max:100',
        ], [
            'oferta.required' => 'El tipo de oferta es obligatorio.',
            'oferta.in' => 'El tipo de oferta seleccionado no es válido.',
            'oferta_otro.required_if' => 'Debe especificar el tipo de oferta alternativa en el campo "¿Cuál?".',
            'oferta_otro.max' => 'La descripción de la oferta alternativa no puede exceder 100 caracteres.',
        ]);

        $nit = session('nit');
        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        // Capturar datos anteriores para auditoría
        $datosAnteriores = $proyecto->only(['titulo', 'categoria', 'descripcion', 'requisitos_especificos', 'habilidades_requeridas', 'latitud', 'longitud']);

        // Mantener las fechas y oferta originales del proyecto
        $datos = [
            'titulo' => $request->titulo,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'requisitos_especificos' => $request->requisitos,
            'habilidades_requeridas' => $request->habilidades,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ];

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $maxSizeKb = 2048;
            $maxSizeBytes = $maxSizeKb * 1024;

            if ($file->getSize() > $maxSizeBytes) {
                return back()->with('error', "La imagen excede el tamaño máximo permitido ({$maxSizeKb}KB).")->withInput();
            }

            $mime = $file->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de imagen no permitido.')->withInput();
            }

            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'proyecto_'.$nit.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('proyectos', $safeFilename, 'public');
            $datos['imagen_url'] = $path;
        }

        if ($request->hasFile('metodologia')) {
            $empresa = Empresa::where('nit', $nit)->first();
            if ($empresa && $empresa->metodologia_url) {
                Storage::disk('public')->delete($empresa->metodologia_url);
            }
            $file = $request->file('metodologia');
            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'metodologia_'.$nit.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('metodologias', $safeFilename, 'public');
            if ($empresa) {
                $empresa->metodologia_url = $path;
                $empresa->save();
            }
        } elseif ($request->boolean('eliminar_metodologia')) {
            $empresa = Empresa::where('nit', $nit)->first();
            if ($empresa && $empresa->metodologia_url) {
                Storage::disk('public')->delete($empresa->metodologia_url);
                $empresa->metodologia_url = null;
                $empresa->save();
            }
        }

        $proyecto->update($datos);

        $empresa = Empresa::where('nit', $nit)->first();
        AuditLog::registrarCambio(
            session('usr_id'),
            'editar',
            'proyectos',
            'proyectos',
            $proyecto->id,
            array_merge($datosAnteriores, ['nombre_objetivo' => $proyecto->titulo, 'empresa' => $empresa?->nombre]),
            array_merge($datos, ['nombre_objetivo' => $proyecto->titulo, 'empresa' => $empresa?->nombre]),
            "La empresa {$empresa?->nombre} ha actualizado la información del proyecto «{$proyecto->titulo}»."
        );

        event(new ProyectoEvent('editado', [
            'message' => "Proyecto actualizado: {$proyecto->titulo}",
            'proyecto' => $proyecto->titulo,
            'empresa' => $empresa?->nombre ?? 'Empresa',
            'url' => route('proyectos.show', $proyecto->id),
        ]));

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto actualizado.');
    }

    public function eliminarProyecto(int $id): RedirectResponse
    {
        $nit = session('nit');

        try {
            // Verificar que el proyecto pertenece a la empresa
            $proyecto = Proyecto::where('id', $id)
                ->where('empresa_nit', $nit)
                ->firstOrFail();

            // Solo cerrar el proyecto (no eliminar)
            $proyecto->update(['estado' => 'cerrado']);

            return redirect()->route('empresa.proyectos')->with('success', 'Proyecto cerrado.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('empresa.proyectos')->with('error', 'Proyecto no encontrado.');
        } catch (\Exception $e) {
            return redirect()->route('empresa.proyectos')->with('error', 'Error al cerrar el proyecto.');
        }
    }

    public function verPostulantes(Request $request, int $id): View
    {
        $nit = session('nit');

        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        $query = $proyecto->postulaciones()->with(['aprendiz.usuario']);

        if ($request->filled('estado') && in_array($request->estado, ['pendiente', 'aceptada', 'rechazada', 'en_progreso'])) {
            $query->where('estado', $request->estado);
        }

        $baseQuery = $proyecto->postulaciones();
        $counts = [
            'total'      => (clone $baseQuery)->count(),
            'pendiente'  => (clone $baseQuery)->where('estado', 'pendiente')->count(),
            'aceptada'   => (clone $baseQuery)->where('estado', 'aceptada')->count(),
            'rechazada'  => (clone $baseQuery)->where('estado', 'rechazada')->count(),
        ];

        $postulantes = $query->orderByDesc('fecha_postulacion')
            ->paginate($this->getPerPage($request, 10, 5, 30))
            ->through(function ($postulacion) {
                return (object) [
                    'pos_id'       => $postulacion->id,
                    'pos_estado'   => $postulacion->estado,
                    'pos_fecha'    => $postulacion->fecha_postulacion,
                    'apr_id'       => $postulacion->aprendiz->id,
                    'apr_nombre'   => $postulacion->aprendiz->nombres,
                    'apr_apellido' => $postulacion->aprendiz->apellidos,
                    'apr_programa' => $postulacion->aprendiz->programa_formacion,
                    'apr_activo'   => $postulacion->aprendiz->activo,
                    'usr_correo'   => $postulacion->aprendiz->usuario->correo,
                ];
            });

        $currentFilter = $request->estado;

        return view('empresa.postulantes', compact('proyecto', 'postulantes', 'counts', 'currentFilter'));
    }

    public function verParticipantes(Request $request, int $id): View
    {
        $nit = session('nit');

        $proyecto = Proyecto::with(['instructor.usuario', 'empresa'])
            ->where('id', $id)
            ->where('empresa_nit', $nit)
            ->firstOrFail();

        // Aprendices aprobados
        $aprendices = Postulacion::where('proyecto_id', $id)
            ->where('estado', 'aceptada')
            ->with(['aprendiz.usuario'])
            ->paginate($this->getPerPage($request, 10, 5, 30))
            ->through(function ($post) {
                return (object) [
                    'apr_id' => $post->aprendiz->id,
                    'apr_nombre' => $post->aprendiz->nombres,
                    'apr_apellido' => $post->aprendiz->apellidos,
                    'apr_programa' => $post->aprendiz->programa_formacion,
                    'usr_correo' => optional($post->aprendiz->usuario)->correo,
                ];
            });

        return view('empresa.participantes', compact('proyecto', 'aprendices'));
    }

    /**
     * Ver reporte de proyecto para exportar PDF
     */
    public function verReporte(int $id): View
    {
        $nit = session('nit');

        $proyecto = Proyecto::where('id', $id)
            ->where('empresa_nit', $nit)
            ->with(['instructor.usuario', 'empresa'])
            ->firstOrFail();

        $etapas = Etapa::where('proyecto_id', $id)
            ->orderBy('orden')
            ->get();

        $aprendices = Aprendiz::whereHas('postulaciones', function ($query) use ($id) {
            $query->where('proyecto_id', $id)
                ->where('estado', 'aceptada');
        })->with('usuario')->get();

        $evidencias = Evidencia::where('evidencias.proyecto_id', $id)
            ->join('etapas', 'evidencias.etapa_id', '=', 'etapas.id')
            ->join('aprendices', 'evidencias.aprendiz_id', '=', 'aprendices.id')
            ->orderBy('etapas.orden', 'asc')
            ->orderByDesc('evidencias.fecha_envio')
            ->select(
                'evidencias.*',
                'aprendices.nombres as aprendiz_nombres',
                'aprendices.apellidos as aprendiz_apellidos'
            )
            ->get();

        $entregas = $evidencias;

        return view('empresa.reporte-proyecto', compact(
            'proyecto', 'etapas', 'aprendices', 'evidencias', 'entregas'
        ));
    }

    public function cambiarEstadoPostulacion(GestionarPostulacionRequest $request, int $id): RedirectResponse|JsonResponse
    {
        $nit = session('nit');

        $postulacion = Postulacion::with('proyecto', 'aprendiz.usuario')
            ->where('id', $id)
            ->whereHas('proyecto', function ($query) use ($nit) {
                $query->where('empresa_nit', $nit);
            })
            ->firstOrFail();

        $estadoInput = strtolower($request->estado);

        $postulacion->update(['estado' => $estadoInput]);

        // Invalidar otras postulaciones pendientes cuando es aceptado
        $totalInvalidadas = 0;
        if ($estadoInput === 'aceptada') {
            $otrasPendientes = Postulacion::where('aprendiz_id', $postulacion->aprendiz_id)
                ->where('id', '!=', $postulacion->id)
                ->whereIn('estado', ['pendiente', 'en_revision'])
                ->get();

            foreach ($otrasPendientes as $otra) {
                $otra->update(['estado' => 'rechazada']);
                AuditLog::registrar(
                    session('usr_id'),
                    'invalidar_postulacion',
                    'postulaciones',
                    'postulaciones',
                    $otra->id,
                    null,
                    ['proyecto_id' => $otra->proyecto_id, 'motivo' => 'Aceptado en otro proyecto'],
                    "Postulación #{$otra->id} invalidada automáticamente porque el aprendiz fue aceptado en otro proyecto."
                );
            }

            $totalInvalidadas = $otrasPendientes->count();
        }

        // Send email notification to aprendiz
        try {
            $aprendiz = $postulacion->aprendiz;
            $usuarioCorreo = optional($aprendiz?->usuario)->correo;
            if ($usuarioCorreo) {
                SendEmailJob::dispatch($usuarioCorreo, new PostulacionEstadoCambiado(
                    $aprendiz->nombres ?? 'Aprendiz',
                    $postulacion->proyecto,
                    ucfirst($estadoInput),
                    $totalInvalidadas
                ));
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email de estado postulación: '.$e->getMessage());
        }

        if ($aprendiz?->usuario) {
            event(new PostulacionEvent(
                $aprendiz->usuario,
                $estadoInput,
                [
                    'message' => "Postulación {$estadoInput}: {$postulacion->proyecto->titulo}",
                    'proyecto' => $postulacion->proyecto->titulo,
                    'usuario' => trim(($aprendiz->nombres ?? '').' '.($aprendiz->apellidos ?? '')),
                    'url' => route('empresa.proyectos.postulantes', $postulacion->proyecto_id),
                ]
            ));
        }

        if ($request->ajax() || $request->wantsJson()) {
            $statusConfig = match($estadoInput) {
                'pendiente' => ['bg' => '#f59e0b', 'icon' => 'fa-clock', 'label' => 'Por Revisar'],
                'aceptada' => ['bg' => '#10b981', 'icon' => 'fa-check', 'label' => 'Aprobado'],
                'rechazada' => ['bg' => '#ef4444', 'icon' => 'fa-times', 'label' => 'Rechazado'],
                'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner', 'label' => 'En Progreso'],
                default => ['bg' => '#64748b', 'icon' => 'fa-info-circle', 'label' => $estadoInput]
            };

            return response()->json([
                'success' => true,
                'message' => 'Estado de postulación actualizado.',
                'estado' => $estadoInput,
                'statusConfig' => $statusConfig,
                'postulacionId' => $postulacion->id,
                'totalInvalidadas' => $totalInvalidadas,
            ]);
        }

        return back()->with('success', 'Estado de postulación actualizado.');
    }

    public function perfil(): View
    {
        $empId = session('emp_id');
        $empresa = Empresa::findOrFail($empId);

        return view('empresa.perfil', compact('empresa'));
    }

    public function actualizarPerfil(Request $request): RedirectResponse
    {
        $empId = session('emp_id');

        $request->validate([
            'nombre_empresa' => 'required|string|max:150',
            'representante' => [
                'required',
                'string',
                'max:100',
                'min:10',
                function ($attribute, $value, $fail) {
                    $palabras = count(array_filter(explode(' ', trim($value))));
                    if ($palabras < 2) {
                        $fail('El nombre del representante debe incluir nombre y apellido (minimo 2 palabras).');
                    }
                },
            ],
            'password' => 'nullable|string|min:'.config('app_config.password.min_length', 8),
            'metodologia' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $datos = [
            'nombre_empresa' => $request->nombre_empresa,
            'representante' => $request->representante,
            'password' => $request->password,
        ];

        if ($request->hasFile('metodologia')) {
            $file = $request->file('metodologia');
            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'metodologia_'.session('nit').'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('metodologias', $safeFilename, 'public');
            $datos['metodologia_url'] = $path;
        }

        if ($request->boolean('eliminar_metodologia')) {
            $datos['eliminar_metodologia'] = true;
        }

        [$exito, $mensaje] = $this->perfilService->actualizarPerfilEmpresa($empId, $datos);

        if (!$exito) {
            return back()->with('error', $mensaje);
        }

        session(['nombre' => $request->nombre_empresa]);

        return back()->with('success', $mensaje);
    }
}
