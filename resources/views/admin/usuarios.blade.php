@extends('layouts.dashboard')

@section('title', 'Usuarios')
@section('page-title', 'Gestión de Usuarios')

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
            <h2 style="font-size:28px; font-weight:800; letter-spacing: -1px;">Gestión de Usuarios</h2>
            <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Administra aprendices e instructores del sistema.</p>
        </div>
        <div style="display:flex; gap:12px;">
            <button class="btn btn-primary" onclick="document.getElementById('aprendices').style.display='block'; document.getElementById('instructores').style.display='none';">
                <i class="fas fa-graduation-cap"></i> Aprendices ({{ $aprendices->count() }})
            </button>
            <button class="btn btn-outline" onclick="document.getElementById('aprendices').style.display='none'; document.getElementById('instructores').style.display='block';">
                <i class="fas fa-chalkboard-teacher"></i> Instructores ({{ $instructores->count() }})
            </button>
        </div>
    </div>

    <div id="aprendices">
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size:18px; font-weight:700;"><i class="fas fa-user-graduate" style="margin-right:8px; color:var(--primary);"></i> Aprendices Registrados</h3>
            </div>
            <div class="table-container" style="border:none; border-radius:0;">
                <table>
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre Completo</th>
                            <th>Programa</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aprendices as $a)
                            <tr>
                                <td style="font-weight:600;">{{ $a->usr_documento }}</td>
                                <td>{{ $a->apr_nombre }} {{ $a->apr_apellido }}</td>
                                <td style="color:var(--text-light); font-size:13px;">{{ $a->apr_programa }}</td>
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
                                        <button type="submit" class="btn btn-sm {{ $a->apr_estado == 1 ? 'btn-danger' : 'btn-primary' }}" style="padding: 6px 14px;">
                                            {{ $a->apr_estado == 1 ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center; padding: 40px; color:var(--text-light);">No hay aprendices registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="instructores" style="display:none;">
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size:18px; font-weight:700;"><i class="fas fa-chalkboard-teacher" style="margin-right:8px; color:var(--primary);"></i> Instructores Registrados</h3>
            </div>
            <div class="table-container" style="border:none; border-radius:0;">
                <table>
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre Completo</th>
                            <th>Especialidad</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instructores as $i)
                            <tr>
                                <td style="font-weight:600;">{{ $i->usr_documento }}</td>
                                <td>{{ $i->ins_nombre }} {{ $i->ins_apellido }}</td>
                                <td style="color:var(--text-light); font-size:13px;">{{ $i->ins_especialidad }}</td>
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
                                        <button type="submit" class="btn btn-sm {{ $i->ins_estado == 1 ? 'btn-danger' : 'btn-primary' }}" style="padding: 6px 14px;">
                                            {{ $i->ins_estado == 1 ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center; padding: 40px; color:var(--text-light);">No hay instructores registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
