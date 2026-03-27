@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')
@section('page-title', 'Administración de Cuentas')

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
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-page-header">
            <div>
                <h2 class="admin-title-main">Gestión de <span style="color: var(--primary);">Usuarios</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px; font-weight: 500;">Administra y supervisa los perfiles de aprendices e instructores.</p>
            </div>
            <div class="admin-tab-group">
                <button id="btn-apr" class="admin-tab-btn active" onclick="showTable('aprendices')">
                    <i class="fas fa-graduation-cap"></i> Aprendices
                </button>
                <button id="btn-ins" class="admin-tab-btn inactive" onclick="showTable('instructores')">
                    <i class="fas fa-chalkboard-teacher"></i> Instructores
                </button>
            </div>
        </div>

        <div id="aprendices" class="animate-fade-in">
            <div class="glass-card admin-table-card">
                <div class="admin-table-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                    <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                        <span class="admin-stat-icon" style="width: 36px; height: 36px; background: var(--primary-soft); color: var(--primary); font-size: 16px;">
                            <i class="fas fa-user-graduate"></i>
                        </span>
                        Comunidad de Aprendices
                    </h3>
                    <div style="position:relative;">
                        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                        <input type="text" id="buscar-aprendiz" placeholder="Buscar aprendiz..." oninput="filtrarTabla(this,'aprendices-tbody')" style="padding:10px 14px 10px 38px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:13px;font-weight:600;color:var(--text);outline:none;background:#f8fafc;min-width:220px;">
                    </div>
                </div>
                <div class="premium-table-container">
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
                        <tbody id="aprendices-tbody">
                            @forelse($aprendices as $a)
                                <tr>
                                    <td style="font-weight:800; color: var(--text);">{{ $a->usr_documento }}</td>
                                    <td>
                                        <div style="font-weight: 700; color: var(--text);">{{ $a->apr_nombre }} {{ $a->apr_apellido }}</div>
                                    </td>
                                    <td>
                                        <span class="aprendiz-badge-portal" style="background: #f8fafc; color: var(--text-light); border-color: #e2e8f0; font-size: 11px;">
                                            {{ $a->apr_programa }}
                                        </span>
                                    </td>
                                    <td style="font-size: 13px; color: var(--text-light); font-weight: 600;">{{ $a->usr_correo }}</td>
                                    <td>
                                        <span class="status-badge {{ $a->apr_estado == 1 ? 'active' : 'inactive' }}" style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800;">
                                            {{ $a->apr_estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.usuarios.estado', $a->apr_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="tipo" value="aprendiz">
                                            <input type="hidden" name="estado" value="{{ $a->apr_estado == 1 ? 0 : 1 }}">
                                            <button type="submit"
                                                class="btn-premium"
                                                @if($a->apr_estado == 1)
                                                    data-confirm="¿Desactivar a {{ $a->apr_nombre }} {{ $a->apr_apellido }}? Perderá acceso a la plataforma."
                                                    data-confirm-title="Desactivar Aprendiz"
                                                @endif
                                                style="padding: 10px 16px; font-size: 11px; background: {{ $a->apr_estado == 1 ? '#f8fafc' : 'var(--primary)' }}; color: {{ $a->apr_estado == 1 ? '#64748b' : 'white' }}; border: {{ $a->apr_estado == 1 ? '1px solid #e2e8f0' : 'none' }}; box-shadow: none;">
                                                <i class="fas {{ $a->apr_estado == 1 ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                {{ $a->apr_estado == 1 ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" style="text-align:center; padding: 60px; color:var(--text-light); font-weight: 600;">No hay aprendices registrados en el sistema.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="instructores" style="display:none;" class="animate-fade-in">
            <div class="glass-card admin-table-card">
                <div class="admin-table-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                    <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                        <span class="admin-stat-icon" style="width: 36px; height: 36px; background: #eff6ff; color: #3b82f6; font-size: 16px;">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        Cuerpo de Instructores
                    </h3>
                    <div style="position:relative;">
                        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                        <input type="text" id="buscar-instructor" placeholder="Buscar instructor..." oninput="filtrarTabla(this,'instructores-tbody')" style="padding:10px 14px 10px 38px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:13px;font-weight:600;color:var(--text);outline:none;background:#f8fafc;min-width:220px;">
                    </div>
                </div>
                <div class="premium-table-container">
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
                        <tbody id="instructores-tbody">
                            @forelse($instructores as $i)
                                <tr>
                                    <td style="font-weight:800; color: var(--text);">{{ $i->usr_documento }}</td>
                                    <td>
                                        <div style="font-weight: 700; color: var(--text);">{{ $i->ins_nombre }} {{ $i->ins_apellido }}</div>
                                    </td>
                                    <td>
                                        <span class="aprendiz-badge-portal" style="background: #eff6ff; color: #3b82f6; border-color: #dbeafe; font-size: 11px;">
                                            {{ $i->ins_especialidad }}
                                        </span>
                                    </td>
                                    <td style="font-size: 13px; color: var(--text-light); font-weight: 600;">{{ $i->usr_correo }}</td>
                                    <td>
                                        <span class="status-badge {{ $i->ins_estado == 1 ? 'active' : 'inactive' }}" style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800;">
                                            {{ $i->ins_estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('admin.usuarios.estado', $i->usr_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="tipo" value="instructor">
                                            <input type="hidden" name="estado" value="{{ $i->ins_estado == 1 ? 0 : 1 }}">
                                            <button type="submit"
                                                class="btn-premium"
                                                @if($i->ins_estado == 1)
                                                    data-confirm="¿Desactivar a {{ $i->ins_nombre }} {{ $i->ins_apellido }}? Perderá acceso a la plataforma."
                                                    data-confirm-title="Desactivar Instructor"
                                                @endif
                                                style="padding: 10px 16px; font-size: 11px; background: {{ $i->ins_estado == 1 ? '#f8fafc' : 'var(--primary)' }}; color: {{ $i->ins_estado == 1 ? '#64748b' : 'white' }}; border: {{ $i->ins_estado == 1 ? '1px solid #e2e8f0' : 'none' }}; box-shadow: none;">
                                                <i class="fas {{ $i->ins_estado == 1 ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                {{ $i->ins_estado == 1 ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" style="text-align:center; padding: 60px; color:var(--text-light); font-weight: 600;">No hay instructores registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function filtrarTabla(inputEl, tbodyId) {
    const q = inputEl.value.toLowerCase();
    document.querySelectorAll('#' + tbodyId + ' tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>
<script src="{{ asset('js/admin.js') }}"></script>
@endsection
