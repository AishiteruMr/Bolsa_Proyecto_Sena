@extends('layouts.dashboard')
@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')

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
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
@endsection

@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-page-header">
            <div>
                <h2 class="admin-title-main">Portafolio de <span style="color: var(--primary);">Convocatorias</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px;">Evolución y seguimiento de tus proyectos estratégicos.</p>
            </div>
            <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium" style="padding: 14px 28px;">
                <i class="fas fa-plus-circle"></i> Nuevo Proyecto
            </a>
        </div>

        <!-- BENTO STATS FOR EMPRESA -->
        <div class="empresa-stats-grid">
            <div class="glass-card empresa-stat-card-dark">
                <div class="empresa-stat-icon-circle" style="background: rgba(255,255,255,0.1);">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; line-height: 1;">{{ $proyectos->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; opacity: 0.8;">Total Publicados</div>
            </div>

            <div class="glass-card empresa-stat-card-mini">
                <div class="empresa-stat-icon-circle" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); color: #fff;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: var(--primary-hover); line-height: 1;">{{ $proyectos->where('pro_estado', 'Activo')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Convocatorias Activas</div>
            </div>

            <div class="glass-card empresa-stat-card-mini">
                <div class="empresa-stat-icon-circle" style="background: #fef3c7; color: #f59e0b;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #f59e0b; line-height: 1;">{{ $proyectos->where('pro_estado', 'Pendiente')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">En Revisión Admin</div>
            </div>

            <div class="glass-card empresa-stat-card-mini">
                <div class="empresa-stat-icon-circle" style="background: #fee2e2; color: #ef4444;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #ef4444; line-height: 1;">{{ $proyectos->where('pro_estado', 'Rechazado')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">No Aprobados</div>
            </div>
        </div>

        <div class="glass-card admin-table-card">
            <div class="admin-table-header">
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 16px;">
                    <span class="empresa-table-header-icon">
                        <i class="fas fa-list-check"></i>
                    </span>
                    Directorio de Gestión de Proyectos
                </h3>
            </div>
            
            @if($proyectos->isNotEmpty())
            <div class="premium-table-container" style="border: none; box-shadow: none;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Información del Proyecto</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Tiempo Estimado</th>
                            <th>Publicación</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyectos as $proyecto)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <div class="empresa-project-img" style="width: 52px; height: 52px; border-radius: 14px;">
                                             @if($proyecto->pro_evidencia_foto)
                                                <img src="{{ asset('storage/' . $proyecto->pro_evidencia_foto) }}">
                                            @else
                                                <i class="fas fa-rocket" style="color: var(--text-lighter); font-size: 20px;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: var(--text); font-size: 15px;">{{ Str::limit($proyecto->pro_titulo_proyecto, 40) }}</div>
                                            <div class="empresa-project-id">ID: PROJ-{{ str_pad($proyecto->pro_id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="background: rgba(241, 245, 249, 0.8); color: #475569; padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase; border: 1px solid #e2e8f0;">
                                        {{ $proyecto->pro_category }} {{ $proyecto->pro_categoria }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($proyecto->pro_estado) {
                                            'Activo' => 'active',
                                            'Pendiente' => 'pending',
                                            'Rechazado' => 'inactive',
                                            default => 'inactive'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $proyecto->pro_estado }}
                                    </span>
                                </td>
                                <td style="font-weight: 700; color: var(--text-light); font-size: 14px;">
                                    <i class="far fa-hourglass" style="margin-right: 6px; color: var(--primary);"></i>
                                    {{ $proyecto->pro_duracion_estimada }} días
                                </td>
                                <td style="color: var(--text-lighter); font-size: 13px; font-weight: 600;">
                                    <i class="far fa-calendar-alt" style="margin-right: 6px;"></i>
                                    {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->translatedFormat('d M, Y') }}
                                </td>
                                <td>
                                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                        @if($proyecto->pro_estado == 'Activo')
                                        <a href="{{ route('empresa.proyectos.postulantes', $proyecto->pro_id) }}" class="empresa-action-btn" title="Ver Postulantes">
                                            <i class="fas fa-users-viewfinder"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('empresa.proyectos.edit', $proyecto->pro_id) }}" class="empresa-action-btn" title="Editar">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('empresa.proyectos.destroy', $proyecto->pro_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este proyecto permanentemente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="empresa-action-btn" style="color: #e11d48;" title="Eliminar">
                                                <i class="fas fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div style="text-align: center; padding: 100px 40px;">
                <div style="width: 100px; height: 100px; margin: 0 auto 24px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                    <i class="fas fa-folder-open" style="font-size: 40px;"></i>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 8px;">Aún no tienes convocatorias</h3>
                <p style="color: var(--text-light); font-size: 16px; margin-bottom: 32px;">Inicia hoy mismo publicando tu primer proyecto para atraer el talento que necesitas.</p>
                <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium" style="padding: 16px 32px;">
                    <i class="fas fa-rocket"></i> Empezar Ahora
                </a>
            </div>
            @endif
        </div>
    </div>

@endsection
