@extends('layouts.dashboard')
@section('title', 'Dashboard Empresa')
@section('page-title', 'Panel Empresa')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
@endsection

@section('content')
    <div class="animate-fade-in">
        <!-- HEADER CORPORATIVO -->
        <div class="empresa-hero">
            <div class="empresa-hero-bg-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="empresa-hero-content">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="empresa-badge-portal">Portal Corporativo</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 600;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F') }}</span>
                </div>
                <h1 class="empresa-hero-title">Panel de Control <span style="color: var(--primary);">{{ session('nombre') }}</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 650px; line-height: 1.6;">Impulsa la innovación y conecta con el mejor talento del SENA gestionando tus proyectos estratégicos.</p>
            </div>
        </div>

        <!-- BENTO STATS GRID -->
        <div class="empresa-stats-grid">
            <div class="glass-card empresa-stat-card">
                <div class="empresa-stat-icon" style="background: var(--primary-soft); color: var(--primary);">
                    <i class="fas fa-folder-plus"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; color: var(--text); line-height: 1;">{{ $totalProyectos }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Proyectos Totales</div>
            </div>

            <div class="glass-card empresa-stat-card">
                <div class="empresa-stat-icon" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); color: #fff;">
                    <i class="fas fa-check-double"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; color: var(--primary-hover); line-height: 1;">{{ $proyectosActivos }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">En Ejecución</div>
            </div>

            <div class="glass-card empresa-stat-card">
                <div class="empresa-stat-icon" style="background: #eff6ff; color: #3b82f6;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; color: #3b82f6; line-height: 1;">{{ $totalPostulaciones }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Postulaciones</div>
            </div>

            <div class="glass-card empresa-stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: white;">
                <div class="empresa-stat-icon" style="background: rgba(255,255,255,0.2);">
                    <i class="fas fa-clock"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; line-height: 1;">{{ $postulacionesPendientes }}</div>
                <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; opacity: 0.9;">Pendientes de Revisión</div>
            </div>
        </div>

        <!-- RECENT PROJECTS TABLE -->
        <div class="glass-card admin-table-card">
            <div class="admin-table-header">
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 14px;">
                    <span style="width: 42px; height: 42px; border-radius: 12px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-list-ul"></i>
                    </span>
                    Proyectos Publicados Recientemente
                </h3>
                <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">
                    <i class="fas fa-plus-circle"></i> Nueva Oferta
                </a>
            </div>
            
            <div class="premium-table-container" style="border: none; box-shadow: none;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Identificador y Título</th>
                            <th>Categoría</th>
                            <th>Estado Actual</th>
                            <th>Métricas de Interés</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proyectosRecientes as $p)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <div class="empresa-project-img">
                                            @if($p->pro_evidencia_foto)
                                                <img src="{{ asset('storage/' . $p->pro_evidencia_foto) }}">
                                            @else
                                                <i class="fas fa-briefcase" style="color: var(--text-lighter);"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text);">{{ Str::limit($p->pro_titulo_proyecto, 40) }}</div>
                                            <div style="font-size: 12px; color: var(--text-lighter); font-weight: 500;">
                                                Expira: {{ \Carbon\Carbon::parse($p->pro_fecha_finalizacion)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="background: #f1f5f9; color: var(--text-light); padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                        {{ $p->pro_categoria }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'Activo' => 'active',
                                            'Pendiente' => 'pending',
                                            'Finalizado' => 'inactive',
                                            'Rechazado' => 'inactive',
                                        ][$p->pro_estado] ?? 'inactive';
                                    @endphp
                                    <span class="empresa-status-badge status-badge {{ $statusClass }}">
                                        <span class="status-dot"></span>
                                        {{ $p->pro_estado }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="display: flex; -webkit-mask-image: linear-gradient(to right, black 70%, transparent);">
                                            @foreach($p->postulaciones->take(3) as $post)
                                                <div class="empresa-aprendiz-avatar">
                                                    {{ substr($post->aprendiz->apr_nombre ?? 'A', 0, 1) }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <span style="font-weight: 800; color: var(--text); font-size: 14px;">{{ $p->postulaciones_count }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('empresa.proyectos') }}" class="empresa-action-btn" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 80px;">
                                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-size: 32px; color: var(--text-lighter); margin: 0 auto 24px;">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 8px;">No has publicado proyectos aún</h4>
                                    <p style="color: var(--text-light); margin-bottom: 24px; font-weight: 500;">Comienza ahora y conecta con el mejor talento técnico y tecnológico.</p>
                                    <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">Publicar Primer Proyecto</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
