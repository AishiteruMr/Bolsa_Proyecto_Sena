@extends('layouts.dashboard')

@section('title', 'Empresas')
@section('page-title', 'Gestión de Empresas')

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
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="font-size:28px; font-weight:800; letter-spacing: -1px;">Gestión de Empresas</h2>
            <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Administra las empresas registradas en el sistema.</p>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 24px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size:18px; font-weight:700;"><i class="fas fa-building" style="margin-right:8px; color:var(--primary);"></i> Empresas Aliadas</h3>
        </div>
        <div class="table-container" style="border:none; border-radius:0;">
            <table>
                <thead>
                    <tr>
                        <th>NIT</th>
                        <th>Nombre</th>
                        <th>Representante</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empresas as $e)
                        <tr>
                            <td style="font-weight:600;">{{ $e->emp_nit }}</td>
                            <td>{{ $e->emp_nombre }}</td>
                            <td style="color:var(--text-light);">{{ $e->emp_representante }}</td>
                            <td style="font-size:13px;">{{ $e->emp_correo }}</td>
                            <td>
                                <span class="badge {{ $e->emp_estado == 1 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $e->emp_estado == 1 ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.empresas.estado', $e->emp_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="estado" value="{{ $e->emp_estado == 1 ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm {{ $e->emp_estado == 1 ? 'btn-danger' : 'btn-primary' }}" style="padding: 6px 14px;">
                                        {{ $e->emp_estado == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; padding: 40px; color:var(--text-light);">No hay empresas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
