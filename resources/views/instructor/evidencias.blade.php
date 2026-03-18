@extends('layouts.dashboard')

@section('title', 'Evidencias del Proyecto')
@section('page-title', 'Calificar Evidencias')

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
            <a href="{{ route('instructor.proyecto.detalle', $proyecto->pro_id) }}" class="project-back-link">
                <i class="fas fa-arrow-left"></i> Volver al proyecto
            </a>
            <h1 class="project-title">{{ $proyecto->pro_titulo_proyecto }}</h1>
            <p class="project-subtitle">Calificación de evidencias subidas por los aprendices</p>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; color: #155724;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- EVIDENCIAS -->
        <div class="card">
            @forelse($evidencias as $evidencia)
                <div class="evidence-item">
                    <div class="evidence-header">
                        <div class="evidence-info">
                            <h4 class="evidence-title">
                                <span class="stage-order">{{ $evidencia->eta_orden }}</span>
                                {{ $evidencia->eta_nombre }}
                            </h4>
                            <p class="evidence-student">
                                <i class="fas fa-user"></i>
                                {{ $evidencia->apr_nombre }} {{ $evidencia->apr_apellido }}
                            </p>
                            <p class="evidence-email">
                                <i class="fas fa-envelope"></i>
                                {{ $evidencia->usr_correo }}
                            </p>
                            <p class="evidence-date">
                                <i class="fas fa-calendar"></i>
                                Subida: {{ \Carbon\Carbon::parse($evidencia->evid_fecha)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="evidence-file">
                            @if($evidencia->evid_archivo)
                                <a href="{{ asset('storage/' . $evidencia->evid_archivo) }}" target="_blank" class="file-link">
                                    <i class="fas fa-download"></i> Descargar Archivo
                                </a>
                            @else
                                <span style="color: #888; font-size: 12px;">Sin archivo adjunto</span>
                            @endif
                        </div>
                    </div>

                    <!-- FORMULARIO DE CALIFICACIÓN -->
                    <form action="{{ route('instructor.evidencias.calificar', $evidencia->evid_id) }}" method="POST" class="evidence-form">
                        @csrf
                        @method('PUT')

                        <div style="display: grid; gap: 12px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 8px; color: #333;">Estado</label>
                                <div style="display: flex; gap: 8px;">
                                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                                        <input type="radio" name="estado" value="Aprobada" {{ $evidencia->evid_estado === 'Aprobada' ? 'checked' : '' }} required>
                                        <span class="badge badge-success">Aprobada</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                                        <input type="radio" name="estado" value="Pendiente" {{ $evidencia->evid_estado === 'Pendiente' ? 'checked' : '' }} required>
                                        <span class="badge badge-warning">Pendiente</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                                        <input type="radio" name="estado" value="Rechazada" {{ $evidencia->evid_estado === 'Rechazada' ? 'checked' : '' }} required>
                                        <span class="badge badge-danger">Rechazada</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 8px; color: #333;">Comentarios</label>
                                <textarea name="comentario" placeholder="Escribe tus comentarios o feedback para el aprendiz..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: inherit; resize: vertical; min-height: 80px;">{{ $evidencia->evid_comentario }}</textarea>
                            </div>

                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <button type="submit" class="btn-approve" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                                    <i class="fas fa-save"></i> Guardar Calificación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-file-upload empty-state-icon"></i>
                    <h4 class="empty-state-title">No hay evidencias</h4>
                    <p class="empty-state-message">Los aprendices aún no han subido evidencias para este proyecto.</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .evidence-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 20px;
        }

        .evidence-item:last-child {
            border-bottom: none;
        }

        .evidence-header {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 20px;
            margin-bottom: 16px;
            align-items: flex-start;
        }

        .evidence-info {
            flex: 1;
        }

        .evidence-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .evidence-student {
            font-size: 14px;
            color: #333;
            margin-bottom: 4px;
        }

        .evidence-student i,
        .evidence-email i,
        .evidence-date i {
            color: #39a900;
            margin-right: 6px;
        }

        .evidence-email,
        .evidence-date {
            font-size: 13px;
            color: #666;
            margin-bottom: 4px;
        }

        .evidence-file {
            text-align: right;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: #0056b3;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .file-link:hover {
            background: #004085;
        }

        .evidence-form {
            background: #f9f9f9;
            padding: 16px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        @media (max-width: 768px) {
            .evidence-header {
                grid-template-columns: 1fr;
            }

            .evidence-file {
                text-align: left;
            }
        }
    </style>
@endsection
