@extends('layouts.dashboard')
@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
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

@section('content')
    <div style="margin-bottom: 40px; animation: fadeIn 0.8s ease-out;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <div>
                <h2 style="font-size:32px; font-weight:800; letter-spacing: -1px; color: var(--text);">Portafolio de <span style="color: var(--primary);">Convocatorias</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px;">Evolución y seguimiento de tus proyectos estratégicos.</p>
            </div>
            <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium" style="padding: 14px 28px;">
                <i class="fas fa-plus-circle"></i> Nuevo Proyecto
            </a>
        </div>

        <!-- BENTO STATS FOR EMPRESA -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
            <div class="glass-card" style="padding: 28px; background: linear-gradient(135deg, var(--secondary) 0%, #1e293b 100%); color: white; border: none;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; line-height: 1;">{{ $proyectos->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; opacity: 0.8;">Total Publicados</div>
            </div>

            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #10b981; line-height: 1;">{{ $proyectos->where('pro_estado', 'Activo')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Convocatorias Activas</div>
            </div>

            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef3c7; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #f59e0b; line-height: 1;">{{ $proyectos->where('pro_estado', 'Pendiente')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">En Revisión Admin</div>
            </div>

            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div style="font-size: 32px; font-weight: 800; color: #ef4444; line-height: 1;">{{ $proyectos->where('pro_estado', 'Rechazado')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">No Aprobados</div>
            </div>
        </div>

        <div class="glass-card" style="padding: 0; overflow: hidden; background: white;">
            <div style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9; background: #fafafa; display: flex; align-items: center; gap: 16px;">
                 <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fas fa-list-check"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text);">Directorio de Gestión de Proyectos</h3>
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
                                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                             @if($proyecto->pro_evidencia_foto)
                                                <img src="{{ asset('storage/' . $proyecto->pro_evidencia_foto) }}" style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <i class="fas fa-rocket" style="color: var(--text-lighter); font-size: 20px;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: var(--text); font-size: 15px;">{{ Str::limit($proyecto->pro_titulo_proyecto, 40) }}</div>
                                            <div style="font-size: 12px; color: var(--text-lighter); font-weight: 600;">ID: PROJ-{{ str_pad($proyecto->pro_id, 4, '0', STR_PAD_LEFT) }}</div>
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
                                        $statusStyles = match($proyecto->pro_estado) {
                                            'Activo' => ['bg' => '#d1fae5', 'color' => '#065f46', 'icon' => 'fa-check-circle'],
                                            'Pendiente' => ['bg' => '#fef3c7', 'color' => '#92400e', 'icon' => 'fa-clock'],
                                            'Rechazado' => ['bg' => '#fee2e2', 'color' => '#991b1b', 'icon' => 'fa-times-circle'],
                                            default => ['bg' => '#f1f5f9', 'color' => '#475569', 'icon' => 'fa-info-circle']
                                        };
                                    @endphp
                                    <span style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }}; padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fas {{ $statusStyles['icon'] }}" style="font-size: 10px;"></i>
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
                                        <a href="{{ route('empresa.postulantes', $proyecto->pro_id) }}" class="btn-premium" style="width: 38px; height: 38px; padding: 0; justify-content: center; background: white; color: var(--primary); border: 1px solid var(--primary-soft); box-shadow: none;" title="Ver Postulantes">
                                            <i class="fas fa-users-viewfinder"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('empresa.proyectos.edit', $proyecto->pro_id) }}" class="btn-premium" style="width: 38px; height: 38px; padding: 0; justify-content: center; background: white; color: var(--text); border: 1px solid #e2e8f0; box-shadow: none;" title="Editar">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('empresa.proyectos.destroy', $proyecto->pro_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este proyecto permanentemente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-premium" style="width: 38px; height: 38px; padding: 0; justify-content: center; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; box-shadow: none;" title="Eliminar">
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

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection
