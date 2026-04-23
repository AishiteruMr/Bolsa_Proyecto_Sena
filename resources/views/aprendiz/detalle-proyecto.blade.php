@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto')
@section('page-title', 'Gestión de Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero" style="padding: 40px 48px; margin-bottom: 32px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-project-diagram"></i></div>
        <div style="position: relative; z-index: 1;">
            <a href="{{ route('aprendiz.postulaciones') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 16px; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                <i class="fas fa-arrow-left"></i> Volver a mis postulaciones
            </a>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Gestión</span>
                <span style="background: rgba(59,130,246,0.2); border: 1px solid rgba(59,130,246,0.3); color: #93c5fd; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ $proyecto->categoria }}</span>
            </div>
            <h1 class="instructor-title">{{ $proyecto->titulo }}</h1>
            <p style="color: rgba(255,255,255,0.7); font-size: 15px; font-weight: 500;">Panel de seguimiento y entrega de productos del proyecto.</p>
        </div>
    </div>

    <!-- Bento Grid Stats -->
    <div class="instructor-stat-grid" style="margin-bottom: 32px;">
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-top: 4px solid #3eb489;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-circle-check"></i>
            </div>
            <div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Estado del Proyecto</div>
                <div style="font-size: 20px; font-weight: 800; color: var(--text);">{{ $proyecto->estado }}</div>
            </div>
        </div>
        
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-top: 4px solid #3b82f6;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-building"></i>
            </div>
            <div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Empresa Aliada</div>
            <div style="font-size: 18px; font-weight: 800; color: var(--text);">{{ $proyecto->emp_nombre ?? $proyecto->empresa->nombre ?? 'No asignada' }}</div>
            </div>
        </div>

        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-top: 4px solid #f59e0b;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Instructor Tutor</div>
                <div style="font-size: 18px; font-weight: 800; color: var(--text);">{{ $proyecto->instructor_nombre }}</div>
            </div>
        </div>

        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-top: 4px solid #ef4444;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Fecha Límite</div>
                <div style="font-size: 18px; font-weight: 800; color: var(--text);">{{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d M, Y') }}</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 28px; align-items: start;">
        <!-- Main Info & Stages -->
        <div style="display: grid; gap: 28px;">
            
            <!-- Descripción y Detalles -->
            <div class="glass-card" style="padding: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Sobre el Proyecto</h3>
                </div>
                
                <p style="color: var(--text-light); line-height: 1.8; margin-bottom: 24px; font-weight: 500;">
                    {{ $proyecto->descripcion }}
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="background: #f8fafc; padding: 20px; border-radius: 16px;">
                        <h4 style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fas fa-list-check" style="color: #3eb489; margin-right: 8px;"></i>Requisitos
                        </h4>
                        <p style="font-size: 13px; color: var(--text-light); font-weight: 500; line-height: 1.6;">{{ $proyecto->requisitos_especificos }}</p>
                    </div>
                    <div style="background: #f8fafc; padding: 20px; border-radius: 16px;">
                        <h4 style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fas fa-star" style="color: #f59e0b; margin-right: 8px;"></i>Habilidades
                        </h4>
                        <p style="font-size: 13px; color: var(--text-light); font-weight: 500; line-height: 1.6;">{{ $proyecto->habilidades_requeridas }}</p>
                    </div>
                </div>
            </div>

            <!-- Etapas y Seguimiento -->
            <div>
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 20px;">
                    <i class="fas fa-tasks" style="color: #3eb489; margin-right: 12px;"></i>Plan de Trabajo y Entregas
                </h3>

                <div style="display: grid; gap: 24px;">
                    @forelse($etapas as $etapa)
                        @php $evidenciasEtapa = $evidencias->where('id', $etapa->id); @endphp
                        <div class="glass-card" style="padding: 28px; position: relative; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 32px rgba(62,180,137,0.12)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(62,180,137,0.06)'">
                            <div style="position: absolute; top: -20px; right: -10px; font-size: 100px; font-weight: 900; color: rgba(62,180,137,0.04); pointer-events: none; line-height: 1;">{{ $etapa->orden }}</div>

                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; position: relative; z-index: 1;">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <span style="width: 40px; height: 40px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px; box-shadow: 0 4px 12px rgba(62,180,137,0.3);">
                                        {{ $etapa->orden }}
                                    </span>
                                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin: 0;">{{ $etapa->nombre }}</h4>
                                </div>
                                @if($evidenciasEtapa->count())
                                    <span style="background: rgba(62,180,137,0.1); color: #3eb489; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">
                                        {{ $evidenciasEtapa->count() }} entrega(s)
                                    </span>
                                @endif
                            </div>

                            <p style="color: var(--text-light); font-size: 14px; margin-bottom: 24px; font-weight: 500; line-height: 1.6; position: relative; z-index: 1;">{{ $etapa->descripcion }}</p>

                            @if($etapa->url_documento)
                            <div style="background: linear-gradient(135deg, rgba(62,180,137,0.1), rgba(62,180,137,0.05)); border: 1px solid rgba(62,180,137,0.2); border-radius: 14px; padding: 18px; margin-bottom: 24px;">
                                <div style="display: flex; align-items: center; gap: 14px;">
                                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <h5 style="font-size: 14px; font-weight: 800; color: var(--text); margin: 0 0 4px 0;">Documento Guía de la Etapa</h5>
                                        <p style="font-size: 12px; color: var(--text-light); margin: 0;">Descarga la guía/formato para esta etapa</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $etapa->url_documento) }}" target="_blank" class="btn-premium" style="padding: 10px 20px; font-size: 13px;">
                                        <i class="fas fa-download" style="margin-right: 6px;"></i>Descargar
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Evidencias Existentes -->
                            @if($evidenciasEtapa->count())
                                <div style="background: #f8fafc; border-radius: 16px; padding: 20px; margin-bottom: 24px; border: 1px solid #e2e8f0;">
                                    <h5 style="font-size: 12px; font-weight: 800; color: var(--text-light); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <i class="fas fa-history" style="margin-right: 8px;"></i>Tus Entregas
                                    </h5>
                                    <div style="display: grid; gap: 12px;">
                                        @foreach($evidenciasEtapa as $evid)
                                            @php
                                                $stateColor = match($evid->estado) {
                                                    'aceptada'  => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a', 'icon' => 'fa-check-circle'],
                                                    'rechazada' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#dc2626', 'icon' => 'fa-times-circle'],
                                                    default     => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-hourglass-half'],
                                                };
                                            @endphp
                                            <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 16px 20px; border-radius: 12px; border: 1px solid #e2e8f0;">
                                                <div style="display: flex; align-items: center; gap: 14px;">
                                                    <div style="width: 40px; height: 40px; background: {{ $stateColor['bg'] }}; color: {{ $stateColor['text'] }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                                        <i class="fas fa-file-alt"></i>
                                                    </div>
                                                    <div>
                                                        <p style="font-size: 13px; font-weight: 700; color: var(--text); margin: 0;">{{ \Carbon\Carbon::parse($evid->fecha_envio)->format('d M, Y - h:i A') }}</p>
                                                        @if($evid->comentario_instructor)
                                                            <p style="font-size: 12px; color: var(--text-light); margin-top: 2px;"><i class="fas fa-comment" style="margin-right: 4px;"></i>{{ $evid->comentario_instructor }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div style="display: flex; align-items: center; gap: 12px;">
                                                    <span style="background: {{ $stateColor['bg'] }}; border: 1px solid {{ $stateColor['border'] }}; color: {{ $stateColor['text'] }}; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                                        <i class="fas {{ $stateColor['icon'] }}"></i> {{ $evid->estado }}
                                                    </span>
                                                    @if($evid->ruta_archivo)
                                                        <a href="{{ asset('storage/' . $evid->ruta_archivo) }}" target="_blank" class="btn-premium" style="padding: 8px 14px; font-size: 12px;">
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
                            <div style="border-top: 1px solid rgba(62,180,137,0.1); padding-top: 24px; position: relative; z-index: 1;">
                                <h5 style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-paper-plane" style="color: #3eb489;"></i> Enviar Nueva Evidencia
                                </h5>
                                <form action="{{ route('aprendiz.evidencia.enviar', [$proyecto->id, $etapa->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div style="display: grid; gap: 16px;">
                                        <textarea name="descripcion" required placeholder="Escribe un breve comentario sobre tu entrega..." style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-family: inherit; font-size: 14px; font-weight: 500; min-height: 80px; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#3eb489'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                                        
                                        <div style="display: flex; gap: 16px; align-items: center;">
                                            <div style="flex: 1; border: 2px dashed rgba(62,180,137,0.3); padding: 16px; border-radius: 12px; background: #f8fafc; text-align: center; color: var(--text-light); cursor: pointer; font-size: 13px; font-weight: 600; position: relative; transition: all 0.3s;" onmouseover="this.style.borderColor='#3eb489'; this.style.background='rgba(62,180,137,0.05)'" onmouseout="this.style.borderColor='rgba(62,180,137,0.3)'; this.style.background='#f8fafc'">
                                                <i class="fas fa-cloud-arrow-up" style="margin-right: 8px; color: #3eb489;"></i> Seleccionar archivo (ZIP, PDF, etc.)
                                                <input type="file" name="archivo" required style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                            </div>
                                            <button type="submit" class="btn-premium" style="padding: 14px 24px; white-space: nowrap;">
                                                <i class="fas fa-paper-plane"></i> Entregar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="glass-card" style="padding: 60px 40px; text-align: center;">
                            <div style="width: 80px; height: 80px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #3eb489;">
                                <i class="fas fa-hourglass-start"></i>
                            </div>
                            <h4 style="color: var(--text); font-size: 18px; font-weight: 800; margin-bottom: 8px;">Planificación en Progreso</h4>
                            <p style="color: var(--text-light);">El instructor aún no ha definido las etapas para este proyecto.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar: Imagen y Info -->
        <div style="display: grid; gap: 24px;">
            
            <!-- Imagen del Proyecto -->
            <div class="glass-card" style="padding: 24px;">
                <h4 style="font-size: 14px; font-weight: 800; color: var(--text); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fas fa-image" style="color: #3eb489; margin-right: 8px;"></i>Imagen del Proyecto
                </h4>
                @if($proyecto->imagen_url)
                    <img src="{{ $proyecto->imagen_url }}" style="width: 100%; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                @else
                    <div style="width: 100%; aspect-ratio: 16/10; background: linear-gradient(135deg, #3eb489, #2d9d74); border-radius: 16px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-image" style="font-size: 40px; margin-bottom: 12px; opacity: 0.7;"></i>
                        <p style="font-size: 13px; font-weight: 700;">Proyecto Sin Imagen</p>
                    </div>
                @endif
            </div>

            <!-- Cronograma -->
            <div class="glass-card" style="padding: 24px;">
                <h4 style="font-size: 14px; font-weight: 800; color: var(--text); margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fas fa-calendar-alt" style="color: #3eb489; margin-right: 8px;"></i>Cronograma
                </h4>
                <div style="display: grid; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: #f8fafc; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div>
                            <p style="font-size: 11px; color: var(--text-light); margin-bottom: 2px; text-transform: uppercase; font-weight: 700;">Lanzamiento</p>
                            <p style="font-size: 14px; font-weight: 800; color: var(--text);">{{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d M, Y') }}</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: #fef2f2; border-radius: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-flag-checkered"></i>
                        </div>
                        <div>
                            <p style="font-size: 11px; color: var(--text-light); margin-bottom: 2px; text-transform: uppercase; font-weight: 700;">Fecha Límite</p>
                            <p style="font-size: 14px; font-weight: 800; color: #ef4444;">{{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px; padding: 14px 16px; background: rgba(62,180,137,0.05); border: 1px solid rgba(62,180,137,0.1); border-radius: 12px;">
                    <p style="font-size: 12px; color: var(--text-light); font-weight: 500; line-height: 1.5;">
                        <i class="fas fa-info-circle" style="color: #3eb489; margin-right: 6px;"></i>Asegúrate de cumplir con los plazos establecidos para cada etapa.
                    </p>
                </div>
            </div>
            
            <!-- Ubicación -->
            @if($proyecto->latitud && $proyecto->longitud)
            <div class="glass-card" style="padding: 24px;">
                <h4 style="font-size: 14px; font-weight: 800; color: var(--text); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fas fa-map-marker-alt" style="color: #ef4444; margin-right: 8px;"></i>Ubicación
                </h4>
                <div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border);">
                    <div id="ubicacion-map" style="width: 100%; height: 200px;"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($proyecto->latitud && $proyecto->longitud)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/maps.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initViewMap('ubicacion-map', {{ $proyecto->latitud }}, {{ $proyecto->longitud }}, '{{ $proyecto->nombre }}');
});
</script>
@endif
@endsection
