@extends('layouts.dashboard')

@section('title', 'Revisión de Proyecto')
@section('page-title', 'Módulo de Verificación de Calidad')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href= "{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
@endsection

@section('content')
<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto;">
    <div style="margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.proyectos') }}" class="btn-premium" style="width: 44px; height: 44px; padding: 0; justify-content: center; background: #fff; border: 1px solid var(--border); color: var(--text-light); box-shadow: none;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="admin-title-main" style="font-size: 26px;">Detalles de la Revisión</h2>
                <p style="color: var(--text-light); font-size: 14px; font-weight: 500;">Evaluando: <span style="color: var(--primary); font-weight: 800;">{{ $proyecto->titulo }}</span></p>
            </div>
        </div>
        <div>
            <span class="aprendiz-badge-portal" style="background: {{ $proyecto->estado == 'pendiente' ? '#fff7ed' : ($proyecto->estado == 'aprobado' ? '#f0fdf4' : '#fef2f2') }}; border-color: {{ $proyecto->estado == 'pendiente' ? '#ffedd5' : ($proyecto->estado == 'aprobado' ? '#dcfce7' : '#fee2e2') }}; color: {{ $proyecto->estado == 'pendiente' ? '#ea580c' : ($proyecto->estado == 'aprobado' ? '#16a34a' : '#dc2626') }}; padding: 8px 16px; font-weight: 800;">
                Estado: {{ $proyecto->estado }}
            </span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 32px; align-items: start;">
        
        <div style="display: grid; gap: 32px;">
            <div class="admin-review-hero">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                    <i class="fas fa-file-invoice" style="color: var(--primary); font-size: 1.4rem;"></i>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text);">Resumen del Proyecto</h3>
                </div>

                <div style="margin-bottom: 32px;">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Descripción Técnica</label>
                    <p style="font-size: 15px; color: var(--text); line-height: 1.8; background: #f8fafc; padding: 24px; border-radius: 16px; border-left: 5px solid var(--primary); font-weight: 500;">
                        {{ $proyecto->descripcion }}
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Requisitos Específicos</label>
                        <div style="font-size: 14px; color: var(--text-light); line-height: 1.6; padding: 16px; background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; height: 100%; font-weight: 600;">
                            {{ $proyecto->requisitos_especificos }}
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Habilidades Requeridas</label>
                        <div style="font-size: 14px; color: var(--text-light); line-height: 1.6; padding: 16px; background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; height: 100%; font-weight: 600;">
                            {{ $proyecto->habilidades_requeridas }}
                        </div>
                    </div>
                </div>

                @if($proyecto->imagen_url)
                <div style="margin-top: 32px;">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Identidad Visual</label>
                    <img src="{{ $proyecto->imagen_url }}" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                </div>
                @endif
            </div>

            <div class="glass-card" style="padding: 32px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-map-marked-alt" style="color: var(--primary); font-size: 1.4rem;"></i>
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--text);">Geolocalización</h3>
                    </div>
                    @if($proyecto->latitud && $proyecto->longitud)
                        <span class="status-badge active" style="font-size: 11px; font-weight: 800;">Coordenadas Válidas</span>
                    @endif
                </div>

                @if($proyecto->latitud && $proyecto->longitud)
                    <div id="revisar-map" class="admin-map-container"></div>
                @else
                    <div style="height: 200px; background: #fff1f2; border-radius: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #be123c; text-align: center; padding: 20px; border: 2px dashed #fecaca;">
                        <i class="fas fa-location-crosshairs" style="font-size: 2rem; margin-bottom: 12px; opacity: 0.5;"></i>
                        <h4 style="font-weight: 800;">Sin Ubicación Definida</h4>
                        <p style="font-size: 13px; margin-top: 4px; font-weight: 600;">La organización no ha marcado un punto geográfico.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="admin-review-sidebar">
            <div class="glass-card" style="padding: 24px; background: #fff;">
                <h3 style="font-size: 14px; font-weight: 800; color: var(--text); text-transform: uppercase; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shield-halved" style="color: var(--primary);"></i> Control de Calidad
                </h3>

                <div style="margin-bottom: 28px; text-align: center;">
                    <div class="admin-quality-score" style="color: {{ $calidad['es_apto'] ? 'var(--primary)' : '#f97316' }};">
                        {{ $calidad['porcentaje'] }}%
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: var(--text-light);">Score de Evaluación</div>
                    <div style="width: 100%; height: 10px; background: #f1f5f9; border-radius: 10px; margin-top: 16px; overflow: hidden; border: 1px solid var(--border);">
                        <div style="width: {{ $calidad['porcentaje'] }}%; height: 100%; background: {{ $calidad['es_apto'] ? 'var(--primary)' : '#f97316' }}; border-radius: 10px;"></div>
                    </div>
                </div>

                <div class="admin-quality-list">
                    @foreach($calidad['detalles'] as $feature => $ok)
                        <div class="admin-quality-item {{ $ok ? 'ok' : 'fail' }}">
                            <span style="font-weight: 700;">
                                {{ match($feature) {
                                    'titulo' => 'Título descriptivo',
                                    'descripcion' => 'Descripción detallada',
                                    'requisitos' => 'Requisitos claros',
                                    'habilidades' => 'Habilidades blandas',
                                    'ubicacion' => 'Ubicación física',
                                    'imagen' => 'Asset de identidad',
                                    default => $feature
                                } }}
                            </span>
                            <i class="fas {{ $ok ? 'fa-check-circle' : 'fa-times-circle' }}" style="font-size: 1.1rem;"></i>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="glass-card" style="padding: 28px; background: var(--text); color: #fff; border: none;">
                <h3 style="font-size: 14px; font-weight: 800; text-transform: uppercase; margin-bottom: 24px; opacity: 0.7; letter-spacing: 1px;">Veredicto Final</h3>
                
                <div style="display: grid; gap: 12px;">
                    <form action="{{ route('admin.proyectos.estado', $proyecto->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="estado" value="aprobado">
                        <button type="submit" class="btn-premium" style="width: 100%; background: var(--primary); color: #fff; font-weight: 800; padding: 16px; font-size: 15px; justify-content: center; border: none;">
                            <i class="fas fa-check-double" style="margin-right: 10px;"></i> Publicar Proyecto
                        </button>
                    </form>

                    <form action="{{ route('admin.proyectos.estado', $proyecto->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="estado" value="rechazado">
                        <button type="submit" class="btn-premium" style="width: 100%; background: #ef4444; color: #fff; font-weight: 800; padding: 16px; font-size: 15px; justify-content: center; border: none;">
                            <i class="fas fa-ban" style="margin-right: 10px;"></i> Rechazar Oferta
                        </button>
                    </form>
                </div>

                <p style="font-size: 11px; margin-top: 20px; opacity: 0.5; text-align: center; font-weight: 600; line-height: 1.5;">
                    Nota: La aprobación activará la visibilidad pública y notificará a la organización proponente.
                </p>
            </div>
        </div>
    </div>
</div>

@if($proyecto->latitud && $proyecto->longitud)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="{{ asset('js/maps.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initViewMap('revisar-map', {{ $proyecto->latitud }}, {{ $proyecto->longitud }}, 'Ubicación Propuesta');
});
</script>
@endif
@endsection
