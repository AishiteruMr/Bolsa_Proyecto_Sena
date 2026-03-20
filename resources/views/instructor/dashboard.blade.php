@extends('layouts.dashboard')

@section('title', 'Dashboard Instructor')
@section('page-title', 'Mi Dashboard')

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
        <h1>Bienvenido de nuevo, 
            <span>{{ session('nombre') }}</span>
        </h1>
    </section>

    <!-- PROYECTOS -->
    <h2 class="section-title" style="text-align:center;">Proyectos Asignados</h2>

    <div class="cards-container">

        @forelse($proyectos as $p)
            <div class="project-card">

                <!-- Imagen -->
                <div class="project-image">
                    <img src="{{ $p->pro_imagen_url ?? asset('assets/') }}" 
                         alt="Imagen del Proyecto">
                </div>

                <!-- Info -->
                <div class="project-info">

                    <h3 class="project-title">
                        {{ $p->pro_titulo_proyecto }}
                    </h3>

                    <p><strong>Empresa:</strong> {{ $p->emp_nombre }}</p>
                    <p><strong>Categoría:</strong> {{ $p->pro_categoria }}</p>

                    <p class="project-description">
                        <strong>Descripción:</strong>
                        {{ $p->pro_descripcion }}
                    </p>

                    <p><strong>Requisitos:</strong> {{ $p->pro_requisitos_especificos }}</p>
                    <p><strong>Habilidades:</strong> {{ $p->pro_habilidades_requerida }}</p>

                    <p><strong>Duración:</strong> {{ $p->pro_duracion_estimada }} días</p>
                    <p><strong>Fecha publicación:</strong> {{ $p->pro_fecha_publi }}</p>

                    <p>
                        <strong>Estado:</strong> 
                        <span class="status">{{ $p->pro_estado }}</span>
                    </p>

                    <!-- BOTÓN -->
                    <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-ver">
                        <i class="fa-solid fa-eye"></i> Ver más información
                    </a>

                </div>
            </div>

        @empty
            <p class="no-projects">No tienes proyectos asignados aún.</p>
        @endforelse

    </div>

@endsection