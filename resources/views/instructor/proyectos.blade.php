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
<div style="margin-bottom: 32px;" class="animate-fade-in">
    <h2 style="font-size:26px; font-weight:800; color:var(--text)">Mis Proyectos Asignados</h2>
    <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Gestiona y supervisa los proyectos activos bajo tu tutoría.</p>
</div>

<div class="instructor-project-catalog-grid animate-fade-in">
    @forelse($proyectos as $p)
    <div class="instructor-catalog-card glass-card">
        <div style="height: 180px; position: relative;">
            <img src="{{ $p->imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
            <div class="instructor-project-image-badge" style="background: var(--primary);">{{ $p->pro_estado }}</div>
        </div>
        
        <div style="flex: 1; display: flex; flex-direction: column; padding: 24px;">
            <h4 style="font-size:1.2rem; font-weight:700; margin-bottom:0.75rem; color: var(--text)">{{ $p->pro_titulo_proyecto }}</h4>
            
            <div style="margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--text-light);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <i class="fas fa-building" style="color:var(--primary); width: 16px;"></i>
                    <span style="font-weight: 600;">{{ $p->emp_nombre }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-tag" style="color:var(--primary); width: 16px;"></i>
                    <span style="font-weight: 600;">{{ $p->pro_categoria }}</span>
                </div>
            </div>

            <div style="margin-top: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; font-size: 0.8rem; color: var(--text-lighter);">
                    <span style="font-weight: 600;"><i class="fas fa-calendar-alt"></i> Publicado: {{ $p->pro_fecha_publi }}</span>
                    <span class="aprendiz-badge-portal" style="background: #eff6ff; border-color: #dbeafe; color: #3b82f6; font-size: 11px; font-weight: 700;">{{ $p->pro_num_postulantes ?? 0 }} Aprendices</span>
                </div>
                
                <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-premium" style="width: 100%; justify-content: center; padding: 12px;">
                    Abrir Gestión <i class="fas fa-chevron-right" style="margin-left: 8px; font-size: 10px;"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="instructor-empty-state">
        <i class="fas fa-project-diagram instructor-empty-icon"></i>
        <h4 style="color:var(--text); font-size: 1.5rem; margin-bottom:8px; font-weight: 800;">No hay proyectos asignados</h4>
        <p style="color:var(--text-light); font-weight: 500;">Actualmente no tienes proyectos bajo tu supervisión.</p>
    </div>
    @endforelse
</div>
@endsection
