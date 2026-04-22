<?php

namespace App\Http\Controllers;

use App\Mail\PostulacionEstadoCambiado;
use App\Models\Aprendiz;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Instructor;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Notifications\AppNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InstructorController extends Controller
{
    public function dashboard()
    {
        $usrId = session('usr_id');

        $instructor = Instructor::where('usuario_id', $usrId)->first();

        if (! $instructor) {
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

        $proximoCierre = $proximosProyectos->filter(function ($p) {
            $fechaFin = Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);

            return $fechaFin->isFuture(); // solo proyectos aún vigentes
        })->sortBy(function ($p) {
            return Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);
        })->first();

        return Inertia::render('Instructor/Dashboard', [
            'instructor' => $instructor,
            'proyectosAsignados' => $proyectosAsignados,
            'proyectos' => $proyectos,
            'totalAprendices' => $totalAprendices,
            'evidenciasPendientes' => $evidenciasPendientes,
            'nuevasPostulaciones' => $nuevasPostulaciones,
            'proximoCierre' => $proximoCierre
        ]);
    }

    public function proyectos()
    {
        $usrId = session('usr_id');
        $proyectos = Proyecto::where('instructor_usuario_id', $usrId)
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->with('empresa')
            ->orderByDesc('id')
            ->get();

        return Inertia::render('Instructor/Proyectos', [
            'proyectos' => $proyectos
        ]);
    }

    public function aprendices()
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
        }])->get();

return Inertia::render('Instructor/Aprendices', [
            'aprendices' => $aprendices
        ]);
    }

    public function perfil()
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usuario_id', $usrId)->first();
        $usuario = User::find($usrId);

        return Inertia::render('Instructor/Perfil', [
            'instructor' => $instructor,
            'usuario' => $usuario
        ]);
    }

    public function actualizarPerfil(Request $request)
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usuario_id', $usrId)->firstOrFail();
        $usuario = User::findOrFail($usrId);

        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'especialidad' => 'required|string|max:100',
            'password' => 'nullable|string|min:8',
        ]);

        $instructor->update([
            'nombres' => $request->nombre,
            'apellidos' => $request->apellido,
            'especialidad' => $request->especialidad,
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

return Inertia::render('Instructor/Historial', [
            'proyectos' => $proyectos
        ]);
    }

    public function reporteSeguimiento(int $id)
    {
        $proyecto = Proyecto::with(['empresa', 'instructor.usuario'])
            ->where('id', $id)
            ->firstOrFail();

        $etapas = Etapa::where('proyecto_id', $id)
            ->orderBy('orden')
            ->get();

        $postulaciones = Postulacion::where('proyecto_id', $id)
            ->where('estado', 'aceptada')
            ->with('aprendiz.usuario')
            ->get();

        $integrantes = $postulaciones;

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

        return Inertia::render('Instructor/ReporteSeguimiento', [
            'proyecto' => $proyecto,
            'etapas' => $etapas,
            'postulaciones' => $postulaciones,
            'integrantes' => $integrantes,
            'evidencias' => $evidencias
        ]);
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

        return Inertia::render('Instructor/DetalleProyecto', [
            'proyecto' => $proyecto,
            'etapas' => $etapas,
            'postulaciones' => $postulaciones,
            'integrantes' => $integrantes
        ]);
    }

    // ✅ MÉTODO PARA CAMBIAR ESTADO DE POSTULACIÓN
    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        // ✅ SEGURIDAD: Validación explícita de estados permitidos
        $request->validate([
            'estado' => 'required|string|in:pendiente,aceptada,rechazada',
        ], [
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: pendiente, aceptada o rechazada.',
        ]);

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
    public function crearEtapa(Request $request, int $proId)
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('id', $proId)
            ->where('instructor_usuario_id', $usrId)
            ->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'required|string|max:1000',
            'orden' => 'required|integer|min:1',
        ]);

        Etapa::create([
            'proyecto_id' => $proId,
            'orden' => $request->orden,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa creada correctamente.');
    }

    // ✅ MÉTODO PARA EDITAR ETAPA
    public function editarEtapa(Request $request, int $etaId)
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('id', $etaId)
            ->whereHas('proyecto', function ($query) use ($usrId) {
                $query->where('instructor_usuario_id', $usrId);
            })->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'required|string|max:1000',
            'orden' => 'required|integer|min:1',
        ]);

        $etapa->update([
            'orden' => $request->orden,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa actualizada correctamente.');
    }

    // ✅ MÉTODO PARA ELIMINAR ETAPA
    public function eliminarEtapa(int $etaId)
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

return Inertia::render('Instructor/Evidencias', [
            'proyecto' => $proyecto,
            'evidencias' => $evidencias
        ]);
    }
}
