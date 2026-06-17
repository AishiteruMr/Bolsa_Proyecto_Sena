<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPerfilRequest;
use App\Http\Requests\EnviarEvidenciaRequest;
use App\Models\Aprendiz;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Services\FileProcessingService;
use App\Services\PostulacionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AprendizController extends Controller
{
    public function __construct(private PostulacionService $postulacionService) {}

    public function dashboard(): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'Perfil de aprendiz no encontrado.');
        }

        $totalPostulaciones = $aprendiz->postulaciones()->count();
        $postulacionesAprobadas = $aprendiz->postulaciones()
            ->where('estado', 'aceptada')
            ->count();
        $proyectosDisponibles = Proyecto::activos()->count();

        $proyectosRecientes = Proyecto::with(['empresa', 'instructor.usuario'])
            ->activos()
            ->recientes()
            ->limit(6)
            ->get();

        $proyectosAprobadosQuery = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendiz?->id ?? 0)
            ->where('estado', 'aceptada');

        $proyectosAprobados = (clone $proyectosAprobadosQuery)->pluck('proyecto_id')->toArray();

        $proyectosAsociados = Proyecto::whereIn('id', $proyectosAprobados)->get();
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

    public function proyectos(Request $request): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontro tu perfil de aprendiz.');
        }

        $query = Proyecto::with('empresa')->activos();

        if ($request->filled('buscar')) {
            $query->busqueda($request->buscar);
        }

        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        $proyectos = $query->recientes()->paginate(9);

        $postulados = [];
        if ($aprendiz) {
            $postulados = DB::table('postulaciones')
                ->where('aprendiz_id', $aprendiz->id)
                ->pluck('proyecto_id')
                ->toArray();
        }

        $categorias = array_keys(config('programas'));

        return view('aprendiz.proyectos', compact('proyectos', 'postulados', 'categorias'));
    }

    public function postulacion(Request $request, int $id): RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = DB::table('aprendices')->where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return back()->with('error', 'Perfil de aprendiz no encontrado.');
        }

        [$exito, $mensaje] = $this->postulacionService->crear($aprendiz->id, $id);

        if (!$exito) {
            return back()->with('error', $mensaje);
        }

        return back()->with('success', 'Postulación enviada. Revisa tu correo.');
    }

    public function postular(Request $request, int $id): RedirectResponse
    {
        return $this->postulacion($request, $id);
    }

    public function misPostulaciones(): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontro tu perfil de aprendiz.');
        }

        $postulaciones = Postulacion::where('aprendiz_id', $aprendiz->id)
            ->with(['proyecto.empresa'])
            ->orderByDesc('fecha_postulacion')
            ->paginate(10);

        return view('aprendiz.postulaciones', compact('postulaciones'));
    }

    public function historial(Request $request): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontro tu perfil de aprendiz.');
        }

        $query = Postulacion::where('aprendiz_id', $aprendiz->id)
            ->with(['proyecto.empresa', 'proyecto.instructor'])
            ->orderByDesc('fecha_postulacion');

        $total = (clone $query)->count();
        $aprobadas = (clone $query)->where('estado', 'aceptada')->count();
        $pendientes = (clone $query)->where('estado', 'pendiente')->count();
        $rechazadas = (clone $query)->where('estado', 'rechazada')->count();

        $proyectos = $query->paginate($this->getPerPage($request, 10, 5, 30))
            ->through(function ($postulacion) {
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
                    'oferta' => $proyecto->oferta,
                    'oferta_otro' => $proyecto->oferta_otro,
                ];
            });

        return view('aprendiz.historial', compact('proyectos', 'total', 'aprobadas', 'pendientes', 'rechazadas'));
    }

    public function misEntregas(Request $request): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontro tu perfil de aprendiz.');
        }

        $proyectos = Proyecto::whereHas('postulaciones', function ($q) use ($aprendiz) {
            $q->where('aprendiz_id', $aprendiz->id)->where('estado', 'aceptada');
        })->with('empresa')
            ->paginate($this->getPerPage($request, 10, 5, 30))
            ->through(function ($p) {
                $p->emp_nombre = $p->empresa->nombre ?? 'No asignada';
                return $p;
            });

        $entregas = collect([]);
        $evidencias = $aprendiz->evidencias()
            ->with(['etapa', 'proyecto'])
            ->orderBy('proyecto_id')
            ->get();

        return view('aprendiz.mis-entregas', compact('proyectos', 'entregas', 'evidencias'));
    }

    public function verDetalleProyecto(int $proId): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontro tu perfil de aprendiz.');
        }

        $proyecto = Proyecto::with(['empresa', 'instructor'])->findOrFail($proId);
        $proyecto->emp_nombre = $proyecto->empresa->nombre ?? 'No asignada';
        $proyecto->instructor_nombre = $proyecto->instructor
            ? $proyecto->instructor->nombres.' '.$proyecto->instructor->apellidos
            : 'No asignado';

        $postulacion = Postulacion::where('aprendiz_id', $aprendiz->id)
            ->where('proyecto_id', $proId)
            ->first();

        if ($postulacion && $postulacion->estado === 'aceptada') {
            $etapas = $proyecto->etapasOrdenadas();

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

        [$puedePostular, $mensaje] = $this->postulacionService->puedePostular($aprendiz->id, $proId);

        return view('aprendiz.detalle-proyecto-publico', compact(
            'proyecto',
            'aprendiz',
            'postulacion',
            'puedePostular',
            'mensaje'
        ));
    }

    public function enviarEvidencia(EnviarEvidenciaRequest $request, int $proId, int $etaId): RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->firstOrFail();

        $postulacion = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendiz->id)
            ->where('proyecto_id', $proId)
            ->where('estado', 'aceptada')
            ->firstOrFail();

        $etapa = Etapa::where('id', $etaId)
            ->where('proyecto_id', $proId)
            ->firstOrFail();

        $existing = Evidencia::where('aprendiz_id', $aprendiz->id)
            ->where('etapa_id', $etaId)
            ->where('proyecto_id', $proId)
            ->whereIn('estado', ['aceptada', 'rechazada'])
            ->first();

        if ($existing) {
            return back()->with('error', 'No puedes enviar más evidencias para esta etapa porque ya fue evaluada.');
        }

        $archivoUrl = null;
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');

            $mime = $file->getMimeType();
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedMimes = [
                'application/pdf' => 'pdf',
                'image/jpeg' => ['jpg', 'jpeg'],
                'image/png' => 'png',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/vnd.ms-excel' => 'xls',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            ];

            $allowedExts = array_unique(array_merge(...array_map(fn($v) => (array) $v, array_values($allowedMimes))));
            if (!in_array($extension, $allowedExts)) {
                return back()->with('error', 'Extensión no permitida: .'.$extension);
            }

            if (!isset($allowedMimes[$mime])) {
                return back()->with('error', 'Tipo de archivo no permitido.');
            }

            $validExts = is_array($allowedMimes[$mime]) ? $allowedMimes[$mime] : [$allowedMimes[$mime]];
            if (!in_array($extension, $validExts)) {
                return back()->with('error', 'El archivo no coincide con su formato.');
            }

            $fileService = new FileProcessingService();
            $path = $fileService->processUpload($file, 'evidencias', [
                'watermark' => true,
                'scan_virus' => config('app.env') === 'production',
            ]);

            if (!$path) {
                return back()->with('error', 'Error al procesar el archivo.');
            }

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

        return back()->with('success', 'Evidencia enviada.');
    }

    public function perfil(): View|RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->first();

        if (!$aprendiz) {
            return redirect()->route('login')->with('error', 'No se encontro tu perfil de aprendiz.');
        }

        $usuario = User::findOrFail($usrId);

        return view('aprendiz.perfil', compact('aprendiz', 'usuario'));
    }

    public function actualizarPerfil(ActualizarPerfilRequest $request): RedirectResponse
    {
        $usrId = session('usr_id');
        $aprendiz = Aprendiz::where('usuario_id', $usrId)->firstOrFail();

        $aprendiz->update([
            'nombres' => $request->nombre,
            'apellidos' => $request->apellido,
        ]);

        if ($request->filled('password')) {
            $usuario = User::findOrFail($usrId);
            $usuario->update([
                'contrasena' => Hash::make($request->password),
            ]);
        }

        session(['nombre' => $request->nombre, 'apellido' => $request->apellido]);

        return back()->with('success', 'Perfil actualizado.');
    }
}