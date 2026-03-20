@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto')
@section('page-title', 'Detalle del Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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

@section('content')
    <link rel="stylesheet" href="{{ asset('css/instructor.css') }}">

    <div class="project-detail">
        <div class="project-header">
            <a href="{{ route('instructor.proyectos') }}" class="project-back-link">
                <i class="fas fa-arrow-left"></i> Volver a proyectos
            </a>
            <div class="header-content">
                <h1 class="project-title">{{ $proyecto->pro_titulo_proyecto }}</h1>
                <p class="project-subtitle">Detalles del proyecto y gestión de postulaciones</p>
            </div>
        </div>


        <!-- IMAGEN DEL PROYECTO -->
        <h2 class="section-title">
            <i class="fas fa-image" style="margin-right: 8px;"></i>Imagen del Proyecto
        </h2>

        <div class="card">
            <div class="card-content image-section">
                @if($proyecto->pro_imagen_url)
                    <!-- Si hay imagen: mostrar grande y botón de editar -->
                    <div class="image-display-container">
                        <img src="{{ $proyecto->pro_imagen_url }}" alt="{{ $proyecto->pro_titulo_proyecto }}" class="project-image-large">
                        <div class="image-actions">
                            <button type="button" class="btn-secondary btn-md" onclick="document.getElementById('editImageForm').style.display = document.getElementById('editImageForm').style.display === 'none' ? 'block' : 'none';">
                                <i class="fas fa-edit"></i> Cambiar Imagen
                            </button>
                        </div>
                    </div>

                    <!-- Formulario de editar imagen (oculto por defecto) -->
                    <form id="editImageForm" action="{{ route('instructor.proyectos.imagen', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data" class="image-upload-form" style="display: none; margin-top: 24px; padding-top: 24px; border-top: 1px solid #e0e0e0;">
                        @csrf
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 16px;">Cambiar imagen del proyecto</h4>
                        <div class="upload-form-group">
                            <input type="file" name="imagen" accept="image/*" required class="form-input-file">
                            <button type="submit" class="btn-primary btn-sm">
                                <i class="fas fa-upload"></i> Actualizar Imagen
                            </button>
                            <button type="button" class="btn-cancel btn-sm" onclick="document.getElementById('editImageForm').style.display = 'none';">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                        @error('imagen')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </form>
                @else
                    <!-- Si no hay imagen: mostrar opción de subir -->
                    <div class="no-image-placeholder-large">
                        <i class="fas fa-image"></i>
                        <h3>Sin imagen asignada</h3>
                        <p>Sube una imagen bonita para tu proyecto</p>
                    </div>

                    <form action="{{ route('instructor.proyectos.imagen', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data" class="image-upload-form">
                        @csrf
                        <div class="upload-form-group-full">
                            <div class="file-input-wrapper">
                                <input type="file" name="imagen" accept="image/*" required id="imagenInput" class="form-input-file-large">
                                <label for="imagenInput" class="file-input-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Selecciona una imagen o arrastra aquí</span>
                                </label>
                            </div>
                            <button type="submit" class="btn-primary btn-lg">
                                <i class="fas fa-upload"></i> Subir Imagen
                            </button>
                        </div>
                        @error('imagen')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </form>
                @endif
            </div>
        </div>

        <!-- INFORMACIÓN DEL PROYECTO -->
        <div class="card">
            <div class="card-content">
                <h3 class="card-subtitle">Información General</h3>
                <div class="project-info-grid">
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

                <div class="project-description-section">
                    <h3 class="card-subtitle">Descripción</h3>
                    <p>{{ $proyecto->pro_descripcion }}</p>

                    <h3 class="card-subtitle">Requisitos Específicos</h3>
                    <p>{{ $proyecto->pro_requisitos_especificos }}</p>

                    <h3 class="card-subtitle">Habilidades Requeridas</h3>
                    <p>{{ $proyecto->pro_habilidades_requerida }}</p>
                </div>
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
                                    <button type="submit" class="btn-approve btn-sm" title="Aprobar postulación">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('instructor.postulaciones.estado', $p->pos_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Rechazada">
                                    <button type="submit" class="btn-reject btn-sm" title="Rechazar postulación">
                                        <i class="fas fa-times"></i>
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
        <div class="card">
            <div class="card-content">
                <h3 class="card-subtitle">
                    <i class="fas fa-plus" style="margin-right: 8px;"></i>Agregar Nueva Etapa
                </h3>
                <form action="{{ route('instructor.etapas.crear', $proyecto->pro_id) }}" method="POST" class="stage-form">
                    @csrf
                    <div class="stage-form-grid">
                        <div class="form-group">
                            <label>Orden</label>
                            <input type="number" name="orden" required min="1" placeholder="1" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" required placeholder="Ej: Análisis" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" name="descripcion" required placeholder="Descripción de la etapa" class="form-input">
                        </div>
                        <button type="submit" class="btn-primary btn-sm align-self-end">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </div>
                    @if ($errors->has('orden') || $errors->has('nombre') || $errors->has('descripcion'))
                        <div class="error-message">
                            @error('orden'){{ $message }}@enderror
                            @error('nombre'){{ $message }}@enderror
                            @error('descripcion'){{ $message }}@enderror
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- LISTA DE ETAPAS -->
        <div class="stages-list">
            @forelse($etapas as $etapa)
                <div class="stage-item">
                    <div class="stage-content">
                        <div class="stage-info">
                            <div class="stage-name">
                                <span class="stage-order">{{ $etapa->eta_orden }}</span>
                                {{ $etapa->eta_nombre }}
                            </div>
                            <div class="stage-description">{{ $etapa->eta_descripcion ?? 'Sin descripción' }}</div>
                        </div>
                        <div class="stage-actions">
                            <form action="{{ route('instructor.etapas.eliminar', $etapa->eta_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-reject btn-sm" onclick="return confirm('¿Estás seguro?')" title="Eliminar etapa">
                                    <i class="fas fa-trash"></i>
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
        <div class="action-buttons">
            <a href="{{ route('instructor.reporte', $proyecto->pro_id) }}" class="btn-primary btn-md" title="Ver reporte de seguimiento">
                <i class="fas fa-chart-bar"></i> Reporte de Seguimiento
            </a>
            <a href="{{ route('instructor.evidencias.ver', $proyecto->pro_id) }}" class="btn-secondary btn-md" title="Ver evidencias del proyecto">
                <i class="fas fa-file-upload"></i> Ver Evidencias
            </a>
        </div>
    </div>

    <style>
        .header-content {
            margin-top: 12px;
        }

        .card-content {
            padding: 20px;
        }

        .card-subtitle {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #333;
        }

        .project-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .project-image-container {
            margin-bottom: 20px;
        }

        .no-image-placeholder {
            background: #f5f5f5;
            padding: 40px;
            text-align: center;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .no-image-placeholder i {
            font-size: 48px;
            color: #ccc;
            display: block;
            margin-bottom: 12px;
        }

        .no-image-placeholder p {
            color: #666;
            margin: 0;
        }

        .upload-form-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .form-input-file {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            font-size: 13px;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 8px;
        }

        .project-description-section {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e0e0e0;
        }

        .project-description-section p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
        }

        .stage-form-grid {
            display: grid;
            grid-template-columns: 100px 200px 1fr auto;
            gap: 12px;
            align-items: flex-end;
        }

        .align-self-end {
            align-self: flex-end;
        }

        .stages-list {
            display: grid;
            gap: 12px;
        }

        .stage-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        .stage-info {
            flex: 1;
        }

        .stage-actions {
            flex-shrink: 0;
        }

        .action-buttons {
            margin-top: 32px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 6px 12px !important;
            font-size: 12px !important;
        }

        .btn-md {
            padding: 10px 20px !important;
            font-size: 13px !important;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0056b3;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #004085;
        }

        .btn-lg {
            padding: 12px 32px !important;
            font-size: 14px !important;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #6c757d;
            color: white;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        /* Estilos de imagen mejorados */
        .image-section {
            text-align: center;
        }

        .image-display-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .project-image-large {
            max-width: 100%;
            max-height: 500px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            object-fit: cover;
        }

        .image-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            width: 100%;
        }

        .no-image-placeholder-large {
            padding: 60px 40px;
            background: linear-gradient(135deg, #f5f5f5 0%, #f9f9f9 100%);
            border-radius: 12px;
            border: 2px dashed #ddd;
            text-align: center;
            margin-bottom: 24px;
        }

        .no-image-placeholder-large i {
            font-size: 64px;
            color: #ccc;
            display: block;
            margin-bottom: 16px;
        }

        .no-image-placeholder-large h3 {
            color: #666;
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 8px 0;
        }

        .no-image-placeholder-large p {
            color: #999;
            font-size: 14px;
            margin: 0;
        }

        .upload-form-group-full {
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
        }

        .file-input-wrapper {
            width: 100%;
            position: relative;
        }

        .form-input-file-large {
            display: none;
        }

        .file-input-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border: 2px dashed #39a900;
            border-radius: 12px;
            background: #f9f9f9;
            cursor: pointer;
            transition: all 0.2s;
            gap: 12px;
        }

        .file-input-label:hover {
            background: #f0f8f0;
            border-color: #2d8500;
        }

        .file-input-label i {
            font-size: 48px;
            color: #39a900;
        }

        .file-input-label span {
            color: #666;
            font-weight: 500;
            font-size: 16px;
        }

        .upload-form-group {
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        @media (max-width: 1024px) {
            .project-info-grid {
                grid-template-columns: 1fr;
            }

            .stage-form-grid {
                grid-template-columns: 1fr;
            }

            .stage-content {
                flex-direction: column;
            }

            .stage-actions {
                align-self: flex-start;
            }

            .project-image-large {
                max-height: 350px;
            }
        }

        @media (max-width: 768px) {
            .upload-form-group {
                flex-direction: column;
            }

            .form-input-file {
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .no-image-placeholder-large {
                padding: 40px 20px;
            }

            .no-image-placeholder-large i {
                font-size: 48px;
            }

            .file-input-label {
                padding: 30px 20px;
            }

            .project-image-large {
                max-height: 250px;
            }
        }
    </style>

    <script>
        // Manejo de cambio de archivo
        document.addEventListener('DOMContentLoaded', function() {
            const fileInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');
            
            fileInputs.forEach(input => {
                if (input.closest('.file-input-wrapper')) {
                    const label = input.closest('.file-input-wrapper').querySelector('.file-input-label');
                    
                    input.addEventListener('change', function(e) {
                        if (this.files && this.files[0]) {
                            const fileName = this.files[0].name;
                            label.innerHTML = `<i class="fas fa-check-circle"></i><span style="color: #28a745;">Archivo seleccionado: ${fileName}</span>`;
                        }
                    });

                    // Drag and drop
                    const wrapper = input.closest('.file-input-wrapper');
                    
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        wrapper.addEventListener(eventName, preventDefaults, false);
                    });

                    function preventDefaults(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    ['dragenter', 'dragover'].forEach(eventName => {
                        wrapper.addEventListener(eventName, () => {
                            label.style.borderColor = '#2d8500';
                            label.style.background = '#f0f8f0';
                        }, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        wrapper.addEventListener(eventName, () => {
                            label.style.borderColor = '#39a900';
                            label.style.background = '#f9f9f9';
                        }, false);
                    });

                    wrapper.addEventListener('drop', (e) => {
                        const dt = e.dataTransfer;
                        const files = dt.files;
                        input.files = files;
                        
                        if (files && files[0]) {
                            const fileName = files[0].name;
                            label.innerHTML = `<i class="fas fa-check-circle"></i><span style="color: #28a745;">Archivo seleccionado: ${fileName}</span>`;
                        }
                    }, false);
                }
            });
        });
    </script>
@endsection
