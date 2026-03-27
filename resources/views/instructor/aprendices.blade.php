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

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/instructor.css') }}">
@endsection

@section('content')
    <div style="margin-bottom: 32px;" class="animate-fade-in">
        <h2 style="font-size:26px; font-weight:800; color:var(--text)">Comunidad de Aprendices</h2>
        <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Supervisa el desempeño y progreso de los aprendices en tus proyectos.</p>
    </div>

    <div class="instructor-community-grid animate-fade-in">
        @forelse($aprendices as $a)
            <div class="glass-card instructor-apprentice-card">
                <div class="instructor-apprentice-avatar">
                    <span>{{ strtoupper(substr($a->apr_nombre ?? 'A', 0, 1)) }}</span>
                </div>
                
                <h4 style="font-size:1.1rem; font-weight:700; margin-bottom:0.5rem; color: var(--text)">{{ $a->apr_nombre ?? '' }} {{ $a->apr_apellido ?? '' }}</h4>
                
                <div style="font-size:0.85rem; color: var(--text-light); margin-bottom: 1rem;">
                    <div style="margin-bottom: 4px;"><i class="fas fa-graduation-cap" style="color:var(--primary); margin-right:6px;"></i>{{ $a->apr_programa ?? 'Sin programa' }}</div>
                    <div><i class="fas fa-envelope" style="margin-right:6px;"></i>{{ $a->usr_correo ?? 'Sin correo' }}</div>
                </div>

                <div style="margin-top: auto; width: 100%; border-top: 1px solid var(--border); padding-top: 1rem;">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <span class="aprendiz-badge-portal" style="background: #f0fdf4; border-color: #bbf7d0; color: #16a34a; width: fit-content; margin: 0 auto; font-size: 10px;">
                            <i class="fas fa-check-circle"></i> Postulación Aprobada
                        </span>
                        <div style="font-size:12px; color:var(--primary); font-weight: 700;">
                            <i class="fas fa-briefcase" style="margin-right:4px;"></i>{{ $a->pro_titulo_proyecto ?? 'Sin proyecto' }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="instructor-empty-state">
                <i class="fas fa-users instructor-empty-icon"></i>
                <h4 style="color:var(--text); font-size:1.5rem; margin-bottom:8px; font-weight: 800;">No hay aprendices activos</h4>
                <p style="color:var(--text-light); font-weight: 500;">Aún no tienes aprendices vinculados a tus proyectos.</p>
            </div>
        @endforelse
    </div>
@endsection
