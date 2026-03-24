@extends('layouts.dashboard')

@section('title', 'Mis Postulaciones')
@section('page-title', 'Mis Postulaciones')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('content')
<div style="margin-bottom: 32px;">
    <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">Mis Postulaciones</h2>
    <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Sigue el estado de tus aplicaciones a los diferentes proyectos de la plataforma.</p>
</div>

<div style="display: grid; gap: 1.5rem;">
    @forelse($postulaciones as $post)
        <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem; transition: transform 0.2s ease;">
            <div style="display: flex; align-items: center; gap: 1.5rem; flex: 1; min-width: 300px;">
                <div style="width: 70px; height: 70px; border-radius: 12px; overflow: hidden; position: relative;">
                    @if($post->pro_imagen_url)
                        <img src="{{ $post->pro_imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-rocket"></i>
                        </div>
                    @endif
                </div>

                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main);">{{ $post->pro_titulo_proyecto }}</h4>
                        <span class="badge badge-info" style="font-size: 9px; padding: 2px 10px; border-radius: 4px;">{{ $post->pro_categoria }}</span>
                    </div>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; font-size: 0.85rem; color: var(--text-muted);">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-building" style="color: var(--primary);"></i>
                            <span style="font-weight: 500; color: var(--text-main);">{{ $post->emp_nombre }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-calendar-day"></i>
                            <span>Postulado: {{ \Carbon\Carbon::parse($post->pos_fecha)->format('d M, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="text-align: right;">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Estado</p>
                    @switch($post->pos_estado)
                        @case('Pendiente')
                            <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); font-size: 11px; padding: 4px 12px;">
                                <i class="fas fa-hourglass-half" style="margin-right: 6px;"></i> Pendiente
                            </span>
                            @break
                        @case('Aprobada')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); font-size: 11px; padding: 4px 12px;">
                                <i class="fas fa-check-circle" style="margin-right: 6px;"></i> Aprobada
                            </span>
                            @break
                        @case('Rechazada')
                            <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); font-size: 11px; padding: 4px 12px;">
                                <i class="fas fa-times-circle" style="margin-right: 6px;"></i> Rechazada
                            </span>
                            @break
                    @endswitch
                </div>

                @if($post->pos_estado === 'Aprobada')
                    <a href="{{ route('aprendiz.proyecto.detalle', $post->pro_id) }}" class="btn-ver" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; border-radius: 8px;">
                        Gestionar <i class="fas fa-chevron-right" style="margin-left:8px; font-size:11px;"></i>
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="glass-card" style="text-align:center; padding: 5rem 2rem;">
            <i class="fas fa-paper-plane" style="font-size: 4rem; color: var(--border); margin-bottom: 1.5rem;"></i>
            <h4 style="color: var(--text-main); font-size: 1.5rem; margin-bottom: 8px;">No tienes postulaciones</h4>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Aún no te has postulado a ningún proyecto. ¡Explora el banco de proyectos y comienza tu viaje!</p>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn-ver" style="display: inline-flex; align-items: center; gap: 8px; padding: 0.8rem 2rem; border-radius: 30px;">
                <i class="fas fa-search"></i> Explorar Proyectos Disponibles
            </a>
        </div>
    @endforelse
</div>

@if($postulaciones->hasPages())
    <div style="margin-top: 40px; display:flex; justify-content:center;">
        {{ $postulaciones->links() }}
    </div>
@endif
@endsection
