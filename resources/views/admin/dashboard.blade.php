@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Página Principal')

@section('styles')
    @vite(['resources/css/admin.css'])
    <style>
        .dashboard-section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 36px 0 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }
        .dashboard-section-header:first-of-type { margin-top: 0; }
        .dashboard-section-header .section-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .dashboard-section-header h2 {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            flex: 1;
        }
        .dashboard-section-header .section-badge {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 12px;
            border-radius: 20px;
            color: #64748b;
            background: #f1f5f9;
        }
        .dashboard-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
        .dashboard-3col {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .dashboard-2-1col {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
        @media (max-width: 1024px) {
            .dashboard-2col, .dashboard-3col, .dashboard-2-1col {
                grid-template-columns: 1fr;
            }
        }
        .stat-card-compact {
            padding: 20px;
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.2s;
        }
        .stat-card-compact:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .stat-card-compact .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .stat-card-compact .stat-number {
            font-size: 24px;
            font-weight: 800;
            line-height: 1.2;
        }
        .stat-card-compact .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .skeleton-pulse {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .skeleton-stat {
            height: 32px; width: 60%; margin-bottom: 8px;
        }
        .skeleton-stat-sm {
            height: 14px; width: 40%; margin-bottom: 4px;
        }
        .skeleton-badge {
            height: 20px; width: 80px; border-radius: 20px;
        }
        .skeleton-chart {
            height: 220px; width: 100%;
        }
    </style>
@endsection

@section('sidebar-nav')
    @include('admin.partials.sidebar-nav')
@endsection

@php $breadcrumbs = [['label' => 'Inicio']]; @endphp
@section('content')
    <div class="animate-fade-in">
        <div class="admin-header-master">
            <div class="admin-header-icon">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="admin-badge-hub">Admin Control Hub</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="admin-header-title">Gestión Estratégica <span style="color: var(--primary);">Global</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 600px; font-weight: 500;">Control unificado sobre el banco de proyectos y el talento humano del ecosistema Sena.</p>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION: VISIÓN GENERAL                               --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="dashboard-section-header">
            <div class="section-icon" style="background:var(--primary-soft);color:var(--primary);">
                <i class="fas fa-th-large"></i>
            </div>
            <h2>Visión General</h2>
            <span class="section-badge">Resumen Ejecutivo</span>
        </div>

        <div class="admin-stats-grid">
            <div class="stat-card-premium" style="padding: 28px; background: white; border-color: var(--primary-soft);">
                <div class="admin-stat-icon" style="background: var(--primary-soft); color: var(--primary); margin-bottom: 24px;">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: var(--primary);">{{ $stats['proyectos'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Banco de Proyectos</div>
                <span class="trend-badge" data-trend="proyectos" style="display:none;margin-top:10px;"></span>
                <div class="inline-pill inline-pill--warning" style="margin-top:16px; width:fit-content;">
                    <i class="fas fa-clock-rotate-left"></i> {{ $stats['pendientes'] }} Pendientes
                </div>
            </div>
            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #f8fafc; color: #64748b; margin-bottom: 24px;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: var(--text);">{{ $stats['usuarios'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Cuentas Totales</div>
                <span class="trend-badge" data-trend="usuarios" style="display:none;margin-top:10px;"></span>
            </div>
            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #eff6ff; color: #3b82f6; margin-bottom: 24px;">
                    <i class="fas fa-building"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #2563eb;">{{ $stats['empresas'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Empresas Aliadas</div>
                <span class="trend-badge" data-trend="empresas" style="display:none;margin-top:10px;"></span>
            </div>
            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #fdf2f8; color: #db2777; margin-bottom: 24px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #db2777;">{{ $stats['aprendices'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Aprendices</div>
                <span class="trend-badge" data-trend="aprendices" style="display:none;margin-top:10px;"></span>
            </div>
            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #fef3c7; color: #d97706; margin-bottom: 24px;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #d97706;">{{ $stats['instructores'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Instructores</div>
                <span class="trend-badge" data-trend="instructores" style="display:none;margin-top:10px;"></span>
            </div>
        </div>

        {{-- Active counts bar (populated via JS) --}}
        <div id="activeCountsBar" style="display: flex; flex-wrap: wrap; gap: 12px; margin: -24px 0 36px; padding: 0 4px;">
            <div class="skeleton-pulse skeleton-badge" style="height:28px;"></div>
            <div class="skeleton-pulse skeleton-badge"></div>
            <div class="skeleton-pulse skeleton-badge"></div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION: PROYECTOS                                    --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="dashboard-section-header">
            <div class="section-icon" style="background:#f0fdf4;color:#10b981;">
                <i class="fas fa-project-diagram"></i>
            </div>
            <h2>Proyectos</h2>
            <span class="section-badge">Estado y tendencias</span>
        </div>

        <div class="dashboard-2col">
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 8px;"></i>
                        Por Estado
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartProyectosEstado"></canvas>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-chart-line" style="color: #10b981; margin-right: 8px;"></i>
                        Creados (Últimos 6 Meses)
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartProyectosMensual"></canvas>
                </div>
            </div>
        </div>

        {{-- Proyectos: categorías --}}
        <div class="glass-card" style="padding: 24px; background: white; margin-top: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                    <i class="fas fa-tags" style="color: #8b5cf6; margin-right: 8px;"></i>
                    Por Categoría
                </h3>
            </div>
            <div style="height: 260px; position: relative;">
                <canvas id="chartProyectosCategoria"></canvas>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION: POSTULACIONES                                 --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="dashboard-section-header">
            <div class="section-icon" style="background:#fef3c7;color:#f59e0b;">
                <i class="fas fa-file-pen"></i>
            </div>
            <h2>Postulaciones</h2>
            <span class="section-badge">Embudo y métricas</span>
        </div>

        <div class="admin-stats-grid" id="postulacionesStatsGrid" style="margin-bottom:24px;">
            <div class="stat-card-premium" style="padding: 24px; background: white; border-color: #fef3c7;">
                <div class="admin-stat-icon" style="background: #fef3c7; color: #f59e0b; margin-bottom: 16px;">
                    <i class="fas fa-file-pen"></i>
                </div>
                <div class="admin-stat-value skeleton-pulse skeleton-stat" style="font-size: 32px; color: #f59e0b;">&nbsp;</div>
                <div class="admin-stat-label" style="font-size: 10px; margin-top: 4px;">Postulaciones Totales</div>
                <div class="inline-pill inline-pill--warning" style="margin-top:12px; width:fit-content;">
                    <i class="fas fa-spinner"></i> <span class="skeleton-pulse" style="display:inline-block;width:40px;">&nbsp;</span>
                </div>
            </div>
            <div class="stat-card-premium" style="padding: 24px; background: white;">
                <div class="admin-stat-icon" style="background: #eff6ff; color: #3b82f6; margin-bottom: 16px;">
                    <i class="fas fa-pen-to-square"></i>
                </div>
                <div class="admin-stat-value skeleton-pulse skeleton-stat" style="font-size: 32px; color: #3b82f6;">&nbsp;</div>
                <div class="admin-stat-label" style="font-size: 10px; margin-top: 4px;">En Revisión</div>
            </div>
            <div class="stat-card-premium" style="padding: 24px; background: white;">
                <div class="admin-stat-icon" style="background: #f0fdf4; color: #10b981; margin-bottom: 16px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="admin-stat-value skeleton-pulse skeleton-stat" style="font-size: 32px; color: #10b981;">&nbsp;</div>
                <div class="admin-stat-label" style="font-size: 10px; margin-top: 4px;">Aceptadas</div>
                <div class="inline-pill inline-pill--success" style="margin-top:12px; width:fit-content;">
                    <i class="fas fa-percentage"></i> <span class="skeleton-pulse" style="display:inline-block;width:50px;">&nbsp;</span>
                </div>
            </div>
            <div class="stat-card-premium" style="padding: 24px; background: white;">
                <div class="admin-stat-icon" style="background: #fef2f2; color: #ef4444; margin-bottom: 16px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="admin-stat-value skeleton-pulse skeleton-stat" style="font-size: 32px; color: #ef4444;">&nbsp;</div>
                <div class="admin-stat-label" style="font-size: 10px; margin-top: 4px;">Rechazadas</div>
            </div>
        </div>

        <div class="dashboard-2col">
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-filter" style="color: var(--primary); margin-right: 8px;"></i>
                        Embudo de Postulaciones
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartPostulacionesFunnel"></canvas>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-chart-line" style="color: #3b82f6; margin-right: 8px;"></i>
                        Recibidas (Últimos 6 Meses)
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartPostulacionesMensual"></canvas>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION: TALENTO HUMANO                               --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="dashboard-section-header">
            <div class="section-icon" style="background:#fdf2f8;color:#db2777;">
                <i class="fas fa-users"></i>
            </div>
            <h2>Talento Humano</h2>
            <span class="section-badge">Usuarios y formación</span>
        </div>

        <div class="dashboard-2col">
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-chart-pie" style="color: #3b82f6; margin-right: 8px;"></i>
                        Usuarios por Tipo
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartUsuariosTipo"></canvas>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-graduation-cap" style="color: #db2777; margin-right: 8px;"></i>
                        Aprendices por Programa
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartProgramas"></canvas>
                </div>
            </div>
        </div>

        <div class="dashboard-2col" style="margin-top: 24px;">
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-chalkboard-user" style="color: #6366f1; margin-right: 8px;"></i>
                        Carga de Instructores
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartInstructoresCarga"></canvas>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-user-plus" style="color: #10b981; margin-right: 8px;"></i>
                        Registro de Usuarios (6 Meses)
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartRegistroUsuarios"></canvas>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION: RENDIMIENTO Y PROYECCIÓN                     --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="dashboard-section-header">
            <div class="section-icon" style="background:#f0fdf4;color:#059669;">
                <i class="fas fa-chart-simple"></i>
            </div>
            <h2>Rendimiento y Proyección</h2>
            <span class="section-badge">Analítica predictiva</span>
        </div>

        <div class="dashboard-2col">
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-bullseye" style="color: #059669; margin-right: 8px;"></i>
                        Tasa de Éxito de Proyectos
                    </h3>
                </div>
                <div id="successRateContent">
                    <div style="display: flex; gap: 16px; margin-bottom: 20px;">
                        <div style="flex:1; text-align:center; padding:16px; background:#f0fdf4; border-radius:12px;">
                            <div class="skeleton-pulse" style="height:32px; width:50%; margin:0 auto 6px; border-radius:6px;"></div>
                            <div class="skeleton-pulse skeleton-badge" style="margin:0 auto;"></div>
                        </div>
                        <div style="flex:1; text-align:center; padding:16px; background:#fef2f2; border-radius:12px;">
                            <div class="skeleton-pulse" style="height:32px; width:50%; margin:0 auto 6px; border-radius:6px;"></div>
                            <div class="skeleton-pulse skeleton-badge" style="margin:0 auto;"></div>
                        </div>
                        <div style="flex:1; text-align:center; padding:16px; background:#eff6ff; border-radius:12px;">
                            <div class="skeleton-pulse" style="height:32px; width:50%; margin:0 auto 6px; border-radius:6px;"></div>
                            <div class="skeleton-pulse skeleton-badge" style="margin:0 auto;"></div>
                        </div>
                    </div>
                    <div style="height: 200px; position: relative;">
                        <canvas id="chartSuccessRate"></canvas>
                    </div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-chart-line" style="color: #6366f1; margin-right: 8px;"></i>
                        Proyección de Proyectos
                    </h3>
                    <span id="trendLabel" class="skeleton-pulse" style="padding:4px 12px; border-radius:20px; font-size:10px; font-weight:700;">&nbsp;</span>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartPredicciones"></canvas>
                </div>
                <div id="predictionMeta" style="margin-top:12px; display:flex; gap:12px;">
                    <div class="skeleton-pulse" style="flex:1; height:20px; border-radius:6px;"></div>
                    <div class="skeleton-pulse" style="flex:1; height:20px; border-radius:6px;"></div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION: ECOSISTEMA EMPRESARIAL                       --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="dashboard-section-header">
            <div class="section-icon" style="background:#eff6ff;color:#2563eb;">
                <i class="fas fa-building"></i>
            </div>
            <h2>Ecosistema Empresarial</h2>
            <span class="section-badge">Empresas y ofertas</span>
        </div>

        <div class="dashboard-3col">
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-trophy" style="color: #f59e0b; margin-right: 8px;"></i>
                        Top Empresas
                    </h3>
                </div>
                <div id="rankingEmpresas"></div>
            </div>
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-gift" style="color: #8b5cf6; margin-right: 8px;"></i>
                        Tipo de Ofertas
                    </h3>
                </div>
                <div style="height: 260px; position: relative;">
                    <canvas id="chartOfertas"></canvas>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text); margin:0;">
                        <i class="fas fa-building" style="color: #2563eb; margin-right: 8px;"></i>
                        Compromiso Empresarial
                    </h3>
                </div>
                <div style="display: flex; gap: 12px;">
                    <div style="flex:1; background:#f0fdf4; border-radius:12px; padding:16px 12px; text-align:center;">
                        <div style="font-size:22px; font-weight:800; color:#10b981;"><span id="empConProyectos" class="skeleton-pulse" style="display:inline-block; width:30px;">&nbsp;</span></div>
                        <div style="font-size:10px; color:#64748b; font-weight:600; margin-top:4px;">Con proyectos</div>
                    </div>
                    <div style="flex:1; background:#fff7ed; border-radius:12px; padding:16px 12px; text-align:center;">
                        <div style="font-size:22px; font-weight:800; color:#f59e0b;"><span id="empSinProyectos" class="skeleton-pulse" style="display:inline-block; width:30px;">&nbsp;</span></div>
                        <div style="font-size:10px; color:#64748b; font-weight:600; margin-top:4px;">Sin proyectos</div>
                    </div>
                </div>
                <div style="margin-top:16px; display: flex; gap: 12px;">
                    <div style="flex:1; background:#f0fdf4; border-radius:12px; padding:12px; text-align:center;">
                        <div style="font-size:20px; font-weight:800; color:#065f46;"><span id="empActivas">-</span></div>
                        <div style="font-size:10px; color:#64748b; font-weight:600;">Activas</div>
                    </div>
                    <div style="flex:1; background:#fef2f2; border-radius:12px; padding:12px; text-align:center;">
                        <div style="font-size:20px; font-weight:800; color:#dc2626;"><span id="empInactivas">-</span></div>
                        <div style="font-size:10px; color:#64748b; font-weight:600;">Inactivas</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION: ACTIVIDAD RECIENTE                           --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="dashboard-section-header">
            <div class="section-icon" style="background:#f8fafc;color:#64748b;">
                <i class="fas fa-clock"></i>
            </div>
            <h2>Actividad Reciente</h2>
            <span class="section-badge">Pendientes</span>
        </div>

        <div class="dashboard-2-1col">
            <div class="glass-card admin-table-card" style="background: white; display: flex; flex-direction: column;">
                <div class="admin-table-header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 40px; height: 40px; background: var(--primary-soft); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 16px;">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1rem; font-weight: 800; color: var(--text); margin: 0;">Proyectos por Auditar</h3>
                            <span style="font-size: 11px; color: var(--text-lighter); font-weight: 600;">{{ $proyectosRecientes->count() }} proyecto(s) reciente(s)</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.proyectos') }}" class="btn-premium" style="padding: 8px 16px; font-size: 11px; background: #f8fafc; color: var(--primary); border: 1px solid var(--primary-soft); box-shadow: none; white-space: nowrap;">Ir al Banco</a>
                </div>
                <div class="premium-table-container" style="flex: 1;">
                    @php
                        $avatarColors = ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#f43f5e', '#06b6d4', '#84cc16'];
                    @endphp
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 24px;">Proyecto</th>
                                <th>Empresa</th>
                                <th>Estado</th>
                                <th style="text-align: right; padding-right: 24px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proyectosRecientes as $i => $p)
                                @php
                                    $statusStyles = match($p->estado) {
                                        'completado' => ['bg' => '#065f46', 'icon' => 'fa-check'],
                                        'aprobado' => ['bg' => '#10b981', 'icon' => 'fa-check'],
                                        'pendiente' => ['bg' => '#f59e0b', 'icon' => 'fa-clock'],
                                        'rechazado' => ['bg' => '#ef4444', 'icon' => 'fa-ban'],
                                        'cerrado' => ['bg' => '#64748b', 'icon' => 'fa-lock'],
                                        'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner'],
                                        default => ['bg' => '#64748b', 'icon' => 'fa-info-circle'],
                                    };
                                    $initial = strtoupper(substr($p->titulo, 0, 1));
                                    $avatarColor = $avatarColors[$i % count($avatarColors)];
                                @endphp
                                <tr>
                                    <td style="padding-left: 24px;">
                                        <div style="display: flex; align-items: center; gap: 14px;">
                                            <div style="width: 38px; height: 38px; border-radius: 10px; background: {{ $avatarColor }}15; color: {{ $avatarColor }}; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; border: 1px solid {{ $avatarColor }}25; flex-shrink: 0;">
                                                {{ $initial }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 700; color: var(--text); font-size: 13px; line-height: 1.5;">{{ $p->titulo }}</div>
                                                @if($p->categoria)
                                                    <span style="font-size: 10px; color: var(--text-lighter); font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">{{ $p->categoria }}</span>
                                                @endif
                                                @if($p->oferta)
                                                    <span style="display: inline-flex; align-items: center; gap: 4px; margin-top: 4px; font-size: 10px; background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(124,58,237,0.08)); color: #7c3aed; padding: 2px 10px 2px 6px; border-radius: 20px; font-weight: 800; border: 1px solid rgba(139,92,246,0.15); box-shadow: 0 2px 4px rgba(139,92,246,0.06);">
                                                        <i class="fas fa-gift" style="font-size: 8px;"></i>
                                                        @switch($p->oferta)
                                                            @case('pasantias') Pasantías @break
                                                            @case('contrato_aprendizaje') Contrato aprendizaje @break
                                                            @case('auxilio_transporte') Auxilio transporte @break
                                                            @case('otro') {{ $p->oferta_otro }} @break
                                                        @endswitch
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 8px; color: var(--text-light); font-weight: 600; font-size: 13px;">
                                            <i class="fas fa-building" style="font-size: 11px; opacity: 0.4;"></i>
                                            {{ $p->empresa_nombre }}
                                        </div>
                                    </td>
                                    <td>
                                        <span style="background: {{ $statusStyles['bg'] }}15; color: {{ $statusStyles['bg'] }}; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid {{ $statusStyles['bg'] }}25;">
                                            <i class="fas {{ $statusStyles['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                                        </span>
                                    </td>
                                    <td style="text-align: right; padding-right: 24px;">
                                        <a href="{{ route('admin.proyectos.revisar', $p->id) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: var(--primary-soft); color: var(--primary); border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff'" onmouseout="this.style.background='var(--primary-soft)'; this.style.color='var(--primary)'">
                                            Revisar <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 60px 24px;">
                                        <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #cbd5e1;">
                                            <i class="fas fa-inbox" style="font-size: 28px;"></i>
                                        </div>
                                        <div style="font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 4px;">Todo al día</div>
                                        <div style="font-size: 13px; color: var(--text-lighter); font-weight: 500;">No hay proyectos pendientes de revisión.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="glass-card" style="padding: 28px; background: white;">
                <h3 style="font-size: 1rem; font-weight: 800; color: var(--text); margin-bottom: 24px;">
                    <i class="fas fa-user-plus" style="color: #3b82f6; margin-right: 8px;"></i>
                    Últimas Incorporaciones
                </h3>
                <div class="user-incorporation-list">
                    @foreach($usuariosRecientes as $u)
                        <div class="user-incorporation-item">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-weight: 800; font-size: 16px; border: 1px solid #dbeafe;">
                                {{ strtoupper(substr($u->correo, 0, 1)) }}
                            </div>
                            <div style="flex: 1; overflow: hidden;">
                                <p style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $u->correo }}</p>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 10px; font-weight: 800; color: var(--primary); text-transform: uppercase;">{{ $u->nombre_rol }}</span>
                                    <span style="width: 3px; height: 3px; background: #cbd5e1; border-radius: 50%;"></span>
                                    <span style="font-size: 10px; color: #94a3b8; font-weight: 600;">{{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->diffForHumans() : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.usuarios') }}" class="btn-premium" style="margin-top: 28px; width: 100%; text-align: center; justify-content: center; background: #0f172a; border: none; font-size: 13px; padding: 14px;">
                    Gestionar Usuarios <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/admin/stats')
                .then(r => r.json())
                .then(data => {
                    const colors = {
                        emerald: '#10b981',
                        amber: '#f59e0b',
                        rose: '#f43f5e',
                        blue: '#3b82f6',
                        indigo: '#6366f1',
                        gray: '#64748b',
                        statusApproved: '#10b981',
                        statusRejected: '#ef4444',
                        statusPending: '#f59e0b',
                        statusCompleted: '#065f46'
                    };

                    // ── PROYECTOS POR ESTADO ──
                    new Chart(document.getElementById('chartProyectosEstado'), {
                        type: 'doughnut',
                        data: {
                            labels: data.proyectos_por_estado.labels,
                            datasets: [{
                                data: data.proyectos_por_estado.data,
                                backgroundColor: data.proyectos_por_estado.labels.map(label => {
                                    const l = label.toLowerCase();
                                    if (l.includes('completado')) return '#065f46';
                                    if (l.includes('cerrado')) return colors.gray;
                                    if (l.includes('aprobado')) return colors.statusApproved;
                                    if (l.includes('pendiente')) return colors.statusPending;
                                    if (l.includes('rechazado')) return colors.statusRejected;
                                    if (l.includes('en progreso')) return colors.blue;
                                    return colors.gray;
                                }),
                                hoverOffset: 15, weight: 2, borderWidth: 0, borderRadius: 6, spacing: 4
                            }]
                        },
                        options: {
                            cutout: '78%', responsive: true, maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { family: 'Open Sans', size: 10, weight: '600' } } },
                                tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, usePointStyle: true, boxPadding: 6, cornerRadius: 12 }
                            }
                        }
                    });

                    // ── USUARIOS POR TIPO ──
                    new Chart(document.getElementById('chartUsuariosTipo'), {
                        type: 'polarArea',
                        data: {
                            labels: data.usuarios_por_tipo.labels,
                            datasets: [{
                                data: data.usuarios_por_tipo.data,
                                backgroundColor: ['rgba(244, 114, 182, 0.65)', 'rgba(167, 139, 250, 0.65)', 'rgba(251, 191, 36, 0.65)', 'rgba(52, 211, 153, 0.65)'],
                                borderWidth: 2, borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            scales: { r: { grid: { color: '#f1f5f9' }, ticks: { display: false } } },
                            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { family: 'Open Sans', size: 10, weight: '600' } } } }
                        }
                    });

                    // ── TOP EMPRESAS ──
                    const rankingContainer = document.getElementById('rankingEmpresas');
                    if (data.ranking_empresas.length > 0) {
                        rankingContainer.innerHTML = data.ranking_empresas.map((emp, i) => `
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; padding: 10px 12px; background: ${i === 0 ? 'hsla(45, 100%, 96%, 1)' : '#f8fafc'}; border-radius: 12px; border: 1px solid ${i === 0 ? 'hsla(45, 100%, 90%, 1)' : '#e2e8f0'};">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: ${i === 0 ? colors.amber : '#94a3b8'}; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; flex-shrink:0;">
                                    ${i + 1}
                                </div>
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 700; font-size: 12px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${emp.nombre}</div>
                                    <div style="font-size: 10px; color: var(--text-light); font-weight: 500;">${emp.total} proyecto${emp.total !== 1 ? 's' : ''}</div>
                                </div>
                                ${i === 0 ? '<i class="fas fa-crown" style="color: #f59e0b; font-size: 12px;"></i>' : ''}
                            </div>
                        `).join('');
                    } else {
                        rankingContainer.innerHTML = '<div style="text-align: center; padding: 30px;"><i class="fas fa-inbox" style="font-size: 24px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i><p style="color: #94a3b8; font-size: 12px; font-weight: 600;">Sin datos aún</p></div>';
                    }

                    // ── ACTIVE COUNTS BAR ──
                    const tot = data.totales || {};
                    const activeBar = document.getElementById('activeCountsBar');
                    if (activeBar) {
                        activeBar.innerHTML = [
                            {label: 'Aprendices activos', count: tot.aprendices_activos, bg: '#fdf2f8', color: '#db2777', icon: 'fa-graduation-cap'},
                            {label: 'Instructores activos', count: tot.instructores_activos, bg: '#fef3c7', color: '#d97706', icon: 'fa-chalkboard-teacher'},
                            {label: 'Empresas activas', count: tot.empresas_activas, bg: '#eff6ff', color: '#2563eb', icon: 'fa-building'},
                        ].map(function(item) {
                            return '<span style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;font-size:11px;font-weight:700;background:'+item.bg+';color:'+item.color+';border:1px solid '+item.color+'20;"><i class="fas '+item.icon+'" style="font-size:10px;"></i> '+item.count+' <span style="opacity:0.6;font-weight:600;">'+item.label+'</span></span>';
                        }).join('');
                    }

                    // ── PROYECTOS CREADOS - LINE CHART ──
                    const ctx = document.getElementById('chartProyectosMensual').getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 260);
                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.metricas_mensuales.labels,
                            datasets: [{
                                label: 'Proyectos',
                                data: data.metricas_mensuales.data,
                                borderColor: colors.emerald, borderWidth: 3, fill: true, backgroundColor: gradient,
                                tension: 0.45, pointBackgroundColor: '#fff', pointBorderColor: colors.emerald,
                                pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: colors.emerald, padding: 12, borderColor: '#e2e8f0', borderWidth: 1, displayColors: false, cornerRadius: 12 } },
                            scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 } }, x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } } }
                        }
                    });

                    // ── PROYECTOS POR CATEGORÍA ──
                    const cats = data.proyectos_por_categoria || [];
                    const catCanvas = document.getElementById('chartProyectosCategoria');
                    if (cats.length && catCanvas) {
                        new Chart(catCanvas, {
                            type: 'bar',
                            data: {
                                labels: cats.map(function(c) { return c.categoria; }),
                                datasets: [{
                                    label: 'Proyectos',
                                    data: cats.map(function(c) { return c.total; }),
                                    backgroundColor: cats.map(function(_, idx) {
                                        var pal = ['rgba(139,92,246,0.7)','rgba(59,130,246,0.7)','rgba(16,185,129,0.7)','rgba(245,158,11,0.7)','rgba(244,63,94,0.7)','rgba(6,182,212,0.7)','rgba(168,85,247,0.7)','rgba(236,72,153,0.7)'];
                                        return pal[idx % pal.length];
                                    }),
                                    borderColor: cats.map(function(_, idx) {
                                        var pal = ['#8b5cf6','#3b82f6','#10b981','#f59e0b','#f43f5e','#06b6d4','#a855f7','#ec4899'];
                                        return pal[idx % pal.length];
                                    }),
                                    borderWidth: 1, borderRadius: 4
                                }]
                            },
                            options: {
                                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                                plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 } },
                                scales: { x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 } }, y: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 10, weight: '600' }, maxRotation: 0 } } }
                            }
                        });
                    } else if (catCanvas) {
                        catCanvas.parentElement.innerHTML = '<div style="text-align:center;padding:40px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin categorías registradas</div>';
                    }

                    // ── APRENDICES POR PROGRAMA ──
                    fetch('/api/admin/stats/programas')
                        .then(r => r.json())
                        .then(programas => {
                            if (!programas.length) {
                                document.getElementById('chartProgramas').parentElement.innerHTML = '<div style="text-align: center; padding: 40px; color: #94a3b8; font-size: 12px; font-weight: 600;"><i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>Sin datos disponibles</div>';
                                return;
                            }
                            new Chart(document.getElementById('chartProgramas'), {
                                type: 'bar',
                                data: {
                                    labels: programas.map(p => p.programa_formacion.length > 18 ? p.programa_formacion.substring(0,16)+'..' : p.programa_formacion),
                                    datasets: [
                                        { label: 'Total', data: programas.map(p => p.total_aprendices), backgroundColor: 'rgba(219, 39, 119, 0.7)', borderColor: '#db2777', borderWidth: 1, borderRadius: 3 },
                                        { label: 'Postulados', data: programas.map(p => p.postulados), backgroundColor: 'rgba(59, 130, 246, 0.7)', borderColor: '#3b82f6', borderWidth: 1, borderRadius: 3 },
                                        { label: 'Aceptados', data: programas.map(p => p.aceptados), backgroundColor: 'rgba(16, 185, 129, 0.7)', borderColor: '#10b981', borderWidth: 1, borderRadius: 3 }
                                    ]
                                },
                                options: {
                                    responsive: true, maintainAspectRatio: false,
                                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { family: 'Open Sans', size: 10, weight: '600' } } }, tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 } },
                                    scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 } }, x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 9, weight: '600' }, maxRotation: 0 } } }
                                }
                            });
                        })
                        .catch(err => console.error('Error cargando programas:', err));

                    // ── POSTULATION FUNNEL CARDS ──
                    const funnel = data.postulaciones_funnel || {labels:[], data:[], total:0, tasa_conversion:0};
                    const postStatsGrid = document.getElementById('postulacionesStatsGrid');
                    const funnelCards = postStatsGrid ? postStatsGrid.querySelectorAll('.stat-card-premium') : [];
                    if (funnelCards.length >= 4) {
                        funnelCards[0].querySelector('.admin-stat-value').textContent = funnel.total;
                        funnelCards[0].querySelector('.inline-pill span').textContent = (funnel.data[0] || 0) + ' Pendientes';
                        funnelCards[1].querySelector('.admin-stat-value').textContent = funnel.data[1] || 0;
                        funnelCards[2].querySelector('.admin-stat-value').textContent = funnel.data[2] || 0;
                        funnelCards[2].querySelector('.inline-pill span').textContent = funnel.tasa_conversion + '% Conversión';
                        funnelCards[3].querySelector('.admin-stat-value').textContent = funnel.data[3] || 0;
                        // Remove skeleton from postulaciones cards
                        funnelCards.forEach(function(c) {
                            c.querySelectorAll('.skeleton-pulse, .skeleton-stat').forEach(function(s) { s.classList.remove('skeleton-pulse', 'skeleton-stat'); });
                        });
                    }

                    // ── POSTULATION FUNNEL CHART ──
                    new Chart(document.getElementById('chartPostulacionesFunnel'), {
                        type: 'doughnut',
                        data: {
                            labels: funnel.labels,
                            datasets: [{ data: funnel.data, backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'], hoverOffset: 15, borderWidth: 0, borderRadius: 6, spacing: 4 }]
                        },
                        options: {
                            cutout: '72%', responsive: true, maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { family: 'Open Sans', size: 10, weight: '600' } } },
                                tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12, callbacks: { label: function(ctx) { const t = funnel.total || 1; return ctx.label + ': ' + ctx.parsed + ' (' + ((ctx.parsed/t)*100).toFixed(1) + '%)'; } } }
                            }
                        }
                    });

                    // ── MONTHLY POSTULATIONS TREND ──
                    const postMensual = data.postulaciones_mensuales || {labels:[], data:[]};
                    if (postMensual.data.length) {
                        const ctxPost = document.getElementById('chartPostulacionesMensual').getContext('2d');
                        const gradPost = ctxPost.createLinearGradient(0, 0, 0, 260);
                        gradPost.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
                        gradPost.addColorStop(1, 'rgba(59, 130, 246, 0)');
                        new Chart(ctxPost, {
                            type: 'line',
                            data: { labels: postMensual.labels, datasets: [{ label: 'Postulaciones', data: postMensual.data, borderColor: '#3b82f6', borderWidth: 3, fill: true, backgroundColor: gradPost, tension: 0.45, pointBackgroundColor: '#fff', pointBorderColor: '#3b82f6', pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6 }] },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#3b82f6', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 } },
                                scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 } }, x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } } }
                            }
                        });
                    } else {
                        document.getElementById('chartPostulacionesMensual').parentElement.innerHTML = '<div style="text-align:center;padding:40px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin postulaciones aún</div>';
                    }

                    // ── OFFER TYPE DISTRIBUTION ──
                    const ofertas = data.ofertas_distribucion || {labels:[], data:[]};
                    if (ofertas.data.length) {
                        new Chart(document.getElementById('chartOfertas'), {
                            type: 'doughnut',
                            data: { labels: ofertas.labels, datasets: [{ data: ofertas.data, backgroundColor: ['#8b5cf6', '#f59e0b', '#06b6d4', '#10b981'], hoverOffset: 15, borderWidth: 0, borderRadius: 6, spacing: 4 }] },
                            options: { cutout: '72%', responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { family: 'Open Sans', size: 10, weight: '600' } } }, tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 } } }
                        });
                    } else {
                        document.getElementById('chartOfertas').parentElement.innerHTML = '<div style="text-align:center;padding:60px 20px;color:#94a3b8;font-size:13px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin ofertas registradas</div>';
                    }

                    // ── INSTRUCTOR WORKLOAD ──
                    const instructores = data.instructores_carga || [];
                    const ctxIns = document.getElementById('chartInstructoresCarga').getContext('2d');
                    if (instructores.length) {
                        new Chart(ctxIns, {
                            type: 'bar',
                            data: {
                                labels: instructores.map(i => i.nombre.length > 18 ? i.nombre.substring(0,16)+'..' : i.nombre),
                                datasets: [{
                                    label: 'Proyectos activos',
                                    data: instructores.map(i => i.total),
                                    backgroundColor: instructores.map((_, idx) => { const c = ['rgba(99,102,241,0.7)','rgba(59,130,246,0.7)','rgba(16,185,129,0.7)','rgba(245,158,11,0.7)','rgba(244,63,94,0.7)','rgba(139,92,246,0.7)','rgba(6,182,212,0.7)']; return c[idx % c.length]; }),
                                    borderColor: instructores.map((_, idx) => { const c = ['#6366f1','#3b82f6','#10b981','#f59e0b','#f43f5e','#8b5cf6','#06b6d4']; return c[idx % c.length]; }),
                                    borderWidth: 1, borderRadius: 4
                                }]
                            },
                            options: {
                                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                                plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 } },
                                scales: { x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 } }, y: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 10, weight: '600' } } } }
                            }
                        });
                    } else {
                        ctxIns.canvas.parentElement.innerHTML = '<div style="text-align:center;padding:40px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin instructores con proyectos</div>';
                    }

                    // ── COMPANY ENGAGEMENT ──
                    const empCompromiso = data.empresas_compromiso || {activas:0, inactivas:0, con_proyectos:0, sin_proyectos:0};
                    document.getElementById('empConProyectos').textContent = empCompromiso.con_proyectos;
                    document.getElementById('empSinProyectos').textContent = empCompromiso.sin_proyectos;
                    document.getElementById('empActivas').textContent = empCompromiso.activas;
                    document.getElementById('empInactivas').textContent = empCompromiso.inactivas;
                    ['empConProyectos','empSinProyectos','empActivas','empInactivas'].forEach(function(id) {
                        document.getElementById(id).classList.remove('skeleton-pulse');
                    });

                    // ── TREND BADGES ──
                    const trends = data.tendencias || {};
                    document.querySelectorAll('.trend-badge').forEach(function(el) {
                        const key = el.getAttribute('data-trend');
                        const t = trends[key];
                        if (t) {
                            el.style.display = 'inline-flex';
                            el.style.alignItems = 'center';
                            el.style.gap = '4px';
                            el.style.padding = '3px 10px';
                            el.style.borderRadius = '20px';
                            el.style.fontSize = '10px';
                            el.style.fontWeight = '800';
                            if (t.direction === 'up') {
                                el.style.background = '#f0fdf4';
                                el.style.color = '#16a34a';
                                el.innerHTML = '<i class="fas fa-arrow-up" style="font-size:8px;"></i> +' + t.change + '% vs mes ant.';
                            } else if (t.direction === 'down') {
                                el.style.background = '#fef2f2';
                                el.style.color = '#dc2626';
                                el.innerHTML = '<i class="fas fa-arrow-down" style="font-size:8px;"></i> ' + t.change + '% vs mes ant.';
                            } else {
                                el.style.background = '#f8fafc';
                                el.style.color = '#64748b';
                                el.innerHTML = '<i class="fas fa-minus" style="font-size:8px;"></i> Sin cambios';
                            }
                        }
                    });

                    // ── SUCCESS RATE ──
                    const tasa = data.tasa_exito || {};
                    const estados = data.proyectos_por_estado || {labels:[], data:[]};
                    const successContainer = document.getElementById('successRateContent');
                    if (successContainer && tasa.total > 0) {
                        var idxCompletado = estados.labels.findIndex(function(l) { return l.toLowerCase().includes('completado'); });
                        var idxAprobado = estados.labels.findIndex(function(l) { return l.toLowerCase().includes('aprobado'); });
                        var idxProgreso = estados.labels.findIndex(function(l) { return l.toLowerCase().includes('en progreso'); });
                        var idxRechazado = estados.labels.findIndex(function(l) { return l.toLowerCase().includes('rechazado'); });
                        var idxPendiente = estados.labels.findIndex(function(l) { return l.toLowerCase().includes('pendiente'); });
                        var completados = idxCompletado >= 0 ? estados.data[idxCompletado] : 0;
                        var aprobados = idxAprobado >= 0 ? estados.data[idxAprobado] : 0;
                        var enProgreso = idxProgreso >= 0 ? estados.data[idxProgreso] : 0;
                        var rechazados = idxRechazado >= 0 ? estados.data[idxRechazado] : 0;
                        var pendientes = idxPendiente >= 0 ? estados.data[idxPendiente] : 0;
                        var enCurso = aprobados + enProgreso;
                        var totalActivos = completados + enCurso + pendientes;
                        successContainer.innerHTML = '\
                            <div style="display:flex;gap:12px;margin-bottom:20px;">\
                                <div style="flex:1;text-align:center;padding:16px 8px;background:#f0fdf4;border-radius:12px;border:1px solid #bbf7d0;">\
                                    <div style="font-size:28px;font-weight:900;color:#16a34a;line-height:1.2;">' + tasa.tasa_exito + '%</div>\
                                    <div style="font-size:9px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.3px;margin-top:6px;">Tasa de éxito</div>\
                                    <div style="font-size:11px;font-weight:700;color:#16a34a;margin-top:6px;background:#fff;padding:4px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;"><i class="fas fa-check-circle" style="font-size:9px;"></i> ' + completados + ' completados</div>\
                                </div>\
                                <div style="flex:1;text-align:center;padding:16px 8px;background:#eff6ff;border-radius:12px;border:1px solid #bfdbfe;">\
                                    <div style="font-size:28px;font-weight:900;color:#2563eb;line-height:1.2;">' + tasa.tasa_activos + '%</div>\
                                    <div style="font-size:9px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.3px;margin-top:6px;">En curso</div>\
                                    <div style="font-size:11px;font-weight:700;color:#2563eb;margin-top:6px;background:#fff;padding:4px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;"><i class="fas fa-spinner" style="font-size:9px;"></i> ' + enCurso + ' activos (' + enProgreso + ' prog.)</div>\
                                </div>\
                                <div style="flex:1;text-align:center;padding:16px 8px;background:#fef2f2;border-radius:12px;border:1px solid #fecaca;">\
                                    <div style="font-size:28px;font-weight:900;color:#dc2626;line-height:1.2;">' + tasa.tasa_rechazo + '%</div>\
                                    <div style="font-size:9px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.3px;margin-top:6px;">Tasa de rechazo</div>\
                                    <div style="font-size:11px;font-weight:700;color:#dc2626;margin-top:6px;background:#fff;padding:4px 10px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;"><i class="fas fa-times-circle" style="font-size:9px;"></i> ' + rechazados + ' rechazados</div>\
                                </div>\
                            </div>\
                            <div style="height:180px;position:relative;">\
                                <canvas id="chartSuccessRate"></canvas>\
                            </div>';
                        new Chart(document.getElementById('chartSuccessRate'), {
                            type: 'bar',
                            data: {
                                labels: ['Completados', 'En curso', 'Pendientes', 'Rechazados'],
                                datasets: [{
                                    label: 'Proyectos',
                                    data: [completados, enCurso, pendientes, rechazados],
                                    backgroundColor: ['rgba(22,163,74,0.8)', 'rgba(37,99,235,0.8)', 'rgba(245,158,11,0.8)', 'rgba(220,38,38,0.8)'],
                                    borderColor: ['#16a34a', '#2563eb', '#f59e0b', '#dc2626'],
                                    borderWidth: 2, borderRadius: 6, borderSkipped: false
                                }]
                            },
                            options: {
                                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(255,255,255,0.95)', titleColor: '#1e293b',
                                        bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0',
                                        borderWidth: 1, cornerRadius: 12,
                                        callbacks: {
                                            label: function(ctx) { return ctx.parsed.x + ' (' + ((ctx.parsed.x / tasa.total) * 100).toFixed(1) + '%)'; }
                                        }
                                    }
                                },
                                scales: {
                                    x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1, callback: function(v) { return Number.isInteger(v) ? v : ''; } } },
                                    y: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 11, weight: '700' } } }
                                }
                            }
                        });
                    } else if (successContainer) {
                        successContainer.innerHTML = '<div style="text-align:center;padding:40px;color:#94a3b8;font-size:13px;font-weight:600;"><i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:12px;"></i>Sin proyectos para evaluar</div>';
                    }

                    // ── PREDICTIONS ──
                    const pred = data.predicciones || {};
                    const predCanvas = document.getElementById('chartPredicciones');
                    if (pred.historico && pred.historico.length && predCanvas) {
                        var allLabels = (pred.labels_meses || []).concat(pred.labels_pred || []);
                        var allData = (pred.historico || []).concat(pred.predicciones || []);
                        var split = (pred.historico || []).length;
                        var trendLabel = document.getElementById('trendLabel');
                        if (trendLabel) {
                            trendLabel.className = '';
                            trendLabel.style.padding = '4px 12px';
                            trendLabel.style.borderRadius = '20px';
                            trendLabel.style.fontSize = '10px';
                            trendLabel.style.fontWeight = '800';
                            if (pred.tendencia === 'creciente') {
                                trendLabel.style.background = '#f0fdf4';
                                trendLabel.style.color = '#16a34a';
                                trendLabel.innerHTML = '<i class="fas fa-arrow-trend-up"></i> +' + pred.pendiente + '/mes';
                            } else if (pred.tendencia === 'decreciente') {
                                trendLabel.style.background = '#fef2f2';
                                trendLabel.style.color = '#dc2626';
                                trendLabel.innerHTML = '<i class="fas fa-arrow-trend-down"></i> ' + pred.pendiente + '/mes';
                            } else {
                                trendLabel.style.background = '#f8fafc';
                                trendLabel.style.color = '#64748b';
                                trendLabel.innerHTML = '<i class="fas fa-minus"></i> Estable';
                            }
                        }
                        var meta = document.getElementById('predictionMeta');
                        if (meta) {
                            meta.innerHTML = '\
                                <div style="flex:1;padding:12px 8px;background:#f8fafc;border-radius:10px;text-align:center;border:1px solid #e2e8f0;">\
                                    <div style="font-size:18px;font-weight:900;color:var(--text);">' + pred.promedio_mensual + '</div>\
                                    <div style="font-size:9px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:0.3px;margin-top:2px;">Prom. mensual</div>\
                                </div>\
                                <div style="flex:1;padding:12px 8px;background:#f0fdf4;border-radius:10px;text-align:center;border:1px solid #bbf7d0;">\
                                    <div style="font-size:18px;font-weight:900;color:#16a34a;">' + pred.proyectado_anual + '</div>\
                                    <div style="font-size:9px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.3px;margin-top:2px;">Proy. anual</div>\
                                </div>\
                                <div style="flex:1;padding:12px 8px;background:' + (pred.pendiente >= 0 ? '#f0fdf4' : '#fef2f2') + ';border-radius:10px;text-align:center;border:1px solid ' + (pred.pendiente >= 0 ? '#bbf7d0' : '#fecaca') + ';">\
                                    <div style="font-size:18px;font-weight:900;color:' + (pred.pendiente >= 0 ? '#16a34a' : '#dc2626') + ';">' + (pred.pendiente >= 0 ? '+' : '') + pred.pendiente + '</div>\
                                    <div style="font-size:9px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.3px;margin-top:2px;">Pendiente</div>\
                                </div>';
                        }
                        var ctxPred = predCanvas.getContext('2d');
                        var gradPred = ctxPred.createLinearGradient(0, 0, 0, 260);
                        gradPred.addColorStop(0, 'rgba(16,185,129,0.35)');
                        gradPred.addColorStop(1, 'rgba(16,185,129,0)');
                        new Chart(predCanvas, {
                            type: 'line',
                            data: {
                                labels: allLabels,
                                datasets: [{
                                    label: 'Proyectos',
                                    data: allData,
                                    borderColor: '#10b981',
                                    backgroundColor: gradPred,
                                    borderWidth: 3, fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: allData.map(function(_, i) { return i >= split ? '#6366f1' : '#fff'; }),
                                    pointBorderColor: allData.map(function(_, i) { return i >= split ? '#6366f1' : '#10b981'; }),
                                    pointBorderWidth: 2, pointRadius: allData.map(function(_, i) { return i >= split ? 5 : 4; }),
                                    pointHoverRadius: 6,
                                    borderDash: allData.map(function(_, i) { return i >= split ? [6,4] : []; }),
                                    segment: {
                                        borderDash: function(ctx) { return ctx.p1DataIndex >= split ? [6,4] : []; }
                                    }
                                }]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: 'rgba(255,255,255,0.95)', titleColor: '#1e293b',
                                        bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0',
                                        borderWidth: 1, cornerRadius: 12,
                                        callbacks: {
                                            label: function(ctx) {
                                                var isPred = ctx.dataIndex >= split;
                                                return (isPred ? '🔮 Proyectado: ' : '📊 ') + ctx.parsed.y;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 } },
                                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 9, weight: '600' } } }
                                }
                            }
                        });
                    } else if (predCanvas) {
                        predCanvas.parentElement.innerHTML = '<div style="text-align:center;padding:40px;color:#94a3b8;font-size:13px;font-weight:600;"><i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:12px;"></i>Datos insuficientes para proyección</div>';
                    }

                    // ── USER REGISTRATION TREND ──
                    const regUsuarios = data.registro_usuarios_mensual || {labels:[], aprendices:[], instructores:[], empresas:[]};
                    if (regUsuarios.labels.length) {
                        new Chart(document.getElementById('chartRegistroUsuarios'), {
                            type: 'bar',
                            data: {
                                labels: regUsuarios.labels,
                                datasets: [
                                    { label: 'Aprendices', data: regUsuarios.aprendices, backgroundColor: 'rgba(219, 39, 119, 0.7)', borderColor: '#db2777', borderWidth: 1, borderRadius: 3 },
                                    { label: 'Instructores', data: regUsuarios.instructores, backgroundColor: 'rgba(99, 102, 241, 0.7)', borderColor: '#6366f1', borderWidth: 1, borderRadius: 3 },
                                    { label: 'Empresas', data: regUsuarios.empresas, backgroundColor: 'rgba(245, 158, 11, 0.7)', borderColor: '#f59e0b', borderWidth: 1, borderRadius: 3 }
                                ]
                            },
                            options: {
                                responsive: true, maintainAspectRatio: false,
                                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { family: 'Open Sans', size: 10, weight: '600' } } }, tooltip: { backgroundColor: 'rgba(255, 255, 255, 0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 } },
                                scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 } }, x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 9, weight: '600' } } } }
                            }
                        });
                    } else {
                        document.getElementById('chartRegistroUsuarios').parentElement.innerHTML = '<div style="text-align:center;padding:40px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin registros nuevos</div>';
                    }
                })
                .catch(err => console.error('Error cargando stats:', err));
        });
    </script>
@endsection