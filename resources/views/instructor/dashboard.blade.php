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
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">¡Hola, {{ session('nombre') }}! 👨‍🏫</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Bienvenido a tu panel de instructor. Gestiona tus proyectos y aprendices.</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <h3>{{ $proyectosAsignados }}</h3>
            <p>Proyectos asignados</p>
        </div>
        <div class="stat-card" style="border-color:#28a745;">
            <h3 style="color:#28a745;">{{ $proyectosActivos }}</h3>
            <p>Proyectos activos</p>
        </div>
        <div class="stat-card" style="border-color:#2980b9;">
            <h3 style="color:#2980b9;">{{ $totalAprendices }}</h3>
            <p>Aprendices en proyectos</p>
        </div>
        <div class="stat-card" style="border-color:#f39c12;">
            <h3 style="color:#f39c12;">{{ $instructor->ins_especialidad ?? 'N/A' }}</h3>
            <p style="font-size:11px;">Especialidad</p>
        </div>
    </div>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="font-size:16px; font-weight:600;">Proyectos Asignados</h3>
            <a href="{{ route('instructor.proyectos') }}" class="btn btn-primary btn-sm">Ver todos</a>
        </div>
        @forelse($proyectos as $p)
            <div style="display:flex; align-items:center; gap:16px; padding:16px; border-bottom:1px solid #f0f0f0;">
                <div style="width:48px; height:48px; border-radius:10px; background:linear-gradient(135deg, #2980b9, #1a6090); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-project-diagram" style="color:#fff; font-size:18px;"></i>
                </div>
                <div style="flex:1;">
                    <h4 style="font-size:14px; font-weight:600; margin-bottom:4px;">{{ $p->pro_titulo_proyecto }}</h4>
                    <p style="font-size:12px; color:#666;">{{ $p->emp_nombre }}</p>
                </div>
                <span class="badge {{ $p->pro_estado === 'Activo' ? 'badge-success' : 'badge-warning' }}">
                    {{ $p->pro_estado }}
                </span>
            </div>
        @empty
            <p style="color:#666; font-size:14px; text-align:center; padding:24px;">No hay proyectos asignados.</p>
        @endforelse
    </div>
@endsection
