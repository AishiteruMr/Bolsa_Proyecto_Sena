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
        
        $instructor = Instructor::where('usr_id', $usrId)->first();

        if (!$instructor) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de instructor.');
        }

        // Proyectos asignados activos
        $proyectosAsignados = Proyecto::where('ins_usr_documento', $usrId)
            ->where('pro_estado', 'Activo')
            ->count();

        // Proyectos recientes con relación a empresa (eager loading)
        $proyectos = Proyecto::where('ins_usr_documento', $usrId)
            ->where('pro_estado', 'Activo')
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('pro_id')
            ->limit(5)
            ->get();

        // Contar aprendices aprobados en proyectos del instructor
        $totalAprendices = Postulacion::whereIn('pro_id',
            Proyecto::where('ins_usr_documento', $usrId)
                ->where('pro_estado', 'Activo')
                ->pluck('pro_id')
        )->where('pos_estado', 'Aprobada')
            ->distinct('apr_id')
            ->count();

        // Evidencias pendientes por calificar
        $evidenciasPendientes = Evidencia::whereIn('evid_pro_id',
            Proyecto::where('ins_usr_documento', $usrId)
                ->pluck('pro_id')
        )->where('evid_estado', 'Pendiente')
            ->count();

        // 🆕 Nuevas postulaciones (últimas 48 horas)
        $nuevasPostulaciones = Postulacion::whereIn('pro_id',
            Proyecto::where('ins_usr_documento', $usrId)->pluck('pro_id')
        )->where('pos_fecha', '>=', now()->subHours(48))->count();

        // 🆕 Próximo cierre de proyecto
        $proximoCierre = Proyecto::where('ins_usr_documento', $usrId)
            ->where('pro_estado', 'Activo')
            ->where('pro_fecha_finalizacion', '>=', now())
            ->orderBy('pro_fecha_finalizacion')
            ->first();

        return view('instructor.dashboard', compact(
            'instructor', 'proyectosAsignados',
            'proyectos', 'totalAprendices', 'evidenciasPendientes',
            'nuevasPostulaciones', 'proximoCierre'
        ));
    }

    public function proyectos()
    {
        $usrId = session('usr_id');
        
        $proyectos = Proyecto::where('ins_usr_documento', $usrId)
            ->where('pro_estado', 'Activo')
            ->with('empresa')
            ->orderByDesc('pro_id')
            ->get();

        return view('instructor.proyectos', compact('proyectos'));
    }

    public function aprendices()
    {
        $usrId = session('usr_id');
        
        $aprendices = Aprendiz::whereHas('postulaciones', function($query) use ($usrId) {
            $query->where('pos_estado', 'Aprobada')
                ->whereHas('proyecto', function($subQuery) use ($usrId) {
                    $subQuery->where('ins_usr_documento', $usrId)
                        ->where('pro_estado', 'Activo');
                });
        })->with(['usuario', 'postulaciones' => function($q) use ($usrId) {
            $q->where('pos_estado', 'Aprobada')
                ->whereHas('proyecto', function($sq) use ($usrId) {
                    $sq->where('ins_usr_documento', $usrId);
                });
        }])->get();

        return view('instructor.aprendices', compact('aprendices'));
    }

    public function perfil()
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usr_id', $usrId)->first();

        if (!$instructor) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de instructor.');
        }

        $usuario = User::findOrFail($usrId);

        // 🆕 Estadísticas reales para el perfil
        $proyectosCount = Proyecto::where('ins_usr_documento', $usrId)->count();
        
        $aprendicesCount = Postulacion::whereIn('pro_id',
            Proyecto::where('ins_usr_documento', $usrId)->pluck('pro_id')
        )->where('pos_estado', 'Aprobada')
            ->distinct('apr_id')
            ->count();

        $evidenciasPendientesCount = Evidencia::whereIn('evid_pro_id',
            Proyecto::where('ins_usr_documento', $usrId)->pluck('pro_id')
        )->where('evid_estado', 'Pendiente')
            ->count();

        return view('instructor.perfil', compact(
            'instructor', 'usuario', 'proyectosCount', 
            'aprendicesCount', 'evidenciasPendientesCount'
        ));
    }

    public function actualizarPerfil(Request $request)
    {
        $usrId = session('usr_id');
        $instructor = Instructor::where('usr_id', $usrId)->firstOrFail();
        $usuario = User::findOrFail($usrId);

        $request->validate([
            'nombre'       => 'required|string|max:50',
            'apellido'     => 'required|string|max:50',
            'especialidad' => 'required|string|max:100',
            'password'     => 'nullable|string|min:6|confirmed',
        ]);

        $instructor->update([
            'ins_nombre'      => $request->nombre,
            'ins_apellido'    => $request->apellido,
            'ins_especialidad'=> $request->especialidad,
        ]);

        if ($request->filled('password')) {
            $usuario->update([
                'usr_contrasena' => Hash::make($request->password),
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
        $proyectos = Proyecto::where('ins_usr_documento', $usrId)
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('pro_fecha_publi')
            ->get();

        return view('instructor.historial', compact('proyectos'));
    }

    // ── REPORTE DE SEGUIMIENTO POR PROYECTO ──
    public function reporteSeguimiento($proId)
    {
        $usrId = session('usr_id');
        
        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', $usrId)
            ->with('empresa')
            ->firstOrFail();

        // Obtener etapas del proyecto
        $etapas = Etapa::where('eta_pro_id', $proId)
            ->orderBy('eta_orden')
            ->get();

        // Obtener aprendices aprobados
        $aprendices = Aprendiz::whereHas('postulaciones', function($query) use ($proId) {
            $query->where('pro_id', $proId)
                ->where('pos_estado', 'Aprobada');
        })->with('usuario')->get();

        // Obtener evidencias
        $evidencias = Evidencia::where('evid_pro_id', $proId)
            ->with(['etapa', 'aprendiz'])
            ->orderBy('eta_orden', 'asc')
            ->orderByDesc('evid_fecha')
            ->get();

        return view('instructor.reporte-seguimiento', compact(
            'proyecto', 'etapas', 'aprendices', 'evidencias'
        ));
    }

    public function detalleProyecto($id)
    {
        $usrId = session('usr_id');

        $proyecto = Proyecto::where('pro_id', $id)
            ->where('ins_usr_documento', $usrId)
            ->with('empresa')
            ->firstOrFail();

        // Obtener etapas del proyecto
        $etapas = Etapa::where('eta_pro_id', $id)
            ->orderBy('eta_orden')
            ->get();

        // Obtener postulaciones con aprendices
        $postulaciones = Postulacion::where('pro_id', $id)
            ->with(['aprendiz.usuario'])
            ->orderByDesc('pos_fecha')
            ->get();

        // Obtener integrantes aprobados
        $integrantes = Postulacion::where('pro_id', $id)
            ->where('pos_estado', 'Aprobada')
            ->with(['aprendiz.usuario'])
            ->get();

        return view('instructor.detalle_proyecto', compact('proyecto', 'etapas', 'postulaciones', 'integrantes'));
    }

    // ✅ MÉTODO PARA CAMBIAR ESTADO DE POSTULACIÓN (SOLO EL INSTRUCTOR)
    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);

        $usrId = session('usr_id');

        // Verificar que la postulación pertenece a un proyecto del instructor
        $postulacion = Postulacion::where('pos_id', $id)
            ->whereHas('proyecto', function($query) use ($usrId) {
                $query->where('ins_usr_documento', $usrId);
            })->firstOrFail();

        $postulacion->update(['pos_estado' => $request->estado]);

        // Enviar correo al aprendiz si se aprueba o rechaza
        if (in_array($request->estado, ['Aprobada', 'Rechazada'])) {
            try {
                $aprendiz = $postulacion->aprendiz()->with('usuario')->first();
                $proyecto = $postulacion->proyecto;
                
                if ($aprendiz && $proyecto) {
                    Mail::to($aprendiz->usuario->usr_correo)
                        ->send(new PostulacionEstadoCambiado(
                            $aprendiz->apr_nombre,
                            $proyecto->pro_titulo_proyecto,
                            $request->estado
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
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', $usrId)
            ->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        Etapa::create([
            'eta_pro_id'      => $proId,
            'eta_orden'       => $request->orden,
            'eta_nombre'      => $request->nombre,
            'eta_descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa creada correctamente.');
    }

    // ✅ MÉTODO PARA EDITAR ETAPA
    public function editarEtapa(Request $request, int $etaId)
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('eta_id', $etaId)
            ->whereHas('proyecto', function($query) use ($usrId) {
                $query->where('ins_usr_documento', $usrId);
            })->firstOrFail();

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        $etapa->update([
            'eta_orden'       => $request->orden,
            'eta_nombre'      => $request->nombre,
            'eta_descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa actualizada correctamente.');
    }

    // ✅ MÉTODO PARA ELIMINAR ETAPA
    public function eliminarEtapa(int $etaId)
    {
        $usrId = session('usr_id');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = Etapa::where('eta_id', $etaId)
            ->whereHas('proyecto', function($query) use ($usrId) {
                $query->where('ins_usr_documento', $usrId);
            })->firstOrFail();

        $etapa->delete();

        return back()->with('success', 'Etapa eliminada correctamente.');
    }

    // ✅ MÉTODO PARA SUBIR IMAGEN AL PROYECTO
    public function subirImagenProyecto(Request $request, int $proId)
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', $usrId)
            ->firstOrFail();

        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($proyecto->pro_imagen_url) {
                $oldPath = str_replace('/storage/', '', $proyecto->pro_imagen_url);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $request->file('imagen')->store('proyectos', 'public');
            $imagenUrl = '/storage/' . $path;

            $proyecto->update(['pro_imagen_url' => $imagenUrl]);

            return back()->with('success', 'Imagen del proyecto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo guardar la imagen.');
    }

    // ✅ MÉTODO PARA VER EVIDENCIAS DE UN PROYECTO
    public function verEvidencias(int $proId)
    {
        $usrId = session('usr_id');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = Proyecto::where('pro_id', $proId)
            ->where('ins_usr_documento', $usrId)
            ->with('empresa')
            ->firstOrFail();

        // Obtener evidencias del proyecto con detalles del aprendiz y etapa
        $evidencias = Evidencia::where('evid_pro_id', $proId)
            ->with(['aprendiz.usuario', 'etapa'])
            ->orderBy('eta_orden')
            ->orderByDesc('evid_fecha')
            ->get();

        return view('instructor.evidencias', compact('proyecto', 'evidencias'));
    }

    // ✅ MÉTODO PARA CALIFICAR EVIDENCIA
    public function calificarEvidencia(Request $request, int $evidId)
    {
        $usrId = session('usr_id');

        // Verificar que la evidencia pertenece a un proyecto del instructor
        $evidencia = Evidencia::where('evid_id', $evidId)
            ->whereHas('proyecto', function($query) use ($usrId) {
                $query->where('ins_usr_documento', $usrId);
            })->firstOrFail();

        $request->validate([
            'estado'      => 'required|in:Aprobada,Rechazada,Pendiente',
            'comentario'  => 'nullable|string|max:1000',
        ]);

        $evidencia->update([
            'evid_estado'     => $request->estado,
            'evid_comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Evidencia calificada correctamente.');
    }
}
