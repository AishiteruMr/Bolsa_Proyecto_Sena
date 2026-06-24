<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPerfilRequest;
use App\Http\Requests\CalificarEvidenciaRequest;
use App\Http\Requests\GestionarEtapaRequest;
use App\Http\Requests\GestionarPostulacionRequest;
use App\Mail\NuevaEtapaCreada;
use App\Mail\PostulacionEstadoCambiado;
use App\Models\Aprendiz;
use App\Models\AuditLog;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Instructor;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Notifications\AppNotification;
use App\Services\PerfilService;
use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstructorController extends Controller
{
    public function __construct(private PerfilService $perfilService) {}

    public function dashboard(): View|RedirectResponse
    {
        $usrId = session('usr_id');

        $instructor = Instructor::where('usuario_id', $usrId)->first();

        if (! $instructor) {
            return redirect()->route('login')->with('error', 'Perfil de instructor no encontrado.');
        }

        $proyectoIds = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->pluck('id');

        $proyectosAsignados = $proyectoIds->count();

        $proyectos = Proyecto::whereIn('id', $proyectoIds)
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $totalAprendices = Postulacion::whereIn('proyecto_id', $proyectoIds)
            ->where('estado', 'aceptada')
            ->distinct('aprendiz_id')
            ->count('aprendiz_id');

        $evidenciasPendientes = Evidencia::whereIn('proyecto_id', $proyectoIds)
            ->where('estado', 'pendiente')
            ->count();

        $nuevasPostulaciones = Postulacion::whereIn('proyecto_id', $proyectoIds)
            ->where('fecha_postulacion', '>=', now()->subHours(48))
            ->count();

        $proximoCierre = Proyecto::whereIn('id', $proyectoIds)
            ->get()
            ->filter(function ($p) {
                $fechaFin = Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);
                return $fechaFin->isFuture();
            })
            ->sortBy(function ($p) {
                return Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);
            })
            ->first();

        // ── MÉTRICAS AVANZADAS DE SEGUIMIENTO ──
        $todosProyectos = Proyecto::where('instructor_usuario_id', $usrId);

        $proyectosCompletados = (clone $todosProyectos)->where('estado', 'completado')->count();

        $proyectosPorEstado = (clone $todosProyectos)
            ->selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $totalPostulaciones = Postulacion::whereIn('proyecto_id', $proyectoIds)->count();

        $postulacionesAceptadas = Postulacion::whereIn('proyecto_id', $proyectoIds)
            ->where('estado', 'aceptada')
            ->count();

        $totalEvidencias = Evidencia::whereIn('proyecto_id', $proyectoIds)->count();
        $evidenciasAprobadas = Evidencia::whereIn('proyecto_id', $proyectoIds)
            ->where('estado', 'aceptada')
            ->count();
        $tasaAprobacionGlobal = $totalEvidencias > 0 ? round(($evidenciasAprobadas / $totalEvidencias) * 100) : 0;

        $actividadReciente = Evidencia::whereIn('evidencias.proyecto_id', $proyectoIds)
            ->where('evidencias.fecha_envio', '>=', now()->subDays(7))
            ->join('aprendices', 'evidencias.aprendiz_id', '=', 'aprendices.id')
            ->join('proyectos', 'evidencias.proyecto_id', '=', 'proyectos.id')
            ->orderByDesc('evidencias.fecha_envio')
            ->limit(10)
            ->select(
                'evidencias.*',
                'aprendices.nombres as aprendiz_nombres',
                'aprendices.apellidos as aprendiz_apellidos',
                'proyectos.titulo as proyecto_titulo'
            )
            ->get();

        return view('instructor.dashboard', compact(
            'instructor', 'proyectosAsignados',
            'proyectos', 'totalAprendices', 'evidenciasPendientes',
            'nuevasPostulaciones', 'proximoCierre',
            'proyectosCompletados', 'proyectosPorEstado',
            'totalPostulaciones', 'postulacionesAceptadas',
            'tasaAprobacionGlobal', 'actividadReciente'
        ));
    }

    public function proyectos(Request $request): View
    {
        $usrId = session('usr_id');
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->with('empresa')
            ->orderByDesc('id')
            ->paginate($this->getPerPage($request, 9, 5, 30));

        return view('instructor.proyectos', compact('proyectos'));
    }

    public function aprendices(Request $request): View
    {
        $usrId = session('usr_id');

        $aprendices = Aprendiz::whereHas('postulaciones', function ($query) use ($usrId) {
            $query->where('estado', 'aceptada')
                ->whereHas('proyecto', function ($subQuery) use ($usrId) {
                    $subQuery->where('instructor_usuario_id', $usrId)
                        ->whereIn('estado', ['aprobado', 'en_progreso']);
                });
        })->with(['usuario', 'postulaciones' => function ($q) use ($usrId) {
            $q->where('estado', 'aceptada')
                ->whereHas('proyecto', function ($sq) use ($usrId) {
                    $sq->where('instructor_usuario_id', $usrId);
                });
        }])->paginate($this->getPerPage($request, 10, 5, 30));

        return view('instructor.aprendices', compact('aprendices'));
    }

    public function perfil(): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usuario_id', $usrId)->first();

        if (! $instructor) {
            return redirect()->route('login')->with('error', 'Perfil de instructor no encontrado.');
        }

        $usuario = User::findOrFail($usrId);

        // 🆕 Estadísticas reales para el perfil
        $proyectosCount = Proyecto::where('instructor_usuario_id', $usrId)->count();

        $aprendicesCount = Postulacion::whereIn('proyecto_id',
            Proyecto::where('instructor_usuario_id', $usrId)->pluck('id')
        )->where('estado', 'aceptada')
            ->distinct('aprendiz_id')
            ->count();

        $evidenciasPendientesCount = Evidencia::whereIn('proyecto_id',
            Proyecto::where('instructor_usuario_id', $usrId)->pluck('id')
        )->where('estado', 'pendiente')
            ->count();

        return view('instructor.perfil', compact(
            'instructor', 'usuario', 'proyectosCount',
            'aprendicesCount', 'evidenciasPendientesCount'
        ));
    }

    public function actualizarPerfil(Request $request): RedirectResponse
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usuario_id', $usrId)->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'especialidad' => 'required|string|max:100',
            'password' => 'nullable|string|min:'.config('app_config.password.min_length', 8),
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'especialidad' => $request->especialidad,
            'password' => $request->password,
        ];

        [$exito, $mensaje] = $this->perfilService->actualizarPerfilInstructor($instructor->id, $datos);

        if (!$exito) {
            return back()->with('error', $mensaje);
        }

        session(['nombre' => $request->nombre, 'apellido' => $request->apellido]);

        return back()->with('success', $mensaje);
    }

    // ── HISTORIAL DE PROYECTOS ──
    public function historial(Request $request): View
    {
        $usrId = session('usr_id');

        // El historial muestra proyectos asignados, sin importar si están activos o inactivos
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('fecha_publicacion')
            ->paginate($this->getPerPage($request, 10, 5, 30))
            ->through(function ($proyecto) {
                $totalAprendices = $proyecto->postulaciones->count();
                $aprendicesAprobados = $proyecto->postulaciones
                    ->where('estado', 'aceptada')
                    ->count();

                return (object) [
                    'id' => $proyecto->id,
                    'titulo' => $proyecto->titulo,
                    'categoria' => $proyecto->categoria,
                    'estado' => $proyecto->estado,
                    'fecha_publicacion' => $proyecto->fecha_publicacion,
                    'pro_fecha_finalizacion' => $proyecto->fecha_publicacion
                        ? Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias)
                        : null,
                    'nombre' => $proyecto->empresa->nombre ?? 'No designada',
                    'total_aprendices' => $totalAprendices,
                    'aprendices_aprobados' => $aprendicesAprobados,
                    'oferta' => $proyecto->oferta,
                    'oferta_otro' => $proyecto->oferta_otro,
                ];
            });

        return view('instructor.historial', compact('proyectos'));
    }

    // ── REPORTE DE SEGUIMIENTO POR PROYECTO ──
    public function reporteSeguimiento(int $proId): View
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->with(['empresa', 'instructor'])
            ->firstOrFail();

        $etapas = Etapa::where('proyecto_id', $proId)
            ->orderBy('orden')
            ->get();

        $aprendices = Aprendiz::whereHas('postulaciones', function ($query) use ($proId) {
            $query->where('proyecto_id', $proId)
                ->where('estado', 'aceptada');
        })->with('usuario')->get();

        $evidencias = Evidencia::where('evidencias.proyecto_id', $proId)
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

        return view('instructor.reporte-seguimiento', compact(
            'proyecto', 'etapas', 'aprendices', 'evidencias', 'entregas'
        ));
    }

    public function detalleProyecto(int $id): View
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('id', $id)
            ->where('instructor_usuario_id', $usrId)
            ->with('empresa')
            ->firstOrFail();

        // Obtener etapas del proyecto
        $etapas = Etapa::where('proyecto_id', $id)
            ->orderBy('orden')
            ->get();

        // Obtener postulaciones con aprendices
        $postulaciones = Postulacion::where('proyecto_id', $id)
            ->with(['aprendiz.usuario'])
            ->orderByDesc('fecha_postulacion')
            ->get();

        // Obtener integrantes aprobados
        $integrantes = Postulacion::where('proyecto_id', $id)
            ->where('estado', 'aceptada')
            ->with(['aprendiz.usuario'])
            ->get();

        // Obtener historial de cambios del proyecto
        $historialCambios = AuditLog::where('tabla_afectada', 'proyectos')
            ->where('registro_id', $id)
            ->orderByDesc('created_at')
            ->get();

        return view('instructor.detalle_proyecto', compact('proyecto', 'etapas', 'postulaciones', 'integrantes', 'historialCambios'));
    }

    // ✅ MÉTODO PARA CAMBIAR ESTADO DE POSTULACIÓN (SOLO EL INSTRUCTOR)
    public function cambiarEstadoPostulacion(GestionarPostulacionRequest $request, int $id): RedirectResponse
    {
        $usrId = session('usr_id');

        // ✅ SEGURIDAD: Verificar que la postulación pertenece a un proyecto del instructor
        $postulacion = Postulacion::where('id', $id)
            ->whereHas('proyecto', function ($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        // ✅ SEGURIDAD: El estado es validado en el validator, se puede usar directamente
        $estadoInput = strtolower($request->estado);

        $postulacion->update(['estado' => $estadoInput]);

        // Invalidar otras postulaciones pendientes cuando es aceptado
        if ($estadoInput === 'aceptada') {
            $otrasPendientes = Postulacion::where('aprendiz_id', $postulacion->aprendiz_id)
                ->where('id', '!=', $postulacion->id)
                ->whereIn('estado', ['pendiente', 'en_revision'])
                ->get();

            foreach ($otrasPendientes as $otra) {
                $otra->update(['estado' => 'rechazada']);
                AuditLog::registrar(
                    $usrId,
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

        // Enviar correo al aprendiz si se aprueba o rechaza
        if (in_array($estadoInput, ['aceptada', 'rechazada'])) {
            try {
                $aprendiz = $postulacion->aprendiz()->with('usuario')->first();
                $proyecto = $postulacion->proyecto;

                if ($aprendiz && $proyecto) {
                    $otrasPendientes = $totalInvalidadas ?? 0;

                    // Display: "Aprobada" for user, but save "aceptada" to DB
                    $displayEstado = $estadoInput === 'aceptada' ? 'Aprobada' : ucfirst($estadoInput);
                    SendEmailJob::dispatch($aprendiz->usuario->correo, new PostulacionEstadoCambiado(
                        $aprendiz->nombres,
                        $proyecto,
                        $displayEstado,
                        $otrasPendientes
                    ));
                }
            } catch (\Exception $e) {
                Log::error('Error al enviar correo de estado de postulación: '.$e->getMessage());
            }
        }

        return back()->with('success', 'Estado de postulación actualizado.');
    }

    // ✅ MÉTODO PARA CREAR ETAPA
    public function crearEtapa(GestionarEtapaRequest $request, int $proId): RedirectResponse
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->firstOrFail();

        $etapa = Etapa::create([
            'proyecto_id' => $proId,
            'orden' => $request->orden,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        // Notificar a los aprendices aceptados (async via queue)
        $postulaciones = Postulacion::where('proyecto_id', $proId)
            ->where('estado', 'aceptada')
            ->with('aprendiz.usuario')
            ->get();

        foreach ($postulaciones as $postulacion) {
            if ($postulacion->aprendiz?->usuario) {
                SendEmailJob::dispatch(
                    $postulacion->aprendiz->usuario->correo,
                    new NuevaEtapaCreada(
                        $postulacion->aprendiz->nombres,
                        $proyecto->titulo,
                        $etapa->nombre,
                        $etapa->descripcion,
                    )
                );
            }
        }

        return back()->with('success', 'Etapa creada.');
    }

    // ✅ MÉTODO PARA EDITAR ETAPA
    public function editarEtapa(GestionarEtapaRequest $request, int $etaId): RedirectResponse
    {
        $usrId = session('usr_id');

        $etapa = Etapa::where('id', $etaId)
            ->whereHas('proyecto', function ($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $etapa->update([
            'orden' => $request->orden,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa actualizada.');
    }

    // ✅ MÉTODO PARA ELIMINAR ETAPA
    public function eliminarEtapa(int $etaId): RedirectResponse
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('id', $etaId)
            ->whereHas('proyecto', function ($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $etapa->delete();

        return back()->with('success', 'Etapa eliminada.');
    }

    // ✅ MÉTODO PARA SUBIR DOCUMENTO/GUÍA A ETAPA
    public function subirDocumentoEtapa(Request $request, int $etaId): RedirectResponse
    {
        $usrId = session('usr_id');

        $etapa = Etapa::where('id', $etaId)
            ->whereHas('proyecto', function ($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $request->validate([
            'documento' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'documentos_requeridos' => 'nullable|json',
        ]);

        if ($request->hasFile('documento')) {
            $file = $request->file('documento');
            $mime = $file->getMimeType();
            $allowedMimes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            ];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de documento no permitido.');
            }

            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'etapa_'.$etaId.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('etapas', $safeFilename, 'public');

            $etapa->update(['url_documento' => $path]);
        }

        if ($request->has('documentos_requeridos')) {
            $documentos = json_decode($request->input('documentos_requeridos'), true);
            if (is_array($documentos)) {
                $etapa->update(['documentos_requeridos' => $documentos]);
            }
        }

        return back()->with('success', 'Documento subido.');
    }

    // ✅ MÉTODO PARA SUBIR ESTRUCTURA DEL PROYECTO (MAPA DE RUTA)
    public function subirEstructura(Request $request, int $proId): RedirectResponse
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->firstOrFail();

        $request->validate([
            'estructura' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:20480',
        ]);

        if ($request->hasFile('estructura')) {
            $file = $request->file('estructura');
            $mime = $file->getMimeType();
            $allowedMimes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/zip',
                'application/x-rar-compressed',
            ];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de archivo no permitido.');
            }

            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'estructura_'.$proId.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('estructuras', $safeFilename, 'public');

            $proyecto->update(['url_estructura' => $path]);
        }

        return back()->with('success', 'Estructura subida.');
    }

    // ✅ MÉTODO PARA ELIMINAR ESTRUCTURA DEL PROYECTO
    public function eliminarEstructura(int $proId): RedirectResponse
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->firstOrFail();

        if ($proyecto->url_estructura) {
            \Storage::disk('public')->delete($proyecto->url_estructura);
            $proyecto->update(['url_estructura' => null]);
        }

        return back()->with('success', 'Estructura eliminada.');
    }

    // ✅ MÉTODO PARA SUBIR IMAGEN AL PROYECTO
    public function subirImagenProyecto(Request $request, int $proId): RedirectResponse
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->firstOrFail();

        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            // Validar MIME real
            $mime = $file->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de imagen no permitido.');
            }

            // Nombre seguro
            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'proyecto_'.$proId.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('proyectos', $safeFilename, 'public');
            $imagenUrl = $path;

            $proyecto->update(['imagen_url' => $imagenUrl]);

            return back()->with('success', 'Imagen actualizada.');
        }

        return back()->with('error', 'No se pudo guardar la imagen.');
    }

    // ✅ MÉTODO PARA VER EVIDENCIAS DE UN PROYECTO
    public function verEvidencias(int $proId): View
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->with('empresa')
            ->firstOrFail();

        // Obtener evidencias del proyecto con detalles del aprendiz y etapa
        $evidencias = Evidencia::where('evidencias.proyecto_id', $proId)
            ->with(['aprendiz.usuario', 'etapa'])
            ->join('etapas', 'evidencias.etapa_id', '=', 'etapas.id')
            ->orderBy('etapas.orden')
            ->orderByDesc('evidencias.fecha_envio')
            ->select('evidencias.*')
            ->paginate(10);

        return view('instructor.evidencias', compact('proyecto', 'evidencias'));
    }

    // ✅ MÉTODO PARA CALIFICAR EVIDENCIA
    public function calificarEvidencia(CalificarEvidenciaRequest $request, int $evidId): RedirectResponse
    {
        $usrId = session('usr_id');

        $evidencia = Evidencia::where('id', $evidId)
            ->whereHas('proyecto', function ($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $estadoInput = strtolower($request->estado);

        $evidencia->update([
            'estado' => $estadoInput,
            'comentario_instructor' => $request->comentario,
        ]);

        try {
            $evidencia->load(['aprendiz.usuario', 'proyecto']);
            $aprendizUsr = $evidencia->aprendiz->usuario ?? null;
            if ($aprendizUsr) {
                // Mapear estado a iconos/colores
                $stateColor = match ($estadoInput) {
                    'aceptada' => 'fa-check-circle',
                    'rechazada' => 'fa-times-circle',
                    'pendiente' => 'fa-info-circle',
                    default => 'fa-info-circle',
                };
                $aprendizUsr->notify(new AppNotification(
                    'Evidencia '.ucfirst($estadoInput),
                    'El instructor ha calificado tu evidencia en el proyecto "'.Str::limit($evidencia->proyecto->titulo ?? '', 30).'".',
                    $stateColor
                ));
            }
        } catch (\Exception $e) {
            Log::error('Error al notificar calificación de evidencia: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }

        return back()->with('success', 'Evidencia calificada.');
    }

    public function iniciarProyecto($id): RedirectResponse
    {
        $proyecto = Proyecto::findOrFail($id);

        if ($proyecto->instructor_usuario_id !== session('usr_id')) {
            abort(403, 'No tienes permiso para modificar este proyecto.');
        }

        if ($proyecto->estado !== 'aprobado') {
            return back()->with('error', 'Solo los proyectos aprobados pueden iniciarse.');
        }

        $proyecto->update(['estado' => 'en_progreso']);

        AuditLog::registrarCambio(
            session('usr_id'),
            'iniciar',
            'proyectos',
            'proyectos',
            $id,
            ['estado' => 'aprobado'],
            ['estado' => 'en_progreso']
        );

        return redirect()->route('instructor.proyecto.detalle', $id)
            ->with('success', 'Proyecto iniciado exitosamente. Ahora los aprendices pueden ver las etapas y entregar evidencias.');
    }

    public function marcarCompletado($id): RedirectResponse
    {
        $proyecto = Proyecto::findOrFail($id);

        if ($proyecto->instructor_usuario_id !== session('usr_id')) {
            abort(403, 'No tienes permiso para modificar este proyecto.');
        }

        if ($proyecto->estado !== 'en_progreso') {
            return back()->with('error', 'Solo los proyectos en progreso pueden marcarse como completados.');
        }

        $proyecto->update(['estado' => 'completado']);

        $postulaciones = Postulacion::where('proyecto_id', $id)
            ->where('estado', 'aceptada')
            ->with('aprendiz.user')
            ->get();
        foreach ($postulaciones as $postulacion) {
            if ($postulacion->aprendiz && $postulacion->aprendiz->user) {
                $postulacion->aprendiz->user->notify(new AppNotification(
                    'Proyecto Completado',
                    'El proyecto "'.Str::limit($proyecto->titulo, 30).'" ha sido marcado como completado.',
                    'fa-check-circle'
                ));
            }
        }

        return redirect()->route('instructor.proyectos')
            ->with('success', 'Proyecto marcado como completado exitosamente.');
    }
}
