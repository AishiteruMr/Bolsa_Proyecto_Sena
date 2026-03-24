@extends('layouts.dashboard')

@section('title', 'Reporte de Seguimiento | ' . $proyecto->pro_titulo_proyecto)
@section('page-title', 'Reporte de Seguimiento')

@section('sidebar-nav')
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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
                <a href="{{ route('instructor.proyecto.detalle', $proyecto->pro_id) }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Volver a la Gestión
                </a>
            </div>
            <h2 style="font-size:28px; font-weight:800; color:var(--primary-dark)">Auditoría de Progreso</h2>
            <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Análisis detallado para: <span style="color: var(--primary); font-weight: 700;">{{ $proyecto->pro_titulo_proyecto }}</span></p>
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
                <p class="stat-value-rep">{{ $evidencias->where('evid_estado', 'Aprobada')->count() }}</p>
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
            <div class="glass-card" style="padding: 2.5rem;">
                <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--text-main); margin-bottom: 2rem; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-id-card-alt" style="color: var(--primary);"></i> Matriz de Rendimiento
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
                                    $e_count = $entregas->where('ene_apr_id', $aprendiz->apr_id)->count();
                                    $a_count = $evidencias->where('evid_apr_id', $aprendiz->apr_id)->where('evid_estado', 'Aprobada')->count();
                                    $progreso = $etapas->count() > 0 ? ($a_count / $etapas->count()) * 100 : 0;
                                @endphp
                                <tr style="background: var(--bg-main); border-radius: 14px;">
                                    <td style="padding: 16px; border-radius: 14px 0 0 14px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 38px; height: 38px; background: white; color: var(--primary); border: 2px solid var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                                                {{ substr($aprendiz->apr_nombre, 0, 1) }}
                                            </div>
                                            <div>
                                                <p style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">{{ $aprendiz->apr_nombre }}</p>
                                                <p style="font-size: 0.75rem; color: var(--text-muted);">{{ $aprendiz->usr_correo }}</p>
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
            <div class="glass-card" style="padding: 2.5rem;">
                <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--text-main); margin-bottom: 2rem;">Bitácora por Etapas</h3>
                <div style="display: grid; gap: 1.5rem;">
                    @foreach($etapas as $etapa)
                        <div class="stage-accordion-rep">
                            <div class="accordion-header-rep" onclick="this.nextElementSibling.classList.toggle('active')">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stage-num-rep">{{ $etapa->eta_orden }}</div>
                                    <div>
                                        <h4 style="font-weight: 700; font-size: 1.05rem; color: var(--text-main);">{{ $etapa->eta_nombre }}</h4>
                                        <p style="font-size: 0.8rem; color: var(--text-muted);">{{ count($entregas->where('ene_eta_id', $etapa->eta_id)) }} entregas totales</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down" style="color: var(--text-muted);"></i>
                            </div>
                            <div class="accordion-content-rep">
                                <div style="padding: 1.5rem; background: white; border-radius: 0 0 16px 16px; border: 1px solid var(--border); border-top: none;">
                                    <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem;">{{ $etapa->eta_descripcion }}</p>
                                    
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                        <div>
                                            <h5 class="sub-label-rep" style="--c: #3b82f6;">Entregas Formales</h5>
                                            @forelse($entregas->where('ene_eta_id', $etapa->eta_id) as $e)
                                                <div class="mini-card-rep">
                                                    <span style="font-weight: 700; color: var(--text-main);">{{ $e->apr_nombre }}</span>
                                                    <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; font-size: 0.65rem;">ENVIADO</span>
                                                </div>
                                            @empty
                                                <p style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Sin envíos.</p>
                                            @endforelse
                                        </div>
                                        <div>
                                            <h5 class="sub-label-rep" style="--c: #10b981;">Calificaciones</h5>
                                            @forelse($evidencias->where('evid_eta_id', $etapa->eta_id) as $ev)
                                                <div class="mini-card-rep">
                                                    <span style="font-weight: 700; color: var(--text-main);">{{ $ev->apr_nombre }}</span>
                                                    <span class="badge" style="background: {{ $ev->evid_estado === 'Aprobada' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $ev->evid_estado === 'Aprobada' ? '#10b981' : '#ef4444' }}; border: none; font-size: 0.65rem;">{{ strtoupper($ev->evid_estado) }}</span>
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
            <div class="glass-card" style="padding: 1.5rem;">
                <h4 style="font-size: 0.85rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 1.25rem;">Ficha Técnica</h4>
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 4px;">ESTADO</p>
                        <span class="badge" style="background: var(--primary); color: white; border: none; width: 100%; text-align: center;">{{ $proyecto->pro_estado }}</span>
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 4px;">EMPRESA</p>
                        <p style="font-weight: 700; color: var(--text-main);">{{ $proyecto->emp_nombre }}</p>
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 4px;">CRONOGRAMA</p>
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                            <span style="color: var(--text-muted);">Cierre:</span>
                            <span style="font-weight: 700; color: var(--text-main);">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}</span>
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
        background: var(--bg-main);
        border: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 16px;
    }
    .accordion-header-rep:hover { background: white; border-color: var(--primary-light); }
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
