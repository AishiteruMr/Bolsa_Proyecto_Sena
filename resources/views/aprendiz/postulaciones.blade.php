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

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 32px;">
        <h2 style="font-size:26px; font-weight:800; color:var(--text); letter-spacing:-0.5px;">Mis <span style="color:var(--primary);">Postulaciones</span></h2>
        <p style="color:var(--text-light); font-size:15px; margin-top:4px; font-weight: 500;">Sigue el estado de tus aplicaciones a los diferentes proyectos de la plataforma.</p>
    </div>

<div style="display: grid; gap: 20px;">
    @forelse($postulaciones as $post)
        <div class="glass-card aprendiz-postulation-card">
            <div style="display: flex; align-items: center; gap: 1.5rem; flex: 1;">
                <div class="aprendiz-postulation-img">
                    @if($post->pro_imagen_url)
                        <img src="{{ $post->pro_imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: var(--primary-soft); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem;">
                            <i class="fas fa-rocket"></i>
                        </div>
                    @endif
                </div>

                <div class="aprendiz-postulation-info">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">{{ $post->pro_titulo_proyecto }}</h4>
                        <span class="aprendiz-badge-portal" style="font-size: 9px; padding: 2px 8px;">{{ $post->pro_categoria }}</span>
                    </div>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; font-size: 0.85rem; color: var(--text-light);">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-building" style="color: var(--primary);"></i>
                            <span style="font-weight: 700; color: var(--text);">{{ $post->emp_nombre }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px; font-weight: 500;">
                            <i class="far fa-calendar-check"></i>
                            <span>Postulado: {{ \Carbon\Carbon::parse($post->pos_fecha)->format('d M, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="text-align: right;">
                    <p style="font-size: 10px; color: var(--text-light); margin-bottom: 6px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">Estado</p>
                    @switch($post->pos_estado)
                        @case('Pendiente')
                            <span class="aprendiz-status-badge aprendiz-status-pending">
                                <i class="fas fa-hourglass-half"></i> Pendiente
                            </span>
                            @break
                        @case('Aprobada')
                            <span class="aprendiz-status-badge aprendiz-status-approved">
                                <i class="fas fa-check-circle"></i> Aprobada
                            </span>
                            @break
                        @case('Rechazada')
                            <span class="aprendiz-status-badge aprendiz-status-rejected">
                                <i class="fas fa-times-circle"></i> Rechazada
                            </span>
                            @break
                    @endswitch
                </div>

                @if($post->pos_estado === 'Aprobada')
                    <a href="{{ route('aprendiz.proyecto.detalle', $post->pro_id) }}" class="btn-premium aprendiz-manage-btn">
                        Gestionar <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="glass-card aprendiz-empty-state">
            <i class="fas fa-paper-plane" style="font-size: 4rem; color: var(--primary-soft); margin-bottom: 1.5rem;"></i>
            <h4 style="color: var(--text); font-size: 1.5rem; font-weight: 800; margin-bottom: 8px;">No tienes postulaciones</h4>
            <p style="color: var(--text-light); margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto; font-weight: 500;">Aún no te has postulado a ningún proyecto. ¡Explora el banco de proyectos y comienza tu viaje!</p>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="display: inline-flex; align-items: center; gap: 10px; padding: 18px 40px; border-radius: 30px; background: var(--secondary);">
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
