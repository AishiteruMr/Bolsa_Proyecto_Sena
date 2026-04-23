<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InfiniteScrollController extends Controller
{
    public function proyectos(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 6;

        $query = Proyecto::with(['empresa', 'instructor.usuario'])->orderByDesc('id');

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
            'data' => $proyectos->map(function ($p) {
                return [
                    'id' => $p->id,
                    'titulo' => $p->titulo,
                    'descripcion' => Str::limit($p->descripcion, 100),
                    'empresa_nombre' => $p->empresa->nombre ?? 'N/A',
                    'estado' => $p->estado,
                    'categoria' => $p->categoria,
                    'fecha_publicacion' => $p->fecha_publicacion?->format('d/m/Y'),
                    'imagen_url' => $p->imagen_url,
                ];
            }),
            'current_page' => (int) $page,
            'per_page' => $perPage,
            'total' => $total,
            'has_more' => ($page * $perPage) < $total,
        ]);
    }

    public function aprendices(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = Aprendiz::with('usuario')->orderByDesc('id');

        if ($request->filled('buscar')) {
            $buscar = addcslashes($request->buscar, '%_\\');
            $query->where(function ($q) use ($buscar) {
                $q->whereRaw('correo LIKE ?', ["%{$buscar}%"])
                    ->orWhereRaw('programa LIKE ?', ["%{$buscar}%"]);
            });
        }

        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo' ? 1 : 0);
        }

        $total = $query->count();
        $aprendices = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'data' => $aprendices->map(function ($a) {
                return [
                    'id' => $a->id,
                    'nombre' => trim(($a->usuario->nombre ?? '').' '.($a->usuario->apellido ?? '')),
                    'correo' => $a->usuario->correo ?? 'N/A',
                    'programa' => $a->programa,
                    'activo' => (bool) $a->activo,
                ];
            }),
            'current_page' => (int) $page,
            'per_page' => $perPage,
            'total' => $total,
            'has_more' => ($page * $perPage) < $total,
        ]);
    }

    public function proyectosEmpresa(Request $request)
    {
        $empId = session('emp_id');
        $page = $request->get('page', 1);
        $perPage = 6;

        $query = Proyecto::where('empresa_nit', $empId)
            ->with('postulaciones')
            ->orderByDesc('id');

        $total = $query->count();
        $proyectos = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

        return response()->json([
            'data' => $proyectos->map(function ($p) {
                return [
                    'id' => $p->id,
                    'titulo' => $p->titulo,
                    'estado' => $p->estado,
                    'fecha_publicacion' => $p->fecha_publicacion?->format('d/m/Y'),
                    'postulaciones_count' => $p->postulaciones->count(),
                    'imagen_url' => $p->imagen_url,
                ];
            }),
            'current_page' => (int) $page,
            'per_page' => $perPage,
            'total' => $total,
            'has_more' => ($page * $perPage) < $total,
        ]);
    }
}
