@extends('layouts.dashboard')

@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')

@section('sidebar-nav')
<span class="nav-label">Principal</span>
<a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
    <i class="fas fa-home"></i> Dashboard
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

@section('content')
<div style="margin-bottom: 32px;">
    <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">Mis Proyectos Asignados</h2>
    <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Gestiona y supervisa los proyectos activos bajo tu tutoría.</p>
</div>

<div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
    @forelse($proyectos as $p)
    <div class="project-card glass-card" style="display: flex; flex-direction: column; height: 100%;">
        <div class="project-image" style="height: 180px;">
            <img src="{{ $p->pro_imagen_url ?? asset('assets/default-project.jpg') }}" alt="" style="width:100%; height:100%; object-fit:cover;">
            <div class="status-badge" style="background: var(--primary); font-size: 10px;">{{ $p->pro_estado }}</div>
        </div>
        
        <div class="project-info" style="flex: 1; display: flex; flex-direction: column; padding: 1.5rem;">
            <h4 style="font-size:1.2rem; font-weight:600; margin-bottom:0.75rem; color: var(--text-main)">{{ $p->pro_titulo_proyecto }}</h4>
            
            <div style="margin-bottom: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <i class="fas fa-building" style="color:var(--primary); width: 16px;"></i>
                    <span>{{ $p->emp_nombre }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-tag" style="color:var(--primary); width: 16px;"></i>
                    <span>{{ $p->pro_categoria }}</span>
                </div>
            </div>

            <div style="margin-top: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; font-size: 0.8rem; color: var(--text-muted);">
                    <span><i class="fas fa-calendar-alt"></i> Publicado: {{ $p->pro_fecha_publi }}</span>
                    <span class="badge badge-info" style="font-size: 11px; padding: 4px 10px;">{{ $p->pro_num_postulantes ?? 0 }} Aprendices</span>
                </div>
                
                <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-ver" style="padding: 0.8rem;">
                    Abrir Gestión <i class="fas fa-chevron-right" style="margin-left: 8px; font-size: 12px;"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="glass-card" style="text-align:center; padding:5rem 2rem; grid-column: 1 / -1;">
        <i class="fas fa-project-diagram" style="font-size:4rem; color:var(--border); margin-bottom:1.5rem;"></i>
        <h4 style="color:var(--text-main); font-size: 1.5rem; margin-bottom:8px;">No hay proyectos asignados</h4>
        <p style="color:var(--text-muted);">Actualmente no tienes proyectos bajo tu supervisión.</p>
    </div>
    @endforelse
</div>
@endsection