<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function dashboard()
    {
        $nit = session('nit');

        $totalProyectos = DB::table('proyecto')->where('emp_nit', $nit)->count();
        $proyectosActivos = DB::table('proyecto')->where('emp_nit', $nit)->where('pro_estado', 'Activo')->count();
        $totalPostulaciones = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->where('proyecto.emp_nit', $nit)
            ->count();
        $postulacionesPendientes = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->where('proyecto.emp_nit', $nit)
            ->where('postulacion.pos_estado', 'Pendiente')
            ->count();

        $proyectosRecientes = DB::table('proyecto')
            ->where('emp_nit', $nit)
            ->orderByDesc('pro_id')
            ->limit(5)
            ->get();

        return view('empresa.dashboard', compact(
            'totalProyectos', 'proyectosActivos', 'totalPostulaciones',
            'postulacionesPendientes', 'proyectosRecientes'
        ));
    }

    public function proyectos()
    {
        $nit = session('nit');
        $proyectos = DB::table('proyecto')
            ->where('emp_nit', $nit)
            ->orderByDesc('pro_id')
            ->get();

        return view('empresa.proyectos', compact('proyectos'));
    }

    public function crearProyecto()
    {
        return view('empresa.crear-proyecto');
    }

    public function guardarProyecto(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:200',
            'categoria'    => 'required|string|max:100',
            'ubicacion'    => 'required|string|max:255',
            'descripcion'  => 'required|string|max:500',
            'requisitos'   => 'required|string|max:200',
            'habilidades'  => 'required|string|max:200',
            'fecha_publi'  => 'required|date',
            'imagen'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $nit = session('nit');
        $imagenUrl = null;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('proyectos', 'public');
            $imagenUrl = '/storage/' . $path;
        }

        // Calcular fecha de finalización (6 meses desde la fecha de publicación)
        $fechaPubli = \Carbon\Carbon::parse($request->fecha_publi);
        $fechaFinalizacion = $fechaPubli->addMonths(6);

        DB::table('proyecto')->insert([
            'emp_nit'                    => $nit,
            'pro_titulo_proyecto'        => $request->titulo,
            'pro_categoria'              => $request->categoria,
            'pro_ubicacion'              => $request->ubicacion,
            'pro_descripcion'            => $request->descripcion,
            'pro_requisitos_especificos' => $request->requisitos,
            'pro_habilidades_requerida'  => $request->habilidades,
            'pro_fecha_publi'            => $request->fecha_publi,
            'pro_fecha_finalizacion'     => $fechaFinalizacion,
            'pro_duracion_estimada'      => $fechaPubli->diffInDays($fechaFinalizacion),
            'pro_estado'                 => 'Activo',
            'pro_imagen_url'             => $imagenUrl,
        ]);

        return redirect()->route('empresa.proyectos')->with('success', '✅ Proyecto publicado correctamente.');
    }

    public function editarProyecto(int $id)
    {
        $nit = session('nit');
        $proyecto = DB::table('proyecto')
            ->where('pro_id', $id)
            ->where('emp_nit', $nit)
            ->firstOrFail();

        return view('empresa.editar-proyecto', compact('proyecto'));
    }

    public function actualizarProyecto(Request $request, int $id)
    {
        $request->validate([
            'titulo'      => 'required|string|max:200',
            'categoria'   => 'required|string|max:100',
            'ubicacion'   => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
            'requisitos'  => 'required|string|max:200',
            'habilidades' => 'required|string|max:200',
            'fecha_publi' => 'required|date',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $nit = session('nit');
        
        // Calcular fecha de finalización (6 meses desde la fecha de publicación)
        $fechaPubli = \Carbon\Carbon::parse($request->fecha_publi);
        $fechaFinalizacion = $fechaPubli->addMonths(6);
        
        $datos = [
            'pro_titulo_proyecto'        => $request->titulo,
            'pro_categoria'              => $request->categoria,
            'pro_ubicacion'              => $request->ubicacion,
            'pro_descripcion'            => $request->descripcion,
            'pro_requisitos_especificos' => $request->requisitos,
            'pro_habilidades_requerida'  => $request->habilidades,
            'pro_fecha_publi'            => $request->fecha_publi,
            'pro_fecha_finalizacion'     => $fechaFinalizacion,
            'pro_duracion_estimada'      => $fechaPubli->diffInDays($fechaFinalizacion),
        ];

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('proyectos', 'public');
            $datos['pro_imagen_url'] = '/storage/' . $path;
        }

        DB::table('proyecto')
            ->where('pro_id', $id)
            ->where('emp_nit', $nit)
            ->update($datos);

        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function eliminarProyecto(int $id)
    {
        $nit = session('nit');
        DB::table('proyecto')->where('pro_id', $id)->where('emp_nit', $nit)->delete();
        return redirect()->route('empresa.proyectos')->with('success', 'Proyecto eliminado.');
    }

    public function verPostulantes(int $id)
    {
        $nit = session('nit');

        $proyecto = DB::table('proyecto')
            ->where('pro_id', $id)
            ->where('emp_nit', $nit)
            ->firstOrFail();

        $postulantes = DB::table('postulacion')
            ->join('aprendiz', 'postulacion.apr_id', '=', 'aprendiz.apr_id')
            ->join('usuario', 'aprendiz.usr_id', '=', 'usuario.usr_id')
            ->where('postulacion.pro_id', $id)
            ->select('postulacion.*', 'aprendiz.apr_nombre', 'aprendiz.apr_apellido',
                     'aprendiz.apr_programa', 'usuario.usr_correo')
            ->orderByDesc('postulacion.pos_fecha')
            ->get();

        return view('empresa.postulantes', compact('proyecto', 'postulantes'));
    }

    public function cambiarEstadoPostulacion(Request $request, int $id)
    {
        $request->validate(['estado' => 'required|in:Pendiente,Aprobada,Rechazada']);

        DB::table('postulacion')->where('pos_id', $id)->update(['pos_estado' => $request->estado]);

        return back()->with('success', 'Estado de postulación actualizado.');
    }

    public function perfil()
    {
        $empId = session('emp_id');
        $empresa = DB::table('empresa')->where('emp_id', $empId)->first();
        return view('empresa.perfil', compact('empresa'));
    }

    public function actualizarPerfil(Request $request)
    {
        $empId = session('emp_id');

        $request->validate([
            'nombre_empresa' => 'required|string|max:150',
            'representante'  => 'required|string|max:100',
            'password'       => 'nullable|string|min:6',
        ]);

        $datos = [
            'emp_nombre'        => $request->nombre_empresa,
            'emp_representante' => $request->representante,
        ];

        if ($request->filled('password')) {
            $datos['emp_contrasena'] = Hash::make($request->password);
        }

        DB::table('empresa')->where('emp_id', $empId)->update($datos);
        session(['nombre' => $request->nombre_empresa]);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
