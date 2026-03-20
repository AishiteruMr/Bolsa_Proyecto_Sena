@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto')
@section('page-title', 'Detalle del Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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
<link rel="stylesheet" href="{{ asset('css/instructor.css') }}">

<div class="project-detail">

    <!-- HEADER -->
    <div class="project-header">
        <a href="{{ route('aprendiz.postulaciones') }}" class="project-back-link">
            <i class="fas fa-arrow-left"></i> Volver a mis postulaciones
        </a>

        <div class="header-content">
            <h1 class="project-title">{{ $proyecto->pro_titulo_proyecto }}</h1>
            <p class="project-subtitle">Detalles del proyecto y envío de evidencias</p>
        </div>
    </div>

    @if(session('success'))
        <div class="success-message">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- IMAGEN -->
    <h2 class="section-title">
        <i class="fas fa-image"></i> Imagen del Proyecto
    </h2>

    <div class="card">
        <div class="card-content image-section">
            @if($proyecto->pro_imagen_url)
                <img src="{{ $proyecto->pro_imagen_url }}" class="project-image-large">
            @else
                <div class="no-image-placeholder-large">
                    <i class="fas fa-image"></i>
                    <h3>Sin imagen</h3>
                </div>
            @endif
        </div>
    </div>

    <!-- INFO -->
    <div class="card">
        <div class="card-content">
            <h3 class="card-subtitle">Información General</h3>

            <div class="project-info-grid">
                <div class="project-info-item">
                    <span class="project-info-label">Empresa:</span>
                    <span>{{ $proyecto->emp_nombre }}</span>
                </div>

                <div class="project-info-item">
                    <span class="project-info-label">Categoría:</span>
                    <span>{{ $proyecto->pro_categoria }}</span>
                </div>

                <div class="project-info-item">
                    <span class="project-info-label">Instructor:</span>
                    <span>{{ $proyecto->instructor_nombre }}</span>
                </div>

                <div class="project-info-item">
                    <span class="project-info-label">Estado:</span>
                    @if($proyecto->pro_estado === 'Activo')
                        <span class="badge badge-success">{{ $proyecto->pro_estado }}</span>
                    @else
                        <span class="badge badge-danger">{{ $proyecto->pro_estado }}</span>
                    @endif
                </div>

                <div class="project-info-item">
                    <span class="project-info-label">Publicación:</span>
                    <span>{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}</span>
                </div>

                <div class="project-info-item">
                    <span class="project-info-label">Finalización:</span>
                    <span>{{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="project-description-section">
                <h3 class="card-subtitle">Descripción</h3>
                <p>{{ $proyecto->pro_descripcion }}</p>

                <h3 class="card-subtitle">Requisitos</h3>
                <p>{{ $proyecto->pro_requisitos_especificos }}</p>

                <h3 class="card-subtitle">Habilidades</h3>
                <p>{{ $proyecto->pro_habilidades_requerida }}</p>
            </div>
        </div>
    </div>

    <!-- ETAPAS -->
    <h2 class="section-title">
        <i class="fas fa-tasks"></i> Etapas del Proyecto
    </h2>

    <div class="stages-grid">
        @forelse($etapas as $etapa)
            <div class="card">
                <div class="card-content">

                    <h3>
                        <span class="stage-order">{{ $etapa->eta_orden }}</span>
                        {{ $etapa->eta_nombre }}
                    </h3>

                    <p>{{ $etapa->eta_descripcion }}</p>

                    <!-- EVIDENCIAS -->
                    @php
                        $evidenciasEtapa = $evidencias->where('eta_id', $etapa->eta_id);
                    @endphp

                    @if($evidenciasEtapa->count())
                        <div class="evidences-list">
                            <h4>Evidencias</h4>

                            @foreach($evidenciasEtapa as $evid)
                                <div class="evidence-item">
                                    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evid->evid_fecha)->format('d/m/Y H:i') }}</p>

                                    <p><strong>Estado:</strong>
                                        @if($evid->evid_estado == 'Aprobada')
                                            <span class="badge badge-success">Aprobada</span>
                                        @elseif($evid->evid_estado == 'Pendiente')
                                            <span class="badge badge-warning">Pendiente</span>
                                        @else
                                            <span class="badge badge-danger">Rechazada</span>
                                        @endif
                                    </p>

                                    @if($evid->evid_comentario)
                                        <p><strong>Comentario:</strong> {{ $evid->evid_comentario }}</p>
                                    @endif

                                    @if($evid->evid_archivo)
                                        <a href="{{ asset('storage/' . $evid->evid_archivo) }}" target="_blank" class="btn-secondary btn-sm">
                                            Descargar
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- FORM -->
                    <form action="{{ route('aprendiz.evidencia.enviar', [$proyecto->pro_id, $etapa->eta_id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <textarea name="descripcion" required placeholder="Describe tu evidencia..." class="form-input"></textarea>

                        <input type="file" name="archivo" class="form-input">

                        <button class="btn-primary btn-sm">
                            Enviar Evidencia
                        </button>
                    </form>

                </div>
            </div>
        @empty
            <div class="empty-state">
                <h4>Sin etapas</h4>
            </div>
        @endforelse
    </div>

</div>

<style>
.project-detail {
    padding: 20px;
}

.card-content {
    padding: 20px;
}

.project-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.project-image-large {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 10px;
}

.stages-grid {
    display: grid;
    gap: 20px;
}

textarea.form-input, input.form-input {
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
}

</style>

@endsection