@extends('layouts.dashboard')
@section('title', 'Historial de Proyectos')
@section('page-title', 'Historial')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> <span>Principal</span>
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> <span>Explorar Proyectos</span>
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> <span>Mis Postulaciones</span>
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> <span>Historial</span>
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> <span>Mis Entregas</span>
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> <span>Mi Perfil</span>
    </a>
@endsection

@section('styles')
    @vite(['resources/css/aprendiz.css'])
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
        .historial-detail-toggle {
            cursor: pointer; user-select: none;
        }
        .historial-detail-toggle:hover {
            color: #3eb489;
        }
        .historial-detail-content {
            display: none; margin-top: 16px; padding-top: 16px;
            border-top: 1px solid #e2e8f0;
        }
        .historial-detail-content.open {
            display: block;
        }
        .stat-card-value {
            font-size: 32px; font-weight: 800; line-height: 1;
        }
        .stat-card-label {
            font-size: 11px; font-weight: 700; color: var(--text-light);
            text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;
        }
        .skill-tag {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;
            background: rgba(62,180,137,0.08); color: #3eb489;
            border: 1px solid rgba(62,180,137,0.15);
        }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('aprendiz.dashboard')], ['label' => 'Historial']]; @endphp
@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-history"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span class="instructor-tag">Historial</span>
            </div>
            <h1 class="instructor-title">Historial de <span style="color: var(--primary);">Postulaciones</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; font-weight: 500;">Tu trayectoria académica completa — todos los proyectos a los que te has postulado.</p>
        </div>
    </div>

    @if($total > 0)
        {{-- Stats mejorados --}}
        <div class="instructor-stat-grid" style="margin-bottom: 24px;">
            <div class="glass-card" style="padding: 20px 24px; display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-inbox"></i>
                </div>
                <div>
                    <div class="stat-card-value" style="color: var(--text);">{{ $total }}</div>
                    <div class="stat-card-label">Total postulaciones</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 20px 24px; display: flex; align-items: center; gap: 16px; border-color: #bbf7d0;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="stat-card-value" style="color: #10b981;">{{ $aprobadas }}</div>
                    <div class="stat-card-label">Aprobadas</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 20px 24px; display: flex; align-items: center; gap: 16px; border-color: #fde68a;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #f59e0b; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="stat-card-value" style="color: #f59e0b;">{{ $pendientes }}</div>
                    <div class="stat-card-label">Pendientes</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 20px 24px; display: flex; align-items: center; gap: 16px; border-color: #fecaca;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div class="stat-card-value" style="color: #ef4444;">{{ $rechazadas }}</div>
                    <div class="stat-card-label">Rechazadas</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 20px 24px; display: flex; align-items: center; gap: 16px; border-color: #c4b5fd;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #8b5cf6; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-percentage"></i>
                </div>
                <div>
                    <div class="stat-card-value" style="color: #8b5cf6;">{{ $tasaAceptacion }}%</div>
                    <div class="stat-card-label">Tasa de aceptación</div>
                </div>
            </div>
        </div>

        {{-- Barra de filtros --}}
        <form method="GET" action="{{ route('aprendiz.historial') }}" class="historial-filter-bar">
            <div class="historial-filter-group">
                <label>Estado</label>
                <select name="estado">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
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
                <label>Ordenar</label>
                <select name="sort">
                    <option value="reciente" {{ request('sort') == 'reciente' ? 'selected' : '' }}>Más reciente</option>
                    <option value="antiguo" {{ request('sort') == 'antiguo' ? 'selected' : '' }}>Más antiguo</option>
                    <option value="estado" {{ request('sort') == 'estado' ? 'selected' : '' }}>Por estado</option>
                </select>
            </div>
            <div class="historial-filter-group" style="flex-direction:row; gap:8px; align-items:end;">
                @if(request()->anyFilled(['estado', 'categoria', 'busqueda', 'fecha_desde', 'fecha_hasta', 'sort']))
                    <a href="{{ route('aprendiz.historial') }}" style="padding:8px 16px; border:1px solid #e2e8f0; border-radius:8px; font-size:12px; font-weight:700; color:#64748b; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                @endif
                <button type="submit" style="padding:8px 20px; background:#3eb489; color:white; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </div>
        </form>

        {{-- Grid de proyectos --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 24px;">
            @foreach($proyectos as $p)
                @php
                    $estadoColor = match($p->estado) {
                        'completado' => ['bg' => '#065f46', 'border' => '#065f46', 'text' => '#ffffff', 'icon' => 'fa-check'],
                        'aceptada' => ['bg' => '#10b981', 'border' => '#bbf7d0', 'text' => '#ffffff', 'icon' => 'fa-check'],
                        'rechazada' => ['bg' => '#ef4444', 'border' => '#fecaca', 'text' => '#ffffff', 'icon' => 'fa-ban'],
                        'en_progreso' => ['bg' => '#3b82f6', 'border' => '#bfdbfe', 'text' => '#ffffff', 'icon' => 'fa-spinner'],
                        'pendiente' => ['bg' => '#f59e0b', 'border' => '#fde68a', 'text' => '#ffffff', 'icon' => 'fa-clock'],
                        'cerrado' => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-lock'],
                        default => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-info-circle'],
                    };
                    $diasRestantes = $p->fecha_finalizacion
                        ? \Carbon\Carbon::parse($p->fecha_finalizacion)->diffInDays(now(), false)
                        : null;
                    $esFinalizado  = $p->pro_estado === 'completado' || $p->pro_estado === 'cerrado';
                @endphp
                <div class="glass-card" style="padding: 0; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 40px rgba(62,180,137,0.12)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(62,180,137,0.06)'">
                    <div style="height: 4px; background: linear-gradient(90deg, {{ $estadoColor['text'] }}, {{ $estadoColor['border'] }});"></div>

                    @if($p->imagen_url)
                        <img src="{{ $p->imagen_url }}" loading="lazy" alt="Imagen del proyecto" style="width:100%; height:130px; object-fit:cover;">
                    @else
                        <div style="height: 90px; background: linear-gradient(135deg, rgba(62,180,137,0.12), rgba(62,180,137,0.04)); display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-project-diagram" style="font-size:32px; color:#3eb489; opacity:0.4;"></i>
                        </div>
                    @endif

                    <div style="padding: 20px 24px;">
                        {{-- Header: título + estado postulación --}}
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; gap:12px;">
                            <h4 style="font-size:15px; font-weight:800; color:var(--text); line-height:1.3; flex:1; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $p->titulo }}</h4>
                            <span style="background:{{ $estadoColor['bg'] }}; border:1.5px solid {{ $estadoColor['border'] }}; color:{{ $estadoColor['text'] }}; border-radius:20px; padding:4px 12px; font-size:10px; font-weight:800; white-space:nowrap; display:flex; align-items:center; gap:5px; flex-shrink:0;">
                                <i class="fas {{ $estadoColor['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                            </span>
                        </div>

                        {{-- Metadatos principales --}}
                        <div style="display:grid; gap:8px; margin-bottom:16px;">
                            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-building" style="width:15px; color:#3eb489; font-size:12px;"></i>
                                <span>{{ $p->nombre }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-tag" style="width:15px; color:#8b5cf6; font-size:12px;"></i>
                                <span>{{ $p->categoria }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-chalkboard-teacher" style="width:15px; color:#0ea5e9; font-size:12px;"></i>
                                <span>{{ $p->instructor_nombre }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-calendar-alt" style="width:15px; color:#f59e0b; font-size:12px;"></i>
                                <span>Postulé el {{ \Carbon\Carbon::parse($p->fecha_postulacion)->format('d M, Y') }}</span>
                                <span style="font-size:11px; color:#94a3b8;">(hace {{ $p->dias_transcurridos }} días)</span>
                            </div>
                            @if($p->ubicacion)
                            <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-map-marker-alt" style="width:15px; color:#ef4444; font-size:12px;"></i>
                                <span>{{ $p->ubicacion }}</span>
                            </div>
                            @endif
                            @if($p->oferta)
                            <div style="display:flex; align-items:center; gap:6px; font-size:11px; font-weight:700; background:linear-gradient(135deg,rgba(139,92,246,0.1),rgba(124,58,237,0.06)); color:#7c3aed; padding:3px 10px 3px 6px; border-radius:20px; border:1px solid rgba(139,92,246,0.12); width:fit-content;">
                                <i class="fas fa-gift" style="font-size:9px;"></i>
                                <span>
                                    @switch($p->oferta)
                                        @case('pasantias') Pasantías @break
                                        @case('contrato_aprendizaje') Contrato aprendizaje @break
                                        @case('auxilio_transporte') Auxilio transporte @break
                                        @case('otro') {{ $p->oferta_otro }} @break
                                    @endswitch
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Habilidades / Requisitos --}}
                        @if($p->habilidades)
                        <div style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:16px;">
                            @foreach(explode(',', $p->habilidades) as $skill)
                                @if(trim($skill))
                                <span class="skill-tag">
                                    <i class="fas fa-star" style="font-size:8px;"></i>
                                    {{ trim($skill) }}
                                </span>
                                @endif
                            @endforeach
                        </div>
                        @endif

                        {{-- Indicador de progreso del proyecto --}}
                        @if($p->total_etapas > 0)
                        <div style="margin-bottom:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <span style="font-size:11px; font-weight:700; color:#64748b;">Progreso del proyecto</span>
                                <span style="font-size:11px; font-weight:800; color:#3eb489;">{{ $p->progreso }}%</span>
                            </div>
                            <div class="historial-progress-bar">
                                <div class="historial-progress-fill" style="width:{{ $p->progreso }}%; background: linear-gradient(90deg, #3eb489, #2dd4a0);"></div>
                            </div>
                            <div style="font-size:10px; color:#94a3b8; margin-top:4px; font-weight:600;">
                                {{ $p->etapas_completadas }} de {{ $p->total_etapas }} etapas completadas
                            </div>
                        </div>
                        @endif

                        {{-- Duración y estado del proyecto --}}
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <span style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; display:block;">Estado del proyecto</span>
                                <span style="font-size:12px; font-weight:700; color:var(--text);">{{ Str::title(str_replace('_', ' ', $p->pro_estado)) }}</span>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; display:block;">Duración</span>
                                <span style="font-size:12px; font-weight:700; color:#3eb489;">{{ $p->duracion_dias ?? '—' }} días</span>
                            </div>
                            <div style="text-align:right;">
                                <span style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; display:block;">Finaliza</span>
                                <span style="font-size:12px; font-weight:700; color:{{ $esFinalizado ? '#10b981' : '#f59e0b' }};">
                                    {{ $p->fecha_finalizacion ? \Carbon\Carbon::parse($p->fecha_finalizacion)->format('d M, Y') : '—' }}
                                </span>
                            </div>
                        </div>

                        {{-- Botón de detalles expandible --}}
                        <div class="historial-detail-toggle" onclick="toggleDetalle({{ $p->id }})" style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#64748b; padding:8px 0; border-top:1px solid #f1f5f9; margin-bottom:12px;">
                            <i class="fas fa-chevron-down" id="icon-{{ $p->id }}" style="font-size:10px; transition:transform 0.3s;"></i>
                            Ver más detalles del proyecto
                        </div>

                        {{-- Contenido expandible --}}
                        <div class="historial-detail-content" id="detalle-{{ $p->id }}">
                            @if($p->descripcion)
                            <div style="margin-bottom:14px;">
                                <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">Descripción</span>
                                <p style="font-size:13px; color:var(--text-light); line-height:1.5; margin:0; display:-webkit-box; -webkit-line-clamp:4; -webkit-box-orient:vertical; overflow:hidden;">
                                    {{ $p->descripcion }}
                                </p>
                            </div>
                            @endif
                            @if($p->requisitos)
                            <div style="margin-bottom:14px;">
                                <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; display:block; margin-bottom:4px;">Requisitos</span>
                                <p style="font-size:13px; color:var(--text-light); line-height:1.5; margin:0;">{{ $p->requisitos }}</p>
                            </div>
                            @endif
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:14px;">
                                <div style="background:#f8fafc; border-radius:8px; padding:10px; text-align:center; border:1px solid #e2e8f0;">
                                    <div style="font-size:18px; font-weight:800; color:#3eb489;">{{ $p->total_etapas }}</div>
                                    <div style="font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Etapas</div>
                                </div>
                                <div style="background:#f8fafc; border-radius:8px; padding:10px; text-align:center; border:1px solid #e2e8f0;">
                                    <div style="font-size:18px; font-weight:800; color:#8b5cf6;">{{ $p->dias_transcurridos }}</div>
                                    <div style="font-size:10px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Días desde postulación</div>
                                </div>
                            </div>
                        </div>

                        {{-- Acción --}}
                        @if($p->estado === 'aceptada')
                            <a href="{{ route('aprendiz.entregas') }}" class="btn-premium" style="width:100%; justify-content:center; padding:10px; font-size:13px;">
                                <i class="fas fa-upload"></i> Ir a Mis Entregas
                            </a>
                        @else
                            <div style="width:100%; background:#f1f5f9; border-radius:10px; padding:10px; text-align:center; font-size:12px; font-weight:700; color:#94a3b8;">
                                <i class="fas fa-lock"></i> Acceso restringido
                                @if($p->estado === 'pendiente')
                                    <span style="display:block; font-size:11px; font-weight:500; color:#94a3b8; margin-top:2px;">Esperando respuesta del instructor</span>
                                @elseif($p->estado === 'rechazada')
                                    <span style="display:block; font-size:11px; font-weight:500; color:#ef4444; margin-top:2px;">Postulación no aprobada</span>
                                @endif
                            </div>
                        @endif
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
        <div class="glass-card" style="padding: 80px 40px; text-align: center;">
            <div style="width:100px; height:100px; background:rgba(62,180,137,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; font-size:40px; color:#3eb489;">
                <i class="fas fa-history"></i>
            </div>
            <h3 style="font-size:22px; font-weight:800; color:var(--text); margin-bottom:10px;">Sin historial aún</h3>
            <p style="font-size:15px; color:var(--text-light); font-weight:500; max-width:400px; margin:0 auto 28px; line-height:1.6;">
                Aún no te has postulado a ningún proyecto. Explora las convocatorias disponibles y da el primer paso en tu carrera.
            </p>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="display:inline-flex;">
                <i class="fas fa-search"></i> Explorar Proyectos
            </a>
        </div>
    @endif
</div>

<script>
function toggleDetalle(id) {
    const content = document.getElementById('detalle-' + id);
    const icon = document.getElementById('icon-' + id);
    content.classList.toggle('open');
    icon.style.transform = content.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
}
</script>
@endsection
