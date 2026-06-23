@extends('layouts.dashboard')

@section('title', 'Historial del Sistema')
@section('page-title', 'Historial de Actividades')

@section('styles')
    @vite(['resources/css/admin.css'])
@endsection

@section('sidebar-nav')
    @include('admin.partials.sidebar-nav')
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('admin.dashboard')], ['label' => 'Historial']]; @endphp

@section('scripts')
    @vite(['resources/js/admin-audit.js'])
@endsection

@section('content')
<div class="animate-fade-in">
    <div class="admin-header-master">
        <div class="admin-header-icon">
            <i class="fas fa-history"></i>
        </div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <span class="admin-badge-hub">Sistema de Auditoría</span>
                <span style="color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 600;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="admin-header-title">Historial de <span style="color: var(--primary);">Actividades</span></h1>
            <p style="color: rgba(255,255,255,0.5); font-size: 18px; max-width: 600px; line-height: 1.6; margin: 0;">Registro cronológico y detallado de todas las operaciones realizadas en la plataforma, organizado por tipo de entidad.</p>
        </div>
    </div>
</div>

{{-- ACTIVITY SUMMARY --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin: 20px 0;">
    <div class="glass-card" style="padding: 16px; text-align: center; border-top: 3px solid var(--primary);">
        <div style="font-size: 24px; font-weight: 800; color: var(--primary);">{{ $totalLogs }}</div>
        <div style="font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase;">Total Eventos</div>
    </div>
    @foreach($accionesCount->take(3) as $acc)
    <div class="glass-card" style="padding: 16px; text-align: center; border-top: 3px solid #6366f1;">
        <div style="font-size: 24px; font-weight: 800; color: #6366f1;">{{ $acc->total }}</div>
        <div style="font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase;">{{ ucfirst($acc->accion) }}</div>
    </div>
    @endforeach
</div>

{{-- MONTHLY ACTIVITY CHART (inline bar) --}}
@if(!empty($actividadMensual['labels']))
<div class="glass-card" style="padding: 20px; background: white; margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 0.9rem; font-weight: 800; color: var(--text);">
            <i class="fas fa-chart-line" style="color: #6366f1; margin-right: 8px;"></i>
            Actividad Mensual
        </h3>
    </div>
    <div style="display: flex; align-items: end; gap: 8px; height: 100px;">
        @php $maxAct = max($actividadMensual['data']) ?: 1; @endphp
        @foreach($actividadMensual['labels'] as $idx => $label)
        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; height: 100%; justify-content: end;">
            <span style="font-size: 9px; font-weight: 700; color: #6366f1;">{{ $actividadMensual['data'][$idx] }}</span>
            <div style="width: 100%; height: {{ ($actividadMensual['data'][$idx] / $maxAct) * 80 }}px; background: linear-gradient(180deg, #6366f1, #a5b4fc); border-radius: 4px 4px 0 0; transition: height 0.6s; min-height: 4px;"></div>
            <span style="font-size: 8px; color: #94a3b8; font-weight: 600; white-space: nowrap;">{{ $label }}</span>
        </div>
        @endforeach
    </div>
</div>
@endif

<form method="GET" action="{{ route('admin.historial') }}" class="filter-bar">
    <div class="filter-bar-group">
        <span class="filter-bar-label">Entidad</span>
        <select name="entidad" class="filter-bar-select">
            <option value="">Todas</option>
            <option value="aprendiz" {{ request('entidad') == 'aprendiz' ? 'selected' : '' }}>Aprendices</option>
            <option value="instructor" {{ request('entidad') == 'instructor' ? 'selected' : '' }}>Instructores</option>
            <option value="empresa" {{ request('entidad') == 'empresa' ? 'selected' : '' }}>Empresas</option>
            <option value="proyecto" {{ request('entidad') == 'proyecto' ? 'selected' : '' }}>Proyectos</option>
        </select>
    </div>
    <div class="filter-bar-group">
        <span class="filter-bar-label">Desde</span>
        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="filter-bar-input">
    </div>
    <div class="filter-bar-group">
        <span class="filter-bar-label">Hasta</span>
        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="filter-bar-input">
    </div>
    <div class="filter-bar-search">
        <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="{{ request('busqueda') }}" aria-label="Buscar por nombre de entidad">
        <i class="fas fa-search"></i>
    </div>
    <div class="filter-bar-actions">
        @if(request()->anyFilled(['entidad', 'fecha_inicio', 'fecha_fin', 'busqueda']))
            <a href="{{ route('admin.historial') }}" class="filter-bar-btn danger">
                <i class="fas fa-times"></i> Limpiar
            </a>
        @endif
        <button type="submit" class="filter-bar-btn primary">
            <i class="fas fa-filter"></i> Filtrar
        </button>
        <a href="{{ route('admin.historial', ['export' => 'csv'] + request()->all()) }}" class="filter-bar-btn outline">
            <i class="fas fa-download"></i> Exportar
        </a>
    </div>
</form>

@php
    $entidadMeta = [
        'aprendiz' => ['icon' => 'fa-graduation-cap', 'color' => '#0ea5e9', 'bg' => '#f0f9ff', 'label' => 'Aprendices', 'desc' => 'Registro, activación y postulaciones de aprendices'],
        'instructor' => ['icon' => 'fa-chalkboard-user', 'color' => '#8b5cf6', 'bg' => '#f5f3ff', 'label' => 'Instructores', 'desc' => 'Registro, activación, asignación y destitución de instructores'],
        'empresa' => ['icon' => 'fa-building', 'color' => '#f59e0b', 'bg' => '#fffbeb', 'label' => 'Empresas', 'desc' => 'Registro, activación y publicación de proyectos'],
        'proyecto' => ['icon' => 'fa-project-diagram', 'color' => '#2563eb', 'bg' => '#eff6ff', 'label' => 'Proyectos', 'desc' => 'Aprobación, rechazo, cierre y asignación de proyectos'],
        'general' => ['icon' => 'fa-gear', 'color' => '#64748b', 'bg' => '#f1f5f9', 'label' => 'General', 'desc' => 'Otras actividades del sistema'],
    ];
    $ordenEntidades = ['aprendiz', 'instructor', 'empresa', 'proyecto', 'general'];

    $actionPillMeta = [
        'crear' => ['color' => '#059669', 'bg' => '#ecfdf5', 'label' => 'Registro'],
        'editar' => ['color' => '#d97706', 'bg' => '#fffbeb', 'label' => 'Actualización'],
        'cambiar_estado' => ['color' => '#d97706', 'bg' => '#fffbeb', 'label' => 'Actualización'],
        'eliminar' => ['color' => '#dc2626', 'bg' => '#fef2f2', 'label' => 'Eliminación'],
        'login' => ['color' => '#2563eb', 'bg' => '#eff6ff', 'label' => 'Inicio Sesión'],
        'logout' => ['color' => '#475569', 'bg' => '#f8fafc', 'label' => 'Cierre Sesión'],
        'asignar' => ['color' => '#8b5cf6', 'bg' => '#f5f3ff', 'label' => 'Asignación'],
        'postularse' => ['color' => '#0ea5e9', 'bg' => '#f0f9ff', 'label' => 'Postulación'],
        'publicar' => ['color' => '#10b981', 'bg' => '#ecfdf5', 'label' => 'Publicación'],
        'desasignar' => ['color' => '#ef4444', 'bg' => '#fef2f2', 'label' => 'Destitución'],
    ];

    $tieneGrupos = collect($ordenEntidades)->first(fn($k) => !empty($grouped[$k]));
@endphp

@foreach($ordenEntidades as $key)
    @if(!empty($grouped[$key]))
        @php
            $meta = $entidadMeta[$key];
            $totalLogs = collect($grouped[$key])->flatten(1)->count();
            $actionCounts = collect($grouped[$key])->flatten(1)->groupBy('accion')->map->count();
        @endphp
        <div class="audit-entity-card">
            <div class="audit-entity-header" style="background: {{ $meta['bg'] }}; border-bottom-color: {{ $meta['color'] }}30;">
                <div class="audit-entity-icon" style="background: {{ $meta['color'] }};">
                    <i class="fas {{ $meta['icon'] }}"></i>
                </div>
                <div class="audit-entity-info">
                    <h2 class="audit-entity-title">{{ $meta['label'] }}</h2>
                    <p class="audit-entity-desc">{{ $meta['desc'] }}</p>
                    <div class="audit-action-pills">
                        @foreach($actionCounts as $accion => $count)
                            @php $pill = $actionPillMeta[$accion] ?? ['color' => '#64748b', 'bg' => '#f1f5f9', 'label' => ucfirst($accion)]; @endphp
                            <span class="audit-action-pill" style="background: {{ $pill['bg'] }}; color: {{ $pill['color'] }};">
                                {{ $count }} {{ $pill['label'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <span class="audit-entity-count" style="color: {{ $meta['color'] }}; border-color: {{ $meta['color'] }}30;">
                    {{ count($grouped[$key]) }} persona(s)
                </span>
            </div>
            <div class="audit-entity-body">
                @foreach($grouped[$key] as $nombre => $personLogs)
                    <div class="audit-person-group">
                        <div class="audit-person-header">
                            <div class="audit-person-avatar" style="background: {{ $meta['color'] }}15; color: {{ $meta['color'] }};">
                                <i class="fas {{ $meta['icon'] }}"></i>
                            </div>
                            <span class="audit-person-name">{{ $nombre }}</span>
                            <span class="audit-person-count">{{ count($personLogs) }} registro(s)</span>
                        </div>
                        <div class="audit-person-body">
                            @php $lastDay = null; @endphp
                            @foreach($personLogs as $log)
                                @php
                                    $day = $log->created_at->format('Y-m-d');
                                    $dayLabel = $log->created_at->isToday() ? 'Hoy' : ($log->created_at->isYesterday() ? 'Ayer' : $log->created_at->translatedFormat('l, d F Y'));
                                @endphp
                                @if($day !== $lastDay)
                                    <div class="audit-day-separator">
                                        <span class="audit-day-label">{{ $dayLabel }}</span>
                                        <span class="audit-day-line"></span>
                                    </div>
                                    @php $lastDay = $day; @endphp
                                @endif
                                @include('admin.partials.audit-log-row')
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endforeach

@if(!$tieneGrupos)
    <div class="glass-card" style="border-radius: 32px; border: 1px solid rgba(0,0,0,0.05); background: white; box-shadow: 0 30px 60px -20px rgba(0,0,0,0.05); padding: 80px 32px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #f1f5f9; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px;">
            <i class="fas fa-ghost"></i>
        </div>
        <h4 style="margin: 0; font-size: 18px; font-weight: 900; color: #1e293b;">Sin registros encontrados</h4>
        <p style="margin: 8px 0 0 0; font-size: 14px; color: #64748b; font-weight: 600;">Ajusta los filtros para encontrar lo que buscas.</p>
    </div>
@endif

@if($logs->hasPages())
    <div style="padding: 20px 28px; display: flex; justify-content: center;">
        {{ $logs->withQueryString()->links() }}
    </div>
@endif

<div class="audit-modal-overlay" id="modalDetalles">
    <div class="audit-modal-box">
        <div class="audit-modal-header">
            <div>
                <h3>Detalles del Cambio</h3>
                <p id="modalSubtitle"></p>
            </div>
            <button onclick="cerrarModal()" class="audit-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="audit-modal-body" id="modalContent"></div>
        <div class="audit-modal-footer">
            <button onclick="cerrarModal()" class="audit-modal-btn">Entendido</button>
        </div>
    </div>
</div>
@endsection