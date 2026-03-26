@extends('layouts.dashboard')
@section('title', 'Dashboard Empresa')
@section('page-title', 'Panel Empresa')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}"
        class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i>
        Dashboard</a>
    <a href="{{ route('empresa.proyectos') }}"
        class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}"><i
            class="fas fa-project-diagram"></i> Mis Proyectos</a>
    <a href="{{ route('empresa.proyectos.crear') }}"
        class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}"><i
            class="fas fa-plus-circle"></i> Publicar Proyecto</a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}"><i
            class="fas fa-building"></i> Perfil Empresa</a>
@endsection

@section('content')
    <div style="margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <span style="background: linear-gradient(135deg, #3EB489, #2d9a6f); color: white; padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; box-shadow: 0 4px 12px rgba(62, 180, 137, 0.3);">
                <i class="fas fa-building" style="margin-right: 6px;"></i>Portal Corporativo
            </span>
            <span style="color: var(--text-muted); font-size: 13px;">{{ now()->translatedFormat('l, d F') }}</span>
        </div>
        <h2 style="font-size:32px; font-weight:800; color: #1e293b; letter-spacing: -1px;">
            Bienvenido, <span style="color: #3EB489;">{{ session('nombre') }}</span> <i class="fas fa-hand-sparkles" style="font-size: 24px;"></i>
        </h2>
        <p style="color: #64748b; font-size: 16px; margin-top: 8px;">Gestiona el talento y supervisa el avance de tus proyectos patrocinados.</p>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
        <div style="background: linear-gradient(135deg, #1e293b, #334155); border-radius: 20px; padding: 28px; color: white; box-shadow: 0 12px 32px rgba(30, 41, 59, 0.25); position: relative; overflow: hidden;">
            <div style="position: absolute; right: -20px; top: -20px; width: 80px; height: 80px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
            <div style="font-size: 13px; opacity: 0.8; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-folder-plus"></i> Proyectos Creados
            </div>
            <div style="font-size: 36px; font-weight: 800;">{{ $totalProyectos }}</div>
            <div style="font-size: 11px; opacity: 0.6; margin-top: 8px;">Total publicados</div>
        </div>
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.04); position: relative;">
            <div style="position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i>
            </div>
            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">En Ejecución</div>
            <div style="font-size: 36px; font-weight: 800; color: #10b981;">{{ $proyectosActivos }}</div>
            <div style="font-size: 11px; color: #94a3b8; margin-top: 8px;">Proyectos activos</div>
        </div>
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.04); position: relative;">
            <div style="position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-users" style="color: #3b82f6; font-size: 18px;"></i>
            </div>
            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Total Interesados</div>
            <div style="font-size: 36px; font-weight: 800; color: #3b82f6;">{{ $totalPostulaciones }}</div>
            <div style="font-size: 11px; color: #94a3b8; margin-top: 8px;">Postulaciones recibidas</div>
        </div>
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.04); position: relative;">
            <div style="position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-clock" style="color: #f59e0b; font-size: 18px;"></i>
            </div>
            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Nuevas Solicitudes</div>
            <div style="font-size: 36px; font-weight: 800; color: #f59e0b;">{{ $postulacionesPendientes }}</div>
            <div style="font-size: 11px; color: #94a3b8; margin-top: 8px;">Pendientes de revisión</div>
        </div>
    </div>

    <div class="glass-card" style="border-radius: 24px; overflow: hidden; border: 1px solid rgba(255,255,255,0.5);">
        <div style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(to right, #f8fafc, #fff);">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: linear-gradient(135deg, #3EB489, #2d9a6f); border-radius: 12px;">
                    <i class="fas fa-chart-line" style="color: white; font-size: 16px;"></i>
                </span>
                Resumen de Proyectos Recientes
            </h3>
            <a href="{{ route('empresa.proyectos.crear') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #3EB489, #2d9a6f); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 13px; box-shadow: 0 4px 12px rgba(62, 180, 137, 0.25);">
                <i class="fas fa-plus"></i> Publicar Nuevo
            </a>
        </div>
        <div style="padding: 8px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left;">
                        <th style="padding: 18px 20px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Título del Proyecto</th>
                        <th style="padding: 18px 20px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Categoría</th>
                        <th style="padding: 18px 20px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Estado</th>
                        <th style="padding: 18px 20px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Postulados</th>
                        <th style="padding: 18px 20px; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyectosRecientes as $p)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding: 18px 20px;">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #e0f2e9, #d1ede5); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-briefcase" style="color: #3EB489; font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b;">{{ Str::limit($p->pro_titulo_proyecto, 35) }}</div>
                                        <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Publicado: {{ \Carbon\Carbon::parse($p->pro_fecha_publi)->format('d M, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 18px 20px;">
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; background: #f1f5f9; color: #64748b;">
                                    {{ $p->pro_categoria }}
                                </span>
                            </td>
                            <td style="padding: 18px 20px;">
                                <span style="padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 600; 
                                    {{ $p->pro_estado === 'Activo' || $p->pro_estado === 'Aprobado' ? 'background: #d1fae5; color: #065f46;' : 'background: #fef3c7; color: #92400e;' }}">
                                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; margin-right: 6px; background: currentColor;"></span>
                                    {{ $p->pro_estado }}
                                </span>
                            </td>
                            <td style="padding: 18px 20px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user-graduate" style="color: #6366f1; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 800; color: #1e293b; font-size: 15px;">{{ $p->postulaciones_count }}</div>
                                        <div style="font-size: 10px; color: #94a3b8;">Aspirantes</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 18px 20px;">
                                <a href="{{ route('empresa.proyectos') }}" style="color: #3EB489; font-size: 18px; transition: transform 0.2s;" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 60px;">
                                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-folder-open" style="font-size: 32px; color: #94a3b8;"></i>
                                </div>
                                <div style="font-size: 16px; font-weight: 600; color: #64748b; margin-bottom: 8px;">No has publicado proyectos todavía</div>
                                <div style="font-size: 13px; color: #94a3b8; margin-bottom: 20px;">Crea tu primer proyecto para comenzar a recibir postulaciones</div>
                                <a href="{{ route('empresa.proyectos.crear') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #3EB489, #2d9a6f); color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600;">
                                    <i class="fas fa-plus"></i> Publicar Proyecto
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        }
    </style>
@endsection