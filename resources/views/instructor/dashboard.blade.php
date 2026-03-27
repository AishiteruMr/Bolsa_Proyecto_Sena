@extends('layouts.dashboard')

@section('title', 'Panel de Control - Inspírate SENA')
@section('page-title', 'Centro de Mando del Instructor')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
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

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/instructor.css') }}">
@endsection

@section('content')
<div class="animate-fade-in dashboard-wrapper">
    
    <!-- HEADER PREMIUM -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <span class="instructor-tag">SENA INNOVACIÓN</span>
                <span id="current-time" style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 600;"></span>
            </div>
            <h1 class="instructor-title">¡Bienvenido, <span style="color: var(--primary);">{{ session('nombre') }}</span>! 👋</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 600px; line-height: 1.6; font-weight: 400;">Tu centro de mando para la excelencia académica y la gestión de proyectos de impacto.</p>
        </div>
    </div>

    <!-- BENTO STATS GRID -->
    <div class="instructor-stat-grid">
        
        <!-- Large Stat Card -->
        <div class="instructor-stat-card-lg glass-card">
            <div class="instructor-stat-icon-main">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div>
                <div style="font-size: 44px; font-weight: 800; color: var(--text); line-height: 1;">{{ $proyectosAsignados }}</div>
                <div style="font-size: 14px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Proyectos Bajo tu Guía</div>
            </div>
        </div>

        <!-- Warning Stat Card -->
        <div class="instructor-warning-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-clock"></i>
                </div>
                <span style="font-size: 10px; font-weight: 800; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px;">ACCIÓN REQUERIDA</span>
            </div>
            <div style="margin-top: 24px;">
                <div style="font-size: 36px; font-weight: 800;">{{ $evidenciasPendientes }}</div>
                <div style="font-size: 13px; font-weight: 600; opacity: 0.9;">Evidencias sin calificar</div>
            </div>
        </div>

        <!-- Success Stat Card -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--radius); padding: 24px;">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div style="margin-top: 24px;">
                <div style="font-size: 36px; font-weight: 800; color: var(--text);">{{ $totalAprendices }}</div>
                <div style="font-size: 13px; font-weight: 600; color: var(--text-light);">Aprendices Aprobados</div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID: PROJECTS + QUICK ACTIONS -->
    <div class="instructor-main-grid">
        
        <!-- Left: Active Projects -->
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <span style="width: 8px; height: 24px; background: var(--primary); border-radius: 4px;"></span>
                    Proyectos en Ejecución
                </h3>
                <a href="{{ route('instructor.proyectos') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 14px; transition: gap 0.3s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                    Ver catálogo <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                </a>
            </div>

            <div class="instructor-project-grid">
                @forelse($proyectos as $p)
                    <div class="glass-card instructor-project-card">
                        <div style="height: 160px; position: relative;">
                            <img src="{{ $p->imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="instructor-project-image-badge">
                                {{ $p->pro_categoria }}
                            </div>
                        </div>
                        <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                            <h4 style="font-size: 17px; font-weight: 800; color: var(--text); line-height: 1.4; margin-bottom: 16px; height: 48px; overflow: hidden;">{{ $p->pro_titulo_proyecto }}</h4>
                            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                                <div style="flex: 1; background: #f8fafc; padding: 10px; border-radius: 12px; text-align: center; border: 1px solid #f1f5f9;">
                                    <span style="display: block; font-size: 16px; font-weight: 800;">{{ $p->postulaciones->where('pos_estado', 'Aprobada')->count() }}</span>
                                    <span style="font-size: 10px; color: var(--text-lighter); font-weight: 700; text-transform: uppercase;">Activos</span>
                                </div>
                                <div style="flex: 1; background: #f8fafc; padding: 10px; border-radius: 12px; text-align: center; border: 1px solid #f1f5f9;">
                                    <span style="display: block; font-size: 16px; font-weight: 800;">{{ $p->postulaciones->where('pos_estado', 'Pendiente')->count() }}</span>
                                    <span style="font-size: 10px; color: var(--text-lighter); font-weight: 700; text-transform: uppercase;">Nuevos</span>
                                </div>
                            </div>
                            <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-premium" style="width: 100%; justify-content: center; font-size: 13px; padding: 10px;">
                                Gestionar <i class="fas fa-play" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="glass-card aprendiz-empty-state" style="grid-column: span 2; padding: 48px; text-align: center;">
                        <i class="fas fa-folder-open" style="font-size: 40px; color: var(--text-lighter); margin-bottom: 16px;"></i>
                        <p style="color: var(--text-light); font-weight: 600;">No tienes proyectos asignados actualmente.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Activity & Quick Actions -->
        <div>
            <h3 style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 24px;">Notificaciones</h3>
            
            <div class="instructor-notification-card">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600;">Postulaciones (48h)</div>
                            <div style="font-size: 16px; font-weight: 800; color: var(--text);">{{ $nuevasPostulaciones }} Recientes</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff1f2; color: #e11d48; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600;">Próximo Hito</div>
                            <div style="font-size: 16px; font-weight: 800; color: var(--text);">
                                {{ $proximoCierre ? $proximoCierre->pro_fecha_finalizacion->diffForHumans() : 'Sin eventos' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="instructor-quick-actions">
                <h4 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; letter-spacing: -0.5px;">Acceso Rápido</h4>
                <div style="display: grid; gap: 12px;">
                    <a href="{{ route('instructor.aprendices') }}" class="instructor-action-link">
                        <i class="fas fa-users" style="color: var(--primary);"></i>
                        <span style="font-size: 14px; font-weight: 600;">Base de Aprendices</span>
                    </a>
                    <a href="{{ route('instructor.perfil') }}" class="instructor-action-link">
                        <i class="fas fa-cog" style="color: var(--primary);"></i>
                        <span style="font-size: 14px; font-weight: 600;">Ajustes de Perfil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
