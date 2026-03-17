<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AprendizController extends Controller
{
    public function dashboard()
    {
        $usrId = session('usr_id');

        $aprendiz = DB::table('aprendiz')->where('usr_id', $usrId)->first();
        $totalPostulaciones = DB::table('postulacion')->where('apr_id', $aprendiz->apr_id ?? 0)->count();
        $postulacionesAprobadas = DB::table('postulacion')
            ->where('apr_id', $aprendiz->apr_id ?? 0)
            ->where('pos_estado', 'Aprobada')
            ->count();
        $proyectosDisponibles = DB::table('proyecto')->where('pro_estado', 'Activo')->count();

        $proyectosRecientes = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.pro_estado', 'Activo')
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->orderByDesc('proyecto.pro_id')
            ->limit(6)
            ->get();

        return view('aprendiz.dashboard', compact(
            'aprendiz', 'totalPostulaciones', 'postulacionesAprobadas',
            'proyectosDisponibles', 'proyectosRecientes'
        ));
    }

    public function proyectos(Request $request)
    {
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendiz')->where('usr_id', $usrId)->first();

        $query = DB::table('proyecto')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('proyecto.pro_estado', 'Activo')
            ->select('proyecto.*', 'empresa.emp_nombre');

        if ($request->filled('buscar')) {
            $query->where('pro_titulo_proyecto', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('categoria')) {
            $query->where('pro_categoria', $request->categoria);
        }

        $proyectos = $query->orderByDesc('proyecto.pro_id')->paginate(9);

        // IDs de proyectos donde ya postuló
        $postulados = [];
        if ($aprendiz) {
            $postulados = DB::table('postulacion')
                ->where('apr_id', $aprendiz->apr_id)
                ->pluck('pro_id')
                ->toArray();
        }

        $categorias = DB::table('proyecto')->distinct()->select('pro_categoria')->pluck('pro_categoria');

        return view('aprendiz.proyectos', compact('proyectos', 'postulados', 'categorias'));
    }

    public function postular(Request $request, int $id)
    {
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendiz')->where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return back()->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $yaPostulado = DB::table('postulacion')
            ->where('apr_id', $aprendiz->apr_id)
            ->where('pro_id', $id)
            ->exists();

        if ($yaPostulado) {
            return back()->with('warning', 'Ya te postulaste a este proyecto.');
        }

        DB::table('postulacion')->insert([
            'apr_id'     => $aprendiz->apr_id,
            'pro_id'     => $id,
            'pos_fecha'  => now(),
            'pos_estado' => 'Pendiente',
        ]);

        return back()->with('success', '✅ Postulación enviada correctamente.');
    }

    public function misPostulaciones()
    {
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendiz')->where('usr_id', $usrId)->first();

        $postulaciones = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('postulacion.apr_id', $aprendiz->apr_id ?? 0)
            ->select('postulacion.*', 'proyecto.pro_titulo_proyecto', 'proyecto.pro_categoria',
                     'proyecto.pro_imagen_url', 'empresa.emp_nombre')
            ->orderByDesc('postulacion.pos_fecha')
            ->get();

        return view('aprendiz.postulaciones', compact('postulaciones'));
    }

    public function perfil()
    {
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendiz')->where('usr_id', $usrId)->first();
        $usuario = DB::table('usuario')->where('usr_id', $usrId)->first();

        return view('aprendiz.perfil', compact('aprendiz', 'usuario'));
    }

    public function actualizarPerfil(Request $request)
    {
        $usrId = session('usr_id');

        $request->validate([
            'nombre'    => 'required|string|max:50',
            'apellido'  => 'required|string|max:50',
            'programa'  => 'required|string|max:100',
            'password'  => 'nullable|string|min:6',
        ]);

        DB::table('aprendiz')->where('usr_id', $usrId)->update([
            'apr_nombre'   => $request->nombre,
            'apr_apellido' => $request->apellido,
            'apr_programa' => $request->programa,
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
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendiz')->where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return back()->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $proyectos = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->leftJoin('instructor', 'proyecto.ins_usr_documento', '=', 'instructor.usr_documento')
            ->where('postulacion.apr_id', $aprendiz->apr_id)
            ->select(
                'postulacion.pos_id',
                'postulacion.pos_estado',
                'postulacion.pos_fecha',
                'proyecto.pro_id',
                'proyecto.pro_titulo_proyecto',
                'proyecto.pro_categoria',
                'proyecto.pro_estado',
                'proyecto.pro_fecha_publi',
                'proyecto.pro_fecha_finalizacion',
                'proyecto.pro_imagen_url',
                'empresa.emp_nombre',
                DB::raw('COALESCE(CONCAT(instructor.ins_nombre, " ", instructor.ins_apellido), "No asignado") as instructor_nombre')
            )
            ->orderByDesc('postulacion.pos_fecha')
            ->get();

        return view('aprendiz.historial', compact('proyectos'));
    }

    // ── MIS ENTREGAS (Reporte de seguimiento) ──
    public function misEntregas()
    {
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendiz')->where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return back()->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        // Proyectos aprobados
        $proyectos = DB::table('postulacion')
            ->join('proyecto', 'postulacion.pro_id', '=', 'proyecto.pro_id')
            ->join('empresa', 'proyecto.emp_nit', '=', 'empresa.emp_nit')
            ->where('postulacion.apr_id', $aprendiz->apr_id)
            ->where('postulacion.pos_estado', 'Aprobada')
            ->select('proyecto.*', 'empresa.emp_nombre')
            ->get();

        // Entregas por proyecto
        $entregas = DB::table('entrega_etapa')
            ->join('etapa', 'entrega_etapa.ene_eta_id', '=', 'etapa.eta_id')
            ->join('proyecto', 'entrega_etapa.ene_pro_id', '=', 'proyecto.pro_id')
            ->where('entrega_etapa.ene_apr_id', $aprendiz->apr_id)
            ->select(
                'entrega_etapa.*',
                'etapa.eta_nombre',
                'etapa.eta_orden',
                'proyecto.pro_titulo_proyecto',
                'proyecto.pro_id'
            )
            ->orderBy('entrega_etapa.ene_pro_id')
            ->orderBy('etapa.eta_orden')
            ->orderBy('entrega_etapa.ene_fecha', 'desc')
            ->get();

        // Evidencias
        $evidencias = DB::table('evidencia')
            ->join('etapa', 'evidencia.evid_eta_id', '=', 'etapa.eta_id')
            ->join('proyecto', 'evidencia.evid_pro_id', '=', 'proyecto.pro_id')
            ->where('evidencia.evid_apr_id', $aprendiz->apr_id)
            ->select(
                'evidencia.*',
                'etapa.eta_nombre',
                'etapa.eta_orden',
                'proyecto.pro_titulo_proyecto',
                'proyecto.pro_id'
            )
            ->orderBy('evidencia.evid_pro_id')
            ->orderBy('etapa.eta_orden')
            ->orderBy('evidencia.evid_fecha', 'desc')
            ->get();

        return view('aprendiz.mis-entregas', compact('proyectos', 'entregas', 'evidencias'));
    }
}
