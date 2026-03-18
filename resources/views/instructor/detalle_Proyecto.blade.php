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

        <!-- IMAGEN DEL PROYECTO -->
        <h2 class="section-title">
            <i class="fas fa-image" style="margin-right: 8px;"></i>Imagen del Proyecto
        </h2>

        <div class="card">
            <div style="padding: 20px;">
                @if($proyecto->pro_imagen_url)
                    <div style="margin-bottom: 20px;">
                        <img src="{{ $proyecto->pro_imagen_url }}" alt="{{ $proyecto->pro_titulo_proyecto }}" class="project-image">
                    </div>
                @else
                    <div style="background: #f5f5f5; padding: 40px; text-align: center; border-radius: 6px; margin-bottom: 20px;">
                        <i class="fas fa-image" style="font-size: 48px; color: #ccc; margin-bottom: 12px;"></i>
                        <p style="color: #666;">Sin imagen asignada</p>
                    </div>
                @endif

                <form action="{{ route('instructor.proyectos.imagen', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data" class="image-upload-form">
                    @csrf
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <input type="file" name="imagen" accept="image/*" required style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background: white;">
                        <button type="submit" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #39a900; color: white; border-radius: 6px; border: none; cursor: pointer; font-weight: 600;">
                            <i class="fas fa-upload"></i> Subir Imagen
                        </button>
                    </div>
                    @error('imagen')
                        <p style="color: #dc3545; font-size: 12px; margin-top: 8px;">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
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

        <!-- FORMULARIO PARA AGREGAR ETAPA -->
        <div class="card" style="margin-bottom: 20px;">
            <div style="padding: 20px;">
                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">
                    <i class="fas fa-plus" style="margin-right: 8px;"></i>Agregar Nueva Etapa
                </h3>
                <form action="{{ route('instructor.etapas.crear', $proyecto->pro_id) }}" method="POST" class="stage-form">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr 2fr auto; gap: 12px; align-items: flex-end;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px; color: #333;">Orden</label>
                            <input type="number" name="orden" required min="1" placeholder="1" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px; color: #333;">Nombre</label>
                            <input type="text" name="nombre" required placeholder="Ej: Análisis" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px; color: #333;">Descripción</label>
                            <input type="text" name="descripcion" required placeholder="Descripción de la etapa" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <button type="submit" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #39a900; color: white; border-radius: 6px; border: none; cursor: pointer; font-weight: 600; white-space: nowrap;">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                    @if ($errors->has('orden') || $errors->has('nombre') || $errors->has('descripcion'))
                        <div style="color: #dc3545; font-size: 12px; margin-top: 8px;">
                            @error('orden'){{ $message }}@enderror
                            @error('nombre'){{ $message }}@enderror
                            @error('descripcion'){{ $message }}@enderror
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- LISTA DE ETAPAS -->
        <div style="display: grid; gap: 12px;">
            @forelse($etapas as $etapa)
                <div class="stage-item">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div style="flex: 1;">
                            <div class="stage-name">
                                <span class="stage-order">{{ $etapa->eta_orden }}</span>
                                {{ $etapa->eta_nombre }}
                            </div>
                            <div class="stage-description">{{ $etapa->eta_descripcion ?? 'Sin descripción' }}</div>
                        </div>
                        <div style="display: flex; gap: 8px; flex-shrink: 0;">
                            <form action="{{ route('instructor.etapas.eliminar', $etapa->eta_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-reject" style="padding: 6px 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600;" onclick="return confirm('¿Estás seguro?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-tasks empty-state-icon"></i>
                    <h4 class="empty-state-title">Sin etapas</h4>
                    <p class="empty-state-message">No hay etapas definidas para este proyecto. ¡Crea una arriba!</p>
                </div>
            @endforelse
        </div>

        <!-- BOTONES DE ACCIONES -->
        <div style="margin-top: 32px; display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('instructor.reporte', $proyecto->pro_id) }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #39a900; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; transition: background 0.2s;">
                <i class="fas fa-chart-bar"></i> Reporte de Seguimiento
            </a>
            <a href="{{ route('instructor.evidencias.ver', $proyecto->pro_id) }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #0056b3; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; transition: background 0.2s;">
                <i class="fas fa-file-upload"></i> Ver Evidencias
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