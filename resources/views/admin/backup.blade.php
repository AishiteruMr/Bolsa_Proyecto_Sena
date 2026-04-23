@extends('layouts.dashboard')

@section('title', 'Backup de Base de Datos')
@section('page-title', 'Backup')
@section('page-title', 'Herramientas - Backup')

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href= "{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
    <span class="nav-label" style="margin-top: 16px;">Herramientas</span>
    <a href="{{ route('admin.backup') }}" class="nav-item {{ request()->routeIs('admin.backup*') ? 'active' : '' }}">
        <i class="fas fa-database"></i> Backup
    </a>
    <a href="{{ route('admin.audit') }}" class="nav-item {{ request()->routeIs('admin.audit') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> Auditoría
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="animate-fade-in">
    <div class="admin-header-master" style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);">
        <div class="admin-header-icon">
            <i class="fas fa-database"></i>
        </div>
        <div style="position: relative; z-index: 1;">
            <h1 class="admin-header-title">Backup de Base de Datos</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 16px; max-width: 500px;">Gestiona copias de seguridad de la base de datos. Los backups incluyen todas las tablas y datos.</p>
        </div>
    </div>

    <div style="padding: 24px;">
        <div style="margin-bottom: 24px;">
            <form action="{{ route('admin.backup.crear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-premium" style="background: var(--primary); color: white; border: none; padding: 14px 24px; border-radius: 12px; font-weight: 700; cursor: pointer;">
                    <i class="fas fa-plus" style="margin-right: 8px;"></i> Crear Nuevo Backup
                </button>
            </form>
        </div>

        @if(session('success'))
            <div style="padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="glass-card" style="background: white;">
            <div style="padding: 24px; border-bottom: 1px solid #e2e8f0;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin: 0;">
                    <i class="fas fa-folder-open" style="color: var(--primary); margin-right: 8px;"></i>
                    Backups Disponibles
                </h3>
            </div>

            @if(empty($backups))
                <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                    <i class="fas fa-database" style="font-size: 64px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p style="font-size: 16px; font-weight: 600;">No hay backups disponibles</p>
                    <p style="font-size: 14px;">Crea el primero usando el botón de arriba.</p>
                </div>
            @else
                <div class="premium-table-container">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Tamaño</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-archive" style="color: #3b82f6;"></i>
                                        </div>
                                        <span style="font-weight: 700; color: var(--text);">{{ $backup['nombre'] }}</span>
                                    </div>
                                </td>
                                <td style="color: var(--text-light); font-weight: 600;">{{ $backup['fecha']->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <span style="padding: 4px 12px; background: #f8fafc; border-radius: 20px; font-size: 12px; font-weight: 700; color: #64748b;">
                                        {{ number_format($backup['tamano'] / 1024, 2) }} KB
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('admin.backup.descargar', $backup['nombre']) }}" 
                                       class="btn-premium" style="width: 32px; height: 32px; padding: 0; justify-content: center; background: #dcfce7; color: #16a34a; box-shadow: none; border-radius: 8px;" title="Descargar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('admin.backup.eliminar', $backup['nombre']) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este backup?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-premium" style="width: 32px; height: 32px; padding: 0; justify-content: center; background: #fef2f2; color: #dc2626; box-shadow: none; border-radius: 8px; border: none; cursor: pointer;" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection