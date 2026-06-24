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
    <span class="nav-label">Comunicación</span>
    <a href="{{ route('chat.index') }}" class="nav-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
        <i class="fas fa-comment-dots"></i> Mensajes
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Perfil
    </a>
@endsection

@section('styles')
    @vite(['resources/css/instructor.css'])
@endsection

@php
$breadcrumbs = [['label' => 'Inicio']];
$hora = now()->format('H');
$saludo = $hora < 12 ? 'Buenos días' : ($hora < 18 ? 'Buenas tardes' : 'Buenas noches');
@endphp
@section('content')
<div class="animate-fade-in dashboard-wrapper">

    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
                <span class="instructor-tag">Instructor Hub</span>
                <span id="current-time" style="color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 600;"></span>
            </div>
            <h1 class="instructor-title">{{ $saludo }}, <span style="color: var(--primary);">{{ session('nombre') }}</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; max-width: 720px; line-height: 1.6; font-weight: 500;">Centro de mando para la excelencia académica y la gestión de proyectos de impacto.</p>
        </div>
        @if($progresoCompletado > 0)
        <div class="instructor-hero-progress">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                <span style="color:rgba(255,255,255,0.6);font-size:11px;font-weight:700;text-transform:uppercase;">Progreso general</span>
                <span style="color:#3eb489;font-size:13px;font-weight:800;">{{ $progresoCompletado }}%</span>
            </div>
            <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width:{{ $progresoCompletado }}%;"></div>
            </div>
        </div>
        @endif
    </div>

    <div class="instructor-stat-grid">
        <div class="instructor-stat-card-lg glass-card">
            <div class="instructor-stat-icon-main">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div>
                <div class="instructor-counter" data-target="{{ $proyectosAsignados }}" style="font-size:44px;font-weight:800;color:var(--text);line-height:1;">0</div>
                <div style="font-size:14px;font-weight:700;color:var(--text-light);text-transform:uppercase;letter-spacing:1px;margin-top:4px;">Proyectos Bajo tu Guía</div>
            </div>
        </div>

        <div class="instructor-warning-card">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:22px;">
                    <i class="fas fa-clock"></i>
                </div>
                <span style="font-size:10px;font-weight:800;background:rgba(255,255,255,0.2);padding:4px 10px;border-radius:20px;">ACCIÓN REQUERIDA</span>
            </div>
            <div style="margin-top:24px;">
                <div class="instructor-counter" data-target="{{ $evidenciasPendientes }}" style="font-size:36px;font-weight:800;">0</div>
                <div style="font-size:13px;font-weight:600;opacity:0.9;">Evidencias sin calificar</div>
                @if($evidenciasUrgentes > 0)
                <div style="margin-top:6px;font-size:11px;font-weight:700;opacity:0.85;">
                    <i class="fas fa-exclamation-circle"></i> {{ $evidenciasUrgentes }} urgentes (últimas 48h)
                </div>
                @endif
            </div>
        </div>

        <div class="glass-card instructor-stat-success">
            <div style="width:48px;height:48px;border-radius:14px;background:rgba(62,180,137,0.1);color:#3eb489;display:flex;align-items:center;justify-content:center;font-size:22px;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div style="margin-top:24px;">
                <div class="instructor-counter" data-target="{{ $totalAprendices }}" style="font-size:36px;font-weight:800;color:var(--text);">0</div>
                <div style="font-size:13px;font-weight:600;color:var(--text-light);">Aprendices Aprobados</div>
            </div>
        </div>
    </div>

    <div class="instructor-metrics-row">
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#065f46;background:#ecfdf5;">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div class="instructor-metric-num instructor-counter" data-target="{{ $proyectosCompletados }}">0</div>
                <div class="instructor-metric-lbl">Completados</div>
            </div>
        </div>
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#3b82f6;background:#eff6ff;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="instructor-metric-num instructor-counter" data-target="{{ $totalPostulaciones }}">0</div>
                <div class="instructor-metric-lbl">Postulaciones</div>
            </div>
        </div>
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#10b981;background:#f0fdf4;">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="instructor-metric-num instructor-counter" data-target="{{ $postulacionesAceptadas }}">0</div>
                <div class="instructor-metric-lbl">Aceptadas</div>
            </div>
        </div>
        <div class="instructor-metric-card">
            <div class="instructor-metric-icon" style="color:#8b5cf6;background:#f5f3ff;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <div class="instructor-metric-num instructor-counter" data-target="{{ $tasaAprobacionGlobal }}" data-suffix="%">0</div>
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
                    $estadosTotales = array_sum($proyectosPorEstado->toArray()) ?: 1;
                @endphp
                <div style="display:flex;gap:4px;height:6px;border-radius:3px;overflow:hidden;margin-bottom:6px;">
                    @foreach(['pendiente','aprobado','en_progreso','completado','rechazado','cerrado'] as $est)
                        @if(isset($proyectosPorEstado[$est]) && $proyectosPorEstado[$est] > 0)
                            <div style="flex:{{ $proyectosPorEstado[$est] }};background:{{ $estadosColores[$est] }};border-radius:3px;" title="{{ $estadosLabels[$est] }}: {{ $proyectosPorEstado[$est] }}"></div>
                        @endif
                    @endforeach
                </div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    @foreach(['pendiente','aprobado','en_progreso','completado','rechazado','cerrado'] as $est)
                        @if(isset($proyectosPorEstado[$est]) && $proyectosPorEstado[$est] > 0)
                            <span class="rp-bdg-status" style="background:{{ $estadosColores[$est] }};font-size:0.5rem;padding:2px 6px;">{{ $proyectosPorEstado[$est] }} {{ $estadosLabels[$est] }}</span>
                        @endif
                    @endforeach
                </div>
                <div class="instructor-metric-lbl" style="margin-top:4px;">Distribución</div>
            </div>
        </div>
    </div>

    @if($evidenciasPendientes > 0 && $evidenciasPendientesLista->count() > 0)
    <div class="instructor-evidence-alert">
        <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(245,158,11,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-tasks" style="color:#f59e0b;font-size:20px;"></i>
            </div>
            <div style="flex:1;min-width:200px;">
                <div style="font-size:14px;font-weight:800;color:var(--text);">Tienes <span style="color:#f59e0b;">{{ $evidenciasPendientes }} evidencias</span> pendientes por calificar</div>
                <div style="font-size:12px;color:var(--text-light);font-weight:500;">{{ $evidenciasPendientesLista->count() }} más recientes listadas abajo</div>
            </div>
            <a href="{{ route('instructor.proyectos') }}" class="btn-premium" style="font-size:12px;padding:10px 18px;">
                Ir a proyectos <i class="fas fa-arrow-right" style="font-size:10px;"></i>
            </a>
        </div>
    </div>
    @endif

    <div class="instructor-main-grid">
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
                <h3 style="font-size:22px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:12px;">
                    <span style="width:8px;height:24px;background:var(--primary);border-radius:4px;"></span>
                    Proyectos en Ejecución
                </h3>
                <a href="{{ route('instructor.proyectos') }}" style="color:var(--primary);font-weight:700;text-decoration:none;font-size:14px;transition:gap 0.3s;display:flex;align-items:center;gap:6px;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                    Ver catálogo <i class="fas fa-chevron-right" style="font-size:12px;"></i>
                </a>
            </div>

            <div class="instructor-project-grid">
                @forelse($proyectos as $p)
                    <div class="instructor-project-card">
                        <div style="height:160px;position:relative;">
                            <img src="{{ $p->imagen_url }}" loading="lazy" alt="" style="width:100%;height:100%;object-fit:cover;">
                            <div class="instructor-project-image-badge">{{ $p->categoria }}</div>
                            @if($p->estado === 'en_progreso')
                            <div style="position:absolute;top:16px;right:16px;background:#3b82f6;color:white;padding:4px 10px;border-radius:20px;font-size:10px;font-weight:800;text-transform:uppercase;">Activo</div>
                            @endif
                        </div>
                        <div style="padding:24px;flex:1;display:flex;flex-direction:column;">
                            <h4 class="instructor-project-title" style="font-size:17px;margin-bottom:8px;">{{ $p->titulo }}</h4>
                            @if($p->empresa)
                            <div style="font-size:12px;color:var(--text-light);font-weight:600;margin-bottom:10px;">
                                <i class="fas fa-building" style="font-size:10px;"></i> {{ $p->empresa->nombre ?? $p->empresa->razon_social ?? '' }}
                            </div>
                            @endif
                            <div style="display:flex;gap:12px;margin-bottom:20px;">
                                <div class="instructor-small-stat">
                                    <span class="count">{{ $p->postulaciones->where('estado', 'aceptada')->count() }}</span>
                                    <span class="label">Activos</span>
                                </div>
                                <div class="instructor-small-stat">
                                    <span class="count">{{ $p->postulaciones->where('estado', 'pendiente')->count() }}</span>
                                    <span class="label">Nuevos</span>
                                </div>
                            </div>
                            <a href="{{ route('instructor.proyecto.detalle', $p->id) }}" class="btn-premium" style="width:100%;justify-content:center;font-size:13px;padding:10px;">
                                Gestionar <i class="fas fa-play" style="font-size:10px;"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="glass-card" style="grid-column:span 2;padding:48px;text-align:center;">
                        <i class="fas fa-folder-open" style="font-size:40px;color:var(--text-lighter);margin-bottom:16px;"></i>
                        <p style="color:var(--text-light);font-weight:600;">No tienes proyectos asignados actualmente.</p>
                    </div>
                @endforelse
            </div>
        </div>

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
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:42px;height:42px;border-radius:12px;background:rgba(59,130,246,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-bell" style="color:#3b82f6;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:0.75rem;font-weight:700;color:var(--text-light);text-transform:uppercase;">Notificaciones</div>
                            <div style="font-size:1.1rem;font-weight:900;color:var(--text);">
                                {{ $notificacionesNoLeidas }} {{ $notificacionesNoLeidas === 1 ? 'Sin leer' : 'Sin leer' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($evidenciasPendientesLista->count() > 0)
            <div class="instructor-activity-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <h4 style="font-size:0.9rem;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-tasks" style="color:#f59e0b;font-size:0.85rem;"></i>
                        Evidencias Pendientes
                    </h4>
                    <a href="{{ route('instructor.proyectos') }}" style="font-size:11px;color:var(--primary);font-weight:700;text-decoration:none;">Ir a proyectos</a>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($evidenciasPendientesLista as $ev)
                    <a href="{{ route('instructor.proyecto.detalle', $ev->proyecto_id) }}" style="display:flex;align-items:center;gap:10px;padding:8px 10px;background:rgba(245,158,11,0.06);border-radius:10px;border:1px solid rgba(245,158,11,0.12);text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='rgba(245,158,11,0.12)'" onmouseout="this.style.background='rgba(245,158,11,0.06)'">
                        <div style="width:6px;height:6px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:0.72rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $ev->aprendiz_nombres }} {{ $ev->aprendiz_apellidos }}</div>
                            <div style="font-size:0.62rem;color:var(--text-light);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($ev->proyecto_titulo, 30) }} · {{ $ev->fecha_envio ? \Carbon\Carbon::parse($ev->fecha_envio)->diffForHumans() : '' }}</div>
                        </div>
                        <span style="font-size:0.55rem;color:#f59e0b;font-weight:800;text-transform:uppercase;white-space:nowrap;">Calificar</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($actividadReciente->count() > 0)
            <div class="instructor-activity-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <h4 style="font-size:0.9rem;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-history" style="color:var(--primary);font-size:0.85rem;"></i>
                        Actividad Reciente (7d)
                    </h4>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($actividadReciente->take(5) as $act)
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
                                <div style="font-size:0.72rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $act->aprendiz_nombres }} {{ $act->aprendiz_apellidos }}</div>
                                <div style="font-size:0.62rem;color:var(--text-light);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($act->proyecto_titulo, 30) }}</div>
                            </div>
                            <span style="font-size:0.55rem;color:{{ $actIcon['c'] }};font-weight:800;white-space:nowrap;text-transform:uppercase;">{{ $act->estado }}</span>
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
                    <a href="{{ route('instructor.proyectos') }}" class="instructor-action-link">
                        <i class="fas fa-check-double" style="color:var(--primary);"></i>
                        <span style="font-size:13px;font-weight:600;">Ir a Evidencias</span>
                        @if($evidenciasPendientes > 0)
                        <span style="margin-left:auto;background:#f59e0b;color:white;font-size:10px;font-weight:800;padding:2px 8px;border-radius:20px;">{{ $evidenciasPendientes }}</span>
                        @endif
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-target'));
        const suffix = el.getAttribute('data-suffix') || '';
        const duration = 1200;
        const start = performance.now();
        function update(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(eased * target);
            el.textContent = current + suffix;
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    }
    document.querySelectorAll('.instructor-counter').forEach(animateCounter);
});
</script>
@endsection
