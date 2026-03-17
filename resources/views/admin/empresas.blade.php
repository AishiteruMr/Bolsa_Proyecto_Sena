@extends('layouts.dashboard')

@section('title', 'Empresas')
@section('page-title', 'Gestión de Empresas')

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Proyectos
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">Gestión de Empresas</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Administra las empresas registradas en el sistema.</p>
    </div>

    <div class="card">
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
                        <td>{{ $e->emp_nit }}</td>
                        <td>{{ $e->emp_nombre }}</td>
                        <td>{{ $e->emp_representante }}</td>
                        <td>{{ $e->emp_correo }}</td>
                        <td>
                            <span class="badge {{ $e->emp_estado == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $e->emp_estado == 1 ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.empresas.estado', $e->emp_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="estado" value="{{ $e->emp_estado == 1 ? 0 : 1 }}">
                                <button type="submit" class="btn btn-sm {{ $e->emp_estado == 1 ? 'btn-danger' : 'btn-primary' }}">
                                    {{ $e->emp_estado == 1 ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center; color:#666;">No hay empresas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
