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
    <div style="animation: fadeIn 0.8s ease-out;">
        <!-- HEADER MAESTRO -->
        <div style="background: linear-gradient(135deg, #0f172a, #1e293b); padding: 48px; border-radius: var(--radius-lg); margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: var(--shadow-premium);">
            <div style="position: absolute; right: -20px; bottom: -20px; font-size: 200px; color: rgba(62,180,137,0.05); transform: rotate(-10deg); pointer-events: none;">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                    <span style="background: var(--primary); color: white; padding: 6px 16px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;">Admin Master Hub</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 600;"><i class="far fa-clock" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 style="font-size: 44px; font-weight: 800; color: white; margin-bottom: 8px; letter-spacing: -1.5px;">Gestión Estratégica <span style="color: var(--primary);">Global</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 600px;">Control total sobre el ecosistema de innovación y talento del SENA.</p>
            </div>
        </div>

        <!-- BENTO ADMIN STATS -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 48px;">
            <div class="glass-card" style="padding: 32px; background: white; border-color: var(--primary-soft);">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div style="font-size: 36px; font-weight: 800; color: var(--text); line-height: 1;">{{ $stats['proyectos'] }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Banco de Proyectos</div>
                <div style="margin-top: 12px; font-size: 12px; color: #f59e0b; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $stats['pendientes'] }} por revisar
                </div>
            </div>

            <div class="glass-card" style="padding: 32px; background: white;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div style="font-size: 36px; font-weight: 800; color: var(--text); line-height: 1;">{{ $stats['usuarios'] }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Cuentas Activas</div>
            </div>

            <div class="glass-card" style="padding: 32px; background: white;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-building"></i>
                </div>
                <div style="font-size: 36px; font-weight: 800; color: #3b82f6; line-height: 1;">{{ $stats['empresas'] }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Aliados Corporativos</div>
            </div>

            <div class="glass-card" style="padding: 32px; background: white;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #fdf2f8; color: #db2777; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div style="font-size: 36px; font-weight: 800; color: #db2777; line-height: 1;">{{ $stats['aprendices'] }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Comunidad Aprendiz</div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 32px;">
            <!-- ACTIVIDAD RECIENTE -->
            <div class="glass-card" style="padding: 0; background: white; overflow: hidden;">
                <div style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 20px; font-weight: 800; color: var(--text);">Proyectos Pendientes de Revisión</h3>
                    <a href="{{ route('admin.proyectos') }}" class="btn-premium" style="padding: 8px 16px; font-size: 12px;">Auditar Banco</a>
                </div>
                <div class="premium-table-container" style="border:none; box-shadow: none;">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Proyecto</th>
                                <th>Empresa Origen</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proyectosRecientes as $p)
                                <tr>
                                    <td style="font-weight: 700;">{{ Str::limit($p->pro_titulo_proyecto, 35) }}</td>
                                    <td style="color: var(--text-light);">{{ $p->emp_nombre }}</td>
                                    <td>
                                        <span style="padding: 6px 12px; border-radius: 30px; font-size: 11px; font-weight: 800; 
                                            {{ $p->pro_estado == 'Activo' ? 'background: #dcfce7; color: #166534;' : 'background: #fef9c3; color: #854d0e;' }}">
                                            {{ $p->pro_estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.proyectos') }}" style="color: var(--primary); font-size: 18px;"><i class="fas fa-chevron-circle-right"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- NUEVAS REGISTRACIONES -->
            <div class="glass-card" style="padding: 32px; background: white;">
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 28px;">Nuevas Incorporaciones</h3>
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    @foreach($usuariosRecientes as $u)
                        <div style="display: flex; align-items: center; gap: 16px; padding: 12px; border-radius: 16px; transition: all 0.3s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #475569; font-weight: 800; font-size: 16px;">
                                {{ strtoupper(substr($u->usr_correo, 0, 1)) }}
                            </div>
                            <div style="flex: 1; overflow: hidden;">
                                <p style="font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 2px;">{{ $u->usr_correo }}</p>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.5px;">{{ $u->nombre_rol }}</span>
                                    <span style="width: 3px; height: 3px; background: #cbd5e1; border-radius: 50%;"></span>
                                    <span style="font-size: 11px; color: #94a3b8;">{{ \Carbon\Carbon::parse($u->usr_fecha_creacion)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.usuarios') }}" class="btn-premium" style="margin-top: 32px; width: 100%; text-align: center; justify-content: center; background: #1e293b;">
                    Control de Usuarios <i class="fas fa-users-cog" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection
