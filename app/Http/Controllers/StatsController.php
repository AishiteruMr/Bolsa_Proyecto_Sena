<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\Proyecto;
use App\Models\User;

class StatsController extends Controller
{
    public function dashboard()
    {
        try {
            $proyectosPorEstado = [
                'labels' => ['Pendiente', 'Aprobado', 'Rechazado', 'En Progreso', 'Cerrado'],
                'data' => [
                    Proyecto::where('estado', 'pendiente')->count(),
                    Proyecto::where('estado', 'aprobado')->count(),
                    Proyecto::where('estado', 'rechazado')->count(),
                    Proyecto::where('estado', 'en_progreso')->count(),
                    Proyecto::where('estado', 'cerrado')->count(),
                ],
            ];

            $usuariosPorTipo = [
                'labels' => ['Aprendices', 'Instructores', 'Empresas', 'Admins'],
                'data' => [
                    Aprendiz::count(),
                    Instructor::count(),
                    Empresa::count(),
                    User::where('rol_id', 4)->count(),
                ],
            ];

            $proyectosPorCategoria = Proyecto::select('categoria')
                ->whereNotNull('categoria')
                ->groupBy('categoria')
                ->selectRaw('categoria, COUNT(*) as total')
                ->orderByDesc('total')
                ->limit(8)
                ->get()
                ->map(function ($item) {
                    return [
                        'categoria' => ucfirst($item->categoria),
                        'total' => $item->total,
                    ];
                });

            $rankingEmpresas = Empresa::withCount('proyectos')
                ->having('proyectos_count', '>', 0)
                ->orderByDesc('proyectos_count')
                ->limit(5)
                ->get()
                ->map(function ($emp) {
                    return [
                        'nombre' => $emp->nombre,
                        'nit' => $emp->nit,
                        'total' => $emp->proyectos_count,
                    ];
                });

            $metricasMensuales = $this->getProyectosMensuales();

            $aprendicesActivos = Aprendiz::where('activo', 1)->count();
            $instructoresActivos = Instructor::where('activo', 1)->count();
            $empresasActivas = Empresa::where('activo', 1)->count();

            return response()->json([
                'proyectos_por_estado' => $proyectosPorEstado,
                'usuarios_por_tipo' => $usuariosPorTipo,
                'proyectos_por_categoria' => $proyectosPorCategoria,
                'ranking_empresas' => $rankingEmpresas,
                'metricas_mensuales' => $metricasMensuales,
                'totales' => [
                    'aprendices_activos' => $aprendicesActivos,
                    'instructores_activos' => $instructoresActivos,
                    'empresas_activas' => $empresasActivas,
                    'total_proyectos' => Proyecto::count(),
                    'total_usuarios' => User::count(),
                ],
            ], 200);
        } catch (\Exception $e) {
            // Fallback: retornar valores por defecto para evitar dashboard en blanco
            return response()->json([
                'proyectos_por_estado' => ['labels' => ['Pendiente', 'Aprobado', 'Rechazado', 'En Progreso', 'Cerrado'], 'data' => [0, 0, 0, 0, 0]],
                'usuarios_por_tipo' => ['labels' => ['Aprendices', 'Instructores', 'Empresas', 'Admins'], 'data' => [0, 0, 0, 0]],
                'proyectos_por_categoria' => [],
                'ranking_empresas' => [],
                'metricas_mensuales' => ['labels' => [], 'data' => []],
                'totales' => [
                    'aprendices_activos' => 0,
                    'instructores_activos' => 0,
                    'empresas_activas' => 0,
                    'total_proyectos' => 0,
                    'total_usuarios' => 0,
                ],
            ], 200);
        }
    }

    public function proyectosMensuales()
    {
        return response()->json($this->getProyectosMensuales());
    }

    private function getProyectosMensuales(): array
    {
        $meses = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->format('M Y');
            $data[] = Proyecto::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
        }

        return [
            'labels' => $meses,
            'data' => $data,
        ];
    }
}
