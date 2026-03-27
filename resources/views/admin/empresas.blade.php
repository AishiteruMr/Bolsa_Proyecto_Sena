@extends('layouts.dashboard')

@section('title', 'Empresas Aliadas - Admin')
@section('page-title', 'Directorio de Empresas')

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

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection
@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-page-header">
            <div>
                <h2 class="admin-title-main">Ecosistema de <span style="color: var(--primary);">Empresas</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px; font-weight: 500;">Gestión y supervisión de organizaciones aliadas al SENA.</p>
            </div>
        </div>

        <!-- BENTO STATS -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid var(--primary);">
                <div class="admin-stat-icon" style="background: var(--primary-soft); color: var(--primary);">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Total Aliados</div>
                    <div class="admin-stat-value">{{ $empresas->count() }}</div>
                </div>
            </div>
            
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid var(--primary-hover);">
                <div class="admin-stat-icon" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); color: #fff;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Empresas Activas</div>
                    <div class="admin-stat-value" style="color: var(--primary-hover);">{{ $empresas->where('emp_estado', 1)->count() }}</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid #f97316;">
                <div class="admin-stat-icon" style="background: #fff7ed; color: #f97316;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="admin-stat-label">En Espera</div>
                    <div class="admin-stat-value" style="color: #f97316;">{{ $empresas->where('emp_estado', 0)->count() }}</div>
                </div>
            </div>
        </div>

        <div class="glass-card admin-table-card">
            <div class="admin-table-header">
                <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <span class="admin-stat-icon" style="width: 36px; height: 36px; background: var(--primary-soft); color: var(--primary); font-size: 16px;">
                        <i class="fas fa-list-check"></i>
                    </span>
                    Directorio Corporativo
                </h3>
            </div>
            
            <div class="premium-table-container">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Identificación (NIT)</th>
                            <th>Razón Social</th>
                            <th>Representante Legal</th>
                            <th>Contacto</th>
                            <th>Estado</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($empresas as $e)
                            <tr>
                                <td style="font-weight: 800; color: var(--primary);">{{ $e->emp_nit }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-building" style="color: var(--text-light); font-size: 14px;"></i>
                                        </div>
                                        <div style="font-weight: 800; color: var(--text);">{{ $e->emp_nombre }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--text-light); font-size: 14px;">
                                        <i class="far fa-user-circle" style="margin-right: 6px; opacity: 0.5;"></i>
                                        {{ $e->emp_representante }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 13px; color: var(--text-light); font-weight: 600;">
                                        <i class="far fa-envelope" style="margin-right: 6px; opacity: 0.5;"></i>
                                        {{ $e->emp_correo }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $e->emp_estado == 1 ? 'active' : 'inactive' }}" style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800;">
                                        {{ $e->emp_estado == 1 ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.empresas.estado', $e->emp_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="estado" value="{{ $e->emp_estado == 1 ? 0 : 1 }}">
                                        <button type="submit" class="btn-premium" style="padding: 10px 16px; font-size: 11px; background: {{ $e->emp_estado == 1 ? '#f8fafc' : 'var(--primary)' }}; color: {{ $e->emp_estado == 1 ? '#64748b' : 'white' }}; border: {{ $e->emp_estado == 1 ? '1px solid #e2e8f0' : 'none' }}; box-shadow: none;">
                                            <i class="fas {{ $e->emp_estado == 1 ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                            {{ $e->emp_estado == 1 ? 'Inhabilitar' : 'Habilitar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 80px; color: var(--text-light);">
                                    <i class="fas fa-building-circle-exclamation" style="font-size: 48px; margin-bottom: 16px; opacity: 0.2;"></i>
                                    <div style="font-size: 16px; font-weight: 800; color: var(--text);">No se han encontrado empresas registradas</div>
                                    <div style="font-size: 14px; margin-top: 4px; font-weight: 500;">Las nuevas inscripciones aparecerán en esta tabla automáticamente.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
