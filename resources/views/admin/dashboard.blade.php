@extends('layouts.dashboard')
@section('title', 'Panel Administrador')
@section('page-title', 'Panel de Administración')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Principal</a>
    <span class="nav-label">Gestión</span>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}"><i class="fas fa-users"></i> Usuarios</a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}"><i class="fas fa-building"></i> Empresas</a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}"><i class="fas fa-project-diagram"></i> Proyectos</a>
@endsection

@section('content')
    <div style="margin-bottom:24px;">
        <h2 style="font-size:22px; font-weight:700;">Panel de Control 🛡️</h2>
        <p style="color:#666; font-size:14px;">Gestiona usuarios, empresas y proyectos de la plataforma.</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card"><h3>{{ $stats['aprendices'] }}</h3><p>Aprendices</p></div>
        <div class="stat-card" style="border-color:#2980b9;"><h3 style="color:#2980b9;">{{ $stats['instructores'] }}</h3><p>Instructores</p></div>
        <div class="stat-card" style="border-color:#8e44ad;"><h3 style="color:#8e44ad;">{{ $stats['empresas'] }}</h3><p>Empresas</p></div>
        <div class="stat-card" style="border-color:#f39c12;"><h3 style="color:#f39c12;">{{ $stats['proyectos'] }}</h3><p>Proyectos</p></div>
        <div class="stat-card" style="border-color:#e74c3c;"><h3 style="color:#e74c3c;">{{ $stats['postulaciones'] }}</h3><p>Postulaciones</p></div>
        <div class="stat-card" style="border-color:#28a745;"><h3 style="color:#28a745;">{{ $stats['aprobadas'] }}</h3><p>Aprobadas</p></div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        <!-- Proyectos recientes -->
        <div class="card">
            <h3 style="font-size:15px; font-weight:600; margin-bottom:14px;">Proyectos Recientes</h3>
            <table>
                <thead><tr><th>Título</th><th>Empresa</th><th>Estado</th></tr></thead>
                <tbody>
                    @foreach($proyectosRecientes as $p)
                        <tr>
                            <td style="font-size:13px;">{{ Str::limit($p->pro_titulo_proyecto, 30) }}</td>
                            <td style="font-size:12px; color:#666;">{{ Str::limit($p->emp_nombre, 20) }}</td>
                            <td>
                                <span class="badge {{ in_array($p->pro_estado, ['Activo','Aprobado']) ? 'badge-success' : 'badge-warning' }}">
                                    {{ $p->pro_estado }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.proyectos') }}" style="font-size:13px; color:#39a900; display:block; margin-top:12px; text-align:right;">Ver todos →</a>
        </div>

        <!-- Usuarios recientes -->
        <div class="card">
            <h3 style="font-size:15px; font-weight:600; margin-bottom:14px;">Usuarios Recientes</h3>
            <table>
                <thead><tr><th>Correo</th><th>Rol</th><th>Fecha</th></tr></thead>
                <tbody>
                    @foreach($usuariosRecientes as $u)
                        <tr>
                            <td style="font-size:12px;">{{ Str::limit($u->usr_correo, 25) }}</td>
                            <td><span class="badge badge-info">{{ $u->rol_nombre }}</span></td>
                            <td style="font-size:11px; color:#888;">{{ \Carbon\Carbon::parse($u->usr_fecha_creacion)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.usuarios') }}" style="font-size:13px; color:#39a900; display:block; margin-top:12px; text-align:right;">Ver todos →</a>
        </div>
    </div>
@endsection
