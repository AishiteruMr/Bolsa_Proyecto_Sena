@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto')
@section('page-title', 'Gestión de Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
        <a href="{{ route('aprendiz.postulaciones') }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 500;">
            <i class="fas fa-arrow-left"></i> Volver a mis postulaciones
        </a>
    </div>
    <h2 style="font-size:26px; font-weight:700; color:var(--primary-hover)">{{ $proyecto->pro_titulo_proyecto }}</h2>
    <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Panel de seguimiento y entrega de productos del proyecto.</p>
</div>

<!-- Bento Grid Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="glass-card" style="padding: 1.5rem; border-top: 4px solid var(--primary);">
        <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">Estado del Proyecto</p>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--text-main);">{{ $proyecto->pro_estado }}</h3>
            <i class="fas fa-circle-check" style="font-size: 1.5rem; color: var(--primary);"></i>
        </div>
    </div>
    
    <div class="glass-card" style="padding: 1.5rem; border-top: 4px solid #3b82f6;">
        <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">Empresa Aliada</p>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main);">{{ $proyecto->emp_nombre }}</h3>
            <i class="fas fa-building" style="font-size: 1.5rem; color: #3b82f6;"></i>
        </div>
    </div>

    <div class="glass-card" style="padding: 1.5rem; border-top: 4px solid #f59e0b;">
        <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">Instructor Tutor</p>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main);">{{ $proyecto->instructor_nombre }}</h3>
            <i class="fas fa-user-tie" style="font-size: 1.5rem; color: #f59e0b;"></i>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Main Info & Stages -->
    <div style="display: grid; gap: 2rem;">
        
        <!-- Descripción y Detalles -->
        <div class="glass-card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main);">Sobre el Proyecto</h3>
                <span class="badge badge-info" style="font-size: 10px; padding: 4px 12px;">{{ $proyecto->pro_categoria }}</span>
            </div>
            
            <p style="color: #4b5563; line-height: 1.7; margin-bottom: 2rem;">
                {{ $proyecto->pro_descripcion }}
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-bottom: 10px;">Requisitos</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">{{ $proyecto->pro_requisitos_especificos }}</p>
                </div>
                <div>
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-bottom: 10px;">Habilidades</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">{{ $proyecto->pro_habilidades_requerida }}</p>
                </div>
            </div>
        </div>

        <!-- Etapas y Seguimiento -->
        <div style="margin-top: 1rem;">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">
                <i class="fas fa-list-check" style="color: var(--primary); margin-right: 10px;"></i> Plan de Trabajo y Entregas
            </h3>

            <div style="display: grid; gap: 2rem;">
                @forelse($etapas as $etapa)
                    <div class="glass-card" style="padding: 2rem; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -10px; right: -10px; font-size: 5rem; font-weight: 900; color: rgba(41, 133, 100, 0.05); pointer-events: none;">
                            {{ $etapa->eta_orden }}
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="width: 32px; height: 32px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                                    {{ $etapa->eta_orden }}
                                </span>
                                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main);">{{ $etapa->eta_nombre }}</h4>
                            </div>
                        </div>

                        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">{{ $etapa->eta_descripcion }}</p>

                        <!-- Evidencias Existentes -->
                        @php $evidenciasEtapa = $evidencias->where('eta_id', $etapa->eta_id); @endphp
                        
                        @if($evidenciasEtapa->count())
                            <div style="background: var(--bg-main); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; border: 1px dashed var(--border);">
                                <h5 style="font-size: 0.85rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px;">Tus Entregas Recientes</h5>
                                <div style="display: grid; gap: 1rem;">
                                    @foreach($evidenciasEtapa as $evid)
                                        <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <div style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                                    <i class="fas fa-file-lines"></i>
                                                </div>
                                                <div>
                                                    <p style="font-size: 0.85rem; font-weight: 600; color: var(--text-main);">{{ \Carbon\Carbon::parse($evid->evid_fecha)->format('d M, Y - h:i A') }}</p>
                                                    @if($evid->evid_comentario)
                                                        <p style="font-size: 0.75rem; color: #f59e0b; margin-top: 2px;"><i class="fas fa-comment"></i> {{ $evid->evid_comentario }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                @switch($evid->evid_estado)
                                                    @case('Aprobada') <span class="badge badge-success" style="font-size:10px">Aprobada</span> @break
                                                    @case('Pendiente') <span class="badge badge-warning" style="font-size:10px">Pendiente</span> @break
                                                    @case('Rechazada') <span class="badge badge-danger" style="font-size:10px">Rechazada</span> @break
                                                @endswitch
                                                @if($evid->evid_archivo)
                                                    <a href="{{ asset('storage/' . $evid->evid_archivo) }}" target="_blank" style="color: var(--primary); font-size: 1.1rem;" title="Ver archivo">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Formulario de Entrega -->
                        <div style="border-top: 1px solid var(--border); padding-top: 1.5rem;">
                            <h5 style="font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.25rem;">Enviar Nueva Evidencia</h5>
                            <form action="{{ route('aprendiz.evidencia.enviar', [$proyecto->pro_id, $etapa->eta_id]) }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 1rem;">
                                @csrf
                                <textarea name="descripcion" required placeholder="Escribe un breve comentario sobre tu entrega..." style="width: 100%; padding: 0.8rem; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 0.85rem; min-height: 80px; outline: none;" onfocus="this.style.borderColor='var(--primary)'"></textarea>
                                
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <div style="flex: 1; border: 1px dashed var(--border); padding: 0.8rem; border-radius: 8px; background: var(--bg-main); text-align: center; color: var(--text-muted); cursor: pointer; font-size: 0.8rem; position: relative;">
                                        <i class="fas fa-cloud-arrow-up" style="margin-right: 8px;"></i> Seleccionar archivo (ZIP, PDF, etc.)
                                        <input type="file" name="archivo" required style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                    </div>
                                    <button type="submit" class="btn-ver" style="padding: 0.8rem 1.5rem; border-radius: 8px;">
                                        Entregar <i class="fas fa-paper-plane" style="margin-left: 8px; font-size: 0.8rem;"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="glass-card" style="padding: 3rem; text-align: center;">
                        <i class="fas fa-hourglass-start" style="font-size: 3rem; color: var(--border); margin-bottom: 1.5rem;"></i>
                        <h4 style="color: var(--text-main); font-size: 1.2rem; margin-bottom: 8px;">Planificación en Progreso</h4>
                        <p style="color: var(--text-muted);">El instructor aún no ha definido las etapas para este proyecto.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar: Cronograma e Imagen -->
    <div style="display: grid; align-content: flex-start; gap: 2rem;">
        
        <div class="glass-card" style="padding: 1.5rem;">
            <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">Visualización</h4>
            @if($proyecto->pro_imagen_url)
                <img src="{{ $proyecto->pro_imagen_url }}" style="width: 100%; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            @else
                <div style="width: 100%; aspect-ratio: 16/10; background: linear-gradient(135deg, var(--primary), var(--primary-hover)); border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-image" style="font-size: 2.5rem; margin-bottom: 10px;"></i>
                    <p style="font-size: 0.8rem; font-weight: 600;">Proyecto SIN EXPO</p>
                </div>
            @endif
        </div>

        <div class="glass-card" style="padding: 1.5rem;">
            <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem;">Cronograma</h4>
            <div style="display: grid; gap: 1.25rem;">
                <div>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 4px; text-transform: uppercase;">Lanzamiento</p>
                    <p style="font-weight: 600; color: var(--text-main); font-size: 0.95rem;">
                        <i class="fas fa-calendar-day" style="color: var(--primary); margin-right: 8px;"></i>
                        {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d M, Y') }}
                    </p>
                </div>
                <div>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 4px; text-transform: uppercase;">Fecha Límite</p>
                    <p style="font-weight: 600; color: var(--text-main); font-size: 0.95rem;">
                        <i class="fas fa-calendar-check" style="color: #ef4444; margin-right: 8px;"></i>
                        {{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d M, Y') }}
                    </p>
                </div>
                <div style="padding-top: 1rem; border-top: 1px solid var(--border);">
                    <p style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">
                        <i class="fas fa-circle-info"></i> Asegúrate de cumplir con los plazos establecidos para cada etapa.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-card { transition: all 0.3s ease; }
    .glass-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(0,0,0,0.06); }
</style>
@endsection
ection
