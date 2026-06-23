<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;

class StatsController extends Controller
{
    public function dashboard()
    {
        try {
            $proyectosPorEstado = [
                'labels' => ['Pendiente', 'Aprobado', 'Rechazado', 'En Progreso', 'Cerrado', 'Completado'],
                'data' => [
                    Proyecto::where('estado', 'pendiente')->count(),
                    Proyecto::where('estado', 'aprobado')->count(),
                    Proyecto::where('estado', 'rechazado')->count(),
                    Proyecto::where('estado', 'en_progreso')->count(),
                    Proyecto::where('estado', 'cerrado')->count(),
                    Proyecto::where('estado', 'completado')->count(),
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
                'postulaciones_funnel' => $this->getPostulacionesFunnel(),
                'postulaciones_mensuales' => $this->getPostulacionesMensuales(),
                'instructores_carga' => $this->getInstructoresCarga(),
                'ofertas_distribucion' => $this->getOfertasDistribucion(),
                'empresas_compromiso' => $this->getEmpresasCompromiso(),
                'registro_usuarios_mensual' => $this->getRegistroUsuariosMensual(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'proyectos_por_estado' => ['labels' => ['Pendiente', 'Aprobado', 'Rechazado', 'En Progreso', 'Cerrado', 'Completado'], 'data' => [0, 0, 0, 0, 0, 0]],
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
                'postulaciones_funnel' => ['labels' => [], 'data' => [], 'total' => 0, 'tasa_conversion' => 0],
                'postulaciones_mensuales' => ['labels' => [], 'data' => []],
                'instructores_carga' => [],
                'ofertas_distribucion' => ['labels' => [], 'data' => []],
                'empresas_compromiso' => ['activas' => 0, 'inactivas' => 0, 'con_proyectos' => 0, 'sin_proyectos' => 0],
                'registro_usuarios_mensual' => ['labels' => [], 'aprendices' => [], 'instructores' => [], 'empresas' => []],
            ], 200);
        }
    }

    public function programas()
    {
        try {
            $programas = Aprendiz::select('aprendices.programa_formacion')
                ->selectRaw('COUNT(*) as total_aprendices')
                ->selectRaw('COUNT(DISTINCT postulaciones.aprendiz_id) as postulados')
                ->selectRaw('COUNT(DISTINCT CASE WHEN postulaciones.estado = "aceptada" THEN postulaciones.aprendiz_id END) as aceptados')
                ->leftJoin('postulaciones', 'postulaciones.aprendiz_id', '=', 'aprendices.id')
                ->groupBy('aprendices.programa_formacion')
                ->orderByDesc('total_aprendices')
                ->get();

            return response()->json($programas);
        } catch (\Exception $e) {
            return response()->json([]);
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

    private function getPostulacionesFunnel(): array
    {
        $pendiente = Postulacion::where('estado', 'pendiente')->count();
        $enRevision = Postulacion::where('estado', 'en_revision')->count();
        $aceptada = Postulacion::where('estado', 'aceptada')->count();
        $rechazada = Postulacion::where('estado', 'rechazada')->count();
        $total = $pendiente + $enRevision + $aceptada + $rechazada;
        $tasaConversion = $total > 0 ? round(($aceptada / $total) * 100, 1) : 0;

        return [
            'labels' => ['Pendientes', 'En Revisión', 'Aceptadas', 'Rechazadas'],
            'data' => [$pendiente, $enRevision, $aceptada, $rechazada],
            'total' => $total,
            'tasa_conversion' => $tasaConversion,
        ];
    }

    private function getPostulacionesMensuales(): array
    {
        $meses = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->format('M Y');
            $data[] = Postulacion::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
        }

        return [
            'labels' => $meses,
            'data' => $data,
        ];
    }

    private function getInstructoresCarga(): array
    {
        return Instructor::select('instructores.id', 'instructores.nombres', 'instructores.apellidos')
            ->selectRaw('(SELECT COUNT(*) FROM proyectos WHERE proyectos.instructor_usuario_id = instructores.usuario_id AND proyectos.deleted_at IS NULL AND proyectos.estado IN ("pendiente","aprobado","en_progreso")) as proyectos_count')
            ->where('activo', 1)
            ->orderByDesc('proyectos_count')
            ->limit(10)
            ->get()
            ->map(function ($inst) {
                return [
                    'nombre' => $inst->nombres . ' ' . $inst->apellidos,
                    'total' => (int) $inst->proyectos_count,
                ];
            })
            ->toArray();
    }

    private function getOfertasDistribucion(): array
    {
        $data = Proyecto::select('oferta')
            ->whereNotNull('oferta')
            ->where('oferta', '!=', '')
            ->groupBy('oferta')
            ->selectRaw('oferta, COUNT(*) as total')
            ->orderByDesc('total')
            ->get();

        $labels = $data->map(function ($item) {
            return match ($item->oferta) {
                'pasantias' => 'Pasantías',
                'contrato_aprendizaje' => 'Contrato Aprendizaje',
                'auxilio_transporte' => 'Auxilio Transporte',
                'otro' => 'Otro',
                default => ucfirst($item->oferta),
            };
        });

        return [
            'labels' => $labels,
            'data' => $data->pluck('total'),
        ];
    }

    private function getEmpresasCompromiso(): array
    {
        $activas = Empresa::where('activo', 1)->count();
        $inactivas = Empresa::where('activo', 0)->count();
        $conProyectos = Empresa::where('activo', 1)->whereHas('proyectos')->count();
        $sinProyectos = Empresa::where('activo', 1)->whereDoesntHave('proyectos')->count();

        return [
            'activas' => $activas,
            'inactivas' => $inactivas,
            'con_proyectos' => $conProyectos,
            'sin_proyectos' => $sinProyectos,
        ];
    }

    private function getRegistroUsuariosMensual(): array
    {
        $meses = [];
        $aprendices = [];
        $instructores = [];
        $empresas = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->format('M Y');

            $usersInMonth = User::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month);

            $aprendices[] = (clone $usersInMonth)->whereHas('aprendiz')->count();
            $instructores[] = (clone $usersInMonth)->whereHas('instructor')->count();
            $empresas[] = (clone $usersInMonth)->whereHas('empresa')->count();
        }

        return [
            'labels' => $meses,
            'aprendices' => $aprendices,
            'instructores' => $instructores,
            'empresas' => $empresas,
        ];
    }
}
