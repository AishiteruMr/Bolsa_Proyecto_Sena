@extends('layouts.dashboard')

@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')

@section('sidebar-nav')
<span class="nav-label">Principal</span>
<a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
    <i class="fas fa-home"></i> Principal
</a>
<a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos', 'instructor.proyecto.detalle') ? 'active' : '' }}">
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
<div class="instructor-hero" style="padding: 40px 48px; margin-bottom: 32px;">
    <div class="instructor-hero-bg-icon"><i class="fas fa-project-diagram"></i></div>
    <div style="position: relative; z-index: 1;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
            <span class="instructor-tag">Proyectos</span>
        </div>
        <h1 style="font-size: 36px; font-weight: 800; color: white; margin-bottom: 8px;">Mis Proyectos Asignados</h1>
        <p style="color: rgba(255,255,255,0.7); font-size: 15px;">Gestiona y supervisa los proyectos activos bajo tu tutoría.</p>
    </div>
</div>

<div class="instructor-project-catalog-grid animate-fade-in">
    @forelse($proyectos as $p)
    <div class="instructor-catalog-card" style="background: rgba(255,255,255,0.9); border-radius: 20px; overflow: hidden; border: 1px solid rgba(62,180,137,0.1); transition: all 0.3s;">
        <div style="height: 180px; position: relative;">
            <img src="{{ $p->imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
            <div class="instructor-project-image-badge" style="background: linear-gradient(135deg, #3eb489, #2d9d74);">{{ $p->estado }}</div>
        </div>
        
        <div style="flex: 1; display: flex; flex-direction: column; padding: 24px;">
            <h4 style="font-size:1.15rem; font-weight:700; margin-bottom:0.75rem; color: var(--text); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $p->titulo }}</h4>
            
            <div style="margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--text-light);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <i class="fas fa-building" style="color:#3eb489; width: 16px;"></i>
                    <span style="font-weight: 600;">{{ $p->nombre }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-tag" style="color:#3eb489; width: 16px;"></i>
                    <span style="font-weight: 600;">{{ $p->categoria }}</span>
                </div>
            </div>

            <div style="margin-top: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; font-size: 0.8rem; color: var(--text-lighter);">
                    <span style="font-weight: 600;"><i class="fas fa-calendar-alt"></i> {{ $p->fecha_publicacion }}</span>
                    <span style="background: rgba(62,180,137,0.1); border: 1px solid rgba(62,180,137,0.2); color: #3eb489; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ $p->pro_num_postulantes ?? 0 }} Aprendices</span>
                </div>
                
                <a href="{{ route('instructor.proyecto.detalle', $p->id) }}" class="btn-premium" style="width: 100%; justify-content: center; padding: 12px;">
                    Abrir Gestión <i class="fas fa-chevron-right" style="margin-left: 8px; font-size: 10px;"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 20px; border: 1px dashed rgba(62,180,137,0.2);">
        <i class="fas fa-project-diagram" style="font-size: 48px; color: #3eb489; margin-bottom: 16px; opacity: 0.5;"></i>
        <h4 style="color:var(--text); font-size: 1.5rem; margin-bottom:8px; font-weight: 800;">No hay proyectos asignados</h4>
        <p style="color:var(--text-light); font-weight: 500;">Actualmente no tienes proyectos bajo tu supervisión.</p>
    </div>
    @endforelse
</div>
@endsection
