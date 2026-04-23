<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProyectoApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
            'buscar' => 'nullable|string|max:100',
            'estado' => 'nullable|string|in:pendiente,aprobado,rechazado,cerrado,en_progreso',
            'categoria' => 'nullable|string|max:50',
        ]);

        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 6);

        $query = Proyecto::with(['empresa', 'instructor.usuario'])
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->orderByDesc('id');

        if ($request->filled('buscar')) {
            $buscar = addcslashes($request->buscar, '%_\\');
            $query->where(function ($q) use ($buscar) {
                $q->whereRaw('titulo LIKE ?', ["%{$buscar}%"])
                    ->orWhereRaw('descripcion LIKE ?', ["%{$buscar}%"])
                    ->orWhereHas('empresa', function ($q) use ($buscar) {
                        $q->whereRaw('nombre LIKE ?', ["%{$buscar}%"]);
                    });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $total = $query->count();
        $proyectos = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'data' => $proyectos->map(fn($p) => [
                'id' => $p->id,
                'titulo' => $p->titulo,
                'descripcion' => Str::limit($p->descripcion, 100),
                'empresa_nombre' => $p->empresa->nombre ?? 'N/A',
                'estado' => $p->estado,
                'categoria' => $p->categoria,
                'fecha_publicacion' => $p->fecha_publicacion?->format('d/m/Y'),
                'imagen_url' => $p->imagen_url,
            ]),
            'current_page' => (int) $page,
            'per_page' => $perPage,
            'total' => $total,
            'has_more' => ($page * $perPage) < $total,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $proyecto = Proyecto::with(['empresa', 'instructor'])
            ->whereIn('estado', ['aprobado', 'en_progreso'])
            ->find($id);

        if (!$proyecto) {
            return response()->json(['error' => 'Proyecto no encontrado'], 404);
        }

        return response()->json([
            'id' => $proyecto->id,
            'titulo' => $proyecto->titulo,
            'descripcion' => $proyecto->descripcion,
            'categoria' => $proyecto->categoria,
            'requisitos' => $proyecto->requisitos_especificos,
            'habilidades' => $proyecto->habilidades_requeridas,
            'empresa' => [
                'nombre' => $proyecto->empresa->nombre ?? 'N/A',
                'nit' => $proyecto->empresa->nit ?? null,
            ],
            'instructor' => $proyecto->instructor ? [
                'nombre' => $proyecto->instructor->nombres.' '.$proyecto->instructor->apellidos,
            ] : null,
            'estado' => $proyecto->estado,
            'fecha_publicacion' => $proyecto->fecha_publicacion?->format('d/m/Y'),
            'duracion_dias' => $proyecto->duracion_estimada_dias,
            'imagen_url' => $proyecto->imagen_url,
        ]);
    }

    public function postulaciones(Request $request, int $id): JsonResponse
    {
        $request->validate(['page' => 'integer|min:1', 'per_page' => 'integer|min:1|max:50']);

        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return response()->json(['error' => 'Proyecto no encontrado'], 404);
        }

        $user = $request->user();
        $aprendiz = Aprendiz::where('usuario_id', $user->id)->first();

        if (!$aprendiz) {
            return response()->json(['error' => 'Perfil de aprendiz no encontrado'], 403);
        }

        $yaPostulado = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendiz->id)
            ->where('proyecto_id', $id)
            ->exists();

        $fechaLimite = Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias ?? 0);
        $puedePostular = !$yaPostulado 
            && in_array($proyecto->estado, ['aprobado', 'en_progreso'])
            && $proyecto->fecha_publicacion
            && !$proyecto->fecha_publicacion->isFuture()
            && now()->lessThanOrEqualTo($fechaLimite);

        $maxPostulaciones = 5;
        $totalPostulaciones = DB::table('postulaciones')
            ->where('aprendiz_id', $aprendiz->id)
            ->whereIn('estado', ['pendiente', 'en_revision'])
            ->count();
        $alcanzoLimite = $totalPostulaciones >= $maxPostulaciones;

        return response()->json([
            'ya_postulado' => $yaPostulado,
            'puede_postular' => $puedePostular && !$alcanzoLimite,
            'estado_postulacion' => DB::table('postulaciones')
                ->where('aprendiz_id', $aprendiz->id)
                ->where('proyecto_id', $id)
                ->value('estado'),
            'alcanzo_limite' => $alcanzoLimite,
            'postulaciones_activas' => $totalPostulaciones,
            'max_postulaciones' => $maxPostulaciones,
        ]);
    }
}