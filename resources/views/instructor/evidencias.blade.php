@extends('layouts.dashboard')

@section('title', 'Calificar Evidencias | ' . $proyecto->titulo)
@section('page-title', 'Centro de Evaluación')

@section('sidebar-nav')
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
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
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    @vite(['resources/css/instructor.css'])
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('instructor.dashboard')], ['label' => 'Evidencias']]; @endphp

@section('content')
<div class="ev-container">

    <div class="ev-header">
        <div class="ev-header-left">
            <a href="{{ route('instructor.proyecto.detalle', $proyecto->id) }}" class="ev-back-link">
                <i class="fas fa-arrow-left"></i> Regresar al Proyecto
            </a>
            <h2 class="ev-title">Centro de Evaluación</h2>
            <p class="ev-subtitle">Proyecto: <span>{{ $proyecto->titulo }}</span></p>
        </div>
        <div class="ev-header-right">
            <div class="ev-badge">
                <i class="fas fa-clipboard-list"></i>
                <span>{{ $evidencias->total() }} Pendiente{{ $evidencias->total() !== 1 ? 's' : '' }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="ev-alert ev-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="ev-list">
        @forelse($evidencias as $evidencia)
            <div class="ev-card" data-evidencia-id="{{ $evidencia->id }}">
                <div class="ev-card-header">
                    <div class="ev-card-header-left">
                        <div class="ev-step-icon">
                            <i class="fas fa-file-invoice"></i>
                            <span class="ev-step-badge">{{ $evidencia->etapa->orden ?? '-' }}</span>
                        </div>
                        <div class="ev-card-meta">
                            <h4 class="ev-card-stage">Etapa {{ $evidencia->etapa->orden ?? '' }}: {{ $evidencia->etapa->nombre ?? 'Desconocida' }}</h4>
                            <p class="ev-card-learner">
                                <i class="fas fa-user-graduate"></i>
                                {{ $evidencia->aprendiz->nombres ?? '' }} {{ $evidencia->aprendiz->apellidos ?? '' }}
                            </p>
                        </div>
                    </div>
                    <div class="ev-card-header-right">
                        <span class="ev-date-label">Fecha de Entrega</span>
                        <span class="ev-date-value">{{ $evidencia->fecha_envio->format('d/m/Y - h:i A') }}</span>
                    </div>
                </div>

                <div class="ev-card-body">
                    <div class="ev-grid">
                        <div class="ev-form-col">
                            @if($evidencia->estado === 'pendiente')
                                <form class="form-calificar-ajax" action="{{ route('instructor.evidencias.calificar', $evidencia->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="ev-form-group">
                                        <label class="ev-label">Resolución de la Entrega</label>
                                        <div class="ev-radio-group">
                                            <label class="ev-radio">
                                                <input type="radio" name="estado" value="aceptada" required>
                                                <div class="ev-radio-box ev-radio-approved">
                                                    <i class="fas fa-check-double"></i>
                                                    <span>Aprobado</span>
                                                </div>
                                            </label>
                                            <label class="ev-radio">
                                                <input type="radio" name="estado" value="pendiente" required>
                                                <div class="ev-radio-box ev-radio-pending">
                                                    <i class="fas fa-history"></i>
                                                    <span>Corregir</span>
                                                </div>
                                            </label>
                                            <label class="ev-radio">
                                                <input type="radio" name="estado" value="rechazada" required>
                                                <div class="ev-radio-box ev-radio-rejected">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span>Reprobado</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="ev-form-group">
                                        <label class="ev-label">Retroalimentación Técnica</label>
                                        <textarea name="comentario" class="ev-textarea" placeholder="Escribe aquí los comentarios sobre la calidad del entregable...">{{ $evidencia->comentario_instructor }}</textarea>
                                    </div>

                                    <button type="submit" class="btn-premium ev-submit-btn">
                                        <i class="fas fa-save"></i> Publicar Evaluación
                                    </button>
                                </form>
                            @else
                                <div class="ev-result" id="eval-result-{{ $evidencia->id }}">
                                    <div class="ev-form-group">
                                        <label class="ev-label">Resolución de la Entrega</label>
                                        <div class="ev-status-grid">
                                            @php
                                                $statuses = [
                                                    'aceptada' => ['icon' => 'fa-check-double', 'label' => 'Aprobado'],
                                                    'pendiente' => ['icon' => 'fa-history', 'label' => 'Corregir'],
                                                    'rechazada' => ['icon' => 'fa-times-circle', 'label' => 'Reprobado'],
                                                ];
                                            @endphp
                                            @foreach($statuses as $est => $cfg)
                                                @php $active = $est === $evidencia->estado; @endphp
                                                <div class="ev-status-item {{ $active ? 'ev-status-' . $est : '' }}">
                                                    <i class="fas {{ $cfg['icon'] }}"></i>
                                                    <span>{{ $cfg['label'] }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="ev-form-group">
                                        <label class="ev-label">Retroalimentación Técnica</label>
                                        <div class="ev-comment-display">
                                            {{ $evidencia->comentario_instructor ?: 'Sin comentarios.' }}
                                        </div>
                                    </div>

                                    <div class="ev-lock-msg">
                                        <i class="fas fa-lock"></i>
                                        <span>Evaluación cerrada — Evidencia ya calificada</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="ev-file-col">
                            <div class="ev-file-section">
                                <h5 class="ev-file-title">Archivo Adjunto</h5>
                                @if($evidencia->ruta_archivo)
                                    <a href="{{ asset('storage/' . $evidencia->ruta_archivo) }}" target="_blank" class="ev-file-link">
                                        <div class="ev-file-icon">
                                            <i class="fas fa-file-download"></i>
                                        </div>
                                        <div class="ev-file-info">
                                            <span class="ev-file-name">Descargar Entregable</span>
                                            <span class="ev-file-format">{{ strtoupper(pathinfo($evidencia->ruta_archivo, PATHINFO_EXTENSION)) }}</span>
                                        </div>
                                    </a>
                                @else
                                    <div class="ev-file-empty">
                                        <i class="fas fa-info-circle"></i>
                                        No se adjuntó archivo
                                    </div>
                                @endif
                            </div>

                            <div class="ev-file-section">
                                <h5 class="ev-file-title">Estado Cronograma</h5>
                                <div class="ev-schedule">
                                    <div class="ev-schedule-row">
                                        <span>Estatus:</span>
                                        <span class="ev-schedule-status">Cumplido</span>
                                    </div>
                                    <div class="ev-progress-track">
                                        <div class="ev-progress-fill"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="ev-empty">
                <div class="ev-empty-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <h3 class="ev-empty-title">Todo al día</h3>
                <p class="ev-empty-text">No hay nuevas evidencias esperando calificación en este proyecto.</p>
            </div>
        @endforelse
    </div>

    @if($evidencias->hasPages())
        <div class="ev-pagination">
            {{ $evidencias->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-calificar-ajax').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            const evidId = this.action.split('/').pop();

            ajax.disableButton(btn, 'Calificando...');
            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            ajax.post(this.action, formData).then(res => {
                ajax.showToast('success', res.data.message);

                const estadosHtml = res.data.estadosHtml;
                const comentario = res.data.comentario;
                const estado = res.data.estado;

                const evalCol = document.querySelector('.ev-card[data-evidencia-id="' + evidId + '"] .form-calificar-ajax');
                if (evalCol) {
                    const parentGrid = evalCol.closest('.ev-grid');
                    if (parentGrid) {
                        evalCol.outerHTML = '<div class="ev-result">' +
                            '<div class="ev-form-group">' +
                                '<label class="ev-label">Resolución de la Entrega</label>' +
                                '<div class="ev-status-grid">' + estadosHtml + '</div>' +
                            '</div>' +
                            '<div class="ev-form-group">' +
                                '<label class="ev-label">Retroalimentación Técnica</label>' +
                                '<div class="ev-comment-display">' + (comentario || 'Sin comentarios.') + '</div>' +
                            '</div>' +
                            '<div class="ev-lock-msg">' +
                                '<i class="fas fa-lock"></i>' +
                                '<span>Evaluación cerrada — Evidencia ya calificada</span>' +
                            '</div>' +
                        '</div>';
                    }
                }

                const badge = document.querySelector('.ev-badge span');
                if (badge) {
                    const match = badge.textContent.match(/(\d+)/);
                    if (match) {
                        const count = parseInt(match[1]);
                        if (count > 0) {
                            badge.textContent = badge.textContent.replace(count, count - 1);
                        }
                    }
                }
            }).catch(err => {
                ajax.enableButton(btn);
                ajax.showToast('error', err.response?.data?.message || 'Error al calificar evidencia.');
            });
        });
    });
});
</script>
@endsection
