@extends('layouts.dashboard')

@section('title', 'Mis Postulaciones')
@section('page-title', 'Mis Postulaciones')

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
<div class="animate-fade-in" style="padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-paper-plane"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span class="instructor-tag">Postulaciones</span>
            </div>
            <h1 class="instructor-title">Mis <span style="color: var(--primary);">Postulaciones</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; font-weight: 500;">Sigue el estado de tus aplicaciones a los diferentes proyectos.</p>
        </div>
    </div>

    @if($postulaciones->count() > 0)
        <div class="instructor-stat-grid" style="margin-bottom: 32px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-inbox"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: var(--text); line-height: 1;">{{ $postulaciones->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Total</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fde68a;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #d97706; line-height: 1;">{{ $postulaciones->where('pos_estado', 'Pendiente')->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Pendientes</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #bbf7d0;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #16a34a; line-height: 1;">{{ $postulaciones->where('pos_estado', 'Aprobada')->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Aprobadas</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fecaca;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #ef4444; line-height: 1;">{{ $postulaciones->where('pos_estado', 'Rechazada')->count() }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Rechazadas</div>
                </div>
            </div>
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 20px;">
        @forelse($postulaciones as $post)
            @php
                $estadoColor = match($post->pos_estado) {
                    'Aprobada'  => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a', 'icon' => 'fa-check-circle'],
                    'Rechazada' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#ef4444', 'icon' => 'fa-times-circle'],
                    default     => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-hourglass-half'],
                };
            @endphp
            <div class="glass-card" style="padding: 0; overflow: hidden; display: flex; align-items: center; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 32px rgba(62,180,137,0.12)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(62,180,137,0.06)'">
                <div style="width: 140px; height: 120px; flex-shrink: 0;">
                    @if($post->pro_imagen_url)
                        <img src="{{ $post->pro_imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, rgba(62,180,137,0.1), rgba(62,180,137,0.05)); display: flex; align-items: center; justify-content: center; color: #3eb489; font-size: 2.5rem;">
                            <i class="fas fa-rocket"></i>
                        </div>
                    @endif
                </div>

                <div style="flex: 1; padding: 24px; min-width: 0;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;">
                        <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin: 0;">{{ $post->pro_titulo_proyecto }}</h4>
                        <span style="background: rgba(62,180,137,0.1); color: #3eb489; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ $post->pro_categoria }}</span>
                    </div>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; font-size: 13px; color: var(--text-light);">
                        <div style="display: flex; align-items: center; gap: 8px; font-weight: 600;">
                            <i class="fas fa-building" style="color: #3eb489; width: 16px;"></i>
                            {{ $post->emp_nombre }}
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; font-weight: 600;">
                            <i class="far fa-calendar-check" style="width: 16px;"></i>
                            Postulado: {{ \Carbon\Carbon::parse($post->pos_fecha)->format('d M, Y') }}
                        </div>
                    </div>
                </div>

                <div style="padding: 24px; display: flex; align-items: center; gap: 20px; flex-shrink: 0;">
                    <div style="text-align: right;">
                        <p style="font-size: 10px; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Estado</p>
                        <span style="background: {{ $estadoColor['bg'] }}; border: 1.5px solid {{ $estadoColor['border'] }}; color: {{ $estadoColor['text'] }}; padding: 10px 18px; border-radius: 20px; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px; white-space: nowrap;">
                            <i class="fas {{ $estadoColor['icon'] }}"></i> {{ $post->pos_estado }}
                        </span>
                    </div>

                    @if($post->pos_estado === 'Aprobada')
                        <a href="{{ route('aprendiz.proyecto.detalle', $post->pro_id) }}" class="btn-premium" style="padding: 12px 20px;">
                            Gestionar <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="glass-card" style="padding: 80px 40px; text-align: center;">
                <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px; color: #3eb489;">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h4 style="color: var(--text); font-size: 22px; font-weight: 800; margin-bottom: 8px;">No tienes postulaciones</h4>
                <p style="color: var(--text-light); margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto;">Aún no te has postulado a ningún proyecto. ¡Explora el banco de proyectos!</p>
                <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="display: inline-flex;">
                    <i class="fas fa-search"></i> Explorar Proyectos
                </a>
            </div>
        @endforelse
    </div>

    @if($postulaciones->hasPages())
        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $postulaciones->links() }}
        </div>
    @endif
</div>
@endsection
