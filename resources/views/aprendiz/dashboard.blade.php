@extends('layouts.dashboard')

@section('title', 'Dashboard Aprendiz')
@section('page-title', 'Mi Dashboard')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> <span>Principal</span>
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> <span>Explorar Proyectos</span>
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> <span>Mis Postulaciones</span>
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> <span>Historial</span>
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> <span>Mis Entregas</span>
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> <span>Mi Perfil</span>
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">
@endsection

@section('content')
    <!-- BIENVENIDA PREMIUM -->
    <div class="instructor-hero" style="padding: 40px 48px; margin-bottom: 32px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-rocket"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
                <span class="instructor-tag">Portal del Talento</span>
                <span style="color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 500;"><i class="far fa-calendar-alt" style="margin-right: 6px;"></i>{{ now()->translatedFormat('l, d F') }}</span>
            </div>
            <h1 style="font-size: 36px; font-weight: 800; color: white; margin-bottom: 8px;">¡Hola de nuevo, <span style="color: #3eb489;">{{ session('nombre') }}</span>!</h1>
            <p style="color: rgba(255,255,255,0.7); font-size: 15px;">Impulsa tu carrera colaborando en desafíos reales de la industria y construye un portafolio de impacto.</p>
        </div>
    </div>

    <!-- BENTO DASHBOARD -->
    <div class="instructor-stat-grid">
        <!-- Status Card Principal -->
        <div class="glass-card" style="grid-column: span 2; display: flex; align-items: center; gap: 32px; padding: 40px; border: 1px solid rgba(62,180,137,0.1);">
            <div style="width: 80px; height: 80px; border-radius: 24px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 32px; box-shadow: 0 15px 30px rgba(62,180,137,0.3);">
                <i class="fas fa-rocket"></i>
            </div>
            <div>
                <h3 style="font-size: 36px; font-weight: 800; color: var(--text); margin: 0;">{{ $postulacionesAprobadas }} Proyectos</h3>
                <p style="font-size: 14px; color: var(--text-light); font-weight: 500; margin: 4px 0 0 0;">En los que estás transformando el futuro.</p>
            </div>
        </div>

        <!-- Info Card - Próximo Cierre -->
        <div class="glass-card" style="border: 1px solid rgba(62,180,137,0.1);">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(239, 68, 68, 0.1); color: #ef4444; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span style="font-size: 12px; color: var(--text-light); font-weight: 700; text-transform: uppercase;">Próximo Cierre</span>
                </div>
                @if($proximoCierre && $proximoCierre->fecha_finalizacion)
                    <h4 style="font-size: 20px; font-weight: 800; color: #ef4444; margin: 0;">{{ \Carbon\Carbon::parse($proximoCierre->fecha_finalizacion)->diffForHumans() }}</h4>
                    <p style="font-size: 12px; color: var(--text-light); margin: 0; font-weight: 500;">{{ Str::limit($proximoCierre->titulo, 30) }}</p>
                @else
                    <h4 style="font-size: 20px; font-weight: 800; color: var(--text-lighter); margin: 0;">Sin cierres</h4>
                    <p style="font-size: 12px; color: var(--text-lighter); margin: 0;">Todo bajo control.</p>
                @endif
            </div>
        </div>

        <!-- Info Card - Actividad -->
        <div class="glass-card" style="border: 1px solid rgba(62,180,137,0.1);">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <span style="font-size: 12px; color: var(--text-light); font-weight: 700; text-transform: uppercase;">Actividad</span>
                </div>
                <h4 style="font-size: 28px; font-weight: 800; color: var(--text); margin: 0;">{{ $totalPostulaciones }}</h4>
                <p style="font-size: 12px; color: var(--text-light); margin: 0; font-weight: 500;">Postulaciones enviadas</p>
            </div>
        </div>
    </div>

    <!-- FEED SECTION -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin: 40px 0 28px;">
        <h3 style="font-size: 24px; font-weight: 800; color: var(--text); letter-spacing: -0.5px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-fire" style="color: #f97316;"></i> Oportunidades para ti
        </h3>
        <a href="{{ route('aprendiz.proyectos') }}" style="color: #3eb489; font-weight: 700; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            Explorar todas <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
        @forelse($proyectosRecientes as $p)
            <div style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid rgba(62,180,137,0.1); transition: all 0.3s;">
                <div style="height: 180px; position: relative;">
                    <img src="{{ $p->imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                    <div style="position: absolute; top: 16px; left: 16px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; padding: 5px 14px; border-radius: 20px; font-size: 10px; font-weight: 700;">
                        {{ $p->categoria }}
                    </div>
                </div>
                <div style="padding: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <span style="width: 4px; height: 20px; background: linear-gradient(135deg, #3eb489, #2d9d74); border-radius: 4px;"></span>
                        <span style="font-size: 14px; font-weight: 700; color: var(--text-light);">{{ $p->nombre }}</span>
                    </div>
                    <h4 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 16px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $p->titulo }}</h4>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; color: var(--text-light); font-weight: 600;"><i class="fas fa-bolt" style="margin-right: 6px; color: #f59e0b;"></i>{{ $p->pro_duracion ?? '8 semanas' }}</span>
                        @if(in_array($p->id, $proyectosAprobados))
                            <a href="{{ route('aprendiz.proyecto.detalle', $p->id) }}" class="btn-premium" style="padding: 10px 20px; font-size: 13px;">Gestionar</a>
                        @else
                            <a href="{{ route('aprendiz.proyectos') }}" style="padding: 10px 20px; font-size: 13px; background: rgba(62,180,137,0.1); color: #3eb489; border-radius: 10px; font-weight: 700; text-decoration: none;">Detalles</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; padding: 5rem 2rem; text-align: center; background: white; border-radius: 20px; border: 1px dashed rgba(62,180,137,0.2);">
                <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px;">
                    <i class="fas fa-search" style="font-size: 40px; color: #3eb489;"></i>
                </div>
                <h4 style="color: var(--text); font-weight: 800; font-size: 24px; margin-bottom: 12px;">Busca tu próxima oportunidad</h4>
                <p style="color: var(--text-light); max-width: 450px; margin: 0 auto;">No hay proyectos disponibles en este momento que se ajusten a tu perfil. Sigue explorando nuestro catálogo.</p>
                <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="margin-top: 32px; display: inline-flex;">Explorar Banco de Proyectos</a>
            </div>
        @endforelse
    </div>

@endsection
