@extends('layouts.dashboard')

@section('title', 'Reporte de Proyecto | ' . $proyecto->titulo)
@section('page-title', 'Reporte de Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
<style>
    :root {
        --primary: hsl(158, 49%, 47%);
        --primary-hover: hsl(158, 49%, 37%);
        --primary-light: hsl(158, 49%, 57%);
        --text-main: #1a2e1a;
        --text-muted: #64748b;
        --border: rgba(158, 49%, 47%, 0.1);
        --bg-main: #f8fafc;
    }
</style>
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Volver a Mis Proyectos
                </a>
            </div>
            <h2 style="font-size:28px; font-weight:800; color:var(--primary-hover)">Auditoría de Progreso</h2>
            <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Análisis detallado para: <span style="color: var(--primary); font-weight: 700;">{{ $proyecto->titulo }}</span></p>
        </div>
        <!-- 
            BOTÓN EXPORTAR PDF
            Llama a la función exportarPDF() en JavaScript.
            NO usa window.print() directamente porque necesitamos 
            expandir los acordeones primero.
        -->
        <button onclick="exportarPDF()" class="btn-ver" style="background: #64748b; padding: 10px 24px; border-radius: 12px; width: auto; position: relative; z-index: 100;">
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
                                    $correoAprendiz = $aprendiz->usuario ? $aprendiz->usuario->correo : 'N/A';
                                @endphp
                                <tr style="background: var(--bg-main); border-radius: 14px;">
                                    <td style="padding: 16px; border-radius: 14px 0 0 14px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 38px; height: 38px; background: white; color: var(--primary); border: 2px solid var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                                                {{ substr($aprendiz->nombres, 0, 1) }}
                                            </div>
                                            <div>
                                                <p style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">{{ $aprendiz->nombres }} {{ $aprendiz->apellidos }}</p>
                                                <p style="font-size: 0.75rem; color: var(--text-muted);">{{ $correoAprendiz }}</p>
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
                                                    <span style="font-weight: 700; color: var(--text-main);">{{ $e->aprendiz_nombres ?? '' }} {{ $e->aprendiz_apellidos ?? '' }}</span>
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
                                                    <span style="font-weight: 700; color: var(--text-main);">{{ $ev->aprendiz_nombres ?? '' }} {{ $ev->aprendiz_apellidos ?? '' }}</span>
                                                    @php
                                                        $evStatusStyles = match($ev->estado) {
                                                            'aceptada' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => '#10b981', 'icon' => 'fa-check'],
                                                            'rechazada' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => '#ef4444', 'icon' => 'fa-ban'],
                                                            'pendiente' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'text' => '#f59e0b', 'icon' => 'fa-clock'],
                                                            'en_progreso' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'text' => '#3b82f6', 'icon' => 'fa-spinner'],
                                                            default => ['bg' => 'rgba(100, 116, 139, 0.1)', 'text' => '#64748b', 'icon' => 'fa-info-circle'],
                                                        };
                                                    @endphp
                                                    <span class="badge" style="background: {{ $evStatusStyles['bg'] }}; color: {{ $evStatusStyles['text'] }}; border: none; font-size: 0.65rem; display: inline-flex; align-items: center; gap: 4px;">
                                                        <i class="fas {{ $evStatusStyles['icon'] }}"></i>{{ Str::title(str_replace('_', ' ', $ev->estado)) }}
                                                    </span>
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
                        @php
                             $statusStyles = match($proyecto->estado) {
                                 'completado' => ['bg' => '#065f46', 'icon' => 'fa-check'],
                                 'aprobado' => ['bg' => '#10b981', 'icon' => 'fa-check'],
                                 'pendiente' => ['bg' => '#f59e0b', 'icon' => 'fa-clock'],
                                 'rechazado' => ['bg' => '#ef4444', 'icon' => 'fa-ban'],
                                 'cerrado' => ['bg' => '#64748b', 'icon' => 'fa-lock'],
                                 'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner'],
                                 default => ['bg' => '#64748b', 'icon' => 'fa-info-circle'],
                             };
                        @endphp
                        <span style="display: inline-block; padding: 6px 14px; background: {{ $statusStyles['bg'] }}; color: #ffffff; border-radius: 10px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; border: 1px solid {{ $statusStyles['bg'] }};">
                            <i class="fas {{ $statusStyles['icon'] }}" style="font-size: 0.5rem; margin-right: 6px; vertical-align: middle;"></i>{{ Str::title(str_replace('_', ' ', $proyecto->estado)) }}
                        </span>
                    </div>
                    <div style="padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 6px; font-weight: 800; text-transform: uppercase;">Instructor Responsable</p>
                        <p style="font-weight: 800; color: var(--text-main); font-size: 0.95rem;">
                            <i class="fas fa-chalkboard-teacher" style="color: var(--primary); margin-right: 8px;"></i>{{ $proyecto->instructor->nombres ?? 'No asignado' }} {{ $proyecto->instructor->apellidos ?? '' }}
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

    /**
     * ================================================
     * ESTILOS PARA IMPRESIÓN / EXPORTAR PDF
     * ================================================
     * 
     * Estos estilos se aplican SOLO cuando se imprime o exporta a PDF.
     * Su objetivo es generar un documento limpio y profesional.
     * 
     * CAMBIOS REALIZADOS:
     * 
     * 1. OCULTAR ELEMENTOS DE NAVEGACIÓN:
     *    - .sidebar, .topbar, .btn-ver, .nav-item = display: none
     *    - Eliminamos el menú lateral y el encabezado para que no aparezcan en el PDF
     * 
     * 2. AJUSTAR LAYOUT PRINCIPAL:
     *    - .main { margin-left: 0 } = El contenido ocupa todo el ancho (sin sidebar)
     * 
     * 3. SIMPLIFICAR TARJETAS (glass-card):
     *    - backdrop-filter: none = Eliminar efecto glass/blur que no se imprime bien
     *    - background: white = Fondo sólido blanco
     *    - border: 1px solid #ddd = Borde simple gris
     *    - box-shadow: none = Sin sombras
     * 
     * 4. VARIABLES CSS:
     *    - Definimos :root dentro de @media print porque las variables
     *      se heredan del layout principal y necesitamos valores directos
     *      para que los colores funcionen en el PDF.
     * 
     * 5. ACORDEONES EXPANDIDOS:
     *    - .accordion-content-rep { display: block !important }
     *    - FUERZA que todo el contenido de los acordeones sea visible
     * 
     * 6. EVITAR CORTES DE PÁGINA:
     *    - .stage-accordion-rep { page-break-inside: avoid }
     *    - Evita que un acordeón se corte entre dos páginas
     * 
     * 7. COLORES DE ESTADO:
     *    - .stat-card-rep, .mini-card-rep = Bordes y fondos simples
     */
    @media print {
        /* Ocultar navegación */
        .sidebar, .topbar, .btn-ver, .nav-item { display: none !important; }
        
        /* Contenido ocupa todo el ancho */
        .main { margin-left: 0 !important; }
        
        /* Tarjetas con estilo simple para impresión */
        .glass-card { 
            box-shadow: none !important; 
            border: 1px solid #ddd !important;
            backdrop-filter: none !important;
            background: white !important;
        }
        
        /* Fondo blanco general */
        body { background: white !important; }
        
        /* Mostrar contenido oculto de acordeones */
        .accordion-content-rep { display: block !important; }
        
        /* Quitar cursor pointer de headers de acordeón */
        .accordion-header-rep { cursor: default !important; }
        
        /* Evitar que los acordeones se corten entre páginas */
        .stage-accordion-rep { page-break-inside: avoid; }
        
        /* Estilos simples para tarjetas de estadísticas */
        .stat-card-rep { border: 1px solid #ddd !important; }
        
        /* Fondo simple para mini-cards */
        .mini-card-rep { background: #f8fafc !important; }
        
        /* Definir variables CSS directamente para impresión */
        :root {
            --primary: hsl(158, 49%, 47%);
            --primary-hover: hsl(158, 49%, 37%);
            --primary-light: hsl(158, 49%, 57%);
            --text-main: #1a2e1a;
            --text-muted: #64748b;
            --border: rgba(0, 0, 0, 0.1);
            --bg-main: #f8fafc;
        }
    }
</style>
@endsection

@section('scripts')
<script>
/**
 * Función para exportar a PDF
 * 
 * PROBLEMA ORIGINAL:
 * Los acordeones (Bitácora Detallada por Etapas) estaban colapsados por defecto
 * y al imprimir solo salía el contenido visible en pantalla (encabezados de los acordeones).
 * 
 * SOLUCIÓN:
 * 1. Antes de imprimir: Agregamos la clase 'active' a todos los acordeones para expandirlos
 * 2. Esperamos 100ms para que el navegador renderice el contenido expandido
 * 3. Ejecutamos window.print() para abrir el diálogo de impresión
 * 4. Después de imprimir (o cancelar): Removemos la clase 'active' para dejar todo como estaba
 * 
 * La clase 'active' cambia el display de 'none' a 'block' mostrando todo el contenido.
 */
function exportarPDF() {
    // PASO 1: Expandir todos los acordeones antes de imprimir
    document.querySelectorAll('.accordion-content-rep').forEach(function(el) {
        el.classList.add('active');
    });
    
    // PASO 2: Esperar a que se renderice el contenido expandido
    setTimeout(function() {
        // PASO 3: Abrir diálogo de impresión del navegador
        window.print();
        
        // PASO 4: Después de imprimir, restaurar estado original (acordeones cerrados)
        setTimeout(function() {
            document.querySelectorAll('.accordion-content-rep').forEach(function(el) {
                el.classList.remove('active');
            });
        }, 100);
    }, 100);
}
</script>
@endsection
