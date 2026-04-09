<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\PostulacionEstadoCambiado;
use App\Models\Instructor;
use App\Models\Proyecto;
use App\Models\Postulacion;
use App\Models\Aprendiz;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\User;

class InstructorController extends Controller
{
    public function dashboard()
    {
        $usrId = session('usr_id');
        
        $instructor = Instructor::where('usuario_id', $usrId)->first();

        if (!$instructor) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de instructor.');
        }

        // Proyectos asignados activos
        $proyectosAsignados = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso']) // Activos
            ->count();

        // Proyectos recientes con relación a empresa (eager loading)
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Contar aprendices aprobados en proyectos del instructor
        $totalAprendices = Postulacion::whereIn('proyecto_id',
            Proyecto::where('instructor_usuario_id', $usrId)
                ->whereIn('estado', ['aprobado', 'en_progreso'])
                ->pluck('id')
        )->where('estado', 'aceptada')
            ->distinct('aprendiz_id')
            ->count();

        // Evidencias pendientes por calificar
        $evidenciasPendientes = Evidencia::whereIn('proyecto_id',
            Proyecto::where('instructor_usuario_id', $usrId)
                ->pluck('id')
        )->where('estado', 'pendiente')
            ->count();

        // 🆕 Nuevas postulaciones (últimas 48 horas)
        $nuevasPostulaciones = Postulacion::whereIn('proyecto_id',
            Proyecto::where('instructor_usuario_id', $usrId)->pluck('id')
        )->where('fecha_postulacion', '>=', now()->subHours(48))->count();

        // 🆕 Próximo cierre de proyecto
        $proximosProyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->get();
            
        $proximoCierre = $proximosProyectos->filter(function($p) {
            $fechaFin = \Carbon\Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);
            return $fechaFin->isFuture(); // solo proyectos aún vigentes
        })->sortBy(function($p) {
            return \Carbon\Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);
        })->first();

        return view('instructor.dashboard', compact(
            'instructor', 'proyectosAsignados',
            'proyectos', 'totalAprendices', 'evidenciasPendientes',
            'nuevasPostulaciones', 'proximoCierre'
        ));
    }

    public function proyectos()
    {
        $usrId = session('usr_id');
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->with('empresa')
            ->orderByDesc('id')
            ->get();

        return view('instructor.proyectos', compact('proyectos'));
    }

    public function aprendices()
    {
        $usrId = session('usr_id');
        
        $aprendices = Aprendiz::whereHas('postulaciones', function($query) use ($usrId) {
            $query->where('estado', 'aceptada')
                ->whereHas('proyecto', function($subQuery) use ($usrId) {
                    $subQuery->where('instructor_usuario_id', $usrId)
                        ->whereIn('estado', ['aprobado', 'en_progreso']);
                });
        })->with(['usuario', 'postulaciones' => function($q) use ($usrId) {
            $q->where('estado', 'aceptada')
                ->whereHas('proyecto', function($sq) use ($usrId) {
                    $sq->where('instructor_usuario_id', $usrId);
                });
        }])->get();

        return view('instructor.aprendices', compact('aprendices'));
    }

    public function perfil()
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usuario_id', $usrId)->first();

        if (!$instructor) {
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

    public function actualizarPerfil(Request $request)
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usuario_id', $usrId)->firstOrFail();
        $usuario = User::findOrFail($usrId);

        $request->validate([
            'nombre'       => 'required|string|max:50',
            'apellido'     => 'required|string|max:50',
            'especialidad' => 'required|string|max:100',
            'password'     => 'nullable|string|min:6',
        ]);

        $instructor->update([
            'nombres'      => $request->nombre,
            'apellidos'    => $request->apellido,
            'especialidad'=> $request->especialidad,
        ]);

        if ($request->filled('password')) {
            $usuario->update([
                'contrasena' => Hash::make($request->password),
            ]);
        }

        session(['nombre' => $request->nombre, 'apellido' => $request->apellido]);
        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    // ── HISTORIAL DE PROYECTOS ──
    public function historial()
    {
        $usrId = session('usr_id');
        
        // El historial muestra proyectos asignados, sin importar si están activos o inactivos
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('fecha_publicacion')
            ->get()
            ->map(function($proyecto) {
                $totalAprendices = $proyecto->postulaciones->count();
                $aprendicesAprobados = $proyecto->postulaciones
                    ->where('estado', 'aceptada')
                    ->count();
                
                return (object)[
                    'id' => $proyecto->id,
                    'titulo' => $proyecto->titulo,
                    'categoria' => $proyecto->categoria,
                    'estado' => $proyecto->estado,
                    'fecha_publicacion' => $proyecto->fecha_publicacion,
                    'pro_fecha_finalizacion' => $proyecto->fecha_publicacion 
                        ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias) 
                        : null,
                    'nombre' => $proyecto->empresa->nombre ?? 'No designada',
                    'total_aprendices' => $totalAprendices,
                    'aprendices_aprobados' => $aprendicesAprobados,
                ];
            });

        return view('instructor.historial', compact('proyectos'));
    }

    // ── REPORTE DE SEGUIMIENTO POR PROYECTO ──
    public function reporteSeguimiento($proId)
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
        $aprendices = Aprendiz::whereHas('postulaciones', function($query) use ($proId) {
            $query->where('proyecto_id', $proId)
                ->where('estado', 'aceptada');
        })->with('usuario')->get();

        // Obtener evidencias
        $evidencias = Evidencia::where('evidencias.proyecto_id', $proId)
            ->with(['etapa', 'aprendiz'])
            ->join('etapas', 'evidencias.etapa_id', '=', 'etapas.id')
            ->orderBy('etapas.orden', 'asc')
            ->orderByDesc('evidencias.fecha_envio')
            ->select('evidencias.*')
            ->get();

        $entregas = $evidencias;

        return view('instructor.reporte-seguimiento', compact(
            'proyecto', 'etapas', 'aprendices', 'evidencias', 'entregas'
        ));
    }

    public function detalleProyecto($id)
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
    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        // View might send 'Aprobada', 'Rechazada', 'Pendiente'
        $estadoInput = strtolower($request->estado);
        if ($estadoInput === 'aprobada') $estadoInput = 'aceptada';

        //$request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);

        $usrId = session('usr_id');

        // Verificar que la postulación pertenece a un proyecto del instructor
        $postulacion = Postulacion::where('id', $id)
            ->whereHas('proyecto', function($query) use($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $postulacion->update(['estado' => $estadoInput]);

        // Enviar correo al aprendiz si se aprueba o rechaza
        if (in_array($estadoInput, ['aceptada', 'rechazada'])) {
            try {
                $aprendiz = $postulacion->aprendiz()->with('usuario')->first();
                $proyecto = $postulacion->proyecto;
                
                if ($aprendiz && $proyecto) {
                    Mail::to($aprendiz->usuario->correo)
                        ->send(new PostulacionEstadoCambiado(
                            $aprendiz->nombres,
                            $proyecto->titulo,
                            ucfirst($estadoInput)
                        ));
                }
            } catch (\Exception $e) {
                Log::error('Error al enviar correo de estado de postulación: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Estado de postulación actualizado correctamente.');
    }

    // ✅ MÉTODO PARA CREAR ETAPA
    public function crearEtapa(Request $request, int $proId)
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        Etapa::create([
            'proyecto_id'     => $proId,
            'orden'           => $request->orden,
            'nombre'          => $request->nombre,
            'descripcion'     => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa creada correctamente.');
    }

    // ✅ MÉTODO PARA EDITAR ETAPA
    public function editarEtapa(Request $request, int $etaId)
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('id', $etaId)
            ->whereHas('proyecto', function($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        $etapa->update([
            'orden'           => $request->orden,
            'nombre'          => $request->nombre,
            'descripcion'     => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa actualizada correctamente.');
    }

    // ✅ MÉTODO PARA ELIMINAR ETAPA
    public function eliminarEtapa(int $etaId)
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('id', $etaId)
            ->whereHas('proyecto', function($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $etapa->delete();

        return back()->with('success', 'Etapa eliminada correctamente.');
    }

    // ✅ MÉTODO PARA SUBIR IMAGEN AL PROYECTO
    public function subirImagenProyecto(Request $request, int $proId)
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
            $path = $request->file('imagen')->store('proyectos', 'public');
            $imagenUrl = $path; // storage path is relative

            $proyecto->update(['imagen_url' => $imagenUrl]);

            return back()->with('success', 'Imagen del proyecto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo guardar la imagen.');
    }

    // ✅ MÉTODO PARA VER EVIDENCIAS DE UN PROYECTO
    public function verEvidencias(int $proId)
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
    public function calificarEvidencia(Request $request, int $evidId)
    {
        $estadoInput = strtolower($request->estado);
        if ($estadoInput === 'aprobada') $estadoInput = 'aceptada';
        
        $usrId = session('usr_id');

        // Verificar que la evidencia pertenece a un proyecto del instructor
        $evidencia = Evidencia::where('id', $evidId)
            ->whereHas('proyecto', function($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $request->validate([
            'comentario'  => 'nullable|string|max:1000',
        ]);

        $evidencia->update([
            'estado'                 => $estadoInput,
            'comentario_instructor'  => $request->comentario,
        ]);

        try {
            $evidencia->load(['aprendiz.usuario', 'proyecto']);
            $aprendizUsr = $evidencia->aprendiz->usuario ?? null;
            if ($aprendizUsr) {
                $statusColor = $estadoInput === 'aceptada' ? 'fa-check-circle' : ($estadoInput === 'rechazada' ? 'fa-times-circle' : 'fa-info-circle');
                $aprendizUsr->notify(new \App\Notifications\AppNotification(
                    'Evidencia ' . ucfirst($estadoInput),
                    'El instructor ha calificado tu evidencia en el proyecto "' . \Illuminate\Support\Str::limit($evidencia->proyecto->titulo ?? '', 30) . '".',
                    $statusColor
                ));
            }
        } catch (\Exception $e) { \Illuminate\Support\Facades\Log::error($e->getMessage()); }

        return back()->with('success', 'Evidencia calificada correctamente.');
    }
}
