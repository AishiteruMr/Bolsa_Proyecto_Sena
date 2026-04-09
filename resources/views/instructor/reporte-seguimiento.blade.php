@extends('layouts.dashboard')

@section('title', 'Reporte de Seguimiento | ' . $proyecto->titulo)
@section('page-title', 'Reporte de Seguimiento')

@section('sidebar-nav')
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('instructor.aprendices') }}" class="nav-item {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('instructor.proyecto.detalle', $proyecto->id) }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Volver a la Gestión
                </a>
            </div>
            <h2 style="font-size:28px; font-weight:800; color:var(--primary-hover)">Auditoría de Progreso</h2>
            <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Análisis detallado para: <span style="color: var(--primary); font-weight: 700;">{{ $proyecto->titulo }}</span></p>
        </div>
        <button onclick="window.print()" class="btn-ver" style="background: #64748b; padding: 10px 24px; border-radius: 12px; width: auto;">
            <i class="fas fa-print" style="margin-right: 8px;"></i> Exportar PDF
        </button>
    </div>

    <!-- Analytics Bento Grid -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">
        <div class="glass-card stat-card-rep" style="--c: #3b82f6;">
            <div class="stat-icon-rep"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-info-rep">
                <p class="stat-value-rep">{{ $aprendices->count() }}</p>
                <p class="stat-label-rep">Aprendices</p>
            </div>
        </div>
        <div class="glass-card stat-card-rep" style="--c: #10b981;">
            <div class="stat-icon-rep"><i class="fas fa-cloud-upload-alt"></i></div>
            <div class="stat-info-rep">
                <p class="stat-value-rep">{{ $entregas->count() }}</p>
                <p class="stat-label-rep">Entregables</p>
            </div>
        </div>
        <div class="glass-card stat-card-rep" style="--c: #f59e0b;">
            <div class="stat-icon-rep"><i class="fas fa-award"></i></div>
            <div class="stat-info-rep">
                <p class="stat-value-rep">{{ $evidencias->where('estado', 'aceptada')->count() }}</p>
                <p class="stat-label-rep">Aprobados</p>
            </div>
        </div>
        <div class="glass-card stat-card-rep" style="--c: #8b5cf6;">
            <div class="stat-icon-rep"><i class="fas fa-tasks"></i></div>
            <div class="stat-info-rep">
                <p class="stat-value-rep">{{ $etapas->count() }}</p>
                <p class="stat-label-rep">Etapas</p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 2.5rem; align-items: start;">
        
        <div style="display: flex; flex-direction: column; gap: 2.5rem;">
            <!-- Apprentice Management Table -->
            <div class="glass-card" style="padding: 2.5rem; border-top: 5px solid #3b82f6; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.1); border-radius: 20px;">
                <h3 style="font-size: 1.4rem; font-weight: 900; color: var(--text-main); margin-bottom: 2rem; display: flex; align-items: center; gap: 15px;">
                    <span style="background: rgba(59, 130, 246, 0.1); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 14px; color: #3b82f6;">
                        <i class="fas fa-chart-line" style="font-size: 1.2rem;"></i> 
                    </span>
                    Matriz de Rendimiento Global
                </h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                        <thead>
                            <tr style="text-align: left; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">
                                <th style="padding: 12px;">Aprendiz</th>
                                <th style="padding: 12px; text-align: center;">Entregas</th>
                                <th style="padding: 12px; text-align: center;">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aprendices as $aprendiz)
                                @php
                                    $e_count = $entregas->where('aprendiz_id', $aprendiz->id)->count();
                                    $a_count = $evidencias->where('aprendiz_id', $aprendiz->id)->where('estado', 'aceptada')->count();
                                    $progreso = $etapas->count() > 0 ? ($a_count / $etapas->count()) * 100 : 0;
                                @endphp
                                <tr style="background: var(--bg-main); border-radius: 14px;">
                                    <td style="padding: 16px; border-radius: 14px 0 0 14px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 38px; height: 38px; background: white; color: var(--primary); border: 2px solid var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                                                {{ substr($aprendiz->nombres, 0, 1) }}
                                            </div>
                                            <div>
                                                <p style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">{{ $aprendiz->nombres }}</p>
                                                <p style="font-size: 0.75rem; color: var(--text-muted);">{{ $aprendiz->correo }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 16px; text-align: center;">
                                        <span style="padding: 6px 14px; background: white; border: 1px solid var(--border); border-radius: 20px; font-size: 0.8rem; font-weight: 700;">{{ $e_count }} / {{ $etapas->count() }}</span>
                                    </td>
                                    <td style="padding: 16px; border-radius: 0 14px 14px 0;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="flex: 1; height: 8px; background: white; border-radius: 4px; overflow: hidden; border: 1px solid var(--border);">
                                                <div style="width: {{ $progreso }}%; height: 100%; background: var(--primary); transition: width 0.5s ease;"></div>
                                            </div>
                                            <span style="font-size: 0.8rem; font-weight: 800; color: var(--primary); min-width: 40px;">{{ round($progreso) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detailed Stage Progress -->
            <div class="glass-card" style="padding: 2.5rem; border-top: 5px solid #8b5cf6; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.1); border-radius: 20px;">
                <h3 style="font-size: 1.4rem; font-weight: 900; color: var(--text-main); margin-bottom: 2rem; display: flex; align-items: center; gap: 15px;">
                     <span style="background: rgba(139, 92, 246, 0.1); width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 14px; color: #8b5cf6;">
                        <i class="fas fa-layer-group" style="font-size: 1.2rem;"></i> 
                    </span>
                    Bitácora Detallada por Etapas
                </h3>
                <div style="display: grid; gap: 1.5rem;">
                    @foreach($etapas as $etapa)
                        <div class="stage-accordion-rep">
                            <div class="accordion-header-rep" onclick="this.nextElementSibling.classList.toggle('active')">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stage-num-rep">{{ $etapa->orden }}</div>
                                    <div>
                                        <h4 style="font-weight: 700; font-size: 1.05rem; color: var(--text-main);">{{ $etapa->nombre }}</h4>
                                        <p style="font-size: 0.8rem; color: var(--text-muted);">{{ count($entregas->where('etapa_id', $etapa->id)) }} entregas totales</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down" style="color: var(--text-muted);"></i>
                            </div>
                            <div class="accordion-content-rep">
                                <div style="padding: 1.5rem; background: white; border-radius: 0 0 16px 16px; border: 1px solid var(--border); border-top: none;">
                                    <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem;">{{ $etapa->descripcion }}</p>
                                    
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                        <div>
                                            <h5 class="sub-label-rep" style="--c: #3b82f6;">Entregas Formales</h5>
                                            @forelse($entregas->where('etapa_id', $etapa->id) as $e)
                                                <div class="mini-card-rep">
                                                    <span style="font-weight: 700; color: var(--text-main);">{{ $e->nombres }}</span>
                                                    <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; font-size: 0.65rem;">ENVIADO</span>
                                                </div>
                                            @empty
                                                <p style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Sin envíos.</p>
                                            @endforelse
                                        </div>
                                        <div>
                                            <h5 class="sub-label-rep" style="--c: #10b981;">Calificaciones</h5>
                                            @forelse($evidencias->where('etapa_id', $etapa->id) as $ev)
                                                <div class="mini-card-rep">
                                                    <span style="font-weight: 700; color: var(--text-main);">{{ $ev->nombres }}</span>
                                                    <span class="badge" style="background: {{ $ev->estado === 'aceptada' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $ev->estado === 'aceptada' ? '#10b981' : '#ef4444' }}; border: none; font-size: 0.65rem;">{{ strtoupper($ev->estado) }}</span>
                                                </div>
                                            @empty
                                                <p style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Pendiente evaluar.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Meta Info Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 2rem;">
            <div class="glass-card" style="padding: 2rem; border-radius: 20px; border-top: 4px solid var(--primary); box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h4 style="font-size: 1.1rem; font-weight: 900; color: var(--text-main); text-transform: uppercase; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-clipboard-list" style="color: var(--primary);"></i> Ficha Técnica
                </h4>
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 6px; font-weight: 800; text-transform: uppercase;">Estado Actual</p>
                        <span style="display: inline-block; padding: 6px 14px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 10px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; border: 1px solid rgba(16, 185, 129, 0.2);">
                            <i class="fas fa-circle" style="font-size: 0.5rem; margin-right: 6px; vertical-align: middle;"></i>{{ $proyecto->estado }}
                        </span>
                    </div>
                    <div style="padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 6px; font-weight: 800; text-transform: uppercase;">Empresa Patrocinadora</p>
                        <p style="font-weight: 800; color: var(--text-main); font-size: 0.95rem;">
                            <i class="fas fa-building" style="color: var(--primary); margin-right: 8px;"></i>{{ $proyecto->empresa->nombre ?? 'No asignada' }}
                        </p>
                    </div>
                    <div style="padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 6px; font-weight: 800; text-transform: uppercase;">Categoría del Proyecto</p>
                        <p style="font-weight: 700; color: var(--text-main); font-size: 0.95rem;">
                            {{ $proyecto->categoria ?? 'General' }}
                        </p>
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 8px; font-weight: 800; text-transform: uppercase;">Cronograma de Ejecución</p>
                        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.85rem; background: var(--bg-main); padding: 16px; border-radius: 12px; border: 1px solid var(--border);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--text-muted); font-weight: 700;"><i class="fas fa-play-circle" style="margin-right: 6px;"></i>Inicio:</span>
                                <span style="font-weight: 800; color: var(--text-main);">{{ $proyecto->fecha_publicacion ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') : 'Por definir' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--text-muted); font-weight: 700;"><i class="fas fa-flag-checkered" style="margin-right: 6px;"></i>Cierre:</span>
                                <span style="font-weight: 800; color: var(--primary);">{{ $proyecto->fecha_publicacion && $proyecto->duracion_estimada_dias ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias)->format('d/m/Y') : 'Por definir' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--text-muted); font-weight: 700;"><i class="far fa-clock" style="margin-right: 6px;"></i>Duración:</span>
                                <span style="font-weight: 800; color: var(--text-main);">{{ $proyecto->duracion_estimada_dias ?? 0 }} Días</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 1.5rem; background: var(--primary); border: none;">
                <h4 style="color: rgba(255,255,255,0.8); font-size: 0.85rem; font-weight: 700; margin-bottom: 1rem;">CALIDAD DE SEGUIMIENTO</h4>
                <div style="text-align: center;">
                    <p style="font-size: 2.5rem; font-weight: 900; color: white;">A+</p>
                    <p style="font-size: 0.7rem; color: rgba(255,255,255,0.7); margin-top: 5px;">Métrica interna SENA</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card-rep {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        border-left: 4px solid var(--c);
    }
    .stat-icon-rep {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        color: var(--c);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: white;
        border: 1px solid var(--border);
    }
    .stat-value-rep { font-size: 1.6rem; font-weight: 800; color: var(--text-main); line-height: 1; }
    .stat-label-rep { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-top: 4px; }

    .stage-accordion-rep { border-radius: 16px; overflow: hidden; margin-bottom: 10px; }
    .accordion-header-rep {
        padding: 1.25rem 2rem;
        background: white;
        border: 2px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .accordion-header-rep:hover { 
        border-color: #8b5cf6; 
        box-shadow: 0 6px 16px rgba(139, 92, 246, 0.15); 
        transform: translateY(-2px);
    }
    .stage-num-rep {
        width: 32px;
        height: 32px;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
    }
    .accordion-content-rep { display: none; }
    .accordion-content-rep.active { display: block; animation: slideDownRep 0.3s ease-out; }
    
    @keyframes slideDownRep {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .sub-label-rep {
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--c);
        text-transform: uppercase;
        border-bottom: 2px solid var(--border);
        padding-bottom: 6px;
        margin-bottom: 1rem;
        display: block;
    }
    .mini-card-rep {
        padding: 10px 14px;
        background: var(--bg-main);
        border-radius: 10px;
        border: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }

    @media print {
        .sidebar-nav, .top-bar, .btn-ver, .nav-item { display: none !important; }
        .glass-card { box-shadow: none !important; border: 1px solid #ddd !important; }
        body { background: white !important; }
        .accordion-content-rep { display: block !important; }
    }
</style>
@endsection
