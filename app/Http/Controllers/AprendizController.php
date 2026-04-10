<?php

namespace App\Http\Controllers;

use App\Mail\PostulacionExitosa;
use App\Models\Aprendiz;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Notifications\AppNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AprendizController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════════════════════════

    public function dashboard()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $totalPostulaciones = $aprendiz->postulaciones()->count();
        $postulacionesAprobadas = $aprendiz->postulaciones()
            ->where('estado', 'aceptada')
            ->count();
        $proyectosDisponibles = Proyecto::activos()->count();

        $proyectosRecientes = Proyecto::with('empresa')
            ->activos()
            ->recientes()
            ->limit(6)
            ->get();

        // Obtener IDs de proyectos con postulación aprobada
        $proyectosAprobadosQuery = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendiz?->id ?? 0)
            ->where('estado', 'aceptada');

        $proyectosAprobados = (clone $proyectosAprobadosQuery)->pluck('proyecto_id')->toArray();

        // Próxima fecha de cierre de sus proyectos (recalculada por duración + publicacion)
        // Ya no hay `fecha_finalizacion` en DB, lo traemos por Colección (ya que usamos append isVencido o similar)
        // Para DB, si necesitamos fecha, usamos DB raw o tomamos en memoria si son pocos:
        $proyectosAsociados = Proyecto::whereIn('id', $proyectosAprobados)->get();
        // Ordenarlos por la estimación (fecha_publicacion + duracion_estimada_dias) que esté en el futuro
        $proximoCierre = $proyectosAsociados->filter(function ($p) {
            $fechaFin = Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);

            return $fechaFin->isFuture();
        })->sortBy(function ($p) {
            return Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 0);
        })->first();

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
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
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
            $postulados = DB::table('postulaciones')
                ->where('aprendiz_id', $aprendiz->id)
                ->pluck('proyecto_id')
                ->toArray();
        }

        // Obtener categorías disponibles
        $categorias = Proyecto::whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria')
            ->toArray();

        return view('aprendiz.proyectos', compact('proyectos', 'postulados', 'categorias'));
    }

    // ══════════════════════════════════════════════════════════════
    // POSTULAR A PROYECTO
    // ══════════════════════════════════════════════════════════════

    public function postular(Request $request, int $id)
    {
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendices')->where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
            return back()->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $yaPostulado = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendiz->id)
            ->where('proyecto_id', $id)
            ->exists();

        if ($yaPostulado) {
            return back()->with('warning', 'Ya te postulaste a este proyecto.');
        }

        DB::table('postulaciones')->insert([
            'aprendiz_id' => $aprendiz->id,
            'proyecto_id' => $id,
            'fecha_postulacion' => now(),
            'estado' => 'pendiente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ── Email de confirmación ──────────────────────────────────
        try {
            $proyecto = Proyecto::find($id);
            $usuCorreo = DB::table('usuarios')->where('id', $aprendiz->usuario_id)->value('correo');
            if ($usuCorreo && $proyecto) {
                Mail::to($usuCorreo)->send(
                    new PostulacionExitosa($aprendiz->nombres, $proyecto)
                );
            }
        } catch (\Exception $e) {
            Log::error('Error enviando email de postulación: '.$e->getMessage());
        }

        // ── Notificación en BD ────────────────────────────────────
        try {
            $aprendizUsr = User::find($aprendiz->usuario_id);
            if ($aprendizUsr) {
                $aprendizUsr->notify(new AppNotification(
                    '🎉 Postulación enviada',
                    'Tu postulación al proyecto fue registrada. Pronto recibirás una respuesta.',
                    'fa-paper-plane'
                ));
            }

            if ($proyecto && $proyecto->instructor_usuario_id) {
                $instUsr = User::find($proyecto->instructor_usuario_id);
                if ($instUsr) {
                    $instUsr->notify(new AppNotification(
                        'Nueva Postulación',
                        'El aprendiz '.$aprendiz->nombres.' se ha postulado a tu proyecto: '.Str::limit($proyecto->titulo, 30),
                        'fa-user-plus'
                    ));
                }
            }
        } catch (\Exception $e) {
            Log::warning('Error en notificaciones: '.$e->getMessage());
        }

        return back()->with('success', '🎉 ¡Postulación enviada! Revisa tu correo para la confirmación.');
    }

    // ══════════════════════════════════════════════════════════════
    // MIS POSTULACIONES
    // ══════════════════════════════════════════════════════════════

    public function misPostulaciones()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $postulaciones = Postulacion::where('aprendiz_id', $aprendiz->id)
            ->with(['proyecto.empresa'])
            ->orderByDesc('fecha_postulacion')
            ->paginate(10);

        return view('aprendiz.postulaciones', compact('postulaciones'));
    }

    // ══════════════════════════════════════════════════════════════
    // HISTORIAL DE PROYECTOS
    // ══════════════════════════════════════════════════════════════

    public function historial()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        $proyectos = Postulacion::where('aprendiz_id', $aprendiz->id)
            ->with(['proyecto.empresa', 'proyecto.instructor'])
            ->orderByDesc('fecha_postulacion')
            ->get()
            ->map(function ($postulacion) {
                $proyecto = $postulacion->proyecto;

                return (object) [
                    'id' => $postulacion->id,
                    'estado' => $postulacion->estado,
                    'fecha_postulacion' => $postulacion->fecha_postulacion,
                    'pro_id' => $proyecto->id,
                    'titulo' => $proyecto->titulo,
                    'categoria' => $proyecto->categoria,
                    'pro_estado' => $proyecto->estado,
                    'fecha_publi' => $proyecto->fecha_publicacion,
                    'fecha_finalizacion' => $proyecto->fecha_publicacion
                        ? Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias)
                        : null,
                    'imagen_url' => $proyecto->imagen_url,
                    'nombre' => $proyecto->empresa->nombre ?? 'No asignada',
                    'instructor_nombre' => $proyecto->instructor
                        ? $proyecto->instructor->nombres.' '.$proyecto->instructor->apellidos
                        : 'No asignado',
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
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        // Proyectos aprobados con empresa
        $proyectos = Proyecto::whereHas('postulaciones', function ($q) use ($aprendiz) {
            $q->where('aprendiz_id', $aprendiz->id)->where('estado', 'aceptada');
        })->with('empresa')->get()
            ->map(function ($p) {
                $p->emp_nombre = $p->empresa->nombre ?? 'No asignada';

                return $p;
            });

        // Entregas por proyecto (entregas de etapas del instructor, aunque antes decia $aprendiz->entregas(), lo revisaremos)
        // El aprendiz no tiene "entregas()" genericas, era Evidencia.
        $entregas = collect([]);

        // Evidencias (estas son las entregas del aprendiz)
        $evidencias = $aprendiz->evidencias()
            ->with(['etapa', 'proyecto'])
            ->orderBy('proyecto_id')
            ->get();

        return view('aprendiz.mis-entregas', compact('proyectos', 'entregas', 'evidencias'));
    }

    // ══════════════════════════════════════════════════════════════
    // VER DETALLE DE PROYECTO APROBADO
    // ══════════════════════════════════════════════════════════════

    public function verDetalleProyecto(int $proId)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontró tu perfil de aprendiz.');
        }

        // Verificar que el aprendiz está aprobado en este proyecto
        $postulacion = Postulacion::where('aprendiz_id', $aprendiz->id)
            ->where('proyecto_id', $proId)
            ->first();

        if (! $postulacion) {
            return back()->with('error', 'No tienes acceso a este proyecto o no has sido aprobado.');
        }

        // Obtener el proyecto con sus relaciones
        $proyecto = Proyecto::with(['empresa', 'instructor'])
            ->findOrFail($proId);

        // Agregar nombres para acceso directo en la vista
        $proyecto->emp_nombre = $proyecto->empresa->nombre ?? 'No asignada';
        $proyecto->instructor_nombre = $proyecto->instructor
            ? $proyecto->instructor->nombres.' '.$proyecto->instructor->apellidos
            : 'No asignado';

        // Obtener etapas del proyecto
        $etapas = $proyecto->etapasOrdenadas();

        // Obtener evidencias del aprendiz para este proyecto
        $evidencias = $aprendiz->evidencias()
            ->where('evidencias.proyecto_id', $proId)
            ->with('etapa')
            ->join('etapas', 'evidencias.etapa_id', '=', 'etapas.id')
            ->select(
                'evidencias.*',
                'etapas.nombre as eta_nombre',
                'etapas.orden as eta_orden'
            )
            ->orderBy('etapas.orden')
            ->orderByDesc('evidencias.fecha_envio')
            ->get();

        return view('aprendiz.detalle-proyecto', compact('proyecto', 'etapas', 'evidencias', 'aprendiz'));
    }

    // ══════════════════════════════════════════════════════════════
    // ENVIAR EVIDENCIA
    // ══════════════════════════════════════════════════════════════

    public function enviarEvidencia(Request $request, int $proId, int $etaId)
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->firstOrFail();

        // Verificar que está aprobado en el proyecto
        $postulacion = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendiz->id)
            ->where('proyecto_id', $proId)
            ->firstOrFail();

        // Validar que la etapa pertenece al proyecto
        $etapa = Etapa::where('id', $etaId)
            ->where('proyecto_id', $proId)
            ->firstOrFail();

        // Validar datos
        $request->validate([
            'descripcion' => 'required|string|max:1000',
            'archivo' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', // 5MB, tipos permitidos
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres.',
            'archivo.max' => 'El archivo no puede ser mayor a 5MB.',
            'archivo.mimes' => 'Tipo de archivo no permitido. Solo: PDF, imágenes, Word, Excel.',
        ]);

        // Guardar archivo si existe
        $archivoUrl = null;
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');

            // Validar MIME real del archivo
            $mime = $file->getMimeType();
            $allowedMimes = [
                'application/pdf',
                'image/jpeg',
                'image/png',
                'image/jpg',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ];

            if (! in_array($mime, $allowedMimes)) {
                return back()->with('error', 'Tipo de archivo no permitido.');
            }

            // Generar nombre seguro (sin path traversal)
            $extension = $file->getClientOriginalExtension();
            $safeFilename = 'evidencia_'.$aprendiz->id.'_'.time().'_'.bin2hex(random_bytes(4)).'.'.$extension;
            $path = $file->storeAs('evidencias', $safeFilename, 'public');
            $archivoUrl = $path;
        }

        DB::table('evidencias')->insert([
            'aprendiz_id' => $aprendiz->id,
            'etapa_id' => $etaId,
            'proyecto_id' => $proId,
            'ruta_archivo' => $archivoUrl,
            'fecha_envio' => now(),
            'estado' => 'pendiente',
            'comentario_instructor' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', '✅ Evidencia enviada correctamente. El instructor la revisará.');
    }

    // ══════════════════════════════════════════════════════════════
    // PERFIL
    // ══════════════════════════════════════════════════════════════

    public function perfil()
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (! $aprendiz) {
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
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->firstOrFail();

        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'programa' => 'required|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
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
            'nombres' => $request->nombre,
            'apellidos' => $request->apellido,
            'programa_formacion' => $request->programa,
        ]);

        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $usuario = User::findOrFail($usrId);
            $usuario->update([
                'contrasena' => Hash::make($request->password),
            ]);
        }

        // Actualizar sesión
        session(['nombre' => $request->nombre, 'apellido' => $request->apellido]);

        return back()->with('success', '✅ Perfil actualizado correctamente.');
    }
}
