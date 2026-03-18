@extends('layouts.dashboard')
@section('title', 'Dashboard Empresa')
@section('page-title', 'Panel Empresa')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}"
        class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i>
        Dashboard</a>
    <a href="{{ route('empresa.proyectos') }}"
        class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}"><i
            class="fas fa-project-diagram"></i> Mis Proyectos</a>
    <a href="{{ route('empresa.proyectos.crear') }}"
        class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}"><i
            class="fas fa-plus-circle"></i> Publicar Proyecto</a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}"><i
            class="fas fa-building"></i> Perfil Empresa</a>
@endsection

@section('content')
    <div style="margin-bottom:24px;">
        <h2 style="font-size:22px; font-weight:700;">Bienvenido, {{ session('nombre') }} 🏢</h2>
        <p style="color:#666; font-size:14px;">Gestiona tus proyectos y revisa las postulaciones de aprendices.</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <h3>{{ $totalProyectos }}</h3>
            <p>Total proyectos</p>
        </div>
        <div class="stat-card">
            <h3>{{ $proyectosActivos }}</h3>
            <p>Proyectos activos</p>
        </div>
    </div>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="font-size:16px; font-weight:600;">Proyectos Recientes</h3>
            <a href="{{ route('empresa.proyectos.crear') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                Nuevo Proyecto</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Postulaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyectosRecientes as $p)
                    <tr>
                        <td style="font-weight:500;">{{ Str::limit($p->pro_titulo_proyecto, 40) }}</td>
                        <td>{{ $p->pro_categoria }}</td>
                        <td>
                            <span
                                class="badge {{ $p->pro_estado === 'Activo' || $p->pro_estado === 'Aprobado' ? 'badge-success' : 'badge-warning' }}">
                                {{ $p->pro_estado }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#666;">{{ $p->pro_fecha_publi }}</td>
                        <td style="font-size:12px; color:#666;">
                            (Aqui iran el numero de postulaciones,agregar luego)
                        </td>
                @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:#666; padding:24px;">No hay proyectos aún.</td>
                        </tr>
                    @endforelse
            </tbody>
        </table>
    </div>
@endsection