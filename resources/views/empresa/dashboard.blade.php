@extends('layouts.dashboard')

@section('title', 'Dashboard Empresa')
@section('page-title', 'Panel Empresa')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Comunicación</span>
    <a href="{{ route('chat.index') }}" class="nav-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
        <i class="fas fa-comment-dots"></i> Mensajes
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    @vite(['resources/css/empresa.css'])
    <style>
        .table-dash {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px;
        }
        .table-dash thead th {
            padding: 12px 20px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            color: var(--text-lighter);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-dash tbody tr {
            background: white;
            border-radius: 14px;
            transition: all 0.2s;
        }
        .table-dash tbody tr:hover {
            box-shadow: 0 4px 16px rgba(62,180,137,0.06);
        }
        .table-dash tbody td {
            padding: 16px 20px;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-dash tbody td:first-child {
            border-left: 1px solid #f1f5f9;
            border-radius: 14px 0 0 14px;
        }
        .table-dash tbody td:last-child {
            border-right: 1px solid #f1f5f9;
            border-radius: 0 14px 14px 0;
        }
        .dash-card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.25s;
        }
        .dash-card:hover {
            box-shadow: 0 8px 28px rgba(0,0,0,0.06);
        }
        .quick-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            background: white;
            border-radius: 14px;
            text-decoration: none;
            border: 1px solid var(--border);
            transition: all 0.25s;
        }
        .quick-link:hover {
            transform: translateX(4px);
            border-color: rgba(62,180,137,0.3);
            box-shadow: 0 4px 16px rgba(62,180,137,0.06);
        }
        .quick-link .ql-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .quick-link .ql-title {
            font-weight: 800;
            color: var(--text);
            font-size: 14px;
        }
        .quick-link .ql-desc {
            font-size: 11px;
            color: var(--text-light);
            font-weight: 500;
        }
        .avatar-stack {
            display: flex;
            align-items: center;
        }
        .avatar-stack .av-item {
            width: 26px; height: 26px;
            border-radius: 50%;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
            font-weight: 800;
            margin-left: -7px;
        }
        .avatar-stack .av-item:first-child { margin-left: 0; }
        @media (max-width: 1024px) {
            .dash-grid { grid-template-columns: 1fr !important; }
        }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Inicio']]; @endphp
