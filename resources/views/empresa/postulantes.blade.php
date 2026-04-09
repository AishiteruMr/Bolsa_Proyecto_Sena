@extends('layouts.dashboard')

@section('title', 'Postulantes')
@section('page-title', 'Candidatos al Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
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
<div class="animate-fade-in" style="padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-users"></i></div>
        <div style="position: relative; z-index: 1;">
            <a href="{{ route('empresa.proyectos') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 16px; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                <i class="fas fa-arrow-left"></i> Volver al Portafolio
            </a>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Postulantes</span>
                <span style="background: rgba(62,180,137,0.1); color: #3eb489; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ count($postulantes) }} candidatos</span>
            </div>
            <h1 class="instructor-title">{{ $proyecto->titulo }}</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 15px; font-weight: 500;">Gestiona las postulaciones de aprendices para este proyecto.</p>
        </div>
    </div>

    <!-- Ver Participantes Button -->
    <div style="margin-bottom: 24px;">
        <a href="{{ route('empresa.proyectos.participantes', $proyecto->id) }}" class="btn-premium" style="padding: 12px 24px; background: linear-gradient(135deg, #0ea5e9, #0284c7);">
            <i class="fas fa-users-rectangle"></i> Ver Participantes del Proyecto
        </a>
    </div>

    <!-- Candidates Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 24px;">
        @forelse($postulantes as $p)
            @php
                $statusConfig = match($p->pos_estado) {
                    'pendiente' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-clock', 'label' => 'Por Revisar'],
                    'aceptada' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a', 'icon' => 'fa-check-circle', 'label' => 'Aprobado'],
                    'rechazada' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#ef4444', 'icon' => 'fa-times-circle', 'label' => 'Rechazado'],
                    default => ['bg' => '#f1f5f9', 'border' => '#e2e8f0', 'text' => '#64748b', 'icon' => 'fa-circle', 'label' => $p->pos_estado]
                };
            @endphp
            <div class="glass-card" style="padding: 28px; position: relative; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 40px rgba(62,180,137,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(62,180,137,0.06)'">
                
                <!-- Status Ribbon -->
                <div style="position: absolute; top: 16px; right: 16px; background: {{ $statusConfig['bg'] }}; border: 1px solid {{ $statusConfig['border'] }}; color: {{ $statusConfig['text'] }}; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas {{ $statusConfig['icon'] }}"></i> {{ $statusConfig['label'] }}
                </div>

                    <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 20px;">
                    <div style="width: 70px; height: 70px; border-radius: 20px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 800; flex-shrink: 0; box-shadow: 0 8px 20px rgba(62,180,137,0.3);">
                        {{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $p->apr_nombre ?? '' }} {{ $p->apr_apellido ?? '' }}
                        </h4>
                        <div style="font-size: 13px; color: #3eb489; font-weight: 700; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                            <i class="fas fa-graduation-cap"></i> {{ $p->apr_programa ?? 'Especialidad SENA' }}
                        </div>
                        <div style="font-size: 12px; color: var(--text-lighter); display: flex; align-items: center; gap: 8px; font-weight: 600;">
                            <i class="fas fa-envelope-open-text" style="color: #94a3b8;"></i> {{ $p->usr_correo ?? '' }}
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                    <div style="background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Fecha Aplicación</span>
                        <span style="font-size: 13px; font-weight: 700; color: var(--text);">{{ \Carbon\Carbon::parse($p->pos_fecha)->translatedFormat('d M, Y') }}</span>
                    </div>
                    <div style="background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Disponibilidad</span>
                        <span style="font-size: 13px; font-weight: 700; color: var(--text);">Inmediata</span>
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('empresa.proyectos.participantes', $proyecto->id) }}" class="btn-premium" style="flex: 1; justify-content: center; background: #3b82f6;">
                        <i class="fas fa-user"></i> Ver Perfil
                    </a>
                    
                    @if($p->pos_estado == 'pendiente')
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('empresa.postulacion.estado', [$p->pos_id, 'aceptada']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-premium" style="width: 44px; height: 44px; padding: 0; justify-content: center; background: #10b981; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);" title="Aprobar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('empresa.postulacion.estado', [$p->pos_id, 'rechazada']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-premium" style="width: 44px; height: 44px; padding: 0; justify-content: center; background: #ef4444; box-shadow: 0 8px 16px rgba(239, 68, 68, 0.25);" title="Rechazar">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 80px 40px;">
                <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3eb489; margin: 0 auto 24px; font-size: 40px;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <h4 style="color: var(--text); font-size: 22px; font-weight: 800; margin-bottom: 8px;">Buscando el Match Perfecto</h4>
                <p style="color: var(--text-light); font-size: 16px; max-width: 500px; margin: 0 auto;">Tu proyecto está en el radar de nuestros aprendices. Recibirás postulaciones pronto.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
