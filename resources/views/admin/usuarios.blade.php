@extends('layouts.dashboard')

@section('title', 'Usuarios')
@section('page-title', 'Gestión de Usuarios')

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
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
        <h2 style="font-size:22px; font-weight:700;">Gestión de Usuarios</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Administra aprendices e instructores del sistema.</p>
    </div>

    <div style="margin-bottom: 24px; display:flex; gap:8px;">
        <button class="btn btn-primary" onclick="document.getElementById('aprendices').style.display='block'; document.getElementById('instructores').style.display='none';">
            <i class="fas fa-graduation-cap"></i> Aprendices ({{ $aprendices->count() }})
        </button>
        <button class="btn btn-outline" onclick="document.getElementById('aprendices').style.display='none'; document.getElementById('instructores').style.display='block';">
            <i class="fas fa-chalkboard-teacher"></i> Instructores ({{ $instructores->count() }})
        </button>
    </div>

    <div id="aprendices">
        <div class="card">
            <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Aprendices</h3>
            <table>
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aprendices as $a)
                        <tr>
                            <td>{{ $a->usr_documento }}</td>
                            <td>{{ $a->apr_nombre }} {{ $a->apr_apellido }}</td>
                            <td>{{ $a->apr_programa }}</td>
                            <td>{{ $a->usr_correo }}</td>
                            <td>
                                <span class="badge {{ $a->apr_estado == 1 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $a->apr_estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.usuarios.estado', $a->apr_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="tipo" value="aprendiz">
                                    <input type="hidden" name="estado" value="{{ $a->apr_estado == 1 ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm {{ $a->apr_estado == 1 ? 'btn-danger' : 'btn-primary' }}">
                                        {{ $a->apr_estado == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; color:#666;">No hay aprendices registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="instructores" style="display:none;">
        <div class="card">
            <h3 style="font-size:16px; font-weight:600; margin-bottom:16px;">Instructores</h3>
            <table>
                <thead>
                    <tr>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instructores as $i)
                        <tr>
                            <td>{{ $i->usr_documento }}</td>
                            <td>{{ $i->ins_nombre }} {{ $i->ins_apellido }}</td>
                            <td>{{ $i->ins_especialidad }}</td>
                            <td>{{ $i->usr_correo }}</td>
                            <td>
                                <span class="badge {{ $i->ins_estado == 1 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $i->ins_estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.usuarios.estado', $i->usr_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="tipo" value="instructor">
                                    <input type="hidden" name="estado" value="{{ $i->ins_estado == 1 ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm {{ $i->ins_estado == 1 ? 'btn-danger' : 'btn-primary' }}">
                                        {{ $i->ins_estado == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; color:#666;">No hay instructores registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