@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">

    {{-- Hero --}}
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-building"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
                <span class="instructor-tag"><i class="fas fa-crown"></i> Portal Corporativo</span>
                <span style="color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 600;">
                    <i class="far fa-calendar-alt" style="margin-right: 6px;"></i>{{ now()->translatedFormat('l, d F, Y') }}
                </span>
            </div>
            <h1 class="instructor-title">Bienvenido, <span style="color: #3eb489;">{{ session('nombre') }}</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; max-width: 640px; line-height: 1.6; font-weight: 500;">Gestiona tus proyectos, revisa postulaciones y conecta con el mejor talento técnico del SENA.</p>
            <div style="display: flex; gap: 12px; margin-top: 24px; flex-wrap: wrap;">
                <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium" style="padding: 12px 24px; font-size: 14px;">
                    <i class="fas fa-plus-circle"></i> Nuevo Proyecto
                </a>
                <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); box-shadow: none;">
                    <i class="fas fa-folder-open"></i> Ver Proyectos
                </a>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card" style="background: linear-gradient(135deg, #0a1a15, #1a2e28); border: none;">
            <div class="stat-icon" style="background: rgba(255,255,255,0.1); color: white;">
                <i class="fas fa-folder-plus"></i>
            </div>
            <div>
                <div class="stat-num" style="color: white;">{{ $totalProyectos }}</div>
                <div class="stat-label" style="color: rgba(255,255,255,0.6);">Proyectos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #10b981;">
                <i class="fas fa-rocket"></i>
            </div>
            <div>
                <div class="stat-num" style="color: #10b981;">{{ $proyectosActivos }}</div>
                <div class="stat-label" style="color: var(--text-lighter);">En ejecución</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #ede9fe; color: #8b5cf6;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="stat-num" style="color: #8b5cf6;">{{ $totalPostulaciones }}</div>
                <div class="stat-label" style="color: var(--text-lighter);">Postulaciones</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="stat-num" style="color: #f59e0b;">{{ $postulacionesPendientes }}</div>
                <div class="stat-label" style="color: var(--text-lighter);">Por revisar</div>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="dash-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">

        {{-- Left: Proyectos Recientes --}}
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 12px; margin: 0;">
                    <span style="width: 8px; height: 24px; background: #3eb489; border-radius: 4px;"></span>
                    Proyectos Recientes
                    <span style="font-size: 11px; font-weight: 700; color: var(--text-lighter); background: #f1f5f9; padding: 3px 10px; border-radius: 20px;">{{ $proyectosRecientes->count() }}</span>
                </h3>
                <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium" style="padding: 10px 18px; font-size: 13px;">
                    <i class="fas fa-plus-circle"></i> Nueva Oferta
                </a>
            </div>

            @if($proyectosRecientes->count() > 0)
                @php $avatarColors = ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#f43f5e', '#06b6d4', '#84cc16']; @endphp
                <div class="dash-card">
                    <div style="overflow-x: auto;">
                        <table class="table-dash">
                            <thead>
                                <tr>
                                    <th style="padding-left: 24px;">Proyecto</th>
                                    <th>Categoría</th>
                                    <th>Oferta</th>
                                    <th>Estado</th>
                                    <th>Postulaciones</th>
                                    <th style="text-align:center; padding-right: 24px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proyectosRecientes as $i => $p)
                                    @php
                                        $s = match($p->estado) {
                                            'completado'  => ['bg' => '#065f46', 'icon' => 'fa-check'],
                                            'aprobado'    => ['bg' => '#10b981', 'icon' => 'fa-check'],
                                            'pendiente'   => ['bg' => '#f59e0b', 'icon' => 'fa-clock'],
                                            'rechazado'   => ['bg' => '#ef4444', 'icon' => 'fa-ban'],
                                            'cerrado'     => ['bg' => '#64748b', 'icon' => 'fa-lock'],
                                            'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner'],
                                            default       => ['bg' => '#64748b', 'icon' => 'fa-info-circle'],
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
                                                    <div style="font-weight: 700; color: var(--text); font-size: 13px;">{{ Str::limit($p->titulo, 42) }}</div>
                                                    <div style="font-size: 10px; color: var(--text-lighter); font-weight: 600; margin-top: 2px;">
                                                        <i class="far fa-calendar"></i> Exp: {{ \Carbon\Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 183)->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="background: #f1f5f9; color: var(--text-light); padding: 4px 10px; border-radius: 30px; font-size: 10px; font-weight: 700; text-transform: uppercase; white-space: nowrap;">{{ $p->categoria }}</span>
                                        </td>
                                        <td>
                                            @if($p->oferta)
                                                <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 10px; background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(124,58,237,0.08)); color: #7c3aed; padding: 3px 10px 3px 6px; border-radius: 20px; font-weight: 800; border: 1px solid rgba(139,92,246,0.15); white-space: nowrap;">
                                                    <i class="fas fa-gift" style="font-size: 8px;"></i>
                                                    @switch($p->oferta)
                                                        @case('pasantias') Pasantías @break
                                                        @case('contrato_aprendizaje') Contrato aprendizaje @break
                                                        @case('auxilio_transporte') Auxilio transporte @break
                                                        @case('otro') {{ $p->oferta_otro }} @break
                                                    @endswitch
                                                </span>
                                            @else
                                                <span style="color: var(--text-lighter); font-size: 13px;">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="background: {{ $s['bg'] }}15; color: {{ $s['bg'] }}; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid {{ $s['bg'] }}25; white-space: nowrap;">
                                                <i class="fas {{ $s['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(($p->postulaciones_count ?? 0) > 0)
                                                <div class="avatar-stack">
                                                    @foreach($p->postulaciones->take(3) as $post)
                                                        <div class="av-item" style="background: linear-gradient(135deg, #3eb489, #2d9d74);" title="{{ $post->aprendiz->nombres ?? '' }} {{ $post->aprendiz->apellidos ?? '' }}">
                                                            {{ substr($post->aprendiz->nombres ?? 'A', 0, 1) }}
                                                        </div>
                                                    @endforeach
                                                    @if(($p->postulaciones_count ?? 0) > 3)
                                                        <span style="font-weight: 800; color: var(--text); font-size: 12px; margin-left: 4px;">+{{ ($p->postulaciones_count ?? 0) - 3 }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span style="color: var(--text-lighter); font-size: 11px; font-weight: 600;">Sin post.</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center; padding-right: 24px;">
                                            <a href="{{ route('empresa.proyectos.detalle', $p->id) }}" class="btn-action btn-action-blue" style="padding: 7px 14px; font-size: 11px;">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9; text-align: center;">
                        <a href="{{ route('empresa.proyectos') }}" style="color: #3eb489; font-weight: 700; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: gap 0.3s;">
                            Ver todos los proyectos <i class="fas fa-arrow-right" style="font-size: 11px;"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="dash-card" style="padding: 64px 32px; text-align: center;">
                    <div style="width: 72px; height: 72px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #3eb489; font-size: 28px;">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 8px;">No has publicado proyectos aún</h4>
                    <p style="color: var(--text-light); font-size: 14px; font-weight: 500; max-width: 420px; margin: 0 auto 24px;">Comienza ahora y conecta con el mejor talento técnico del SENA.</p>
                    <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium" style="display: inline-flex;">
                        <i class="fas fa-plus-circle"></i> Publicar Primer Proyecto
                    </a>
                </div>
            @endif
        </div>

        {{-- Right: Acciones Rápidas --}}
        <div>
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <span style="width: 6px; height: 20px; background: #3eb489; border-radius: 3px;"></span>
                Acciones Rápidas
            </h3>

            <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 28px;">
                <a href="{{ route('empresa.proyectos.crear') }}" class="quick-link">
                    <div class="ql-icon" style="background: linear-gradient(135deg, #3eb489, #2d9d74); color: white;">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div class="ql-title">Publicar Proyecto</div>
                        <div class="ql-desc">Crea una nueva oferta de práctica</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: var(--text-lighter); font-size: 12px;"></i>
                </a>

                <a href="{{ route('empresa.proyectos') }}" class="quick-link">
                    <div class="ql-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white;">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div class="ql-title">Mis Proyectos</div>
                        <div class="ql-desc">Administra tus ofertas activas</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: var(--text-lighter); font-size: 12px;"></i>
                </a>

                <a href="{{ route('empresa.perfil') }}" class="quick-link">
                    <div class="ql-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                        <i class="fas fa-building"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div class="ql-title">Perfil Empresa</div>
                        <div class="ql-desc">Actualiza la información corporativa</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: var(--text-lighter); font-size: 12px;"></i>
                </a>

                <a href="{{ route('notificaciones.index') }}" class="quick-link">
                    <div class="ql-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div class="ql-title">Notificaciones</div>
                        <div class="ql-desc">Revisa tus últimas novedades</div>
                    </div>
                    <i class="fas fa-chevron-right" style="color: var(--text-lighter); font-size: 12px;"></i>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
