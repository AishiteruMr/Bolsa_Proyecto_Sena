@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto | ' . $proyecto->pro_titulo_proyecto)
@section('page-title', 'Detalle de Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="display: grid; grid-template-columns: 2fr 1fr; gap: 28px; padding-bottom: 40px; align-items: start;">
    
    <!-- Main Content -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Hero Image -->
        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <div style="width: 100%; height: 240px; position: relative;">
                <img src="{{ $proyecto->pro_imagen_url ?: asset('assets/proyecto_default.jpg') }}" alt="Proyecto" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, transparent 60%);"></div>
                <div style="position: absolute; bottom: 20px; left: 24px;">
                    <span style="background: #3eb489; color: white; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: inline-block;">{{ $proyecto->pro_categoria }}</span>
                    <h2 style="color: white; font-size: 1.6rem; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $proyecto->pro_titulo_proyecto }}</h2>
                </div>
            </div>
            
            <div style="padding: 28px;">
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 16px;">Descripción de la Convocatoria</h3>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 14px; font-weight: 500;">
                    {{ $proyecto->pro_descripcion }}
                </p>
            </div>
        </div>

        <!-- Requirements Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="glass-card" style="padding: 24px;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59,130,246,0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4 style="font-weight: 800; font-size: 15px; color: var(--text);">Requisitos Técnicos</h4>
                </div>
                <p style="color: var(--text-light); font-size: 13px; line-height: 1.6; font-weight: 500;">{{ $proyecto->pro_requisitos_especificos }}</p>
            </div>

            <div class="glass-card" style="padding: 24px;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4 style="font-weight: 800; font-size: 15px; color: var(--text);">Habilidades Buscadas</h4>
                </div>
                <p style="color: var(--text-light); font-size: 13px; line-height: 1.6; font-weight: 500;">{{ $proyecto->pro_habilidades_requerida }}</p>
            </div>
        </div>

        <!-- Stages Section -->
        <div class="glass-card" style="padding: 28px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">
                    <i class="fas fa-tasks" style="color: #3eb489; margin-right: 10px;"></i>Estructura del Proyecto
                </h3>
                <span style="font-size: 12px; color: var(--text-light); font-weight: 700;">{{ count($etapas) }} Etapas Definidas</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                @forelse($etapas as $index => $etapa)
                    <div style="display: flex; gap: 20px;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $index == 0 ? 'linear-gradient(135deg, #3eb489, #2d9d74)' : '#f8fafc' }}; color: {{ $index == 0 ? 'white' : 'var(--text-light)' }}; border: 2px solid {{ $index == 0 ? '#3eb489' : '#e2e8f0' }}; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800; flex-shrink: 0; box-shadow: {{ $index == 0 ? '0 4px 12px rgba(62,180,137,0.3)' : 'none' }};">
                                {{ $index + 1 }}
                            </div>
                            @if(!$loop->last)
                                <div style="width: 2px; flex: 1; min-height: 40px; background: #e2e8f0; margin: 8px 0;"></div>
                            @endif
                        </div>
                        <div style="flex: 1; padding-bottom: 20px;">
                            <h5 style="font-weight: 800; color: var(--text); margin-bottom: 4px; font-size: 15px;">{{ $etapa->eta_nombre }}</h5>
                            <p style="font-size: 13px; color: var(--text-light); line-height: 1.6;">{{ $etapa->eta_descripcion }}</p>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; background: #f8fafc; border-radius: 16px; border: 2px dashed #e2e8f0;">
                        <i class="fas fa-stream" style="font-size: 32px; color: var(--text-lighter); margin-bottom: 12px;"></i>
                        <p style="color: var(--text-light); font-weight: 600;">El instructor aún no ha definido las etapas de este proyecto.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div style="display: flex; flex-direction: column; gap: 20px; position: sticky; top: 24px;">
        
        <!-- Status Card -->
        <div class="glass-card" style="padding: 24px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-light); font-weight: 800; margin-bottom: 10px;">Estado Actual</p>
                @php
                    $statusClass = match($proyecto->pro_estado) {
                        'Activo' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a'],
                        'Pendiente' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706'],
                        default => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#ef4444'],
                    };
                @endphp
                <span style="background: {{ $statusClass['bg'] }}; border: 1px solid {{ $statusClass['border'] }}; color: {{ $statusClass['text'] }}; font-size: 14px; padding: 8px 20px; border-radius: 20px; font-weight: 800;">
                    {{ $proyecto->pro_estado }}
                </span>
            </div>
            
            <div style="display: grid; gap: 14px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 13px; color: var(--text-light); font-weight: 600;">Duración:</span>
                    <span style="font-size: 14px; font-weight: 800; color: var(--text);">{{ $proyecto->pro_duracion_estimada }} días</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 13px; color: var(--text-light); font-weight: 600;">Publicado:</span>
                    <span style="font-size: 14px; font-weight: 800; color: var(--text);">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 13px; color: var(--text-light); font-weight: 600;">Cierre:</span>
                    <span style="font-size: 14px; font-weight: 800; color: #ef4444;">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Instructor Assigned -->
        <div class="glass-card" style="padding: 24px;">
            <h4 style="font-size: 14px; font-weight: 800; color: var(--text); margin-bottom: 16px;">
                <i class="fas fa-chalkboard-teacher" style="color: #3eb489; margin-right: 8px;"></i>Instructor Responsable
            </h4>
            @if($proyecto->ins_nombre)
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px;">
                        {{ substr($proyecto->ins_nombre, 0, 1) }}
                    </div>
                    <div>
                        <p style="font-size: 14px; font-weight: 800; color: var(--text);">{{ $proyecto->ins_nombre }} {{ $proyecto->ins_apellido }}</p>
                        <p style="font-size: 12px; color: #3eb489; font-weight: 600;">Instructor SENA</p>
                    </div>
                </div>
            @else
                <div style="display: flex; align-items: center; gap: 12px; color: var(--text-light); padding: 16px; background: #f8fafc; border-radius: 12px;">
                    <i class="fas fa-user-clock" style="font-size: 20px;"></i>
                    <p style="font-size: 13px; font-weight: 600;">Pendiente por asignar.</p>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="{{ route('empresa.proyectos.edit', $proyecto->pro_id) }}" class="btn-premium" style="justify-content: center; background: #3b82f6; padding: 14px 20px;">
                <i class="fas fa-edit"></i> Editar Proyecto
            </a>
            <a href="{{ route('empresa.proyectos.postulantes', $proyecto->pro_id) }}" class="btn-premium" style="justify-content: center; padding: 14px 20px;">
                <i class="fas fa-users"></i> Ver Postulantes
            </a>
        </div>
    </div>
</div>
@endsection
