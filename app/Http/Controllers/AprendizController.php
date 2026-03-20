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

class AprendizController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════════════════════════

    public function dashboard()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        $totalPostulaciones = $aprendiz->countPostulaciones();
        $postulacionesAprobadas = $aprendiz->countPostulacionesAprobadas();
        $proyectosDisponibles = Proyecto::activos()->count();

        $proyectosRecientes = Proyecto::with('empresa')
            ->activos()
            ->recientes()
            ->limit(6)
            ->get();

        $proyectosAprobados = $aprendiz->postulacionesAprobadas()
            ->pluck('pro_id')
            ->toArray();

        return view('aprendiz.dashboard', compact(
            'aprendiz',
            'totalPostulaciones',
            'postulacionesAprobadas',
            'proyectosDisponibles',
            'proyectosRecientes',
            'proyectosAprobados'
        ));
    }

    // ══════════════════════════════════════════════════════════════
    // EXPLORAR PROYECTOS
    // ══════════════════════════════════════════════════════════════

    public function proyectos(Request $request)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

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
        $postulados = $aprendiz->postulaciones()
            ->pluck('pro_id')
            ->toArray();

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
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        // Validar que pueda postularse
        [$esValido, $mensaje] = Postulacion::validarPostulacion($aprendiz->apr_id, $id);

        if (!$esValido) {
            return back()->with('warning', $mensaje);
        }

        // Crear postulación
        Postulacion::create([
            'apr_id'     => $aprendiz->apr_id,
            'pro_id'     => $id,
            'pos_fecha'  => now(),
            'pos_estado' => 'Pendiente',
        ]);

        return back()->with('success', '✅ Postulación enviada correctamente. Espera la revisión del instructor.');
    }

    // ══════════════════════════════════════════════════════════════
    // MIS POSTULACIONES
    // ══════════════════════════════════════════════════════════════

    public function misPostulaciones()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        $postulaciones = $aprendiz->postulaciones()
            ->with(['proyecto' => function ($query) {
                $query->with('empresa');
            }])
            ->recientes()
            ->paginate(10);

        return view('aprendiz.postulaciones', compact('postulaciones'));
    }

    // ══════════════════════════════════════════════════════════════
    // HISTORIAL DE PROYECTOS
    // ══════════════════════════════════════════════════════════════

    public function historial()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        $proyectos = $aprendiz->postulaciones()
            ->with(['proyecto' => function ($query) {
                $query->with('empresa');
            }])
            ->recientes()
            ->get()
            ->map(function ($postulacion) {
                $proyecto = $postulacion->proyecto;
                $proyecto->pos_estado = $postulacion->pos_estado;
                $proyecto->pos_fecha = $postulacion->pos_fecha;
                $proyecto->instructor_nombre = $proyecto->instructor?->getFullNameAttribute() ?? 'No asignado';
                return $proyecto;
            });

        return view('aprendiz.historial', compact('proyectos'));
    }

    // ══════════════════════════════════════════════════════════════
    // MIS ENTREGAS Y EVIDENCIAS
    // ══════════════════════════════════════════════════════════════

    public function misEntregas()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        // Proyectos aprobados del aprendiz
        $proyectos = $aprendiz->proyectosAprobados()
            ->get()
            ->map(fn($postulacion) => $postulacion->proyecto->load('empresa'));

        // Evidencias del aprendiz
        $evidencias = $aprendiz->evidencias()
            ->with(['etapa', 'proyecto'])
            ->orderBy('evid_pro_id')
            ->orderBy('evid_fecha', 'desc')
            ->get();

        return view('aprendiz.mis-entregas', compact('proyectos', 'evidencias'));
    }

    // ══════════════════════════════════════════════════════════════
    // VER DETALLE DE PROYECTO APROBADO
    // ══════════════════════════════════════════════════════════════

    public function verDetalleProyecto(int $proId)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();

        // Verificar que el aprendiz está aprobado en este proyecto
        $postulacion = $aprendiz->postulacionesAprobadas()
            ->where('pro_id', $proId)
            ->firstOrFail();

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

        // Validar que está aprobado en el proyecto
        $postulacion = $aprendiz->postulacionesAprobadas()
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
            $archivoUrl = $request->file('archivo')->store('evidencias', 'public');
        }

        // Crear evidencia
        Evidencia::create([
            'evid_apr_id'     => $aprendiz->apr_id,
            'evid_eta_id'     => $etaId,
            'evid_pro_id'     => $proId,
            'evid_archivo'    => $archivoUrl,
            'evid_fecha'      => now(),
            'evid_estado'     => 'Pendiente',
            'evid_comentario' => null,
        ]);

        return back()->with('success', '✅ Evidencia enviada correctamente. El instructor la revisará.');
    }

    // ══════════════════════════════════════════════════════════════
    // PERFIL
    // ══════════════════════════════════════════════════════════════

    public function perfil()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usr_id', $usrId)->firstOrFail();
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
