@extends('layouts.dashboard')

@section('title', 'Revisión de Proyecto')
@section('page-title', 'Módulo de Verificación de Calidad')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users-cog"></i> Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Proyectos
    </a>
@endsection

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">
    <div style="margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.proyectos') }}" class="btn btn-sm btn-outline" style="border-radius: 10px; padding: 10px 15px;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 style="font-size: 26px; font-weight: 800; color: var(--secondary); letter-spacing: -0.5px;">Detalles de la Revisión</h2>
                <p style="color: var(--text-light); font-size: 14px; font-weight: 500;">Evaluando: <span style="color: var(--primary-dark); font-weight: 700;">{{ $proyecto->pro_titulo_proyecto }}</span></p>
            </div>
        </div>
        <div style="text-align: right;">
            <span class="badge {{ $proyecto->pro_estado == 'Pendiente' ? 'badge-warning' : ($proyecto->pro_estado == 'Activo' ? 'badge-success' : 'badge-danger') }}" style="padding: 10px 20px; font-size: 13px; border-radius: 12px;">
                Estado Actual: {{ $proyecto->pro_estado }}
            </span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 32px; align-items: start;">
        
        {{-- COLUMNA IZQUIERDA: CONTENIDO --}}
        <div style="display: grid; gap: 32px;">
            
            {{-- SECCIÓN: INFORMACIÓN --}}
            <div class="card" style="padding: 40px; border-radius: 20px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                    <i class="fas fa-file-lines" style="color: var(--primary); font-size: 1.4rem;"></i>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--secondary);">Presentación del Proyecto</h3>
                </div>

                <div style="margin-bottom: 32px;">
                    <h4 style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Descripción General</h4>
                    <p style="font-size: 15px; color: var(--text); line-height: 1.7; background: var(--bg); padding: 20px; border-radius: 15px; border-left: 4px solid var(--primary);">
                        {{ $proyecto->pro_descripcion }}
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div>
                        <h4 style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Requisitos Específicos</h4>
                        <div style="font-size: 14px; color: var(--text); line-height: 1.6; padding: 16px; background: rgba(0,0,0,0.02); border-radius: 12px; height: 100%;">
                            {{ $proyecto->pro_requisitos_especificos }}
                        </div>
                    </div>
                    <div>
                        <h4 style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Habilidades Requeridas</h4>
                        <div style="font-size: 14px; color: var(--text); line-height: 1.6; padding: 16px; background: rgba(0,0,0,0.02); border-radius: 12px; height: 100%;">
                            {{ $proyecto->pro_habilidades_requerida }}
                        </div>
                    </div>
                </div>

                @if($proyecto->pro_imagen_url)
                <div style="margin-top: 32px;">
                    <h4 style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Imagen de Identidad</h4>
                    <img src="{{ $proyecto->getImagenUrlAttribute() }}" style="width: 100%; max-height: 350px; object-fit: cover; border-radius: 15px; box-shadow: var(--shadow-sm);">
                </div>
                @endif
            </div>

            {{-- SECCIÓN: UBICACIÓN --}}
            <div class="card" style="padding: 32px; border-radius: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-map-location-dot" style="color: var(--primary); font-size: 1.4rem;"></i>
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--secondary);">Geolocalización</h3>
                    </div>
                    @if($proyecto->pro_latitud && $proyecto->pro_longitud)
                        <span style="font-size: 11px; background: var(--primary-soft); color: var(--primary-dark); padding: 4px 10px; border-radius: 20px; font-weight: 700;">Punto Verificado</span>
                    @endif
                </div>

                @if($proyecto->pro_latitud && $proyecto->pro_longitud)
                    <div id="revisar-map" style="width: 100%; height: 280px; border-radius: 15px; border: 1px solid var(--border);"></div>
                @else
                    <div style="height: 200px; background: #f8d7da; border-radius: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #721c24; text-align: center; padding: 20px;">
                        <i class="fas fa-triangle-exclamation" style="font-size: 2rem; margin-bottom: 12px;"></i>
                        <h4 style="font-weight: 700;">Ubicación no configurada</h4>
                        <p style="font-size: 13px; margin-top: 4px;">La empresa no seleccionó una ubicación en el mapa.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- COLUMNA DERECHA: SIDEBAR DE CALIDAD --}}
        <div style="position: sticky; top: 100px; display: grid; gap: 24px;">
            
            {{-- SCORE DE CALIDAD --}}
            <div class="card" style="padding: 24px; border-radius: 20px; border: none; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h3 style="font-size: 14px; font-weight: 800; color: var(--secondary); text-transform: uppercase; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-star" style="color: #f1c40f;"></i> Checklist de Calidad
                </h3>

                <div style="margin-bottom: 24px; text-align: center;">
                    <div style="font-size: 48px; font-weight: 800; color: {{ $calidad['es_apto'] ? 'var(--primary-dark)' : '#e67e22' }}; line-height: 1;">
                        {{ $calidad['porcentaje'] }}%
                    </div>
                    <div style="font-size: 13px; font-weight: 700; color: var(--text-light); margin-top: 4px;">Puntaje de Aprobación</div>
                    <div style="width: 100%; height: 8px; background: var(--bg); border-radius: 10px; margin-top: 16px; overflow: hidden;">
                        <div style="width: {{ $calidad['porcentaje'] }}%; height: 100%; background: {{ $calidad['es_apto'] ? 'var(--primary)' : '#e67e22' }}; border-radius: 10px;"></div>
                    </div>
                </div>

                <ul style="list-style: none; display: grid; gap: 12px;">
                    @foreach($calidad['detalles'] as $feature => $ok)
                        <li style="display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; padding: 10px; background: {{ $ok ? 'rgba(62,180,137,0.05)' : 'rgba(231,76,60,0.05)' }}; border-radius: 10px;">
                            <span style="font-weight: 500; color: var(--text-light);">
                                @php
                                    $label = match($feature) {
                                        'titulo' => 'Título descriptivo',
                                        'descripcion' => 'Descripción detallada',
                                        'requisitos' => 'Requisitos claros',
                                        'habilidades' => 'Habilidades blandas',
                                        'ubicacion' => 'Ubicación física',
                                        'imagen' => 'Imagen de portada',
                                        default => $feature
                                    };
                                @endphp
                                {{ $label }}
                            </span>
                            <i class="fas {{ $ok ? 'fa-check-circle' : 'fa-circle-xmark' }}" style="color: {{ $ok ? '#27ae60' : '#e74c3c' }}; font-size: 1.1rem;"></i>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- ACCIONES --}}
            <div class="card" style="padding: 24px; border-radius: 20px; background: var(--secondary); color: #fff;">
                <h3 style="font-size: 14px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; opacity: 0.8;">Veredicto Final</h3>
                
                <div style="display: grid; gap: 12px;">
                    <form action="{{ route('admin.proyectos.estado', $proyecto->pro_id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="estado" value="Activo">
                        <button type="submit" class="btn" style="width: 100%; background: var(--primary); color: #fff; font-weight: 700; padding: 14px; border-radius: 12px; justify-content: center; font-size: 15px;">
                            <i class="fas fa-check"></i> Aprobar Proyecto
                        </button>
                    </form>

                    <form action="{{ route('admin.proyectos.estado', $proyecto->pro_id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="estado" value="Rechazado">
                        <button type="submit" class="btn" style="width: 100%; background: #e74c3c; color: #fff; font-weight: 700; padding: 14px; border-radius: 12px; justify-content: center; font-size: 15px;">
                            <i class="fas fa-times"></i> Rechazar y Notificar
                        </button>
                    </form>
                </div>

                <p style="font-size: 11px; margin-top: 20px; opacity: 0.6; text-align: center; font-weight: 500;">
                    Al aprobarlo, el proyecto será visible inmediatamente para todos los aprendices.
                </p>
            </div>
        </div>
    </div>
</div>

@if($proyecto->pro_latitud && $proyecto->pro_longitud)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $proyecto->pro_latitud }};
    const lng = {{ $proyecto->pro_longitud }};
    const map = L.map('revisar-map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map).bindPopup('Ubicación Propuesta').openPopup();
});
</script>
@endif
@endsection
