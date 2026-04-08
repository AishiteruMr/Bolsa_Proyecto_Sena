@extends('layouts.dashboard')

@section('title', 'Calificar Evidencias | ' . $proyecto->titulo)
@section('page-title', 'Calificaciones')

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
    <link rel="stylesheet" href="{{ asset('css/instructor.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('instructor.proyecto.detalle', $proyecto->id) }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 700;">
                    <i class="fas fa-arrow-left"></i> Regresar al Proyecto
                </a>
            </div>
            <h2 style="font-size:28px; font-weight:800; color:var(--text)">Centro de Evaluación</h2>
            <p style="color:var(--text-light); font-size:15px; margin-top:4px; font-weight: 500;">Proyecto: <span style="color: var(--text); font-weight: 800;">{{ $proyecto->titulo }}</span></p>
        </div>
        <div class="aprendiz-badge-portal" style="background: #eff6ff; border-color: #dbeafe; color: #3b82f6; padding: 8px 16px; font-weight: 800;">
            {{ count($evidencias) }} Entregas Pendientes
        </div>
    </div>

    @if(session('success'))
        <div class="glass-card animate-fade-in" style="background: #f0fdf4; border-color: #bbf7d0; color: #16a34a; padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px; border-radius: 12px;">
            <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
            <span style="font-weight: 700;">{{ session('success') }}</span>
        </div>
    @endif

    <div style="display: grid; gap: 2.5rem;">
        @forelse($evidencias as $evidencia)
            <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: 20px;">
                <!-- Header of the evidence card -->
                <div style="padding: 1.5rem 2rem; background: #f8fafc; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div class="instructor-evidence-header-icon">
                            <i class="fas fa-file-invoice" style="font-size: 1.4rem;"></i>
                            <span class="instructor-evidence-step-badge">
                                {{ $evidencia->orden }}
                            </span>
                        </div>
                        <div>
                            <h4 style="font-size: 1.15rem; font-weight: 800; color: var(--text);">Etapa: {{ $evidencia->nombre }}</h4>
                            <p style="font-size: 0.85rem; color: var(--text-light); font-weight: 600;"><i class="fas fa-user-graduate" style="margin-right: 6px;"></i>{{ $evidencia->nombres }} {{ $evidencia->apellidos }}</p>
                        </div>
                    </div>
                    
                    <div style="text-align: right;">
                        <p style="font-size: 0.75rem; color: var(--text-lighter); margin-bottom: 6px; text-transform: uppercase; font-weight: 800;">Fecha de Entrega</p>
                        <p style="font-size: 0.95rem; font-weight: 700; color: var(--text);">{{ \Carbon\Carbon::parse($evidencia->fecha_envio)->format('d/m/Y - h:i A') }}</p>
                    </div>
                </div>

                <!-- Body of the card -->
                <div style="padding: 2.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2.5rem;">
                        
                        <!-- Left: Grading Form -->
                        <form action="{{ route('instructor.evidencias.calificar', $evidencia->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; margin-bottom: 1.25rem; letter-spacing: 0.5px;">Resolución de la Entrega</label>
                                <div style="display: flex; gap: 1rem;">
                                    <label class="instructor-grad-radio">
                                        <input type="radio" name="estado" value="aceptada" {{ $evidencia->estado === 'aceptada' ? 'checked' : '' }} required>
                                        <div class="instructor-grad-box">
                                            <i class="fas fa-check-double"></i>
                                            <span>Aprobado</span>
                                        </div>
                                    </label>
                                    <label class="instructor-grad-radio">
                                        <input type="radio" name="estado" value="pendiente" {{ $evidencia->estado === 'pendiente' ? 'checked' : '' }} required>
                                        <div class="instructor-grad-box">
                                            <i class="fas fa-history"></i>
                                            <span>Corregir</span>
                                        </div>
                                    </label>
                                    <label class="instructor-grad-radio">
                                        <input type="radio" name="estado" value="rechazada" {{ $evidencia->estado === 'rechazada' ? 'checked' : '' }} required>
                                        <div class="instructor-grad-box">
                                            <i class="fas fa-times-circle"></i>
                                            <span>Reprobado</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div style="margin-bottom: 2rem;">
                                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">Retroalimentación Técnica</label>
                                <textarea name="comentario" class="instructor-input-control" style="min-height: 120px; padding: 1.25rem;" placeholder="Escribe aquí los comentarios sobre la calidad del entregable...">{{ $evidencia->comentario_instructor }}</textarea>
                            </div>

                            <button type="submit" class="btn-premium" style="width: 100%; padding: 1rem; font-size: 1rem; justify-content: center;">
                                <i class="fas fa-save" style="margin-right: 10px;"></i> Publicar Evaluación
                            </button>
                        </form>

                        <!-- Right: Deliverable Info -->
                        <div class="instructor-deliverable-info">
                            <div>
                                <h5 style="font-size: 0.8rem; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; margin-bottom: 12px;">Archivo Adjunto</h5>
                                @if($evidencia->ruta_archivo)
                                    <a href="{{ asset('storage/' . $evidencia->ruta_archivo) }}" target="_blank" class="instructor-team-member" style="text-decoration: none; padding: 12px;">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; border: 1px solid #dbeafe;">
                                            <i class="fas fa-file-download"></i>
                                        </div>
                                        <div style="overflow: hidden;">
                                            <p style="font-size: 0.85rem; font-weight: 800; color: #2563eb; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Descargar Entregable</p>
                                            <p style="font-size: 0.7rem; color: var(--text-lighter); font-weight: 600;">Formato: {{ strtoupper(pathinfo($evidencia->ruta_archivo, PATHINFO_EXTENSION)) }}</p>
                                        </div>
                                    </a>
                                @else
                                    <div style="text-align: center; padding: 1.5rem; border: 2px dashed var(--border); border-radius: 12px; color: var(--text-lighter); font-size: 0.85rem; font-weight: 600;">
                                        <i class="fas fa-info-circle" style="margin-bottom: 6px; display: block; font-size: 1.2rem;"></i>
                                        No se adjuntó archivo
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h5 style="font-size: 0.8rem; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; margin-bottom: 12px;">Estado Cronograma</h5>
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700;">
                                        <span style="color: var(--text-light);">Estatus:</span>
                                        <span style="color: #059669;">Cumplido</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                                        <div style="width: 100%; height: 100%; background: #10b981; border-radius: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card animate-fade-in" style="padding: 5rem 2rem; text-align: center;">
                <div style="width: 100px; height: 100px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; color: var(--border); border: 1px solid var(--border);">
                    <i class="fas fa-check-double" style="font-size: 3rem;"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text);">Todo al día</h3>
                <p style="color: var(--text-light); max-width: 400px; margin: 0 auto; font-weight: 500;">No hay nuevas evidencias esperando calificación en este proyecto.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
