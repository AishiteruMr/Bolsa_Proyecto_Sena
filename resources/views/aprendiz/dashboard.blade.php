@extends('layouts.dashboard')

@section('title', 'Dashboard Aprendiz')
@section('page-title', 'Mi Dashboard')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">
@endsection

@section('content')
    <!-- BIENVENIDA PREMIUM -->
    <div class="aprendiz-welcome">
        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
            <span class="aprendiz-badge-portal">Portal del Talento</span>
            <span style="color: var(--text-lighter); font-size: 13px; font-weight: 500;"><i class="far fa-calendar-alt" style="margin-right: 6px;"></i>{{ now()->translatedFormat('l, d F') }}</span>
        </div>
        <h2 class="aprendiz-hero-title">¡Hola de nuevo, <span style="color: var(--primary);">{{ session('nombre') }}</span>! 👋</h2>
        <p style="color: var(--text-light); font-size: 17px; max-width: 600px; line-height: 1.6;">Impulsa tu carrera colaborando en desafíos reales de la industria y construye un portafolio de impacto.</p>
    </div>

    <!-- BENTO DASHBOARD -->
    <div class="aprendiz-dashboard-grid">
        <!-- Status Card -->
        <div class="glass-card aprendiz-status-card">
            <div class="aprendiz-status-icon">
                <i class="fas fa-rocket"></i>
            </div>
            <div>
                <h3 style="font-size: 28px; font-weight: 800;">{{ $postulacionesAprobadas }} Proyectos</h3>
                <p style="font-size: 14px; color: rgba(255,255,255,0.6); font-weight: 500;">En los que estás transformando el futuro.</p>
            </div>
        </div>

        <!-- Info Card 1 -->
        <div class="glass-card aprendiz-info-card">
            <div>
                <p class="aprendiz-card-label">Próximo Cierre</p>
                @if($proximoCierre)
                    <h4 style="font-size: 20px; font-weight: 800; color: #ef4444; letter-spacing: -0.5px;">{{ \Carbon\Carbon::parse($proximoCierre->pro_fecha_finalizacion)->diffForHumans() }}</h4>
                    <p style="font-size: 12px; color: var(--text-light); margin-top: 6px; font-weight: 500;">{{ Str::limit($proximoCierre->pro_titulo_proyecto, 25) }}</p>
                @else
                    <h4 style="font-size: 20px; font-weight: 800; color: var(--text-lighter);">Sin cierres</h4>
                    <p style="font-size: 12px; color: var(--text-lighter); margin-top: 6px;">Todo bajo control.</p>
                @endif
            </div>
            <div class="aprendiz-progress-bar">
                <div style="width: 100%; height: 100%; background: #ef4444; opacity: 0.3;"></div>
            </div>
        </div>

        <!-- Info Card 2 -->
        <div class="glass-card aprendiz-info-card">
            <div>
                <p class="aprendiz-card-label">Actividad</p>
                <h4 class="aprendiz-card-value">{{ $totalPostulaciones }}</h4>
                <p style="font-size: 12px; color: var(--text-light); margin-top: 4px; font-weight: 500;">Postulaciones enviadas</p>
            </div>
            <div class="aprendiz-progress-bar">
                <div class="aprendiz-progress-fill" style="width: 65%;"></div>
            </div>
        </div>
    </div>

    <!-- FEED SECTION -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
        <h3 style="font-size: 24px; font-weight: 800; color: var(--text); letter-spacing: -0.5px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-fire" style="color: #f97316;"></i> Oportunidades para ti
        </h3>
        <a href="{{ route('aprendiz.proyectos') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: gap 0.3s;" onmouseover="this.style.gap='12px'" onmouseout="this.style.gap='8px'">
            Explorar todas <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
        </a>
    </div>

    <div class="admin-project-grid animate-fade-in" style="animation-delay: 0.2s;">
        @forelse($proyectosRecientes as $p)
            <div class="glass-card aprendiz-project-card">
                <div class="aprendiz-project-image-wrapper">
                    <img src="{{ $p->imagen_url }}" alt="">
                    <div class="aprendiz-project-category">
                        {{ $p->pro_categoria }}
                    </div>
                </div>
                <div class="aprendiz-project-body">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <span style="width: 24px; height: 3px; background: var(--primary); border-radius: 4px;"></span>
                        <span style="font-size: 14px; font-weight: 700; color: var(--text-light);">{{ $p->emp_nombre }}</span>
                    </div>
                    <h4 style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 20px; line-height: 1.3; height: 58px; overflow: hidden;">{{ $p->pro_titulo_proyecto }}</h4>
                    
                    <div class="aprendiz-project-footer">
                        <span style="font-size: 13px; color: var(--text-light); font-weight: 600;"><i class="fas fa-bolt" style="margin-right: 8px; color: #f59e0b;"></i> Reto {{ $p->pro_duracion ?? '8 semanas' }}</span>
                        @if(in_array($p->pro_id, $proyectosAprobados))
                            <a href="{{ route('aprendiz.proyecto.detalle', $p->pro_id) }}" class="btn-premium" style="padding: 12px 24px; font-size: 13px;">Gestionar</a>
                        @else
                            <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="padding: 12px 24px; font-size: 13px; background: #f1f5f9; color: var(--text-light); box-shadow: none;">Detalles</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card aprendiz-empty-state">
                <div style="width: 100px; height: 100px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
                    <i class="fas fa-search" style="font-size: 40px; color: var(--text-lighter);"></i>
                </div>
                <h4 style="color: var(--text); font-weight: 800; font-size: 24px; margin-bottom: 12px;">Busca tu próxima oportunidad</h4>
                <p style="color: var(--text-light); max-width: 450px; margin: 0 auto;">No hay proyectos disponibles en este momento que se ajusten a tu perfil. Sigue explorando nuestro catálogo.</p>
                <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="margin-top: 40px; background: #0f172a;">Explorar Banco de Proyectos</a>
            </div>
        @endforelse
    </div>

@endsection
