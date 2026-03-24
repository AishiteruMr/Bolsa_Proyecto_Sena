@extends('layouts.dashboard')

@section('title', 'Aprendices')
@section('page-title', 'Mis Aprendices')

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

@section('content')
    <div style="margin-bottom: 32px;">
        <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">Comunidad de Aprendices</h2>
        <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Supervisa el desempeño y progreso de los aprendices en tus proyectos.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($aprendices as $a)
            <div class="glass-card" style="padding: 1.5rem; display: flex; flex-direction: column; align-items: center; text-align: center; transition: transform .3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="width:80px; height:80px; border-radius:50%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); display:flex; align-items:center; justify-content:center; margin-bottom: 1.25rem; box-shadow: 0 8px 16px rgba(41, 133, 100, 0.2);">
                    <span style="color:#fff; font-size:28px; font-weight:700;">{{ strtoupper(substr($a->apr_nombre ?? 'A', 0, 1)) }}</span>
                </div>
                
                <h4 style="font-size:1.1rem; font-weight:600; margin-bottom:0.5rem; color: var(--text-main)">{{ $a->apr_nombre ?? '' }} {{ $a->apr_apellido ?? '' }}</h4>
                
                <div style="font-size:0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                    <div style="margin-bottom: 4px;"><i class="fas fa-graduation-cap" style="color:var(--primary); margin-right:6px;"></i>{{ $a->apr_programa ?? 'Sin programa' }}</div>
                    <div><i class="fas fa-envelope" style="margin-right:6px;"></i>{{ $a->usr_correo ?? 'Sin correo' }}</div>
                </div>

                <div style="margin-top: auto; width: 100%; pt-4; border-top: 1px solid var(--border); padding-top: 1rem;">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <span class="badge badge-success" style="width: fit-content; margin: 0 auto; font-size: 10px; padding: 4px 12px;">
                            <i class="fas fa-check-circle" style="margin-right:4px;"></i>Postulación Aprobada
                        </span>
                        <div style="font-size:12px; color:var(--primary); font-weight: 500;">
                            <i class="fas fa-briefcase" style="margin-right:4px;"></i>{{ $a->pro_titulo_proyecto ?? 'Sin proyecto' }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card" style="text-align:center; padding:5rem 2rem; grid-column: 1 / -1;">
                <i class="fas fa-users" style="font-size:4rem; color:var(--border); margin-bottom:1.5rem;"></i>
                <h4 style="color:var(--text-main); font-size:1.5rem; margin-bottom:8px;">No hay aprendices activos</h4>
                <p style="color:var(--text-muted);">Aún no tienes aprendices vinculados a tus proyectos.</p>
            </div>
        @endforelse
    </div>
@endsection
