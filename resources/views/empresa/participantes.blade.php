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
    @vite(['resources/css/empresa.css'])
    <style>
        .stat-item {
            background: #f8fafc;
            padding: 14px;
            border-radius: 14px;
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .stat-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('empresa.dashboard')], ['label' => 'Proyectos', 'url' => route('empresa.proyectos')], ['label' => 'Participantes']]; @endphp
@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-user-graduate"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.3s;">
                    <i class="fas fa-arrow-left"></i> Volver al Portafolio
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Participantes</span>
                <span style="background: rgba(59,130,246,0.1); color: #3b82f6; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ $aprendices->total() }} aprendices</span>
            </div>
            <h1 class="instructor-title">{{ $proyecto->titulo }}</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 15px; font-weight: 500;">Aprendices aprobados e instructor asignado a este proyecto.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 32px;">
        <div class="stat-item" style="border-left: 3px solid #3eb489;">
            <div class="stat-item-icon" style="background: rgba(62,180,137,0.1); color: #3eb489;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div style="font-size: 22px; font-weight: 800; line-height: 1.2;">{{ $proyecto->instructor ? 'Asignado' : 'Pendiente' }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.3px;">Instructor</div>
            </div>
        </div>
        <div class="stat-item" style="border-left: 3px solid #3b82f6;">
            <div class="stat-item-icon" style="background: rgba(59,130,246,0.1); color: #3b82f6;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div style="font-size: 22px; font-weight: 800; line-height: 1.2;">{{ $aprendices->total() }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.3px;">Aprendices</div>
            </div>
        </div>
        <div class="stat-item" style="border-left: 3px solid #8b5cf6;">
            <div class="stat-item-icon" style="background: rgba(139,92,246,0.1); color: #8b5cf6;">
                <i class="fas fa-chart-simple"></i>
            </div>
            <div>
                <div style="font-size: 22px; font-weight: 800; line-height: 1.2;">
                    <a href="{{ route('empresa.proyectos.reporte', $proyecto->id) }}" style="color: #8b5cf6; text-decoration: none;">Ver Etapas</a>
                </div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.3px;">Seguimiento</div>
            </div>
        </div>
    </div>

    <!-- Instructor Card -->
    <div style="margin-bottom: 40px;">
        <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-chalkboard-teacher" style="color: #3eb489;"></i> Instructor Asignado
        </h3>
        @if($proyecto->instructor)
            <div class="glass-card" style="padding: 28px; display: flex; align-items: center; gap: 24px; border-left: 4px solid #3eb489;">
                <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 800; flex-shrink: 0; box-shadow: 0 8px 20px rgba(62,180,137,0.3);">
                    {{ strtoupper(substr($proyecto->instructor->nombres ?? 'I', 0, 1)) }}
                </div>
                <div style="flex: 1;">
                    <h4 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 6px;">
                        {{ $proyecto->instructor->nombres ?? '' }} {{ $proyecto->instructor->apellidos ?? '' }}
                    </h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; font-size: 14px; color: var(--text-light);">
                        <span><i class="fas fa-envelope" style="margin-right: 6px; color: #3eb489;"></i> {{ optional($proyecto->instructor->usuario)->correo ?? '' }}</span>
                        @if($proyecto->instructor->especialidad)
                            <span><i class="fas fa-flask" style="margin-right: 6px; color: #3eb489;"></i> {{ $proyecto->instructor->especialidad }}</span>
                        @endif
                    </div>
                </div>
                <div style="background: rgba(62,180,137,0.1); padding: 12px 20px; border-radius: 12px; flex-shrink: 0;">
                    <span style="font-size: 12px; font-weight: 800; color: #3eb489; text-transform: uppercase;">Instructor SENA</span>
                </div>
            </div>
        @else
            <div class="glass-card" style="padding: 28px; text-align: center; border: 2px dashed rgba(62,180,137,0.2);">
                <div style="width: 60px; height: 60px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 24px; color: #3eb489;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <p style="font-size: 16px; color: var(--text-light); font-weight: 600;">Aún no se ha asignado un instructor a este proyecto.</p>
            </div>
        @endif
    </div>

    <!-- Aprendices -->
    <div>
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class="fas fa-user-graduate" style="color: #3b82f6;"></i> Aprendices Aprobados
            </h3>
            <span style="background: #eff6ff; color: #3b82f6; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 700;">{{ $aprendices->total() }}</span>
        </div>

        @if($aprendices->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;">
                @foreach($aprendices as $a)
                    <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 18px; border-left: 4px solid #3b82f6;">
                        <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; flex-shrink: 0; box-shadow: 0 6px 16px rgba(59,130,246,0.25);">
                            {{ strtoupper(substr($a->apr_nombre ?? 'A', 0, 1)) }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 4px;">
                                {{ $a->apr_nombre ?? '' }} {{ $a->apr_apellido ?? '' }}
                            </h4>
                            <div style="font-size: 13px; color: #3eb489; font-weight: 600; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                                <i class="fas fa-graduation-cap"></i> {{ $a->apr_programa ?? 'Programa SENA' }}
                            </div>
                            <div style="font-size: 12px; color: var(--text-lighter); font-weight: 600; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-envelope" style="color: #94a3b8;"></i> {{ $a->usr_correo ?? '' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($aprendices->hasPages())
                <div style="margin-top: 40px; display: flex; justify-content: center;">
                    {{ $aprendices->withQueryString()->links() }}
                </div>
            @endif
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