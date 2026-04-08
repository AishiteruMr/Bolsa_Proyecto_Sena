@extends('layouts.dashboard')

@section('title', 'Participantes del Proyecto')
@section('page-title', 'Participantes')

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
<div class="animate-fade-in" style="padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero" style="margin-bottom: 32px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-users"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos.postulantes', $proyecto->id) }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                    <i class="fas fa-arrow-left"></i> Volver a Postulantes
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Participantes</span>
            </div>
            <h1 class="instructor-title">{{ $proyecto->titulo }}</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 15px; font-weight: 500;">Aprendices aprobados e instructor asignado a este proyecto.</p>
        </div>
    </div>

    <!-- Instructor Card -->
    <div style="margin-bottom: 32px;">
        <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-chalkboard-teacher" style="color: #3eb489;"></i> Instructor Asignado
        </h3>
        @if($proyecto->instructor)
            <div class="glass-card" style="padding: 28px; display: flex; align-items: center; gap: 24px; border-left: 4px solid #3eb489;">
                <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 800; flex-shrink: 0; box-shadow: 0 8px 20px rgba(62,180,137,0.3);">
                    {{ strtoupper(substr($proyecto->instructor->nombres, 0, 1)) }}
                </div>
                <div style="flex: 1;">
                    <h4 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 6px;">
                        {{ $proyecto->instructor->nombres }} {{ $proyecto->instructor->apellidos }}
                    </h4>
                    <div style="display: flex; gap: 20px; font-size: 14px; color: var(--text-light);">
                        <span><i class="fas fa-envelope" style="margin-right: 6px; color: #3eb489;"></i> {{ $proyecto->instructor->ins_correo }}</span>
                        @if($proyecto->instructor->ins_telefono)
                            <span><i class="fas fa-phone" style="margin-right: 6px; color: #3eb489;"></i> {{ $proyecto->instructor->ins_telefono }}</span>
                        @endif
                    </div>
                </div>
                <div style="background: rgba(62,180,137,0.1); padding: 12px 20px; border-radius: 12px;">
                    <span style="font-size: 12px; font-weight: 800; color: #3eb489; text-transform: uppercase;">Instructor SENA</span>
                </div>
            </div>
        @else
            <div class="glass-card" style="padding: 28px; text-align: center; border: 2px dashed rgba(62,180,137,0.2);">
                <i class="fas fa-user-clock" style="font-size: 40px; color: var(--text-lighter); margin-bottom: 12px;"></i>
                <p style="font-size: 16px; color: var(--text-light); font-weight: 600;">Aún no se ha asignado un instructor a este proyecto.</p>
            </div>
        @endif
    </div>

    <!-- Aprendices -->
    <div>
        <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-user-graduate" style="color: #3b82f6;"></i> Aprendices Aprobados
            <span style="background: #eff6ff; color: #3b82f6; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; margin-left: 8px;">{{ $aprendices->count() }}</span>
        </h3>

        @if($aprendices->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;">
                @foreach($aprendices as $aprendiz)
                    <div class="glass-card" style="padding: 24px; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 32px rgba(62,180,137,0.12)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(62,180,137,0.06)'">
                        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                            <div style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; flex-shrink: 0; box-shadow: 0 6px 16px rgba(59,130,246,0.3);">
                                {{ strtoupper(substr($aprendiz->nombres, 0, 1)) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 17px; font-weight: 800; color: var(--text); margin-bottom: 4px;">
                                    {{ $aprendiz->nombres }} {{ $aprendiz->apellidos }}
                                </h4>
                                <p style="font-size: 13px; color: #3eb489; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-graduation-cap"></i> {{ $aprendiz->programa_formacion }}
                                </p>
                            </div>
                        </div>

                        <div style="background: #f8fafc; border-radius: 12px; padding: 14px 16px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-envelope" style="color: #94a3b8; width: 16px;"></i>
                                <span style="font-size: 13px; color: var(--text-light); font-weight: 600; word-break: break-all;">{{ $aprendiz->correo }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-card" style="padding: 60px 40px; text-align: center;">
                <div style="width: 80px; height: 80px; background: rgba(59,130,246,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #3b82f6;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 8px;">Sin aprendices aprobados</h4>
                <p style="color: var(--text-light);">Aún no hay aprendices aprobados para este proyecto.</p>
            </div>
        @endif
    </div>
</div>
@endsection
