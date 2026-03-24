@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto | ' . $proyecto->pro_titulo_proyecto)
@section('page-title', 'Detalle de Proyecto')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('content')
<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
    
    <!-- Main Content Pillar -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Header Hero Section -->
        <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: 20px;">
            <div style="width: 100%; height: 240px; position: relative;">
                <img src="{{ $proyecto->pro_imagen_url ?: asset('assets/proyecto_default.jpg') }}" alt="Proyecto" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, transparent 60%);"></div>
                <div style="position: absolute; bottom: 20px; left: 24px;">
                    <span class="badge" style="background: var(--primary); color: white; margin-bottom: 8px;">{{ $proyecto->pro_categoria }}</span>
                    <h2 style="color: white; font-size: 2rem; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $proyecto->pro_titulo_proyecto }}</h2>
                </div>
            </div>
            
            <div style="padding: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem;">Descripción de la Convocatoria</h3>
                <div style="color: var(--text-muted); line-height: 1.7; font-size: 1rem; text-align: justify;">
                    {!! nl2br(e($proyecto->pro_descripcion)) !!}
                </div>
            </div>
        </div>

        <!-- Bento Grid for Requirements -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="glass-card" style="padding: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4 style="font-weight: 700; font-size: 1.1rem;">Requisitos Técnicos</h4>
                </div>
                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">{{ $proyecto->pro_requisitos_especificos }}</p>
            </div>

            <div class="glass-card" style="padding: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4 style="font-weight: 700; font-size: 1.1rem;">Habilidades Buscadas</h4>
                </div>
                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">{{ $proyecto->pro_habilidades_requerida }}</p>
            </div>
        </div>

        <!-- Stages Section -->
        <div class="glass-card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main);">Estructura del Proyecto</h3>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">{{ count($etapas) }} Etapas Definidas</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @forelse($etapas as $index => $etapa)
                    <div style="display: flex; gap: 1.5rem;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $index == 0 ? 'var(--primary)' : 'var(--bg-main)' }}; color: {{ $index == 0 ? 'white' : 'var(--text-muted)' }}; border: 2px solid {{ $index == 0 ? 'var(--primary)' : 'var(--border)' }}; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700; z-index: 2;">
                                {{ $index + 1 }}
                            </div>
                            @if(!$loop->last)
                                <div style="width: 2px; flex: 1; background: var(--border); margin: 4px 0;"></div>
                            @endif
                        </div>
                        <div style="padding-bottom: 1rem;">
                            <h5 style="font-weight: 700; color: var(--text-main); margin-bottom: 4px;">{{ $etapa->eta_nombre }}</h5>
                            <p style="font-size: 0.9rem; color: var(--text-muted);">{{ $etapa->eta_descripcion }}</p>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem; background: var(--bg-main); border-radius: 12px; border: 1px dashed var(--border);">
                        <i class="fas fa-stream" style="font-size: 2rem; color: var(--border); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-muted);">El instructor aún no ha definido las etapas de este proyecto.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar Info Pillar -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 2rem;">
        
        <!-- Status Card -->
        <div class="glass-card" style="padding: 1.5rem;">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); font-weight: 700; margin-bottom: 8px;">Estado Actual</p>
                <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); font-size: 1rem; padding: 6px 16px;">
                    {{ $proyecto->pro_estado }}
                </span>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Duración:</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">{{ $proyecto->pro_duracion_estimada }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Publicado:</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Instructor Assigned -->
        <div class="glass-card" style="padding: 1.5rem;">
            <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem;">Instructor Responsable</h4>
            @if($proyecto->ins_nombre)
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem;">
                        {{ substr($proyecto->ins_nombre, 0, 1) }}
                    </div>
                    <div>
                        <p style="font-size: 0.9rem; font-weight: 700; color: var(--text-main);">{{ $proyecto->ins_nombre }} {{ $proyecto->ins_apellido }}</p>
                        <p style="font-size: 0.75rem; color: var(--primary);">Instructor SENA</p>
                    </div>
                </div>
            @else
                <div style="display: flex; align-items: center; gap: 12px; color: var(--text-muted);">
                    <i class="fas fa-user-clock" style="font-size: 1.5rem;"></i>
                    <p style="font-size: 0.85rem;">Pendiente por asignar instructor.</p>
                </div>
            @endif
        </div>

        <!-- Call to Action -->
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('empresa.proyectos.edit', $proyecto->pro_id) }}" class="btn-ver" style="justify-content: center; background: #3b82f6; width: 100%; padding: 1rem;">
                <i class="fas fa-edit" style="margin-right: 8px;"></i> Editar Proyecto
            </a>
            <a href="{{ route('empresa.proyectos.postulantes', $proyecto->pro_id) }}" class="btn-ver" style="justify-content: center; width: 100%; padding: 1rem;">
                <i class="fas fa-users" style="margin-right: 8px;"></i> Ver Postulantes
            </a>
        </div>
    </div>
</div>
@endsection