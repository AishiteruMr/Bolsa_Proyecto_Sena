@extends('layouts.dashboard')

@section('title', 'Dashboard Instructor')
@section('page-title', 'Dashboard de Instructor')

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

    <!-- BIENVENIDA -->
    <section class="welcome">
        <h1>¡Hola, <span>{{ session('nombre') }}!</span> 👋</h1>
        <p style="color:var(--text-muted)">Bienvenido a tu panel de gestión académica.</p>
    </section>

    <!-- STATS (Bento Grid) -->
    <div class="stats-container">
        <div class="stat-card glass-card">
            <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
            <div class="stat-info">
                <h3>{{ count($proyectos) }}</h3>
                <p>Proyectos Asignados</p>
            </div>
        </div>
        <div class="stat-card glass-card" style="border-top: none;">
            <div class="stat-icon" style="background: #3b82f6"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-info">
                <h3>{{ $totalAprendices ?? '0' }}</h3>
                <p>Aprendices Activos</p>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-icon" style="background: #f59e0b"><i class="fas fa-file-upload"></i></div>
            <div class="stat-info">
                <h3>{{ $evidenciasPendientes ?? '0' }}</h3>
                <p>Evidencias por Calificar</p>
            </div>
        </div>
    </div>

    <!-- PROYECTOS -->
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-rocket" style="color:var(--primary)"></i> Proyectos en Curso
        </h2>
    </div>

    <div class="cards-container">

        @forelse($proyectos as $p)
            <div class="project-card">

                <!-- Imagen -->
                <div class="project-image">
                    <img src="{{ $p->pro_imagen_url ?? asset('assets/default-project.jpg') }}" 
                         alt="Imagen del Proyecto" style="width:100%; object-fit:cover;">
                    <div class="status-badge">{{ $p->pro_estado }}</div>
                </div>

                <!-- Info -->
                <div class="project-info">
                    <h3 class="project-title">{{ $p->pro_titulo_proyecto }}</h3>
                    
                    <div class="info-meta">
                        <span><i class="fas fa-building"></i> {{ $p->emp_nombre }}</span>
                        <span><i class="fas fa-tag"></i> {{ $p->pro_categoria }}</span>
                    </div>

                    <p class="project-description">
                        {{ $p->pro_descripcion }}
                    </p>

                    <div style="display:flex; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap">
                        <span class="badge badge-info" style="font-size:10px"><i class="fas fa-clock"></i> {{ $p->pro_duracion_estimada }} días</span>
                        <span class="badge badge-success" style="font-size:10px"><i class="fas fa-calendar"></i> {{ $p->pro_fecha_publi }}</span>
                    </div>

                    <!-- BOTÓN -->
                    <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-ver">
                        Gestionar Proyecto <i class="fa-solid fa-arrow-right" style="margin-left:8px; font-size:14px"></i>
                    </a>

                </div>
            </div>

        @empty
            <div class="glass-card" style="padding: 4rem; text-align: center; grid-column: 1/-1">
                <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--border); margin-bottom: 1rem"></i>
                <p style="color: var(--text-muted)">No tienes proyectos asignados aún.</p>
            </div>
        @endforelse

    </div>

@endsection