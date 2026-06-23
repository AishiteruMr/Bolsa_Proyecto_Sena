@extends('layouts.dashboard')

@section('title', 'Panel de Control - Inspírate SENA')
@section('page-title', 'Centro de Mando del Instructor')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('instructor.aprendices') }}" class="nav-item {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Perfil
    </a>
@endsection

@section('styles')
    @vite(['resources/css/instructor.css'])
@endsection

@php $breadcrumbs = [['label' => 'Inicio']]; @endphp
@section('content')
<div class="animate-fade-in dashboard-wrapper">
    
    <!-- HEADER INSTRUCTOR (reutiliza estilos de instructor.css) -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
                <span class="instructor-tag">Instructor Hub</span>
                <span id="current-time" style="color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 600;"></span>
            </div>
            <h1 class="instructor-title">Centro de Mando del <span style="color: var(--primary);">Instructor</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; max-width: 720px; line-height: 1.6; font-weight: 500;">Tu centro de mando para la excelencia académica y la gestión de proyectos de impacto.</p>
        </div>
    </div>

    <!-- BENTO STATS GRID -->
    <div class="instructor-stat-grid">
        
        <!-- Large Stat Card -->
        <div class="instructor-stat-card-lg glass-card">
            <div class="instructor-stat-icon-main">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div>
                <div style="font-size: 44px; font-weight: 800; color: var(--text); line-height: 1;">{{ $proyectosAsignados }}</div>
                <div style="font-size: 14px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Proyectos Bajo tu Guía</div>
            </div>
        </div>

        <!-- Warning Stat Card -->
        <div class="instructor-warning-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-clock"></i>
                </div>
                <span style="font-size: 10px; font-weight: 800; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px;">ACCIÓN REQUERIDA</span>
            </div>
            <div style="margin-top: 24px;">
                <div style="font-size: 36px; font-weight: 800;">{{ $evidenciasPendientes }}</div>
                <div style="font-size: 13px; font-weight: 600; opacity: 0.9;">Evidencias sin calificar</div>
            </div>
        </div>

        <!-- Success Stat Card -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--radius); padding: 24px;">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div style="margin-top: 24px;">
                <div style="font-size: 36px; font-weight: 800; color: var(--text);">{{ $totalAprendices }}</div>
                <div style="font-size: 13px; font-weight: 600; color: var(--text-light);">Aprendices Aprobados</div>
            </div>
        </div>
    </div>

    <!-- MÉTRICAS DE SEGUIMIENTO -->
    <div class="instructor-metrics-row">
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#065f46;background:#ecfdf5;">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div class="instructor-metric-num">{{ $proyectosCompletados }}</div>
                <div class="instructor-metric-lbl">Completados</div>
            </div>
        </div>
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#3b82f6;background:#eff6ff;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="instructor-metric-num">{{ $totalPostulaciones }}</div>
                <div class="instructor-metric-lbl">Postulaciones</div>
            </div>
        </div>
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#10b981;background:#f0fdf4;">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="instructor-metric-num">{{ $postulacionesAceptadas }}</div>
                <div class="instructor-metric-lbl">Aceptadas</div>
            </div>
        </div>
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#8b5cf6;background:#f5f3ff;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <div class="instructor-metric-num">{{ $tasaAprobacionGlobal }}%</div>
                <div class="instructor-metric-lbl">Aprobación Global</div>
            </div>
        </div>
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#f59e0b;background:#fffbeb;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div style="flex:1;">
                @php
                    $estadosColores = ['pendiente'=>'#f59e0b','aprobado'=>'#10b981','en_progreso'=>'#3b82f6','completado'=>'#065f46','rechazado'=>'#ef4444','cerrado'=>'#64748b'];
                    $estadosLabels = ['pendiente'=>'Pend.','aprobado'=>'Aprob.','en_progreso'=>'Prog.','completado'=>'Comp.','rechazado'=>'Rech.','cerrado'=>'Cerrado'];
                @endphp
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    @foreach(['pendiente','aprobado','en_progreso','completado','rechazado','cerrado'] as $est)
                        @if(isset($proyectosPorEstado[$est]) && $proyectosPorEstado[$est] > 0)
                            <span class="rp-bdg-status" style="background:{{ $estadosColores[$est] }};font-size:0.55rem;padding:2px 8px;">{{ $proyectosPorEstado[$est] }} {{ $estadosLabels[$est] }}</span>
                        @endif
                    @endforeach
                </div>
                <div class="instructor-metric-lbl" style="margin-top:4px;">Distribución</div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID: PROJECTS + QUICK ACTIONS -->
    <div class="instructor-main-grid">
        
        <!-- Left: Active Projects -->
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <span style="width: 8px; height: 24px; background: var(--primary); border-radius: 4px;"></span>
                    Proyectos en Ejecución
                </h3>
                <a href="{{ route('instructor.proyectos') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 14px; transition: gap 0.3s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                    Ver catálogo <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                </a>
            </div>

            <div class="instructor-project-grid">
                @forelse($proyectos as $p)
                    <div class="instructor-project-card">
                        <div style="height: 160px; position: relative;">
                            <img src="{{ $p->imagen_url }}" loading="lazy" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="instructor-project-image-badge">
                                {{ $p->categoria }}
                            </div>
                        </div>
                        <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                            <h4 class="instructor-project-title" style="font-size: 17px; margin-bottom:8px;">{{ $p->titulo }}</h4>
                            @if($p->oferta)
                            <div style="font-size: 11px; font-weight: 800; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 5px; background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(124,58,237,0.08)); color: #7c3aed; padding: 4px 12px 4px 8px; border-radius: 20px; border: 1px solid rgba(139,92,246,0.15); box-shadow: 0 2px 6px rgba(139,92,246,0.08);">
                                <i class="fas fa-gift" style="font-size: 10px;"></i>
                                @switch($p->oferta)
                                    @case('pasantias') Pasantías @break
                                    @case('contrato_aprendizaje') Contrato aprendizaje @break
                                    @case('auxilio_transporte') Auxilio transporte @break
                                    @case('otro') {{ $p->oferta_otro }} @break
                                @endswitch
                            </div>
                            @endif
                            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                                <div class="instructor-small-stat">
                                    <span class="count">{{ $p->postulaciones->where('estado', 'aceptada')->count() }}</span>
                                    <span class="label">Activos</span>
                                </div>
                                <div class="instructor-small-stat">
                                    <span class="count">{{ $p->postulaciones->where('estado', 'pendiente')->count() }}</span>
                                    <span class="label">Nuevos</span>
                                </div>
                            </div>
                            <a href="{{ route('instructor.proyecto.detalle', $p->id) }}" class="btn-premium" style="width: 100%; justify-content: center; font-size: 13px; padding: 10px;">
                                Gestionar <i class="fas fa-play" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="glass-card aprendiz-empty-state" style="grid-column: span 2; padding: 48px; text-align: center;">
                        <i class="fas fa-folder-open" style="font-size: 40px; color: var(--text-lighter); margin-bottom: 16px;"></i>
                        <p style="color: var(--text-light); font-weight: 600;">No tienes proyectos asignados actualmente.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Activity, Notifications & Quick Actions -->
        <div>
            <h3 class="mb-6" style="font-size:18px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:10px;">
                <span style="width:6px;height:20px;background:var(--primary);border-radius:3px;display:inline-block;"></span>
                Centro de Monitoreo
            </h3>

            <div class="instructor-notification-card">
                <div style="display:flex;flex-direction:column;gap:16px;">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:42px;height:42px;border-radius:12px;background:rgba(62,180,137,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-bolt" style="color:#3eb489;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:0.75rem;font-weight:700;color:var(--text-light);text-transform:uppercase;">Postulaciones (48h)</div>
                            <div style="font-size:1.1rem;font-weight:900;color:var(--text);">{{ $nuevasPostulaciones }} Recientes</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:42px;height:42px;border-radius:12px;background:rgba(245,158,11,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-calendar-alt" style="color:#f59e0b;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:0.75rem;font-weight:700;color:var(--text-light);text-transform:uppercase;">Próximo Hito</div>
                            <div style="font-size:1.1rem;font-weight:900;color:var(--text);">
                                {{ ($proximoCierre && $proximoCierre->fecha_publicacion) ? \Carbon\Carbon::parse($proximoCierre->fecha_publicacion)->addDays($proximoCierre->duracion_estimada_dias ?? 0)->diffForHumans() : 'Sin eventos' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($actividadReciente->count() > 0)
            <div class="instructor-activity-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <h4 style="font-size:0.9rem;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-history" style="color:var(--primary);font-size:0.85rem;"></i>
                        Actividad Reciente (7d)
                    </h4>
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($actividadReciente as $act)
                        @php
                            $actIcon = match($act->estado) {
                                'aceptada' => ['i'=>'fa-check-circle','c'=>'#22c55e'],
                                'rechazada' => ['i'=>'fa-times-circle','c'=>'#ef4444'],
                                'pendiente' => ['i'=>'fa-hourglass-half','c'=>'#f59e0b'],
                                default => ['i'=>'fa-circle','c'=>'#94a3b8'],
                            };
                        @endphp
                        <div style="display:flex;align-items:center;gap:10px;padding:8px 10px;background:var(--primary-soft);border-radius:10px;border:1px solid var(--border);">
                            <div style="width:8px;height:8px;border-radius:50%;background:{{ $actIcon['c'] }};flex-shrink:0;"></div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:0.75rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $act->aprendiz_nombres }} {{ $act->aprendiz_apellidos }}
                                </div>
                                <div style="font-size:0.65rem;color:var(--text-light);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ Str::limit($act->proyecto_titulo, 35) }}
                                </div>
                            </div>
                            <span style="font-size:0.6rem;color:{{ $actIcon['c'] }};font-weight:700;white-space:nowrap;">{{ Str::title($act->estado) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="instructor-quick-actions">
                <h4 style="font-size:16px;font-weight:900;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-rocket" style="font-size:14px;"></i> Acceso Rápido
                </h4>
                <div style="display:grid;gap:10px;">
                    <a href="{{ route('instructor.proyectos') }}" class="instructor-action-link">
                        <i class="fas fa-project-diagram" style="color:var(--primary);"></i>
                        <span style="font-size:13px;font-weight:600;">Mis Proyectos</span>
                    </a>
                    <a href="{{ route('instructor.historial') }}" class="instructor-action-link">
                        <i class="fas fa-history" style="color:var(--primary);"></i>
                        <span style="font-size:13px;font-weight:600;">Historial</span>
                    </a>
                    <a href="{{ route('instructor.aprendices') }}" class="instructor-action-link">
                        <i class="fas fa-users" style="color:var(--primary);"></i>
                        <span style="font-size:13px;font-weight:600;">Base de Aprendices</span>
                    </a>
                    <a href="{{ route('instructor.perfil') }}" class="instructor-action-link">
                        <i class="fas fa-cog" style="color:var(--primary);"></i>
                        <span style="font-size:13px;font-weight:600;">Ajustes de Perfil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
