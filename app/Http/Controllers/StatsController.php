<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Evidencia;
use App\Models\Instructor;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;

class StatsController extends Controller
{
    public function dashboard()
    {
        try {
            $proyectosPorEstado = $this->getProyectosPorEstado();

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

            $rankingEmpresas = $this->getRankingEmpresas();

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
                'tendencias' => $this->getTendencias(),
                'tasa_exito' => $this->getTasaExitoProyectos(),
                'predicciones' => $this->getPredicciones(),
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
                'tendencias' => [],
                'tasa_exito' => ['tasa_exito' => 0, 'tasa_rechazo' => 0, 'completados' => 0, 'en_progreso' => 0, 'total' => 0],
                'predicciones' => ['historico' => [], 'predicciones' => [], 'labels' => [], 'tendencia' => 'estable', 'pendiente' => 0],
            ], 200);
        }
    }

    public function analytics()
    {
        $fechaInicio = request('fecha_inicio') ? now()->parse(request('fecha_inicio')) : now()->subYear();
        $fechaFin = request('fecha_fin') ? now()->parse(request('fecha_fin')) : now();

        $meses = [];
        $proyectosData = [];
        $postulacionesData = [];
        $usuariosData = [];
        $aprendicesData = [];
        $empresasData = [];
        $periodo = $fechaInicio->copy();
        while ($periodo <= $fechaFin) {
            $meses[] = $periodo->format('M Y');
            $proyectosData[] = Proyecto::whereYear('created_at', $periodo->year)->whereMonth('created_at', $periodo->month)->count();
            $postulacionesData[] = Postulacion::whereYear('created_at', $periodo->year)->whereMonth('created_at', $periodo->month)->count();
            $usersInMonth = User::whereYear('created_at', $periodo->year)->whereMonth('created_at', $periodo->month);
            $usuariosData[] = (clone $usersInMonth)->count();
            $aprendicesData[] = (clone $usersInMonth)->whereHas('aprendiz')->count();
            $empresasData[] = (clone $usersInMonth)->whereHas('empresa')->count();
            $periodo->addMonth();
        }

        return response()->json([
            'periodo' => ['inicio' => $fechaInicio->format('Y-m'), 'fin' => $fechaFin->format('Y-m')],
            'proyectos_mensuales' => ['labels' => $meses, 'data' => $proyectosData],
            'postulaciones_mensuales' => ['labels' => $meses, 'data' => $postulacionesData],
            'usuarios_mensuales' => ['labels' => $meses, 'data' => $usuariosData],
            'registro_mensual_detalle' => [
                'labels' => $meses,
                'aprendices' => $aprendicesData,
                'empresas' => $empresasData,
            ],
            'proyectos_por_estado' => $this->getProyectosPorEstado(),
            'postulaciones_funnel' => $this->getPostulacionesFunnel(),
            'tasa_exito' => $this->getTasaExitoProyectos(),
            'predicciones' => $this->getPredicciones('proyectos'),
            'predicciones_postulaciones' => $this->getPredicciones('postulaciones'),
            'predicciones_usuarios' => $this->getPredicciones('usuarios'),
            'top_empresas' => $this->getRankingEmpresas(),
            'instructores_carga' => $this->getInstructoresCarga(),
            'empresas_compromiso' => $this->getEmpresasCompromiso(),
            'ofertas_distribucion' => $this->getOfertasDistribucion(),
            'tendencias' => $this->getTendencias(),
            'programas_distribucion' => $this->getProgramasDistribucion(),
            'calidad_proyectos' => $this->getCalidadProyectos(),
            'categorias_rendimiento' => $this->getCategoriasRendimiento(),
            'duracion_promedio' => $this->getDuracionPromedio(),
            'evidencias_stats' => $this->getEvidenciasStats(),
            'metricas_globales' => $this->getMetricasGlobales(),
        ], 200);
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

    private function getProyectosPorEstado(): array
    {
        return [
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
    }

    private function getRankingEmpresas(): array
    {
        return Empresa::withCount('proyectos')
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
            })->toArray();
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

    private function getTendencias(): array
    {
        $now = now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $previousMonthStart = $now->copy()->subMonth()->startOfMonth();
        $previousMonthEnd = $now->copy()->subMonth()->endOfMonth();

        $modelos = [
            'proyectos' => Proyecto::class,
            'usuarios' => User::class,
            'aprendices' => Aprendiz::class,
            'instructores' => Instructor::class,
            'empresas' => Empresa::class,
        ];

        $tendencias = [];
        foreach ($modelos as $key => $model) {
            $current = $model::where('created_at', '>=', $currentMonthStart)->count();
            $previous = $model::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();
            $change = $previous > 0 ? round((($current - $previous) / $previous) * 100, 1) : ($current > 0 ? 100 : 0);
            $tendencias[$key] = [
                'change' => $change,
                'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'flat'),
                'current' => $current,
                'previous' => $previous,
            ];
        }

        return $tendencias;
    }

    private function getTasaExitoProyectos(): array
    {
        $total = Proyecto::count();
        $completados = Proyecto::where('estado', 'completado')->count();
        $enProgreso = Proyecto::where('estado', 'en_progreso')->count();
        $rechazados = Proyecto::where('estado', 'rechazado')->count();
        $aprobados = Proyecto::where('estado', 'aprobado')->count();
        $tasaExito = $total > 0 ? round(($completados / $total) * 100, 1) : 0;
        $tasaRechazo = $total > 0 ? round(($rechazados / $total) * 100, 1) : 0;
        $tasaActivos = $total > 0 ? round((($enProgreso + $aprobados) / $total) * 100, 1) : 0;

        return [
            'tasa_exito' => $tasaExito,
            'tasa_rechazo' => $tasaRechazo,
            'tasa_activos' => $tasaActivos,
            'completados' => $completados,
            'en_progreso' => $enProgreso,
            'rechazados' => $rechazados,
            'total' => $total,
        ];
    }

    private function getPredicciones(string $modelo = 'proyectos'): array
    {
        $meses = [];
        $data = [];

        $query = match ($modelo) {
            'proyectos' => Proyecto::class,
            'postulaciones' => Postulacion::class,
            'usuarios' => User::class,
            default => Proyecto::class,
        };

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->format('M Y');
            $data[] = $query::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
        }

        $n = count($data);
        if ($n < 2) {
            return ['historico' => $data, 'predicciones' => [], 'labels_meses' => $meses, 'labels_pred' => [], 'tendencia' => 'estable', 'pendiente' => 0, 'promedio_mensual' => 0, 'proyectado_anual' => 0];
        }

        $x = range(0, $n - 1);
        $xMean = array_sum($x) / $n;
        $yMean = array_sum($data) / $n;
        $num = 0; $den = 0;
        foreach ($x as $i => $xv) {
            $num += ($xv - $xMean) * ($data[$i] - $yMean);
            $den += ($xv - $xMean) ** 2;
        }
        $slope = $den != 0 ? $num / $den : 0;
        $intercept = $yMean - $slope * $xMean;

        $predicciones = [];
        $labelsPred = [];
        for ($i = 1; $i <= 3; $i++) {
            $predicciones[] = max(0, (int) round($slope * ($n - 1 + $i) + $intercept));
            $labelsPred[] = now()->addMonths($i)->format('M Y');
        }

        $totalLast6 = array_sum($data);
        $avgMonthly = $totalLast6 / max($n, 1);
        $proyectado12 = (int) round($avgMonthly * 12);

        return [
            'modelo' => $modelo,
            'historico' => $data,
            'predicciones' => $predicciones,
            'labels_meses' => $meses,
            'labels_pred' => $labelsPred,
            'tendencia' => $slope > 0.5 ? 'creciente' : ($slope < -0.5 ? 'decreciente' : 'estable'),
            'pendiente' => round($slope, 2),
            'promedio_mensual' => round($avgMonthly, 1),
            'proyectado_anual' => $proyectado12,
        ];
    }

    private function getProgramasDistribucion(): array
    {
        return Aprendiz::select('programa_formacion')
            ->whereNotNull('programa_formacion')
            ->groupBy('programa_formacion')
            ->selectRaw('programa_formacion, COUNT(*) as total')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $label = strlen($item->programa_formacion) > 30
                    ? substr($item->programa_formacion, 0, 28) . '..'
                    : $item->programa_formacion;
                return ['label' => $label, 'total' => (int) $item->total];
            })->toArray();
    }

    private function getCalidadProyectos(): array
    {
        $rangos = ['0-25' => 0, '26-50' => 0, '51-75' => 0, '76-90' => 0, '91-100' => 0];
        $proyectos = Proyecto::whereNotNull('titulo')->get();

        foreach ($proyectos as $p) {
            try {
                $calidad = $p->calidadProyecto();
                $pct = $calidad['porcentaje'] ?? 0;
                if ($pct <= 25) $rangos['0-25']++;
                elseif ($pct <= 50) $rangos['26-50']++;
                elseif ($pct <= 75) $rangos['51-75']++;
                elseif ($pct <= 90) $rangos['76-90']++;
                else $rangos['91-100']++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return [
            'labels' => array_keys($rangos),
            'data' => array_values($rangos),
        ];
    }

    private function getCategoriasRendimiento(): array
    {
        $categorias = Proyecto::select('categoria')
            ->whereNotNull('categoria')
            ->groupBy('categoria')
            ->selectRaw('categoria, COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN estado = "completado" THEN 1 ELSE 0 END) as completados')
            ->selectRaw('SUM(CASE WHEN estado = "rechazado" THEN 1 ELSE 0 END) as rechazados')
            ->selectRaw('SUM(CASE WHEN estado IN ("aprobado","en_progreso") THEN 1 ELSE 0 END) as activos')
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                $total = max((int) $item->total, 1);
                return [
                    'categoria' => ucfirst($item->categoria),
                    'total' => (int) $item->total,
                    'completados' => (int) $item->completados,
                    'rechazados' => (int) $item->rechazados,
                    'activos' => (int) $item->activos,
                    'tasa_exito' => round(((int) $item->completados / $total) * 100, 1),
                ];
            })->toArray();

        return $categorias;
    }

    private function getDuracionPromedio(): array
    {
        $promedio = Proyecto::whereNotNull('duracion_estimada_dias')
            ->where('duracion_estimada_dias', '>', 0)
            ->avg('duracion_estimada_dias');

        $minimo = Proyecto::whereNotNull('duracion_estimada_dias')
            ->where('duracion_estimada_dias', '>', 0)
            ->min('duracion_estimada_dias');

        $maximo = Proyecto::whereNotNull('duracion_estimada_dias')
            ->where('duracion_estimada_dias', '>', 0)
            ->max('duracion_estimada_dias');

        $conDuracion = Proyecto::whereNotNull('duracion_estimada_dias')
            ->where('duracion_estimada_dias', '>', 0)
            ->count();

        $sinDuracion = Proyecto::count() - $conDuracion;

        return [
            'promedio_dias' => round((float) $promedio),
            'minimo_dias' => (int) $minimo,
            'maximo_dias' => (int) $maximo,
            'con_duracion' => $conDuracion,
            'sin_duracion' => $sinDuracion,
        ];
    }

    private function getEvidenciasStats(): array
    {
        return [
            'pendientes' => Evidencia::where('estado', 'pendiente')->count(),
            'aceptadas' => Evidencia::where('estado', 'aceptada')->count(),
            'rechazadas' => Evidencia::where('estado', 'rechazada')->count(),
            'total' => Evidencia::count(),
        ];
    }

    private function getMetricasGlobales(): array
    {
        $totalProyectos = max(Proyecto::count(), 1);
        $completados = Proyecto::where('estado', 'completado')->count();
        $activos = Proyecto::whereIn('estado', ['aprobado', 'en_progreso'])->count();

        $postulacionesTotal = max(Postulacion::count(), 1);
        $postulacionesAceptadas = Postulacion::where('estado', 'aceptada')->count();

        $puntaje = 0;
        $puntaje += ($completados / $totalProyectos) * 30;
        $puntaje += ($activos / $totalProyectos) * 25;
        $puntaje += ($postulacionesAceptadas / $postulacionesTotal) * 25;
        $puntaje += (Empresa::where('activo', 1)->count() / max(Empresa::count(), 1)) * 20;

        $nivel = $puntaje >= 80 ? 'excelente' : ($puntaje >= 60 ? 'bueno' : ($puntaje >= 40 ? 'regular' : 'critico'));

        return [
            'puntaje' => round($puntaje),
            'nivel' => $nivel,
            'completados' => $completados,
            'activos' => $activos,
            'total_proyectos' => $totalProyectos,
            'tasa_completados' => round(($completados / $totalProyectos) * 100, 1),
            'tasa_actividad' => round(($activos / $totalProyectos) * 100, 1),
        ];
    }
}
