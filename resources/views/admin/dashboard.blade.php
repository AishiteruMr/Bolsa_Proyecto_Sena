@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Página Principal')

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
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
@endsection

@section('content')
    <div class="animate-fade-in">
        <!-- HEADER MAESTRO -->
        <div class="admin-header-master">
            <div class="admin-header-icon">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="admin-badge-hub">Admin Control Hub</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="admin-header-title">Gestión Estratégica <span style="color: var(--primary);">Global</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 600px; font-weight: 500;">Control unificado sobre el banco de proyectos y el talento humano del ecosistema Sena.</p>
            </div>
        </div>

        <!-- BENTO ADMIN STATS -->
        <div class="admin-stats-grid">
            <div class="stat-card-premium" style="padding: 28px; background: white; border-color: var(--primary-soft);">
                <div class="admin-stat-icon" style="background: var(--primary-soft); color: var(--primary); margin-bottom: 24px;">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px;">{{ $stats['proyectos'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Banco de Proyectos</div>
                <div class="inline-pill inline-pill--warning" style="margin-top:16px; width:fit-content;">
                    <i class="fas fa-clock-rotate-left"></i> {{ $stats['pendientes'] }} Pendientes
                </div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #f8fafc; color: #64748b; margin-bottom: 24px;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px;">{{ $stats['usuarios'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Cuentas Activas</div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #eff6ff; color: #3b82f6; margin-bottom: 24px;">
                    <i class="fas fa-building"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #2563eb;">{{ $stats['empresas'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Aliados Corporativos</div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #fdf2f8; color: #db2777; margin-bottom: 24px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #db2777;">{{ $stats['aprendices'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Comunidad Aprendiz</div>
            </div>
        </div>

        <div class="admin-main-grid">
            <!-- ACTIVIDAD RECIENTE -->
            <div class="glass-card admin-table-card" style="background: white;">
                <div class="admin-table-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">Proyectos por Auditar</h3>
                    <a href="{{ route('admin.proyectos') }}" class="btn-premium" style="padding: 8px 16px; font-size: 11px; background: #f8fafc; color: var(--primary); border: 1px solid var(--primary-soft); box-shadow: none;">Ir al Banco</a>
                </div>
                <div class="premium-table-container">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Proyecto</th>
                                <th>Empresa Origen</th>
                                <th>Estado</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proyectosRecientes as $p)
                                <tr>
                                    <td style="font-weight: 800; color: var(--text);">{{ Str::limit($p->pro_titulo_proyecto, 40) }}</td>
                                    <td style="color: var(--text-light); font-weight: 600;">{{ $p->emp_nombre }}</td>
                                    <td>
                                        <span class="status-badge {{ $p->pro_estado == 'Activo' ? 'active' : 'inactive' }}" style="padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800;">
                                            {{ $p->pro_estado }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('admin.proyectos.revisar', $p->pro_id) }}" class="btn-premium" style="width: 32px; height: 32px; padding: 0; justify-content: center; background: var(--primary-soft); color: var(--primary); box-shadow: none; border-radius: 8px;">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; padding: 40px; color: var(--text-lighter); font-weight: 600;">No hay proyectos pendientes.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- NUEVAS REGISTRACIONES -->
            <div class="glass-card" style="padding: 32px; background: white;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 28px;">Incorporaciones</h3>
                <div class="user-incorporation-list">
                    @foreach($usuariosRecientes as $u)
                        <div class="user-incorporation-item">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-weight: 800; font-size: 16px; border: 1px solid #dbeafe;">
                                {{ strtoupper(substr($u->usr_correo, 0, 1)) }}
                            </div>
                            <div style="flex: 1; overflow: hidden;">
                                <p style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $u->usr_correo }}</p>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 10px; font-weight: 800; color: var(--primary); text-transform: uppercase;">{{ $u->nombre_rol }}</span>
                                    <span style="width: 3px; height: 3px; background: #cbd5e1; border-radius: 50%;"></span>
                                    <span style="font-size: 10px; color: #94a3b8; font-weight: 600;">{{ \Carbon\Carbon::parse($u->usr_fecha_creacion)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.usuarios') }}" class="btn-premium" style="margin-top: 32px; width: 100%; text-align: center; justify-content: center; background: #0f172a; border: none; font-size: 13px; padding: 14px;">
                    Gestionar Usuarios <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
