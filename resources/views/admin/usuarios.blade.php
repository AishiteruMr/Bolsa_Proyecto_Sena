@extends('layouts.dashboard')

@section('title', 'Usuarios')
@section('page-title', 'Gestión de Usuarios')

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 40px; animation: fadeIn 0.8s ease-out;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <div>
                <h2 style="font-size:32px; font-weight:800; letter-spacing: -1px; color: var(--text);">Gestión de <span style="color: var(--primary);">Usuarios</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px;">Administra y supervisa los perfiles de aprendices e instructores.</p>
            </div>
            <div style="display:flex; gap:12px; background: #f1f5f9; padding: 6px; border-radius: 16px;">
                <button id="btn-apr" class="btn-premium" style="background: var(--primary); color: white; border-radius: 12px; padding: 10px 20px; font-size: 14px;" onclick="showTable('aprendices')">
                    <i class="fas fa-graduation-cap"></i> Aprendices
                </button>
                <button id="btn-ins" class="btn-premium" style="background: transparent; color: var(--text-light); box-shadow: none; border-radius: 12px; padding: 10px 20px; font-size: 14px;" onclick="showTable('instructores')">
                    <i class="fas fa-chalkboard-teacher"></i> Instructores
                </button>
            </div>
        </div>

        <div id="aprendices" style="animation: fadeIn 0.5s ease-out;">
            <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: var(--radius);">
                <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: rgba(248, 250, 252, 0.5);">
                    <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            <i class="fas fa-user-graduate"></i>
                        </span>
                        Comunidad de Aprendices
                    </h3>
                </div>
                <div class="premium-table-container" style="border: none; box-shadow: none;">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombre Completo</th>
                                <th>Programa de Formación</th>
                                <th>Contacto</th>
                                <th>Estado</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aprendices as $a)
                                <tr>
                                    <td style="font-weight:700; color: var(--text);">{{ $a->usr_documento }}</td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--text);">{{ $a->apr_nombre }} {{ $a->apr_apellido }}</div>
                                    </td>
                                    <td>
                                        <span style="background: #f1f5f9; color: var(--text-light); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                            {{ $a->apr_programa }}
                                        </span>
                                    </td>
                                    <td style="font-size: 13px; color: var(--text-light);">{{ $a->usr_correo }}</td>
                                    <td>
                                        <span style="background: {{ $a->apr_estado == 1 ? '#d1fae5' : '#fee2e2' }}; color: {{ $a->apr_estado == 1 ? '#065f46' : '#991b1b' }}; padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                                            {{ $a->apr_estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.usuarios.estado', $a->apr_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="tipo" value="aprendiz">
                                            <input type="hidden" name="estado" value="{{ $a->apr_estado == 1 ? 0 : 1 }}">
                                            <button type="submit" class="btn-premium" style="padding: 8px 16px; font-size: 11px; background: {{ $a->apr_estado == 1 ? '#f1f5f9' : 'var(--primary)' }}; color: {{ $a->apr_estado == 1 ? 'var(--text-light)' : 'white' }}; box-shadow: none;">
                                                <i class="fas {{ $a->apr_estado == 1 ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                {{ $a->apr_estado == 1 ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" style="text-align:center; padding: 60px; color:var(--text-lighter); font-weight: 600;">No hay aprendices registrados en el sistema.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="instructores" style="display:none; animation: fadeIn 0.5s ease-out;">
            <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: var(--radius);">
                <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: rgba(248, 250, 252, 0.5);">
                    <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        Cuerpo de Instructores
                    </h3>
                </div>
                <div class="premium-table-container" style="border: none; box-shadow: none;">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombre Completo</th>
                                <th>Especialidad</th>
                                <th>Contacto</th>
                                <th>Estado</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instructores as $i)
                                <tr>
                                    <td style="font-weight:700; color: var(--text);">{{ $i->usr_documento }}</td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--text);">{{ $i->ins_nombre }} {{ $i->ins_apellido }}</div>
                                    </td>
                                    <td>
                                        <span style="background: #eff6ff; color: #3b82f6; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                            {{ $i->ins_especialidad }}
                                        </span>
                                    </td>
                                    <td style="font-size: 13px; color: var(--text-light);">{{ $i->usr_correo }}</td>
                                    <td>
                                        <span style="background: {{ $i->ins_estado == 1 ? '#d1fae5' : '#fee2e2' }}; color: {{ $i->ins_estado == 1 ? '#065f46' : '#991b1b' }}; padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                                            {{ $i->ins_estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.usuarios.estado', $i->usr_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="tipo" value="instructor">
                                            <input type="hidden" name="estado" value="{{ $i->ins_estado == 1 ? 0 : 1 }}">
                                            <button type="submit" class="btn-premium" style="padding: 8px 16px; font-size: 11px; background: {{ $i->ins_estado == 1 ? '#f1f5f9' : 'var(--primary)' }}; color: {{ $i->ins_estado == 1 ? 'var(--text-light)' : 'white' }}; box-shadow: none;">
                                                <i class="fas {{ $i->ins_estado == 1 ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                {{ $i->ins_estado == 1 ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" style="text-align:center; padding: 60px; color:var(--text-lighter); font-weight: 600;">No hay instructores registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTable(type) {
            const aprDiv = document.getElementById('aprendices');
            const insDiv = document.getElementById('instructores');
            const btnApr = document.getElementById('btn-apr');
            const btnIns = document.getElementById('btn-ins');

            if (type === 'aprendices') {
                aprDiv.style.display = 'block';
                insDiv.style.display = 'none';
                btnApr.style.background = 'var(--primary)';
                btnApr.style.color = 'white';
                btnApr.style.boxShadow = '0 10px 20px -5px rgba(62,180,137,0.4)';
                btnIns.style.background = 'transparent';
                btnIns.style.color = 'var(--text-light)';
                btnIns.style.boxShadow = 'none';
            } else {
                aprDiv.style.display = 'none';
                insDiv.style.display = 'block';
                btnIns.style.background = 'var(--primary)';
                btnIns.style.color = 'white';
                btnIns.style.boxShadow = '0 10px 20px -5px rgba(62,180,137,0.4)';
                btnApr.style.background = 'transparent';
                btnApr.style.color = 'var(--text-light)';
                btnApr.style.boxShadow = 'none';
            }
        }
    </script>
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection
