@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto')
@section('page-title', 'Detalle del Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i> Mis Postulaciones
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Entregas
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Perfil
    </a>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">

    <div class="project-detail">
        <div class="project-header">
            <a href="{{ route('aprendiz.postulaciones') }}" class="project-back-link">
                <i class="fas fa-arrow-left"></i> Volver a mis postulaciones
            </a>
            <h1 class="project-title">{{ $proyecto->pro_titulo_proyecto }}</h1>
            <p class="project-subtitle">Detalles del proyecto y envío de evidencias</p>
        </div>

        @if(session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- INFORMACIÓN DEL PROYECTO -->
        <div class="card">
            @if($proyecto->pro_imagen_url)
                <img src="{{ $proyecto->pro_imagen_url }}" alt="{{ $proyecto->pro_titulo_proyecto }}" class="project-image">
            @else
                <div class="project-image-placeholder">
                    <i class="fas fa-image"></i>
                </div>
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
                    <span class="project-info-label">Instructor:</span>
                    <span class="project-info-value">{{ $proyecto->instructor_nombre }}</span>
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
                <h3>Descripción</h3>
                <p>{{ $proyecto->pro_descripcion }}</p>

                <h3>Requisitos Específicos</h3>
                <p>{{ $proyecto->pro_requisitos_especificos }}</p>

                <h3>Habilidades Requeridas</h3>
                <p>{{ $proyecto->pro_habilidades_requerida }}</p>
            </div>
        </div>

        <!-- ETAPAS Y FORMULARIO DE EVIDENCIA -->
        <h2 class="section-title">
            <i class="fas fa-tasks"></i>Etapas del Proyecto
        </h2>

        <div class="stages-grid">
            @forelse($etapas as $etapa)
                <div class="stage-card">
                    <div class="stage-header">
                        <div class="stage-header-content">
                            <div class="stage-title">
                                <span class="stage-number">{{ $etapa->eta_orden }}</span>
                                {{ $etapa->eta_nombre }}
                            </div>
                            <p class="stage-description">{{ $etapa->eta_descripcion }}</p>
                        </div>
                    </div>

                    <!-- EVIDENCIAS ANTERIORES -->
                    @php
                        $evidenciasEtapa = $evidencias->where('eta_id', $etapa->eta_id);
                    @endphp

                    @if($evidenciasEtapa->count() > 0)
                        <div class="evidences-list">
                            <h4>
                                <i class="fas fa-check"></i>Evidencias Subidas
                            </h4>
                            @foreach($evidenciasEtapa as $evid)
                                <div class="evidence-item">
                                    <div class="evidence-item-header">
                                        <div class="evidence-item-content">
                                            <p class="evidence-item-meta">
                                                <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evid->evid_fecha)->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="evidence-item-meta evidence-item-status">
                                                <strong>Estado:</strong>
                                                @switch($evid->evid_estado)
                                                    @case('Aprobada')
                                                        <span class="badge badge-success">{{ $evid->evid_estado }}</span>
                                                        @break
                                                    @case('Pendiente')
                                                        <span class="badge badge-warning">{{ $evid->evid_estado }}</span>
                                                        @break
                                                    @case('Rechazada')
                                                        <span class="badge badge-danger">{{ $evid->evid_estado }}</span>
                                                        @break
                                                @endswitch
                                            </p>
                                            @if($evid->evid_comentario)
                                                <div class="evidence-comment">
                                                    <strong>Comentario del instructor:</strong>
                                                    <p>{{ $evid->evid_comentario }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        @if($evid->evid_archivo)
                                            <a href="{{ asset('storage/' . $evid->evid_archivo) }}" target="_blank" class="download-btn">
                                                <i class="fas fa-download"></i> Descargar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- FORMULARIO PARA ENVIAR EVIDENCIA -->
                    <div class="evidence-form-section">
                        <h4>
                            <i class="fas fa-upload"></i>Enviar Nueva Evidencia
                        </h4>

                        <form action="{{ route('aprendiz.evidencia.enviar', [$proyecto->pro_id, $etapa->eta_id]) }}" method="POST" enctype="multipart/form-data" class="form-evidence">
                            @csrf

                            <div class="form-evidence-group">
                                <div class="form-field">
                                    <label>Descripción de la Evidencia *</label>
                                    <textarea 
                                        name="descripcion" 
                                        required 
                                        placeholder="Describe lo que has realizado en esta etapa...">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <p class="form-field-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-field">
                                    <label>Archivo (máx. 5MB)</label>
                                    <input 
                                        type="file" 
                                        name="archivo"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.zip">
                                    @error('archivo')
                                        <p class="form-field-error">{{ $message }}</p>
                                    @enderror
                                    <p class="form-field-help">Formatos aceptados: PDF, Word, Excel, PowerPoint, Imágenes, ZIP</p>
                                </div>

                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-paper-plane"></i> Enviar Evidencia
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-tasks empty-state-icon"></i>
                    <h4 class="empty-state-title">Sin etapas</h4>
                    <p class="empty-state-message">Este proyecto aún no tiene etapas definidas.</p>
                </div>
            @endforelse
        </div>
    </div>

