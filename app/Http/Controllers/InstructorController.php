<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PostulacionEstadoCambiado;

class InstructorController extends Controller
{
    public function dashboard()
    {
        $usrId = session('usr_id');
        $instructor = DB::table('instructor')->where('usr_id', $usrId)->first();

        $proyectosAsignados = DB::table('proyecto')
            ->where('ins_usr_documento', session('documento'))
            ->where('pro_estado', 'Activo')
            ->count();

        $proyectos = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.ins_usr_documento', session('documento'))
            ->where('proyecto.pro_estado', 'Activo')
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->orderByDesc('proyecto.pro_id')
            ->limit(5)
            ->get();

        $totalAprendices = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->where('proyecto.ins_usr_documento', session('documento'))
            ->where('proyecto.pro_estado', 'Activo')
            ->where('postulacion.pos_estado', 'Aprobada')
            ->distinct()
            ->count('postulacion.apr_id');

        return view('instructor.dashboard', compact(
            'instructor', 'proyectosAsignados',
            'proyectos', 'totalAprendices'
        ));
    }

    public function proyectos()
    {
        $proyectos = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.ins_usr_documento', session('documento'))
            ->where('proyecto.pro_estado', 'Activo')
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->orderByDesc('proyecto.pro_id')
            ->get();

        return view('instructor.proyectos', compact('proyectos'));
    }

    public function aprendices()
    {
        $aprendices = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->join('aprendiz', 'postulacion.apr_id', '=', 'aprendiz.apr_id')
            ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
            ->where('proyecto.ins_usr_documento', session('documento'))
            ->where('proyecto.pro_estado', 'Activo')
            ->where('postulacion.pos_estado', 'Aprobada')
            ->select('aprendiz.*', 'usuario.usr_correo', 'proyecto.pro_titulo_proyecto',
                     'postulacion.pos_estado', 'postulacion.pos_fecha')
            ->get();

        return view('instructor.aprendices', compact('aprendices'));
    }

    public function perfil()
    {
        $usrId = session('usr_id');
        $instructor = DB::table('instructor')->where('usr_id', $usrId)->first();
        $usuario = DB::table('usuario')->where('usr_id', $usrId)->first();
        return view('instructor.perfil', compact('instructor', 'usuario'));
    }

    public function actualizarPerfil(Request $request)
    {
        $usrId = session('usr_id');
        $request->validate([
            'nombre'       => 'required|string|max:50',
            'apellido'     => 'required|string|max:50',
            'especialidad' => 'required|string|max:100',
            'password'     => 'nullable|string|min:6',
        ]);

        DB::table('instructor')->where('usr_id', $usrId)->update([
            'ins_nombre'      => $request->nombre,
            'ins_apellido'    => $request->apellido,
            'ins_especialidad'=> $request->especialidad,
        ]);

        if ($request->filled('password')) {
            DB::table('usuario')->where('usr_id', $usrId)->update([
                'usr_contrasena' => Hash::make($request->password),
            ]);
        }

        session(['nombre' => $request->nombre, 'apellido' => $request->apellido]);
        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    // ── HISTORIAL DE PROYECTOS ──
    public function historial()
    {
        $usrDocumento = session('documento');
        
        // El historial muestra proyectos asignados, sin importar si están activos o inactivos
        $proyectos = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->leftJoin('postulacion', 'proyecto.pro_id', '=', 'postulacion.pro_id')
            ->leftJoin('aprendiz', 'postulacion.apr_id', '=', 'aprendiz.apr_id')
            ->where('proyecto.ins_usr_documento', $usrDocumento)
            ->select(
                'proyecto.pro_id',
                'proyecto.pro_titulo_proyecto',
                'proyecto.pro_categoria',
                'proyecto.pro_estado',
                'proyecto.pro_fecha_publi',
                'proyecto.pro_fecha_finalizacion',
                'empresa.emp_nombre',
                DB::raw('COUNT(DISTINCT postulacion.apr_id) as total_aprendices'),
                DB::raw('COUNT(CASE WHEN postulacion.pos_estado = "Aprobada" THEN 1 END) as aprendices_aprobados')
            )
            ->groupBy('proyecto.pro_id', 'proyecto.pro_titulo_proyecto', 'proyecto.pro_categoria', 
                      'proyecto.pro_estado', 'proyecto.pro_fecha_publi', 'proyecto.pro_fecha_finalizacion',
                      'empresa.emp_nombre')
            ->orderByDesc('proyecto.pro_fecha_publi')
            ->get();

        return view('instructor.historial', compact('proyectos'));
    }

    // ── REPORTE DE SEGUIMIENTO POR PROYECTO ──
    public function reporteSeguimiento($proId)
    {
        $usrDocumento = session('documento');
        
        // Verificar que el proyecto pertenece al instructor
        $proyecto = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.pro_id', $proId)
            ->where('proyecto.ins_usr_documento', $usrDocumento)
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->first();

        if (!$proyecto) {
            abort(403, 'No tienes acceso a este proyecto.');
        }

        // Obtener etapas del proyecto
        $etapas = DB::table('etapa')
            ->where('eta_pro_id', $proId)
            ->orderBy('eta_orden')
            ->get();

        // Obtener aprendices aprobados
        $aprendices = DB::table('aprendiz')
            ->join('postulacion', 'aprendiz.apr_id', '=', 'postulacion.apr_id')
            ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
            ->where('postulacion.pro_id', $proId)
            ->where('postulacion.pos_estado', 'Aprobada')
            ->select('aprendiz.apr_id', 'aprendiz.apr_nombre', 'aprendiz.apr_apellido', 'usuario.usr_correo')
            ->get();

        // Obtener entregas y evidencias
        $entregas = DB::table('entrega_etapa')
            ->join('etapa', 'entrega_etapa.ene_eta_id', '=', 'etapa.eta_id')
            ->join('aprendiz', 'entrega_etapa.ene_apr_id', '=', 'aprendiz.apr_id')
            ->where('entrega_etapa.ene_pro_id', $proId)
            ->select(
                'entrega_etapa.*',
                'etapa.eta_nombre',
                'etapa.eta_orden',
                'aprendiz.apr_nombre',
                'aprendiz.apr_apellido'
            )
            ->orderBy('etapa.eta_orden')
            ->orderBy('entrega_etapa.ene_fecha', 'desc')
            ->get();

        // Obtener evidencias
        $evidencias = DB::table('evidencia')
            ->join('etapa', 'evidencia.evid_eta_id', '=', 'etapa.eta_id')
            ->join('aprendiz', 'evidencia.evid_apr_id', '=', 'aprendiz.apr_id')
            ->where('evidencia.evid_pro_id', $proId)
            ->select(
                'evidencia.*',
                'etapa.eta_nombre',
                'etapa.eta_orden',
                'aprendiz.apr_nombre',
                'aprendiz.apr_apellido'
            )
            ->orderBy('etapa.eta_orden')
            ->orderBy('evidencia.evid_fecha', 'desc')
            ->get();

        return view('instructor.reporte-seguimiento', compact(
    'proyecto', 'etapas', 'aprendices', 'entregas', 'evidencias'
));
}

// ✅ MÉTODO SEPARADO (FUERA del anterior)
public function detalleProyecto($id)
{
    $usrDocumento = session('documento');

    $proyecto = DB::table('proyecto')
        ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
        ->where('proyecto.pro_id', $id)
        ->where('proyecto.ins_usr_documento', $usrDocumento)
        ->select('proyecto.*', 'empresa.emp_nombre')
        ->first();

    if (!$proyecto) {
        abort(403, 'No tienes acceso a este proyecto');
    }

    // Obtener etapas del proyecto
    $etapas = DB::table('etapa')
        ->where('eta_pro_id', $id)
        ->orderBy('eta_orden')
        ->get();

    // Obtener postulaciones con estado
    $postulaciones = DB::table('postulacion')
        ->join('aprendiz', 'postulacion.apr_id', '=', 'aprendiz.apr_id')
        ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
        ->where('postulacion.pro_id', $id)
        ->select('postulacion.*', 'aprendiz.apr_nombre', 'aprendiz.apr_apellido',
                 'aprendiz.apr_programa', 'usuario.usr_correo')
        ->orderByDesc('postulacion.pos_fecha')
        ->get();

    // Obtener integrantes aprobados
    $integrantes = DB::table('postulacion')
        ->join('aprendiz', 'postulacion.apr_id', '=', 'aprendiz.apr_id')
        ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
        ->where('postulacion.pro_id', $id)
        ->where('postulacion.pos_estado', 'Aprobada')
        ->select('aprendiz.*', 'usuario.usr_correo', 'postulacion.pos_fecha')
        ->get();

    return view('instructor.detalle_proyecto', compact('proyecto', 'etapas', 'postulaciones', 'integrantes'));
}

     // ✅ MÉTODO PARA CAMBIAR ESTADO DE POSTULACIÓN (SOLO EL INSTRUCTOR)
    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);

        $usrDocumento = session('documento');

        // Verificar que la postulación pertenece a un proyecto del instructor
        $postulacion = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->where('postulacion.pos_id', $id)
            ->where('proyecto.ins_usr_documento', $usrDocumento)
            ->first();

        if (!$postulacion) {
            abort(403, 'No tienes permiso para cambiar el estado de esta postulación.');
        }

        DB::table('postulacion')->where('pos_id', $id)->update(['pos_estado' => $request->estado]);

        // Enviar correo al aprendiz si se aprueba o rechaza
        if (in_array($request->estado, ['Aprobada', 'Rechazada'])) {
            try {
                $postulacionCompleta = DB::table('postulacion')
                    ->join('aprendiz', 'postulacion.apr_id', '=', 'aprendiz.apr_id')
                    ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
                    ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
                    ->where('postulacion.pos_id', $id)
                    ->select('aprendiz.apr_nombre', 'usuario.usr_correo', 'proyecto.pro_titulo_proyecto')
                    ->first();

                if ($postulacionCompleta) {
                    Mail::to($postulacionCompleta->usr_correo)
                        ->send(new PostulacionEstadoCambiado(
                            $postulacionCompleta->apr_nombre,
                            $postulacionCompleta->pro_titulo_proyecto,
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
        $usrDocumento = session('documento');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = DB::table('proyecto')
            ->where('pro_id', $proId)
            ->where('ins_usr_documento', $usrDocumento)
            ->first();

        if (!$proyecto) {
            abort(403, 'No tienes permiso para agregar etapas a este proyecto.');
        }

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        DB::table('etapa')->insert([
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
        $usrDocumento = session('documento');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = DB::table('etapa')
            ->join('proyecto', 'etapa.eta_pro_id', '=', 'proyecto.pro_id')
            ->where('etapa.eta_id', $etaId)
            ->where('proyecto.ins_usr_documento', $usrDocumento)
            ->first();

        if (!$etapa) {
            abort(403, 'No tienes permiso para editar esta etapa.');
        }

        $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'required|string|max:1000',
            'orden'        => 'required|integer|min:1',
        ]);

        DB::table('etapa')->where('eta_id', $etaId)->update([
            'eta_orden'       => $request->orden,
            'eta_nombre'      => $request->nombre,
            'eta_descripcion' => $request->descripcion,
        ]);

        return back()->with('success', 'Etapa actualizada correctamente.');
    }

    // ✅ MÉTODO PARA ELIMINAR ETAPA
    public function eliminarEtapa(int $etaId)
    {
        $usrDocumento = session('documento');

        // Verificar que la etapa pertenece a un proyecto del instructor
        $etapa = DB::table('etapa')
            ->join('proyecto', 'etapa.eta_pro_id', '=', 'proyecto.pro_id')
            ->where('etapa.eta_id', $etaId)
            ->where('proyecto.ins_usr_documento', $usrDocumento)
            ->first();

        if (!$etapa) {
            abort(403, 'No tienes permiso para eliminar esta etapa.');
        }

        DB::table('etapa')->where('eta_id', $etaId)->delete();

        return back()->with('success', 'Etapa eliminada correctamente.');
    }

    // ✅ MÉTODO PARA SUBIR IMAGEN AL PROYECTO
    public function subirImagenProyecto(Request $request, int $proId)
    {
        $usrDocumento = session('documento');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = DB::table('proyecto')
            ->where('pro_id', $proId)
            ->where('ins_usr_documento', $usrDocumento)
            ->first();

        if (!$proyecto) {
            abort(403, 'No tienes permiso para editar este proyecto.');
        }

        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('proyectos', 'public');
            $imagenUrl = '/storage/' . $path;

            DB::table('proyecto')->where('pro_id', $proId)->update([
                'pro_imagen_url' => $imagenUrl,
            ]);

            return back()->with('success', 'Imagen del proyecto actualizada correctamente.');
        }

        return back()->with('error', 'No se pudo guardar la imagen.');
    }

    // ✅ MÉTODO PARA VER EVIDENCIAS DE UN PROYECTO
    public function verEvidencias(int $proId)
    {
        $usrDocumento = session('documento');

        // Verificar que el proyecto pertenece al instructor
        $proyecto = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.pro_id', $proId)
            ->where('proyecto.ins_usr_documento', $usrDocumento)
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->first();

        if (!$proyecto) {
            abort(403, 'No tienes acceso a este proyecto.');
        }

        // Obtener evidencias del proyecto con detalles del aprendiz y etapa
        $evidencias = DB::table('evidencia')
            ->join('aprendiz', 'evidencia.evid_apr_id', '=', 'aprendiz.apr_id')
            ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
            ->join('etapa', 'evidencia.evid_eta_id', '=', 'etapa.eta_id')
            ->where('evidencia.evid_pro_id', $proId)
            ->select(
                'evidencia.*',
                'aprendiz.apr_nombre',
                'aprendiz.apr_apellido',
                'usuario.usr_correo',
                'etapa.eta_nombre',
                'etapa.eta_orden'
            )
            ->orderBy('etapa.eta_orden')
            ->orderByDesc('evidencia.evid_fecha')
            ->get();

        return view('instructor.evidencias', compact('proyecto', 'evidencias'));
    }

    // ✅ MÉTODO PARA CALIFICAR EVIDENCIA
    public function calificarEvidencia(Request $request, int $evidId)
    {
        $usrDocumento = session('documento');

        // Verificar que la evidencia pertenece a un proyecto del instructor
        $evidencia = DB::table('evidencia')
            ->join('proyecto', 'evidencia.evid_pro_id', '=', 'proyecto.pro_id')
            ->where('evidencia.evid_id', $evidId)
            ->where('proyecto.ins_usr_documento', $usrDocumento)
            ->first();

        if (!$evidencia) {
            abort(403, 'No tienes permiso para calificar esta evidencia.');
        }

        $request->validate([
            'estado'      => 'required|in:Aprobada,Rechazada,Pendiente',
            'comentario'  => 'nullable|string|max:1000',
        ]);

        DB::table('evidencia')->where('evid_id', $evidId)->update([
            'evid_estado'     => $request->estado,
            'evid_comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Evidencia calificada correctamente.');
    }

        
    
}
