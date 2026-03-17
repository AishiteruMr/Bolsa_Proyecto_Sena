<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function dashboard()
    {
        $usrId = session('usr_id');
        $instructor = DB::table('instructor')->where('usr_id', $usrId)->first();

        $proyectosAsignados = DB::table('proyecto')
            ->where('ins_usr_documento', session('documento'))
            ->count();

        $proyectosActivos = DB::table('proyecto')
            ->where('ins_usr_documento', session('documento'))
            ->where('pro_estado', 'Activo')
            ->count();

        $proyectos = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.ins_usr_documento', session('documento'))
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->orderByDesc('proyecto.pro_id')
            ->limit(5)
            ->get();

        $totalAprendices = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->where('proyecto.ins_usr_documento', session('documento'))
            ->where('postulacion.pos_estado', 'Aprobada')
            ->distinct()
            ->count('postulacion.apr_id');

        return view('instructor.dashboard', compact(
            'instructor', 'proyectosAsignados', 'proyectosActivos',
            'proyectos', 'totalAprendices'
        ));
    }

    public function proyectos()
    {
        $proyectos = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.ins_usr_documento', session('documento'))
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
}
