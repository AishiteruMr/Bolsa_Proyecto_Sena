<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPerfilRequest;
use App\Http\Requests\CalificarEvidenciaRequest;
use App\Http\Requests\GestionarEtapaRequest;
use App\Http\Requests\GestionarPostulacionRequest;
use App\Mail\PostulacionEstadoCambiado;
use App\Models\Aprendiz;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Instructor;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Notifications\AppNotification;
use App\Services\PerfilService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de instructor.');
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

        return view('instructor.dashboard', compact(
            'instructor', 'proyectosAsignados',
            'proyectos', 'totalAprendices', 'evidenciasPendientes',
            'nuevasPostulaciones', 'proximoCierre'
        ));
    }

    public function proyectos(): View
    {
        $usrId = session('usr_id');
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->with('empresa')
            ->orderByDesc('id')
            ->get();

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
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de instructor.');
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
    public function historial(): View
    {
        $usrId = session('usr_id');

        // El historial muestra proyectos asignados, sin importar si están activos o inactivos
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('fecha_publicacion')
            ->get()
            ->map(function ($proyecto) {
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
                ];
            });

        return view('instructor.historial', compact('proyectos'));
    }

    // ── REPORTE DE SEGUIMIENTO POR PROYECTO ──
    public function reporteSeguimiento(int $proId): View
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->with('empresa')
            ->firstOrFail();

        // Obtener etapas del proyecto
        $etapas = Etapa::where('proyecto_id', $proId)
            ->orderBy('orden')
            ->get();

        // Obtener aprendices aprobados
        $aprendices = Aprendiz::whereHas('postulaciones', function ($query) use ($proId) {
            $query->where('proyecto_id', $proId)
                ->where('estado', 'aceptada');
        })->with('usuario')->get();

        // Obtener evidencias con datos del aprendiz
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

        return view('instructor.detalle_proyecto', compact('proyecto', 'etapas', 'postulaciones', 'integrantes'));
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

        // Enviar correo al aprendiz si se aprueba o rechaza
        if (in_array($estadoInput, ['aceptada', 'rechazada'])) {
            try {
                $aprendiz = $postulacion->aprendiz()->with('usuario')->first();
                $proyecto = $postulacion->proyecto;

                if ($aprendiz && $proyecto) {
                    // Display: "Aprobada" for user, but save "aceptada" to DB
                    $displayEstado = $estadoInput === 'aceptada' ? 'Aprobada' : ucfirst($estadoInput);
                    Mail::to($aprendiz->usuario->correo)
                        ->send(new PostulacionEstadoCambiado(
                            $aprendiz->nombres,
                            $proyecto,
                            $displayEstado
                        ));
                }
            } catch (\Exception $e) {
                Log::error('Error al enviar correo de estado de postulación: '.$e->getMessage());
            }
        }

        return back()->with('success', 'Estado de postulación actualizado correctamente.');
    }

    // ✅ MÉTODO PARA CREAR ETAPA
    public function crearEtapa(GestionarEtapaRequest $request, int $proId): RedirectResponse
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->firstOrFail();

        Etapa::create([
            'proyecto_id' => $proId,
            'orden' => $request->orden,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa creada correctamente.');
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

        return back()->with('success', 'Etapa actualizada correctamente.');
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

        return back()->with('success', 'Etapa eliminada correctamente.');
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

        return back()->with('success', 'Documento subido correctamente.');
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

            return back()->with('success', 'Imagen del proyecto actualizada correctamente.');
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
            ->get();

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

        return back()->with('success', 'Evidencia calificada correctamente.');
    }
}
