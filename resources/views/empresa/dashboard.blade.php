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
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase;">Portal Corporativo</span>
            <span style="color: var(--text-muted); font-size: 13px;">{{ now()->translatedFormat('l, d F') }}</span>
        </div>
        <h2 style="font-size:32px; font-weight:800; color: #1e293b; letter-spacing: -1px;">Bienvenido, {{ session('nombre') }} 🏢</h2>
        <p style="color: #64748b; font-size: 16px;">Gestiona el talento y supervisa el avance de tus proyectos patrocinados.</p>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
        <div class="glass-card stat-box-empresa" style="background: linear-gradient(135deg, #1e293b, #334155); color: white; border: none; padding: 32px;">
            <h3 style="font-size: 32px; font-weight: 800; margin-bottom: 4px;">{{ $totalProyectos }}</h3>
            <p style="font-size: 13px; color: rgba(255,255,255,0.7);">Proyectos creados</p>
        </div>
        <div class="glass-card stat-box-empresa" style="padding: 32px; border-left: 4px solid var(--primary);">
            <h3 style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 4px;">{{ $proyectosActivos }}</h3>
            <p style="font-size: 13px; color: #64748b;">En ejecución activa</p>
        </div>
        <div class="glass-card stat-box-empresa" style="padding: 32px;">
            <h3 style="font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 4px;">{{ $totalPostulaciones }}</h3>
            <p style="font-size: 13px; color: #64748b;">Total interesados</p>
        </div>
        <div class="glass-card stat-box-empresa" style="padding: 32px;">
            <h3 style="font-size: 32px; font-weight: 800; color: #f59e0b; margin-bottom: 4px;">{{ $postulacionesPendientes }}</h3>
            <p style="font-size: 13px; color: #64748b;">Nuevas solicitudes</p>
        </div>
    </div>

    <div class="glass-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b;">Resumen de Proyectos Recientes</h3>
            <a href="{{ route('empresa.proyectos.crear') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px;">
                <i class="fas fa-plus" style="margin-right: 8px;"></i> Publicar Nuevo
            </a>
        </div>
        <div style="padding: 12px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left;">
                        <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Título del Proyecto</th>
                        <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Categoría</th>
                        <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Estado</th>
                        <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Postulados</th>
                        <th style="padding: 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyectosRecientes as $p)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding: 16px;">
                                <div style="font-weight: 700; color: #1e293b;">{{ Str::limit($p->pro_titulo_proyecto, 40) }}</div>
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Publicado: {{ \Carbon\Carbon::parse($p->pro_fecha_publi)->format('d M, Y') }}</div>
                            </td>
                            <td style="padding: 16px;"><span style="font-size: 13px; color: #64748b;">{{ $p->pro_categoria }}</span></td>
                            <td style="padding: 16px;">
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; 
                                    {{ $p->pro_estado === 'Activo' || $p->pro_estado === 'Aprobado' ? 'background: #dcfce7; color: #166534;' : 'background: #fef9c3; color: #824b0e;' }}">
                                    {{ $p->pro_estado }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="font-weight: 800; color: #1e293b;">{{ $p->postulaciones_count }}</div>
                                    <div style="font-size: 11px; color: #94a3b8;">Aspirantes</div>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <a href="{{ route('empresa.proyectos') }}" style="color: var(--primary); font-size: 18px;"><i class="fas fa-arrow-circle-right"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 40px;">No has publicado proyectos todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .stat-box-empresa {
            transition: transform 0.3s ease;
        }
        .stat-box-empresa:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection