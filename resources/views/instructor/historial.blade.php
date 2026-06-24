@extends('layouts.dashboard')

@section('title', 'Historial de Proyectos')
@section('page-title', 'Historial de Proyectos')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos', 'instructor.proyecto.detalle', 'instructor.evidencias.ver', 'instructor.reporte') ? 'active' : '' }}">
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
    <style>
        .historial-filter-bar {
            display: flex; flex-wrap: wrap; gap: 12px; align-items: end;
            background: white; padding: 20px 24px; border-radius: 16px;
            border: 1px solid rgba(62,180,137,0.1); margin-bottom: 24px;
        }
        .historial-filter-group {
            display: flex; flex-direction: column; gap: 4px;
        }
        .historial-filter-group label {
            font-size: 11px; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .historial-filter-group select,
        .historial-filter-group input {
            padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px;
            font-size: 13px; color: var(--text); background: #f8fafc;
            outline: none; transition: border-color 0.2s;
        }
        .historial-filter-group select:focus,
        .historial-filter-group input:focus {
            border-color: #3eb489; background: white;
        }
        .historial-progress-bar {
            height: 6px; border-radius: 3px; background: #e2e8f0; overflow: hidden;
        }
        .historial-progress-fill {
            height: 100%; border-radius: 3px; transition: width 0.6s ease;
        }
        .historial-card {
            background: white; border-radius: 20px; overflow: hidden;
            border: 1px solid rgba(62,180,137,0.1);
            transition: all 0.3s; display: flex; flex-direction: column;
        }
        .historial-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(62,180,137,0.1);
        }
        .stat-value {
            font-size: 28px; font-weight: 800; line-height: 1;
        }
        .stat-label {
            font-size: 10px; font-weight: 700; color: var(--text-light);
            text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;
        }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('instructor.dashboard')], ['label' => 'Historial']]; @endphp
@section('content')
<div class="animate-fade-in">

    {{-- Hero --}}
    <div class="instructor-hero" style="padding: 40px 48px; margin-bottom: 24px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-history"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
                <span class="instructor-tag">Historial</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 800; color: white; margin-bottom: 8px;">Historial de Proyectos</h1>
            <p style="color: rgba(255,255,255,0.7); font-size: 15px;">Registro histórico completo de todos los proyectos supervisados, con métricas de progreso y actividad.</p>
        </div>
    </div>

    @if($stats->total > 0)
        {{-- Stats mejorados --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 14px; margin-bottom: 24px;">
            <div class="glass-card" style="padding: 16px 20px; text-align: center; border-top: 3px solid #3eb489;">
                <div class="stat-value" style="color: #3eb489;">{{ $stats->total }}</div>
                <div class="stat-label">Total proyectos</div>
            </div>
            <div class="glass-card" style="padding: 16px 20px; text-align: center; border-top: 3px solid #3b82f6;">
                <div class="stat-value" style="color: #3b82f6;">{{ $stats->activos }}</div>
                <div class="stat-label">Activos</div>
            </div>
            <div class="glass-card" style="padding: 16px 20px; text-align: center; border-top: 3px solid #10b981;">
                <div class="stat-value" style="color: #10b981;">{{ $stats->completados }}</div>
                <div class="stat-label">Completados</div>
            </div>
            <div class="glass-card" style="padding: 16px 20px; text-align: center; border-top: 3px solid #64748b;">
                <div class="stat-value" style="color: #64748b;">{{ $stats->cerrados }}</div>
                <div class="stat-label">Cerrados</div>
            </div>
            @if($stats->pendientes > 0)
            <div class="glass-card" style="padding: 16px 20px; text-align: center; border-top: 3px solid #f59e0b;">
                <div class="stat-value" style="color: #f59e0b;">{{ $stats->pendientes }}</div>
                <div class="stat-label">Pendientes</div>
            </div>
            @endif
        </div>

        {{-- Barra de filtros --}}
        <form method="GET" action="{{ route('instructor.historial') }}" class="historial-filter-bar">
            <div class="historial-filter-group">
                <label>Estado</label>
                <select name="estado">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="en_progreso" {{ request('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                    <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                </select>
            </div>
            <div class="historial-filter-group">
                <label>Categoría</label>
                <select name="categoria">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="historial-filter-group" style="flex:1; min-width:180px;">
                <label>Buscar</label>
                <input type="text" name="busqueda" placeholder="Título o empresa..." value="{{ request('busqueda') }}">
            </div>
            <div class="historial-filter-group">
                <label>Desde</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
            </div>
            <div class="historial-filter-group">
                <label>Hasta</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
            </div>
            <div class="historial-filter-group">
                <label>Oferta</label>
                <select name="oferta">
                    <option value="">Todas</option>
                    <option value="pasantias" {{ request('oferta') == 'pasantias' ? 'selected' : '' }}>Pasantías</option>
                    <option value="contrato_aprendizaje" {{ request('oferta') == 'contrato_aprendizaje' ? 'selected' : '' }}>Contrato</option>
                    <option value="auxilio_transporte" {{ request('oferta') == 'auxilio_transporte' ? 'selected' : '' }}>Auxilio</option>
                </select>
            </div>
            <div class="historial-filter-group">
                <label>Ordenar</label>
                <select name="sort">
                    <option value="reciente" {{ request('sort') == 'reciente' ? 'selected' : '' }}>Más reciente</option>
                    <option value="antiguo" {{ request('sort') == 'antiguo' ? 'selected' : '' }}>Más antiguo</option>
                    <option value="titulo" {{ request('sort') == 'titulo' ? 'selected' : '' }}>Título A-Z</option>
                    <option value="estado" {{ request('sort') == 'estado' ? 'selected' : '' }}>Por estado</option>
                </select>
            </div>
            <div class="historial-filter-group" style="flex-direction:row; gap:8px; align-items:end;">
                @if(request()->anyFilled(['estado', 'categoria', 'busqueda', 'fecha_desde', 'fecha_hasta', 'sort', 'oferta']))
                    <a href="{{ route('instructor.historial') }}" style="padding:8px 16px; border:1px solid #e2e8f0; border-radius:8px; font-size:12px; font-weight:700; color:#64748b; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                @endif
                <button type="submit" style="padding:8px 20px; background:#3eb489; color:white; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </div>
        </form>

        {{-- Grid de proyectos --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1.5rem;">
            @foreach($proyectos as $proyecto)
                @php
                    $statusStyles = match($proyecto->estado) {
                        'completado' => ['bg' => '#065f46', 'icon' => 'fa-check', 'label' => 'Completado'],
                        'aprobado' => ['bg' => '#10b981', 'icon' => 'fa-check', 'label' => 'Aprobado'],
                        'pendiente' => ['bg' => '#f59e0b', 'icon' => 'fa-clock', 'label' => 'Pendiente'],
                        'rechazado' => ['bg' => '#ef4444', 'icon' => 'fa-ban', 'label' => 'Rechazado'],
                        'cerrado' => ['bg' => '#64748b', 'icon' => 'fa-lock', 'label' => 'Cerrado'],
                        'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner', 'label' => 'En Progreso'],
                        default => ['bg' => '#64748b', 'icon' => 'fa-info-circle', 'label' => 'Desconocido'],
                    };
                    $diasTranscurridos = $proyecto->fecha_publicacion
                        ? now()->diffInDays($proyecto->fecha_publicacion)
                        : 0;
                @endphp
                <div class="historial-card">
                    {{-- Barra superior de color según estado --}}
                    <div style="height: 4px; background: {{ $statusStyles['bg'] }};"></div>

                    <div style="padding: 1.5rem; flex: 1;">
                        {{-- Header: estado + fecha --}}
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                            <span style="background: {{ $statusStyles['bg'] }}; color: #ffffff; padding: 5px 12px; border-radius: 20px; font-size: 10px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas {{ $statusStyles['icon'] }}"></i> {{ $statusStyles['label'] }}
                            </span>
                            <span style="font-size: 0.7rem; color: var(--text-light); white-space:nowrap;">
                                <i class="fas fa-calendar-alt" style="margin-right: 3px;"></i>
                                {{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d M, Y') }}
                                <span style="color:#94a3b8;">(hace {{ $diasTranscurridos }} días)</span>
                            </span>
                        </div>

                        {{-- Título --}}
                        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 0.75rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $proyecto->titulo }}
                        </h3>

                        {{-- Metadatos --}}
                        <div style="display: flex; flex-direction: column; gap: 6px; font-size: 0.82rem; color: var(--text-light); margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-building" style="color: #3eb489; width: 15px; font-size:12px;"></i>
                                <span style="font-weight: 600;">{{ $proyecto->nombre }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-tag" style="color: #3eb489; width: 15px; font-size:12px;"></i>
                                <span style="font-weight: 600;">{{ $proyecto->categoria }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clock" style="color: #f59e0b; width: 15px; font-size:12px;"></i>
                                <span style="font-weight: 600;">Duración: {{ $proyecto->duracion_dias ?? '—' }} días</span>
                            </div>
                            @if($proyecto->ultima_actividad)
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clock" style="color: #8b5cf6; width: 15px; font-size:12px;"></i>
                                <span style="font-weight: 600;">Última actividad: {{ \Carbon\Carbon::parse($proyecto->ultima_actividad)->format('d M, Y') }}</span>
                            </div>
                            @endif
                            @if($proyecto->oferta)
                            <div style="display: flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 700; background: linear-gradient(135deg, rgba(139,92,246,0.1), rgba(124,58,237,0.06)); color: #7c3aed; padding: 3px 10px 3px 6px; border-radius: 20px; border: 1px solid rgba(139,92,246,0.12); width: fit-content;">
                                <i class="fas fa-gift" style="font-size: 9px;"></i>
                                <span>
                                    @switch($proyecto->oferta)
                                        @case('pasantias') Pasantías @break
                                        @case('contrato_aprendizaje') Contrato aprendizaje @break
                                        @case('auxilio_transporte') Auxilio transporte @break
                                        @case('otro') {{ $proyecto->oferta_otro }} @break
                                    @endswitch
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Progreso de etapas --}}
                        @if($proyecto->total_etapas > 0)
                        <div style="margin-bottom: 1rem;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                                <span style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase;">Progreso</span>
                                <span style="font-size:11px; font-weight:800; color:#3eb489;">{{ $proyecto->progreso }}%</span>
                            </div>
                            <div class="historial-progress-bar">
                                <div class="historial-progress-fill" style="width:{{ $proyecto->progreso }}%; background: linear-gradient(90deg, #3eb489, #2dd4a0);"></div>
                            </div>
                            <div style="font-size:10px; color:#94a3b8; margin-top:3px; font-weight:600;">
                                {{ $proyecto->etapas_completadas }} de {{ $proyecto->total_etapas }} etapas
                            </div>
                        </div>
                        @endif

                        {{-- Postulaciones stats --}}
                        <div style="background: rgba(62,180,137,0.04); padding: 0.85rem; border-radius: 14px; border: 1px solid rgba(62,180,137,0.1); display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; text-align: center;">
                            <div>
                                <p style="font-size: 1.3rem; font-weight: 800; color: #3eb489; margin: 0;">{{ $proyecto->total_aprendices }}</p>
                                <p style="font-size: 0.6rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin: 0;">Postulaciones</p>
                            </div>
                            <div style="border-left: 1px solid rgba(62,180,137,0.15);">
                                <p style="font-size: 1.3rem; font-weight: 800; color: #10b981; margin: 0;">{{ $proyecto->aprendices_aprobados }}</p>
                                <p style="font-size: 0.6rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin: 0;">Aprobados</p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div style="padding: 0.85rem 1.5rem; border-top: 1px solid rgba(62,180,137,0.08); background: rgba(62,180,137,0.02); display: flex; gap: 8px;">
                        <a href="{{ route('instructor.reporte', $proyecto->id) }}" class="btn-premium" style="flex:1; justify-content: center; padding: 9px; font-size:12px;">
                            <i class="fas fa-chart-pie" style="margin-right: 5px;"></i> Ver Reporte
                        </a>
                        <a href="{{ route('instructor.proyecto.detalle', $proyecto->id) }}" style="flex:1; padding:9px; border:1px solid #e2e8f0; border-radius:12px; text-align:center; font-size:12px; font-weight:700; color:#64748b; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:5px;">
                            <i class="fas fa-eye"></i> Detalle
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if($proyectos->hasPages())
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $proyectos->withQueryString()->links() }}
            </div>
        @endif
    @else
        <div style="padding: 5rem 2rem; text-align: center; background: white; border-radius: 20px; border: 1px dashed rgba(62,180,137,0.2);">
            <i class="fas fa-history" style="font-size: 4rem; color: #3eb489; margin-bottom: 1.5rem; opacity: 0.5;"></i>
            <h4 style="color: var(--text); font-size: 1.5rem; margin-bottom: 8px; font-weight: 800;">Historial vacío</h4>
            <p style="color: var(--text-light);">Aún no tienes proyectos finalizados o registrados en tu historial.</p>
        </div>
    @endif
</div>
@endsection
