@extends('layouts.dashboard')

@section('title', 'Panel de Control - Inspírate SENA')
@section('page-title', 'Centro de Mando del Instructor')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
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
    
    <!-- HEADER INSTRUCTOR (reutiliza estilos de instructor.css) -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
                <span class="instructor-tag">Instructor Hub</span>
                <span id="current-time" style="color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 600;"></span>
            </div>
            <h1 class="instructor-title">Centro de Mando del <span style="color: var(--primary);">Instructor</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; max-width: 720px; line-height: 1.6; font-weight: 500;">Tu centro de mando para la excelencia académica y la gestión de proyectos de impacto.</p>
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
            <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
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
                    <div class="instructor-project-card">
                        <div style="height: 160px; position: relative;">
                            <img src="{{ $p->imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="instructor-project-image-badge">
                                {{ $p->categoria }}
                            </div>
                        </div>
                        <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                            <h4 class="instructor-project-title" style="font-size: 17px; margin-bottom:16px;">{{ $p->titulo }}</h4>
                            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                                <div class="instructor-small-stat">
                                    <span class="count">{{ $p->postulaciones->where('estado', 'aceptada')->count() }}</span>
                                    <span class="label">Activos</span>
                                </div>
                                <div class="instructor-small-stat">
                                    <span class="count">{{ $p->postulaciones->where('estado', 'pendiente')->count() }}</span>
                                    <span class="label">Nuevos</span>
                                </div>
                            </div>
                            <a href="{{ route('instructor.proyecto.detalle', $p->id) }}" class="btn-premium" style="width: 100%; justify-content: center; font-size: 13px; padding: 10px;">
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
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(62,180,137,0.1); color: var(--primary); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600;">Postulaciones (48h)</div>
                            <div style="font-size: 16px; font-weight: 800; color: var(--text);">{{ $nuevasPostulaciones }} Recientes</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff3e0; color: #f59e0b; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600;">Próximo Hito</div>
                            <div style="font-size: 16px; font-weight: 800; color: var(--text);">
                                {{ ($proximoCierre && $proximoCierre->fecha_publicacion) ? \Carbon\Carbon::parse($proximoCierre->fecha_publicacion)->addDays($proximoCierre->duracion_estimada_dias ?? 0)->diffForHumans() : 'Sin eventos' }}
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
