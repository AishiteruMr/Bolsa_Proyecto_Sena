@extends('layouts.dashboard')

@section('title', 'Mis Entregas y Evidencias')
@section('page-title', 'Mis Entregas')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    @vite(['resources/css/aprendiz.css'])
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('aprendiz.dashboard')], ['label' => 'Mis Entregas']]; @endphp
@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-tasks"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span class="instructor-tag">Entregas</span>
            </div>
            <h1 class="instructor-title">Mis <span style="color: var(--primary);">Entregas</span> y Evidencias</h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; font-weight: 500;">Seguimiento de tus entregables en proyectos aprobados.</p>
        </div>
    </div>

    @if($proyectos->count() > 0)
        <div class="instructor-stat-grid" style="margin-bottom: 32px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: var(--text); line-height: 1;">{{ $evidencias->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Evidencias Totales</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #bbf7d0;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #34d399; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #065f46; line-height: 1;">{{ $evidencias->where('estado', 'aceptada')->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Aprobadas</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fde68a;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #fbbf24; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #b45309; line-height: 1;">{{ $evidencias->where('estado', 'pendiente')->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Pendientes</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fecaca;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #f87171; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #b91c1c; line-height: 1;">{{ $evidencias->where('estado', 'rechazada')->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Rechazadas</div>
                </div>
            </div>
        </div>

        <div id="entregas-grid" style="display: grid; gap: 32px;">
            @foreach($proyectos as $proyecto)
                @php
                    $evidencias_proyecto = $evidencias->where('proyecto_id', $proyecto->id);
                @endphp
                <div class="glass-card" style="padding: 0; overflow: hidden;">
                    <div style="padding: 24px 32px; background: linear-gradient(135deg, rgba(62,180,137,0.05), rgba(62,180,137,0.02)); border-bottom: 1px solid rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 4px;">{{ $proyecto->titulo }}</h4>
                                <p style="font-size: 13px; color: var(--text-light); margin: 0; font-weight: 600;">
                                    <i class="fas fa-building" style="margin-right: 6px; color: #3eb489;"></i>{{ $proyecto->nombre }}
                                    &nbsp;&middot;&nbsp;
                                    <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>Cierre: {{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <span style="background: rgba(62,180,137,0.1); border: 1px solid rgba(62,180,137,0.2); padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 800; color: #3eb489;">
                            {{ $evidencias_proyecto->count() }} Evidencias
                        </span>
                    </div>

                    <div style="padding: 24px 32px; display: grid; gap: 16px;">
                        @if($evidencias_proyecto->count() > 0)
                            @foreach($evidencias_proyecto as $evidencia)
                                @php
                                    $stateColor = match($evidencia->estado) {
                                        'aceptada'  => ['bg' => '#d1fae5', 'border' => '#86efac', 'text' => '#065f46', 'icon' => 'fa-check'],
                                        'rechazada' => ['bg' => '#fee2e2', 'border' => '#fca5a5', 'text' => '#991b1b', 'icon' => 'fa-ban'],
                                        'pendiente' => ['bg' => '#fef3c7', 'border' => '#fcd34d', 'text' => '#92400e', 'icon' => 'fa-clock'],
                                        'en_progreso' => ['bg' => '#dbeafe', 'border' => '#93c5fd', 'text' => '#1e40af', 'icon' => 'fa-spinner'],
                                        default     => ['bg' => '#f1f5f9', 'border' => '#cbd5e1', 'text' => '#475569', 'icon' => 'fa-info-circle'],
                                    };
                                @endphp
                                <div data-evidencia-id="{{ $evidencia->id }}" data-evidencia-estado="{{ $evidencia->estado }}" style="background: {{ $stateColor['bg'] }}; border: 1.5px solid {{ $stateColor['border'] }}; border-radius: 16px; padding: 20px 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateX(8px)'" onmouseout="this.style.transform='translateX(0)'">
                                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                                        <div style="flex: 1; min-width: 280px;">
                                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                                <span style="width: 32px; height: 32px; border-radius: 10px; background: {{ $stateColor['bg'] }}; color: {{ $stateColor['text'] }}; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; flex-shrink: 0;">
                                                    {{ $evidencia->etapa->orden ?? '?' }}
                                                </span>
                                                <h5 style="font-size: 16px; font-weight: 800; color: var(--text); margin: 0;">
                                                    {{ $evidencia->etapa->nombre ?? 'Etapa sin nombre' }}
                                                </h5>
                                            </div>
                                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600; margin-bottom: 10px;">
                                                <i class="far fa-clock" style="margin-right: 8px;"></i>
                                                Entregado: {{ $evidencia->fecha_envio->translatedFormat('d M Y, H:i') }}
                                            </div>
                                            @if($evidencia->comentario_instructor)
                                                <div style="background: rgba(255,255,255,0.8); border-radius: 10px; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.05);">
                                                    <p style="font-size: 13px; color: var(--text); font-weight: 600; margin: 0;">
                                                        <i class="fas fa-comment-dots" style="color: #3eb489; margin-right: 8px;"></i>{{ $evidencia->comentario_instructor }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px; flex-shrink: 0;">
                                                <span style="background: {{ $stateColor['bg'] }}; color: {{ $stateColor['text'] }}; border: 1.5px solid {{ $stateColor['border'] }}; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; white-space: nowrap; display: flex; align-items: center; gap: 8px;">
                                                    <i class="fas {{ $stateColor['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $evidencia->estado)) }}
                                                </span>
                                            @if($evidencia->ruta_archivo)
                                                <a href="{{ asset('storage/' . $evidencia->ruta_archivo) }}" target="_blank"
                                                   class="btn-premium" style="padding: 8px 16px; font-size: 12px;">
                                                    <i class="fas fa-file-download"></i> Ver Archivo
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 48px; background: rgba(62,180,137,0.02); border-radius: 16px; border: 2px dashed rgba(62,180,137,0.1);">
                                <i class="fas fa-inbox" style="font-size: 36px; color: var(--text-lighter); margin-bottom: 12px; display: block;"></i>
                                <p style="font-weight: 700; color: var(--text-light); margin: 0;">Sin evidencias registradas aún</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($proyectos->hasPages())
            <div id="entregas-pagination" style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $proyectos->withQueryString()->links() }}
            </div>
        @endif
    @else
        <div class="glass-card" style="padding: 80px 40px; text-align: center;">
            <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px; color: #3eb489;">
                <i class="fas fa-inbox"></i>
            </div>
            <h4 style="color: var(--text); font-size: 22px; font-weight: 800; margin-bottom: 8px;">Sin proyectos aprobados</h4>
            <p style="color: var(--text-light); max-width: 450px; margin: 0 auto 32px;">
                Cuando tengas un proyecto aprobado, podrás gestionar y enviar tus evidencias desde aquí.
            </p>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="display: inline-flex;">
                <i class="fas fa-search"></i> Explorar Proyectos
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
(function () {
    if (!document.getElementById('entregas-grid')) return;

    const ESTADO_COLORS = {
        'aceptada':   { bg: '#d1fae5', border: '#86efac', text: '#065f46', icon: 'fa-check' },
        'rechazada':  { bg: '#fee2e2', border: '#fca5a5', text: '#991b1b', icon: 'fa-ban' },
        'pendiente':  { bg: '#fef3c7', border: '#fcd34d', text: '#92400e', icon: 'fa-clock' },
        'en_progreso':{ bg: '#dbeafe', border: '#93c5fd', text: '#1e40af', icon: 'fa-spinner' },
    };

    let rtFallbackDebounce = null;

    function fallbackRefreshEntregas() {
        fetch(window.location.href)
            .then(r => r.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newGrid = doc.getElementById('entregas-grid');
                const newPag  = doc.getElementById('entregas-pagination');
                const curGrid = document.getElementById('entregas-grid');
                const curPag  = document.getElementById('entregas-pagination');
                if (newGrid && curGrid) curGrid.innerHTML = newGrid.innerHTML;
                if (newPag && curPag) curPag.innerHTML = newPag.innerHTML;
                if (!newPag && curPag) curPag.innerHTML = '';
            })
            .catch(() => {});
    }

    window.addEventListener('realtime:evidencia', function (e) {
        const d = e.detail || {};
        const evidenciaId = d.evidencia_id || d.id;
        const newEstado   = d.estado || d.nuevo_estado;

        const row = evidenciaId
            ? document.querySelector('[data-evidencia-id="' + evidenciaId + '"]')
            : null;

        if (row && newEstado && ESTADO_COLORS[newEstado]) {
            const cfg = ESTADO_COLORS[newEstado];
            row.dataset.evidenciaEstado = newEstado;
            row.style.background   = cfg.bg;
            row.style.borderColor  = cfg.border;

            // Update estado badge (last span with white-space:nowrap)
            const badge = row.querySelector('span[style*="white-space: nowrap"]');
            if (badge) {
                badge.style.background  = cfg.bg;
                badge.style.color       = cfg.text;
                badge.style.borderColor = cfg.border;
                badge.innerHTML = `<i class="fas ${cfg.icon}"></i> ${newEstado.charAt(0).toUpperCase() + newEstado.slice(1).replace('_', ' ')}`;
            }

            // Refresh the stat counters at top
            const allRows = document.querySelectorAll('[data-evidencia-estado]');
            let total = 0, aceptada = 0, pendiente = 0, rechazada = 0;
            allRows.forEach(r => {
                total++;
                const st = r.dataset.evidenciaEstado;
                if (st === 'aceptada') aceptada++;
                else if (st === 'pendiente') pendiente++;
                else if (st === 'rechazada') rechazada++;
            });
            const statNums = document.querySelectorAll('.instructor-stat-grid .glass-card > div:last-child > div:first-child');
            if (statNums[0]) statNums[0].textContent = total;
            if (statNums[1]) statNums[1].textContent = aceptada;
            if (statNums[2]) statNums[2].textContent = pendiente;
            if (statNums[3]) statNums[3].textContent = rechazada;
        } else {
            clearTimeout(rtFallbackDebounce);
            rtFallbackDebounce = setTimeout(fallbackRefreshEntregas, 800);
        }
    });
})();
</script>
@endsection
