@extends('layouts.dashboard')

@section('title', 'Dashboard Aprendiz')
@section('page-title', 'Mi Dashboard')

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
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
    <!-- Bienvenida -->
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">¡Hola, {{ session('nombre') }}! 👋</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Bienvenido a tu panel de aprendiz. Aquí puedes explorar y postularte a proyectos.</p>
    </div>

    <!-- Stats -->
    <div class="stat-grid">
        <div class="stat-card">
            <h3>{{ $totalPostulaciones }}</h3>
            <p>Postulaciones totales</p>
        </div>
        <div class="stat-card" style="border-color:#28a745;">
            <h3 style="color:#28a745;">{{ $postulacionesAprobadas }}</h3>
            <p>Postulaciones aprobadas</p>
        </div>
        <div class="stat-card" style="border-color:#2980b9;">
            <h3 style="color:#2980b9;">{{ $proyectosDisponibles }}</h3>
            <p>Proyectos disponibles</p>
        </div>
        <div class="stat-card" style="border-color:#f39c12;">
            <h3 style="color:#f39c12;">{{ $aprendiz->apr_programa ?? 'N/A' }}</h3>
            <p style="font-size:11px;">Programa de formación</p>
        </div>
    </div>

    <!-- Proyectos recientes -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="font-size:16px; font-weight:600;">Proyectos Disponibles</h3>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn btn-primary btn-sm">Ver todos</a>
        </div>
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px,1fr)); gap:16px;">
            @forelse($proyectosRecientes as $p)
                <div style="border:1px solid #f0f0f0; border-radius:10px; overflow:hidden;">
                    @if($p->pro_imagen_url)
                        <img src="{{ $p->pro_imagen_url }}" alt="" style="width:100%; height:140px; object-fit:cover;">
                    @else
                        <div style="width:100%; height:140px; background:linear-gradient(135deg,#39a900,#2d8500); display:flex; align-items:center; justify-content:center; color:#fff; font-size:32px;">💼</div>
                    @endif
                    <div style="padding:14px;">
                        <span class="badge badge-info" style="margin-bottom:8px;">{{ $p->pro_categoria }}</span>
                        <h4 style="font-size:14px; font-weight:600; margin-bottom:6px;">{{ $p->pro_titulo_proyecto }}</h4>
                        <p style="font-size:12px; color:#666; margin-bottom:10px;">{{ $p->emp_nombre }}</p>
                        <a href="{{ route('aprendiz.proyectos') }}" class="btn btn-outline btn-sm">Ver más</a>
                    </div>
                </div>
            @empty
                <p style="color:#666; font-size:14px; grid-column:1/-1; text-align:center; padding:20px;">No hay proyectos disponibles aún.</p>
            @endforelse
        </div>
    </div>
@endsection
