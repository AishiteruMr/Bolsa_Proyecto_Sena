@extends('layouts.dashboard')

@section('title', 'Panel Administrador')
@section('page-title', 'Panel de Administración')

    <!-- SIDEBAR CUSTOM -->
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
    <div style="margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Admin Hub</span>
            <span style="color: var(--text-muted); font-size: 13px;">{{ now()->format('l, d F Y') }}</span>
        </div>
        <h2 style="font-size:36px; font-weight:800; color: #1e293b; letter-spacing: -1px;">Centro de Control Maestro</h2>
        <p style="color: #64748b; font-size: 16px;">Supervisión global de la ecosistema Inspírate SENA.</p>
    </div>

    <!-- BENTO STATS -->
    <div class="bento-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
        <div class="glass-card stat-box" style="background: linear-gradient(135deg, #0f766e, #115e59); color: white; border: none;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <span style="font-size: 11px; font-weight: 700; background: rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 20px;">Total Proyectos</span>
            </div>
            <h3 style="font-size: 32px; font-weight: 800;">{{ $stats['proyectos'] }}</h3>
            <p style="font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 4px;">{{ $stats['pendientes'] }} pendientes de revisión</p>
        </div>

        <div class="glass-card stat-box">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #f0fdf4; color: #166534; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>
            <h3 style="font-size: 32px; font-weight: 800; color: #1e293b;">{{ $stats['usuarios'] }}</h3>
            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Usuarios registrados</p>
        </div>

        <div class="glass-card stat-box">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; color: #1e40af; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <h3 style="font-size: 32px; font-weight: 800; color: #1e293b;">{{ $stats['empresas'] }}</h3>
            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Empresas vinculadas</p>
        </div>

        <div class="glass-card stat-box">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #fff7ed; color: #9a3412; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <h3 style="font-size: 32px; font-weight: 800; color: #1e293b;">{{ $stats['aprendices'] }}</h3>
            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Aprendices activos</p>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        
        <!-- Recientes Card -->
        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size:18px; font-weight:700; color: #1e293b;">Actividad Reciente en Proyectos</h3>
                <a href="{{ route('admin.proyectos') }}" style="font-size: 13px; font-weight: 700; color: var(--primary); text-decoration: none;">Gestionar todos <i class="fas fa-arrow-right"></i></a>
            </div>
            <div style="padding: 12px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Proyecto</th>
                            <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Empresa</th>
                            <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyectosRecientes as $p)
                            <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 16px; font-weight: 600; color: #1e293b;">{{ Str::limit($p->pro_titulo_proyecto, 30) }}</td>
                                <td style="padding: 16px; color: #64748b; font-size: 14px;">{{ $p->emp_nombre }}</td>
                                <td style="padding: 16px;">
                                    <span style="padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; 
                                        {{ $p->pro_estado == 'Activo' ? 'background: #dcfce7; color: #166534;' : 'background: #fef9c3; color: #854d0e;' }}">
                                        {{ $p->pro_estado }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Usuarios Card -->
        <div class="glass-card" style="padding: 32px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 24px;">Nuevos Usuarios</h3>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($usuariosRecientes as $u)
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #475569; font-weight: 700;">
                            {{ strtoupper(substr($u->usr_correo, 0, 1)) }}
                        </div>
                        <div style="flex: 1; overflow: hidden;">
                            <p style="font-size: 14px; font-weight: 700; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $u->usr_correo }}</p>
                            <p style="font-size: 12px; color: #64748b;">{{ $u->nombre_rol }}</p>
                        </div>
                        <span style="font-size: 11px; color: #94a3b8; font-weight: 600;">{{ \Carbon\Carbon::parse($u->usr_fecha_creacion)->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('admin.usuarios') }}" class="btn btn-primary" style="margin-top: 32px; width: 100%; justify-content: center; padding: 12px; border-radius: 12px; background: #1e293b;">Administrar Usuarios</a>
        </div>

        <!-- Quick Actions -->
        <div class="glass-card" style="padding: 32px; grid-column: 1 / -1;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 24px;">Acciones Rápidas</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                <a href="{{ route('admin.proyectos.exportar') }}" class="btn btn-outline" style="text-align: center; justify-content: center; padding: 20px;">
                    <i class="fas fa-file-csv" style="margin-right: 8px;"></i> Exportar Proyectos
                </a>
                <a href="{{ route('admin.usuarios') }}" class="btn btn-outline" style="text-align: center; justify-content: center; padding: 20px;">
                    <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Revisar Usuarios
                </a>
                <a href="{{ route('admin.empresas') }}" class="btn btn-outline" style="text-align: center; justify-content: center; padding: 20px;">
                    <i class="fas fa-building" style="margin-right: 8px;"></i> Gestionar Empresas
                </a>
                <a href="{{ route('notificaciones.index') }}" class="btn btn-outline" style="text-align: center; justify-content: center; padding: 20px;">
                    <i class="fas fa-bell" style="margin-right: 8px;"></i> Ver Mis Alertas
                </a>
            </div>
        </div>
    </div>

    <style>
        .stat-box {
            padding: 32px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);
        }
    </style>
@endsection