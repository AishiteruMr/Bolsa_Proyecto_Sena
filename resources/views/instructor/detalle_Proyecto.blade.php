@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto')
@section('page-title', 'Detalle del Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos*') ? 'active' : '' }}">
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

@section('content')
    <link rel="stylesheet" href="{{ asset('css/instructor.css') }}">

    <div class="project-detail">
        <div class="project-header">
            <a href="{{ route('instructor.proyectos') }}" class="project-back-link">
                <i class="fas fa-arrow-left"></i> Volver a proyectos
            </a>
            <h1 class="project-title">{{ $proyecto->pro_titulo_proyecto }}</h1>
            <p class="project-subtitle">Detalles del proyecto y gestión de postulaciones</p>
        </div>

        <!-- INFORMACIÓN DEL PROYECTO -->
        <div class="card">
            @if($proyecto->pro_imagen_url)
                <img src="{{ $proyecto->pro_imagen_url }}" alt="{{ $proyecto->pro_titulo_proyecto }}" class="project-image">
            @endif

            <div class="project-info-section">
                <div class="project-info-item">
                    <span class="project-info-label">Empresa:</span>
                    <span class="project-info-value">{{ $proyecto->emp_nombre }}</span>
                </div>
                <div class="project-info-item">
                    <span class="project-info-label">Categoría:</span>
                    <span class="project-info-value">{{ $proyecto->pro_categoria }}</span>
                </div>
                <div class="project-info-item">
                    <span class="project-info-label">Estado:</span>
                    <span class="project-info-value">
                        @if($proyecto->pro_estado === 'Activo')
                            <span class="badge badge-success">{{ $proyecto->pro_estado }}</span>
                        @else
                            <span class="badge badge-danger">{{ $proyecto->pro_estado }}</span>
                        @endif
                    </span>
                </div>
                <div class="project-info-item">
                    <span class="project-info-label">Fecha Publicación:</span>
                    <span class="project-info-value">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}</span>
                </div>
                <div class="project-info-item">
                    <span class="project-info-label">Fecha Finalización:</span>
                    <span class="project-info-value">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}</span>
                </div>
            </div>

            <div style="padding: 20px; border-top: 1px solid #e0e0e0;">
                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px;">Descripción</h3>
                <p style="color: #666; line-height: 1.6;">{{ $proyecto->pro_descripcion }}</p>

                <h3 style="font-size: 16px; font-weight: 600; margin-top: 20px; margin-bottom: 8px;">Requisitos Específicos</h3>
                <p style="color: #666;">{{ $proyecto->pro_requisitos_especificos }}</p>

                <h3 style="font-size: 16px; font-weight: 600; margin-top: 20px; margin-bottom: 8px;">Habilidades Requeridas</h3>
                <p style="color: #666;">{{ $proyecto->pro_habilidades_requerida }}</p>
            </div>
        </div>

        <!-- POSTULACIONES -->
        <h2 class="section-title">
            <i class="fas fa-file-alt" style="margin-right: 8px;"></i>Postulaciones
        </h2>

        <div class="card">
            @forelse($postulaciones as $p)
                <div class="postulation-item">
                    <div class="postulation-avatar">
                        <span>{{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="postulation-info">
                        <h4 class="postulation-name">{{ $p->apr_nombre ?? '' }} {{ $p->apr_apellido ?? '' }}</h4>
                        <p class="postulation-program">
                            <i class="fas fa-graduation-cap"></i>{{ $p->apr_programa ?? 'Sin programa' }}
                        </p>
                        <p class="postulation-email">
                            <i class="fas fa-envelope"></i>{{ $p->usr_correo ?? 'Sin correo' }}
                        </p>
                    </div>
                    <div class="postulation-actions">
                        <div class="postulation-status-container">
                            @switch($p->pos_estado)
                                @case('Pendiente')
                                    <span class="badge badge-warning">{{ $p->pos_estado }}</span>
                                    @break
                                @case('Aprobada')
                                    <span class="badge badge-success">{{ $p->pos_estado }}</span>
                                    @break
                                @case('Rechazada')
                                    <span class="badge badge-danger">{{ $p->pos_estado }}</span>
                                    @break
                                @default
                                    <span class="badge badge-info">{{ $p->pos_estado }}</span>
                            @endswitch
                            <p class="postulation-date">
                                <i class="fas fa-calendar"></i>{{ \Carbon\Carbon::parse($p->pos_fecha)->format('d/m/Y') }}
                            </p>
                        </div>
                        @if($p->pos_estado === 'Pendiente')
                            <div class="postulation-buttons">
                                <form action="{{ route('instructor.postulaciones.estado', $p->pos_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Aprobada">
                                    <button type="submit" class="btn-approve">
                                        <i class="fas fa-check"></i> Aprobar
                                    </button>
                                </form>
                                <form action="{{ route('instructor.postulaciones.estado', $p->pos_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Rechazada">
                                    <button type="submit" class="btn-reject">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-file-alt empty-state-icon"></i>
                    <h4 class="empty-state-title">No hay postulaciones</h4>
                    <p class="empty-state-message">Aún no hay aprendices postulados a este proyecto.</p>
                </div>
            @endforelse
        </div>

        <!-- INTEGRANTES APROBADOS -->
        <h2 class="section-title">
            <i class="fas fa-users" style="margin-right: 8px;"></i>Integrantes del Proyecto
        </h2>

        <div class="card">
            @forelse($integrantes as $integrante)
                <div class="member-item">
                    <div class="member-avatar">
                        <span>{{ strtoupper(substr($integrante->apr_nombre ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="member-info">
                        <div class="member-name">{{ $integrante->apr_nombre }} {{ $integrante->apr_apellido }}</div>
                        <div class="member-program">{{ $integrante->apr_programa ?? 'Sin programa' }}</div>
                        <div style="font-size: 12px; color: #888; margin-top: 4px;">
                            <i class="fas fa-envelope"></i> {{ $integrante->usr_correo }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-users empty-state-icon"></i>
                    <h4 class="empty-state-title">Sin integrantes</h4>
                    <p class="empty-state-message">No hay aprendices aprobados aún para este proyecto.</p>
                </div>
            @endforelse
        </div>

        <!-- ETAPAS DEL PROYECTO -->
        <h2 class="section-title">
            <i class="fas fa-tasks" style="margin-right: 8px;"></i>Etapas del Proyecto
        </h2>

        <div style="display: grid; gap: 12px;">
            @forelse($etapas as $etapa)
                <div class="stage-item">
                    <div class="stage-name">
                        <span class="stage-order">{{ $etapa->eta_orden }}</span>
                        {{ $etapa->eta_nombre }}
                    </div>
                    <div class="stage-description">{{ $etapa->eta_descripcion ?? 'Sin descripción' }}</div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-tasks empty-state-icon"></i>
                    <h4 class="empty-state-title">Sin etapas</h4>
                    <p class="empty-state-message">No hay etapas definidas para este proyecto.</p>
                </div>
            @endforelse
        </div>

        <!-- BOTÓN REPORTE DE SEGUIMIENTO -->
        <div style="margin-top: 32px; display: flex; gap: 12px;">
            <a href="{{ route('instructor.reporte', $proyecto->pro_id) }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #39a900; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; transition: background 0.2s;">
                <i class="fas fa-chart-bar"></i> Ver Reporte de Seguimiento
            </a>
        </div>
    </div>

    <style>
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #39a900;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #2d8500;
        }
    </style>
@endsection