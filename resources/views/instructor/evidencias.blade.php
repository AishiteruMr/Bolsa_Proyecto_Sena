@extends('layouts.dashboard')

@section('title', 'Calificar Evidencias | ' . $proyecto->pro_titulo_proyecto)
@section('page-title', 'Calificaciones')

@section('sidebar-nav')
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
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('instructor.proyecto.detalle', $proyecto->pro_id) }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Regresar al Proyecto
                </a>
            </div>
            <h2 style="font-size:28px; font-weight:800; color:var(--primary-dark)">Centro de Evaluación</h2>
            <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Proyecto: <span style="color: var(--text-main); font-weight: 700;">{{ $proyecto->pro_titulo_proyecto }}</span></p>
        </div>
        <div class="badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); padding: 8px 16px;">
            {{ count($evidencias) }} Entregas Pendientes
        </div>
    </div>

    @if(session('success'))
        <div class="glass-card" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #065f46; padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px; border-radius: 12px;">
            <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
            <span style="font-weight: 600;">{{ session('success') }}</span>
        </div>
    @endif

    <div style="display: grid; gap: 2.5rem;">
        @forelse($evidencias as $evidencia)
            <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: 20px;">
                <!-- Header of the evidence card -->
                <div style="padding: 1.5rem 2rem; background: var(--bg-main); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: white; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--primary); position: relative;">
                            <i class="fas fa-file-invoice" style="font-size: 1.4rem;"></i>
                            <span style="position: absolute; -top: 8px; -right: 8px; background: var(--primary); color: white; width: 22px; height: 22px; border-radius: 50%; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white;">
                                {{ $evidencia->eta_orden }}
                            </span>
                        </div>
                        <div>
                            <h4 style="font-size: 1.15rem; font-weight: 800; color: var(--text-main);">Etapa: {{ $evidencia->eta_nombre }}</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted);"><i class="fas fa-user-graduate" style="margin-right: 6px;"></i>{{ $evidencia->apr_nombre }} {{ $evidencia->apr_apellido }}</p>
                        </div>
                    </div>
                    
                    <div style="text-align: right;">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; font-weight: 700;">Fecha de Entrega</p>
                        <p style="font-size: 0.95rem; font-weight: 600; color: var(--text-main);">{{ \Carbon\Carbon::parse($evidencia->evid_fecha)->format('d/m/Y - h:m A') }}</p>
                    </div>
                </div>

                <!-- Body of the card -->
                <div style="padding: 2rem;">
                    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2.5rem;">
                        
                        <!-- Left: Grading Form -->
                        <form action="{{ route('instructor.evidencias.calificar', $evidencia->evid_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 1rem;">Resolución de la Entrega</label>
                                <div style="display: flex; gap: 1rem;">
                                    <label class="grad-radio">
                                        <input type="radio" name="estado" value="Aprobada" {{ $evidencia->evid_estado === 'Aprobada' ? 'checked' : '' }} required>
                                        <div class="grad-box" style="--c: #10b981;">
                                            <i class="fas fa-check-double"></i>
                                            <span>Aprobado</span>
                                        </div>
                                    </label>
                                    <label class="grad-radio">
                                        <input type="radio" name="estado" value="Pendiente" {{ $evidencia->evid_estado === 'Pendiente' ? 'checked' : '' }} required>
                                        <div class="grad-box" style="--c: #f59e0b;">
                                            <i class="fas fa-history"></i>
                                            <span>Corregir</span>
                                        </div>
                                    </label>
                                    <label class="grad-radio">
                                        <input type="radio" name="estado" value="Rechazada" {{ $evidencia->evid_estado === 'Rechazada' ? 'checked' : '' }} required>
                                        <div class="grad-box" style="--c: #ef4444;">
                                            <i class="fas fa-times-circle"></i>
                                            <span>Reprobado</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 10px;">Retroalimentación Técnica</label>
                                <textarea name="comentario" class="form-control" style="width: 100%; min-height: 120px; padding: 1rem; border-radius: 12px; font-size: 0.95rem;" placeholder="Escribe aquí los comentarios sobre la calidad del entregable...">{{ $evidencia->evid_comentario }}</textarea>
                            </div>

                            <button type="submit" class="btn-ver" style="width: 100%; padding: 1rem; border-radius: 12px; font-size: 1rem; justify-content: center;">
                                <i class="fas fa-save" style="margin-right: 10px;"></i> Publicar Evaluación
                            </button>
                        </form>

                        <!-- Right: Deliverable Info -->
                        <div style="background: var(--bg-main); padding: 1.5rem; border-radius: 16px; border: 1px solid var(--border); display: flex; flex-direction: column; gap: 1.5rem;">
                            <div>
                                <h5 style="font-size: 0.8rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px;">Archivo Adjunto</h5>
                                @if($evidencia->evid_archivo)
                                    <a href="{{ asset('storage/' . $evidencia->evid_archivo) }}" target="_blank" style="display: flex; align-items: center; gap: 12px; text-decoration: none; padding: 12px; background: white; border-radius: 10px; border: 1px solid var(--border); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-download"></i>
                                        </div>
                                        <div style="overflow: hidden;">
                                            <p style="font-size: 0.85rem; font-weight: 700; color: var(--primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Descargar Entregable</p>
                                            <p style="font-size: 0.7rem; color: var(--text-muted);">Formato: {{ strtoupper(pathinfo($evidencia->evid_archivo, PATHINFO_EXTENSION)) }}</p>
                                        </div>
                                    </a>
                                @else
                                    <div style="text-align: center; padding: 1rem; border: 1px dashed var(--border); border-radius: 10px; color: var(--text-muted); font-size: 0.85rem;">
                                        <i class="fas fa-info-circle" style="margin-bottom: 6px; display: block;"></i>
                                        No se adjuntó archivo
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h5 style="font-size: 0.8rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px;">Cronograma</h5>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                                        <span style="color: var(--text-muted);">Estándar:</span>
                                        <span style="font-weight: 700; color: #059669;">A tiempo</span>
                                    </div>
                                    <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 3px;">
                                        <div style="width: 100%; height: 100%; background: #10b981; border-radius: 3px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card" style="padding: 5rem 2rem; text-align: center;">
                <div style="width: 100px; height: 100px; background: var(--bg-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--border);">
                    <i class="fas fa-check-double" style="font-size: 3rem;"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">Todo al día</h3>
                <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto;">No hay nuevas evidencias esperando calificación en este proyecto.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .grad-radio input { display: none; }
    .grad-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: white;
        border: 2px solid #f1f5f9;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        min-width: 100px;
    }
    .grad-box i { font-size: 1.2rem; color: #94a3b8; }
    .grad-box span { font-size: 0.85rem; font-weight: 700; color: #64748b; }
    .grad-radio input:checked + .grad-box {
        border-color: var(--c);
        background: {{ 'rgba(var(--c), 0.1)' }}; /* Placeholder logic */
    }
    /* Specific styles for checked states as CSS variables don't work easily with RGBA in raw CSS here */
    .grad-radio input[value="Aprobada"]:checked + .grad-box { border-color: #10b981; background: rgba(16, 185, 129, 0.1); }
    .grad-radio input[value="Aprobada"]:checked + .grad-box i, .grad-radio input[value="Aprobada"]:checked + .grad-box span { color: #059669; }
    
    .grad-radio input[value="Pendiente"]:checked + .grad-box { border-color: #f59e0b; background: rgba(245, 158, 11, 0.1); }
    .grad-radio input[value="Pendiente"]:checked + .grad-box i, .grad-radio input[value="Pendiente"]:checked + .grad-box span { color: #d97706; }
    
    .grad-radio input[value="Rechazada"]:checked + .grad-box { border-color: #ef4444; background: rgba(239, 68, 68, 0.1); }
    .grad-radio input[value="Rechazada"]:checked + .grad-box i, .grad-radio input[value="Rechazada"]:checked + .grad-box span { color: #dc2626; }
</style>
@endsection
