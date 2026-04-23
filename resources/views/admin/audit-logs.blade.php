@extends('layouts.dashboard')

@section('title', 'Logs de Auditoría')
@section('page-title', 'Auditoría del Sistema')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
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
    <a href="{{ route('admin.audit') }}" class="nav-item {{ request()->routeIs('admin.audit*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> Auditoría
    </a>
@endsection

@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-header-master" style="margin-bottom: 24px;">
            <div class="admin-header-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                    <span class="admin-badge-hub">Auditoría</span>
                </div>
                <h1 class="admin-header-title">Logs de <span style="color: var(--primary);">Auditoría</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 16px; max-width: 600px; font-weight: 500;">Historial completo de acciones realizadas en el sistema.</p>
            </div>
        </div>

        <div class="glass-card" style="padding: 24px; margin-bottom: 24px; background: white;">
            <form method="GET" action="{{ route('admin.audit') }}">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 16px; align-items: end;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Módulo</label>
                        <select name="modulo" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                            <option value="">Todos</option>
                            @foreach($modulos ?? [] as $modulo)
                                <option value="{{ $modulo }}" {{ request('modulo') == $modulo ? 'selected' : '' }}>{{ ucfirst($modulo) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Acción</label>
                        <select name="accion" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                            <option value="">Todas</option>
                            @foreach($acciones ?? [] as $accion)
                                <option value="{{ $accion }}" {{ request('accion') == $accion ? 'selected' : '' }}>{{ ucfirst($accion) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                </div>
                <div style="display: flex; gap: 12px; margin-top: 16px; justify-content: flex-end;">
                    @if(request()->has('modulo') || request()->has('accion') || request()->has('fecha_inicio') || request()->has('fecha_fin'))
                        <a href="{{ route('admin.audit') }}" class="btn-premium" style="padding: 12px 20px; background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; box-shadow: none; font-size: 13px;">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    @endif
                    <button type="submit" class="btn-premium" style="padding: 12px 24px; font-size: 13px;">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div class="glass-card" style="background: white; padding: 0; overflow: hidden;">
            <div class="premium-table-container">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Módulo</th>
                            <th>Tabla</th>
                            <th>ID Registro</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td style="font-size: 12px; color: var(--text-light);">
                                    <i class="far fa-clock" style="margin-right: 4px; opacity: 0.5;"></i>
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px;">
                                            {{ strtoupper(substr($log->usuario->correo ?? 'S', 0, 1)) }}
                                        </div>
                                        <span style="font-weight: 600; font-size: 13px;">{{ $log->usuario->correo ?? 'Sistema' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge" style="background: {{ match($log->accion) { 'crear' => '#f0fdf4', 'editar' => '#fffbeb', 'eliminar' => '#fef2f2', default => '#f8fafc' } }}; color: {{ match($log->accion) { 'crear' => '#15803d', 'editar' => '#b45309', 'eliminar' => '#dc2626', default => '#64748b' } }}; border-color: {{ match($log->accion) { 'crear' => '#bbf7d0', 'editar' => '#fde68a', 'eliminar' => '#fecaca', default => '#e2e8f0' } }; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800;">
                                        <i class="fas {{ $log->accion_icon }}"></i>
                                        {{ ucfirst($log->accion) }}
                                    </span>
                                </td>
                                <td style="font-weight: 600; font-size: 13px;">{{ ucfirst($log->modulo) }}</td>
                                <td style="font-size: 12px; color: var(--text-light);">{{ $log->tabla_afectada ?? '—' }}</td>
                                <td style="font-size: 12px; color: var(--text-light);">{{ $log->registro_id ?? '—' }}</td>
                                <td style="font-size: 11px; color: var(--text-lighter);">{{ $log->ip_address ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 60px; color: var(--text-lighter);">
                                    <i class="fas fa-clipboard-list" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
                                    <p style="font-weight: 700; font-size: 16px;">No hay registros de auditoría</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div style="padding: 20px; border-top: 1px solid var(--border);">
                {{ $logs->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection
