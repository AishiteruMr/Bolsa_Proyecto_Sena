<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use App\Models\Proyecto;
use App\Models\Postulacion;
use App\Models\Evidencia;
use App\Models\Etapa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\PostulacionExitosa;

class AprendizController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════════════════════════

    public function dashboard()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $totalPostulaciones = $aprendiz->postulaciones()->count();
        $postulacionesAprobadas = $aprendiz->postulaciones()
            ->where('pos_estado', 'Aprobada')
            ->count();
        $proyectosDisponibles = Proyecto::activos()->count();

        $proyectosRecientes = Proyecto::with('empresa')
            ->activos()
            ->recientes()
            ->limit(6)
            ->get();

        // Obtener IDs de proyectos con postulación aprobada
        $proyectosAprobadosQuery = DB::table('postulacion')
            ->where('apr_id', $aprendiz?->apr_id ?? 0)
            ->where('pos_estado', 'Aprobada');
        
        $proyectosAprobados = (clone $proyectosAprobadosQuery)->pluck('pro_id')->toArray();

        // Próxima fecha de cierre de sus proyectos
        $proximoCierre = Proyecto::whereIn('pro_id', $proyectosAprobados)
            ->where('pro_fecha_finalizacion', '>', now())
            ->orderBy('pro_fecha_finalizacion')
            ->first();

        return view('aprendiz.dashboard', compact(
            'aprendiz',
            'totalPostulaciones',
            'postulacionesAprobadas',
            'proyectosDisponibles',
            'proyectosRecientes',
            'proyectosAprobados',
            'proximoCierre'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // EXPLORAR PROYECTOS
    // ══════════════════════════════════════════════════════════════

    public function proyectos(Request $request)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $query = Proyecto::with('empresa')
            ->activos();

        // Búsqueda por título
        if ($request->filled('buscar')) {
            $query->busqueda($request->buscar);
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        $proyectos = $query->recientes()->paginate(9);

        // IDs de proyectos donde ya postuló
        $postulados = [];
        if ($aprendiz) {
            $postulados = DB::table('postulacion')
                ->where('apr_id', $aprendiz->apr_id)
                ->pluck('pro_id')
                ->toArray();
        }

        // Obtener categorías disponibles
        $categorias = Proyecto::distinct()->pluck('pro_categoria');

        return view('aprendiz.proyectos', compact('proyectos', 'postulados', 'categorias'));
    }

    // ══════════════════════════════════════════════════════════════
    // POSTULAR A PROYECTO
    // ══════════════════════════════════════════════════════════════

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

        // ── Email de confirmación ──────────────────────────────────
        try {
            $proyecto  = \App\Models\Proyecto::find($id);
            $usuCorreo = DB::table('usuario')->where('usr_id', $aprendiz->usr_id)->value('usr_correo');
            if ($usuCorreo && $proyecto) {
                Mail::to($usuCorreo)->send(
                    new PostulacionExitosa($aprendiz->apr_nombre, $proyecto)
                );
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email de postulación: ' . $e->getMessage());
        }

        // ── Notificación en BD ────────────────────────────────────
        try {
            DB::table('notificacion')->insert([
                'usr_id'       => $aprendiz->usr_id,
                'noti_titulo'  => '🎉 Postulación enviada',
                'noti_mensaje' => 'Tu postulación al proyecto fue registrada. Pronto recibirás una respuesta.',
                'noti_leida'   => 0,
                'noti_fecha'   => now(),
            ]);
        } catch (\Exception $e) {
            Log::warning('Tabla notificacion no encontrada o error: ' . $e->getMessage());
        }

        return back()->with('success', '🎉 ¡Postulación enviada! Revisa tu correo para la confirmación.');
    }

    // ══════════════════════════════════════════════════════════════
    // MIS POSTULACIONES
    // ══════════════════════════════════════════════════════════════

    public function misPostulaciones()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $postulaciones = Postulacion::where('apr_id', $aprendiz->apr_id)
            ->with(['proyecto.empresa'])
            ->orderByDesc('pos_fecha')
            ->paginate(10);

        return view('aprendiz.postulaciones', compact('postulaciones'));
    }

    // ══════════════════════════════════════════════════════════════
    // HISTORIAL DE PROYECTOS
    // ══════════════════════════════════════════════════════════════

    public function historial()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $proyectos = Postulacion::where('apr_id', $aprendiz->apr_id)
            ->with(['proyecto.empresa', 'proyecto.instructor'])
            ->orderByDesc('pos_fecha')
            ->get()
            ->map(function($postulacion) {
                $proyecto = $postulacion->proyecto;
                return (object)[
                    'pos_id' => $postulacion->pos_id,
                    'pos_estado' => $postulacion->pos_estado,
                    'pos_fecha' => $postulacion->pos_fecha,
                    'pro_id' => $proyecto->pro_id,
                    'pro_titulo_proyecto' => $proyecto->pro_titulo_proyecto,
                    'pro_categoria' => $proyecto->pro_categoria,
                    'pro_estado' => $proyecto->pro_estado,
                    'pro_fecha_publi' => $proyecto->pro_fecha_publi,
                    'pro_fecha_finalizacion' => $proyecto->pro_fecha_finalizacion,
                    'pro_imagen_url' => $proyecto->pro_imagen_url,
                    'emp_nombre' => $proyecto->empresa->emp_nombre,
                    'instructor_nombre' => $proyecto->instructor 
                        ? $proyecto->instructor->ins_nombre . " " . $proyecto->instructor->ins_apellido 
                        : "No asignado"
                ];
            });

        return view('aprendiz.historial', compact('proyectos'));
    }

    // ══════════════════════════════════════════════════════════════
    // MIS ENTREGAS Y EVIDENCIAS
    // ══════════════════════════════════════════════════════════════

    public function misEntregas()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        // Proyectos aprobados con empresa
        $proyectos = Proyecto::whereHas('postulaciones', function($q) use ($aprendiz) {
            $q->where('apr_id', $aprendiz->apr_id)->where('pos_estado', 'Aprobada');
        })->with('empresa')->get()
          ->map(function($p) {
              $p->emp_nombre = $p->empresa->emp_nombre;
              return $p;
          });

        // Entregas por proyecto
        $entregas = $aprendiz->entregas()
            ->with(['etapa', 'proyecto'])
            ->orderBy('ene_pro_id')
            ->get();

        // Evidencias
        $evidencias = $aprendiz->evidencias()
            ->with(['etapa', 'proyecto'])
            ->orderBy('evid_pro_id')
            ->get();

        return view('aprendiz.mis-entregas', compact('proyectos', 'entregas', 'evidencias'));
    }

    // ══════════════════════════════════════════════════════════════
    // VER DETALLE DE PROYECTO APROBADO
    // ══════════════════════════════════════════════════════════════

    public function verDetalleProyecto(int $proId)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        // Verificar que el aprendiz está aprobado en este proyecto
        $postulacion = Postulacion::where('apr_id', $aprendiz->apr_id)
            ->where('pro_id', $proId)
            ->first();

        if (!$postulacion) {
            return back()->with('error', 'No tienes acceso a este proyecto o no has sido aprobado.');
        }

        // Obtener el proyecto con sus relaciones
        $proyecto = Proyecto::with(['empresa', 'instructor'])
            ->findOrFail($proId);

        // Obtener etapas del proyecto
        $etapas = $proyecto->etapasOrdenadas();

        // Obtener evidencias del aprendiz para este proyecto
        $evidencias = $aprendiz->evidencias()
            ->where('evid_pro_id', $proId)
            ->with('etapa')
            ->join('etapa', 'evidencia.evid_eta_id', '=', 'etapa.eta_id')
            ->where('evidencia.evid_pro_id', $proId)
            ->where('evidencia.evid_apr_id', $aprendiz->apr_id)
            ->select(
                'evidencia.*',
                'etapa.eta_nombre',
                'etapa.eta_orden'
            )
            ->orderBy('etapa.eta_orden')
            ->orderByDesc('evid_fecha')
            ->select('evidencia.*')
            ->get();

        return view('aprendiz.detalle-proyecto', compact('proyecto', 'etapas', 'evidencias', 'aprendiz'));
    }

    // ══════════════════════════════════════════════════════════════
    // ENVIAR EVIDENCIA
    // ══════════════════════════════════════════════════════════════

    public function enviarEvidencia(Request $request, int $proId, int $etaId)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        // Verificar que está aprobado en el proyecto
        $postulacion = DB::table('postulacion')
            ->where('apr_id', $aprendiz->apr_id)
            ->where('pro_id', $proId)
            ->firstOrFail();

        // Validar que la etapa pertenece al proyecto
        $etapa = Etapa::where('eta_id', $etaId)
            ->where('eta_pro_id', $proId)
            ->firstOrFail();

        // Validar datos
        $request->validate([
            'descripcion' => 'required|string|max:1000',
            'archivo'     => 'nullable|file|max:5120', // 5MB máximo
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres.',
            'archivo.max' => 'El archivo no puede ser mayor a 5MB.',
        ]);

        // Guardar archivo si existe
        $archivoUrl = null;
        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('evidencias', 'public');
            $archivoUrl = $path;
        }

        DB::table('evidencia')->insert([
            'evid_apr_id'    => $aprendiz->apr_id,
            'evid_eta_id'    => $etaId,
            'evid_pro_id'    => $proId,
            'evid_archivo'   => $archivoUrl,
            'evid_fecha'     => now(),
            'evid_estado'    => 'Pendiente',
            'evid_comentario'=> null,
        ]);

        return back()->with('success', '✅ Evidencia enviada correctamente. El instructor la revisará.');
    }

    // ══════════════════════════════════════════════════════════════
    // PERFIL
    // ══════════════════════════════════════════════════════════════

    public function perfil()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $usuario = User::findOrFail($usrId);

        return view('aprendiz.perfil', compact('aprendiz', 'usuario'));
    }

    // ══════════════════════════════════════════════════════════════
    // ACTUALIZAR PERFIL
    // ══════════════════════════════════════════════════════════════

    public function actualizarPerfil(Request $request)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        // Validar datos
        $request->validate([
            'nombre'    => 'required|string|max:50',
            'apellido'  => 'required|string|max:50',
            'programa'  => 'required|string|max:100',
            'password'  => 'nullable|string|min:6|confirmed',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede exceder 50 caracteres.',
            'programa.required' => 'El programa de formación es obligatorio.',
            'programa.max' => 'El programa no puede exceder 100 caracteres.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Actualizar aprendiz
        $aprendiz->update([
            'apr_nombre'   => $request->nombre,
            'apr_apellido' => $request->apellido,
            'apr_programa' => $request->programa,
        ]);

        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $usuario = User::findOrFail($usrId);
            $usuario->update([
                'usr_contrasena' => Hash::make($request->password),
            ]);
        }

        // Actualizar sesión
        session(['nombre' => $request->nombre, 'apellido' => $request->apellido]);

        return back()->with('success', '✅ Perfil actualizado correctamente.');
    }
}
