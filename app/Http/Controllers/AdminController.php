<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'aprendices'   => DB::table('aprendiz')->count(),
            'instructores' => DB::table('instructor')->count(),
            'empresas'     => DB::table('empresa')->count(),
            'proyectos'    => DB::table('proyecto')->count(),
            'postulaciones'=> DB::table('postulacion')->count(),
            'aprobadas'    => DB::table('postulacion')->where('pos_estado', 'Aprobada')->count(),
        ];

        $proyectosRecientes = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->orderByDesc('proyecto.pro_id')
            ->limit(5)
            ->get();

        $usuariosRecientes = DB::table('usuario')
            ->join('rol', 'usuario.rol_id', '=', 'rol.rol_id')
            ->select('usuario.*', 'rol.rol_nombre')
            ->orderByDesc('usuario.usr_fecha_creacion')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'proyectosRecientes', 'usuariosRecientes'));
    }

    public function usuarios()
    {
        $aprendices = DB::table('aprendiz')
            ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
            ->select('aprendiz.*', 'usuario.usr_correo', 'usuario.usr_fecha_creacion', 'usuario.usr_documento')
            ->get();

        $instructores = DB::table('instructor')
            ->join('usuario', 'instructor.usr_id', '=', 'usuario.usr_id')
            ->select('instructor.*', 'usuario.usr_correo', 'usuario.usr_fecha_creacion', 'usuario.usr_documento')
            ->get();

        return view('admin.usuarios', compact('aprendices', 'instructores'));
    }

    public function cambiarEstadoUsuario(Request $request, int $id)
    {
        $request->validate([
            'tipo' => 'required|in:aprendiz,instructor',
            'estado' => 'required|in:0,1'
        ]);

        if ($request->tipo === 'aprendiz') {
            DB::table('aprendiz')->where('apr_id', $id)->update(['apr_estado' => $request->estado]);
        } else {
            DB::table('instructor')->where('usr_id', $id)->update(['ins_estado' => $request->estado]);
        }

        return back()->with('success', 'Estado del usuario actualizado.');
    }

    public function empresas()
    {
        $empresas = DB::table('empresa')->orderByDesc('emp_id')->get();
        return view('admin.empresas', compact('empresas'));
    }

    public function cambiarEstadoEmpresa(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:0,1']);

        DB::table('empresa')
            ->where('emp_id', $id)
            ->update(['emp_estado' => $request->estado]);

        return back()->with('success', 'Estado de la empresa actualizado.');
    }

    public function proyectos()
    {
        $proyectos = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->leftJoin('usuario', 'proyecto.ins_usr_documento', '=', 'usuario.usr_documento')
            ->leftJoin('instructor', 'usuario.usr_id', '=', 'instructor.usr_id')
            ->select(
                'proyecto.*',
                'empresa.emp_nombre',
                'instructor.ins_nombre'
            )
            ->orderByDesc('proyecto.pro_id')
            ->get();

        $instructores = DB::table('instructor')
            ->join('usuario', 'instructor.usr_id', '=', 'usuario.usr_id')
            ->select('instructor.ins_nombre', 'usuario.usr_documento')
            ->get();

        return view('admin.proyectos', compact('proyectos', 'instructores'));
    }

    public function cambiarEstadoProyecto(Request $request, int $id)
    {
        $request->validate([
            'estado' => 'required|in:Activo,Inactivo,Aprobado,Rechazado'
        ]);

        // Si el proyecto se inactiva, desasociar el instructor
        if ($request->estado === 'Inactivo') {
            DB::table('proyecto')
                ->where('pro_id', $id)
                ->update([
                    'pro_estado' => $request->estado,
                    'ins_usr_documento' => null
                ]);
        } else {
            DB::table('proyecto')
                ->where('pro_id', $id)
                ->update(['pro_estado' => $request->estado]);
        }

        return back()->with('success', 'Estado del proyecto actualizado.');
    }

    public function asignarInstructor(Request $request, $id)
    {
        $request->validate([
            'ins_usr_documento' => 'required|exists:usuario,usr_documento'
        ]);

        DB::table('proyecto')
            ->where('pro_id', $id)
            ->update([
                'ins_usr_documento' => $request->ins_usr_documento
            ]);

        return back()->with('success', 'Instructor asignado correctamente');
    }
}