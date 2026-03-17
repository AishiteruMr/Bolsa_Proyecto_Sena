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
}
