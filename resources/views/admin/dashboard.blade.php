@extends('layouts.dashboard')

@section('title', 'Panel Administrador')
@section('page-title', 'Panel de Administración')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users-cog"></i> Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Proyectos
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 32px;">
        <h2 style="font-size:28px; font-weight:800; letter-spacing: -1px;">Panel de Control ✨</h2>
        <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Resumen general de la plataforma Bolsa de Proyectos SENA.</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <i class="fas fa-user-graduate" style="position:absolute; right:20px; top:20px; font-size:40px; color:rgba(57,169,0,0.1); z-index:1;"></i>
            <h3>{{ $stats['aprendices'] }}</h3>
            <p>Aprendices</p>
        </div>
        <div class="stat-card" style="border-bottom: 4px solid #3498db;">
            <i class="fas fa-chalkboard-teacher" style="position:absolute; right:20px; top:20px; font-size:40px; color:rgba(52,152,219,0.1); z-index:1;"></i>
            <h3 style="color:#3498db;">{{ $stats['instructores'] }}</h3>
            <p>Instructores</p>
        </div>
        <div class="stat-card" style="border-bottom: 4px solid #9b59b6;">
            <i class="fas fa-building" style="position:absolute; right:20px; top:20px; font-size:40px; color:rgba(155,89,182,0.1); z-index:1;"></i>
            <h3 style="color:#9b59b6;">{{ $stats['empresas'] }}</h3>
            <p>Empresas</p>
        </div>
        <div class="stat-card" style="border-bottom: 4px solid #f1c40f;">
            <i class="fas fa-project-diagram" style="position:absolute; right:20px; top:20px; font-size:40px; color:rgba(241,196,15,0.1); z-index:1;"></i>
            <h3 style="color:#f1c40f;">{{ $stats['proyectos'] }}</h3>
            <p>Proyectos Total</p>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap:24px; margin-top:32px;">
        <!-- Proyectos recientes -->
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                <h3 style="font-size:18px; font-weight:700;">Proyectos Recientes</h3>
                <a href="{{ route('admin.proyectos') }}" class="btn btn-primary btn-sm">Ver todos</a>
            </div>
            <div class="table-container" style="border:none; border-radius:0;">
                <table>
                    <thead>
                        <tr>
                            <th>Proyecto</th>
                            <th>Empresa</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyectosRecientes as $p)
                            <tr>
                                <td style="font-weight:600;">{{ Str::limit($p->pro_titulo_proyecto, 25) }}</td>
                                <td style="color:var(--text-light);">{{ Str::limit($p->emp_nombre, 20) }}</td>
                                <td>
                                    <span class="badge {{ in_array($p->pro_estado, ['Activo','Aprobado']) ? 'badge-success' : 'badge-warning' }}">
                                        {{ $p->pro_estado }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Usuarios recientes -->
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                <h3 style="font-size:18px; font-weight:700;">Usuarios Recientes</h3>
                <a href="{{ route('admin.usuarios') }}" class="btn btn-primary btn-sm">Ver todos</a>
            </div>
            <div class="table-container" style="border:none; border-radius:0;">
                <table>
                    <thead>
                        <tr>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuariosRecientes as $u)
                            <tr>
                                <td style="font-weight:500;">{{ Str::limit($u->usr_correo, 25) }}</td>
                                <td><span class="badge badge-info">{{ $u->nombre_rol }}</span></td>
                                <td style="color:var(--text-light);">{{ \Carbon\Carbon::parse($u->usr_fecha_creacion)->format('d/m/y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
