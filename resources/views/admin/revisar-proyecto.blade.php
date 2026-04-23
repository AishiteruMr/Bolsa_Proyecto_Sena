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
                <h2 class="admin-title-main" style="font-size: 26px;">Control de Calidad Exhaustivo</h2>
                <p style="color: var(--text-light); font-size: 14px; font-weight: 500;">Evaluando: <span style="color: var(--primary); font-weight: 800;">{{ $proyecto->titulo }}</span></p>
            </div>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <div style="background: {{ $calidad['puede_publicarse'] ? '#f0fdf4' : '#fef2f2' }}; border: 2px solid {{ $calidad['puede_publicarse'] ? '#22c55e' : '#ef4444' }}; border-radius: 12px; padding: 8px 16px;">
                <span style="font-weight: 800; font-size: 13px; color: {{ $calidad['puede_publicarse'] ? '#16a34a' : '#dc2626' }};">
                    <i class="fas {{ $calidad['puede_publicarse'] ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                    {{ $calidad['puede_publicarse'] ? 'APTO PARA PUBLICAR' : 'NO APTO' }}
                </span>
            </div>
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
                <h3 style="font-size: 14px; font-weight: 800; color: var(--text); text-transform: uppercase; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shield-halved" style="color: var(--primary);"></i> Evaluación de Viabilidad
                </h3>

                <div style="margin-bottom: 24px; text-align: center;">
                    <div style="font-size: 56px; font-weight: 900; line-height: 1; color: {{ $calidad['es_apto'] ? '#22c55e' : '#f97316' }};">
                        {{ $calidad['porcentaje'] }}%
                    </div>
                    <div style="font-size: 12px; font-weight: 800; color: var(--text-light); margin-top: 8px; text-transform: uppercase; letter-spacing: 1px;">
                        Score de Viabilidad
                    </div>
                    <div style="font-size: 12px; color: var(--text-light); margin-top: 4px;">
                        {{ $calidad['puntos_obtenidos'] }} / {{ $calidad['puntos_totales'] }} puntos
                    </div>
                    <div style="width: 100%; height: 12px; background: #f1f5f9; border-radius: 10px; margin-top: 16px; overflow: hidden; border: 1px solid var(--border);">
                        <div style="width: {{ $calidad['porcentaje'] }}%; height: 100%; background: {{ $calidad['es_apto'] ? 'linear-gradient(90deg, #22c55e, #16a34a)' : 'linear-gradient(90deg, #f97316, #ea580c)' }}; border-radius: 10px; transition: width 0.5s ease;"></div>
                    </div>
                    <div style="margin-top: 8px; font-size: 11px; font-weight: 600; color: var(--text-light);">
                        Mínimo requerido: 75%
                    </div>
                </div>

                @if(count($calidad['errores_criticos']) > 0)
                <div style="background: #fef2f2; border: 2px solid #fca5a5; border-radius: 10px; padding: 12px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #dc2626; font-weight: 700; font-size: 13px; margin-bottom: 8px;">
                        <i class="fas fa-times-octagon"></i> Errores Críticos
                    </div>
                    <ul style="margin: 0; padding-left: 16px; font-size: 11px; color: #991b1b; font-weight: 600;">
                        @foreach($calidad['errores_criticos'] as $error)
                            <li style="margin-bottom: 4px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(count($calidad['warnings']) > 0)
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 12px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #d97706; font-weight: 700; font-size: 13px; margin-bottom: 8px;">
                        <i class="fas fa-exclamation-triangle"></i> Advertencias
                    </div>
                    <ul style="margin: 0; padding-left: 16px; font-size: 11px; color: #92400e; font-weight: 600;">
                        @foreach($calidad['warnings'] as $warning)
                            <li style="margin-bottom: 4px;">{{ $warning }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid var(--border);">
                    <span style="font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px;">Criterios Obligatorios</span>
                </div>

                <div class="admin-quality-list" style="max-height: 320px; overflow-y: auto;">
                    @foreach($calidad['detalles'] as $feature => $item)
                        @if(!isset($item['opcional']) || !$item['opcional'])
                        <div class="admin-quality-item {{ $item['ok'] ? 'ok' : 'fail' }}" style="margin-bottom: 10px; padding: 10px; border-radius: 8px; background: {{ $item['ok'] ? '#f0fdf4' : '#fef2f2' }}; border: 1px solid {{ $item['ok'] ? '#bbf7d0' : '#fecaca' }};">
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; font-size: 12px; color: {{ $item['ok'] ? '#15803d' : '#dc2626' }};">
                                        {{ match($feature) {
                                            'empresa_activa' => 'Empresa Activa',
                                            'titulo' => 'Título',
                                            'descripcion' => 'Descripción',
                                            'requisitos' => 'Requisitos',
                                            'habilidades' => 'Habilidades',
                                            'coherencia' => 'Coherencia R-H',
                                            'categoria' => 'Categoría',
                                            'duracion' => 'Duración',
                                            default => $feature
                                        } }}
                                    </div>
                                    <div style="font-size: 10px; color: {{ $item['ok'] ? '#166534' : '#b91c1c' }}; margin-top: 2px; font-weight: 500;">
                                        {{ $item['descripcion'] }}
                                        @if(isset($item['palabras']))
                                            <span style="opacity: 0.7;">({{ $item['palabras'] }} palabras)</span>
                                        @endif
                                    </div>
                                    @if($feature == 'descripcion' && isset($item['detalles']))
                                    <div style="margin-top: 6px; display: flex; gap: 8px; flex-wrap: wrap;">
                                        <span style="font-size: 9px; padding: 2px 6px; border-radius: 4px; background: {{ $item['detalles']['tiene_objetivo'] ? '#dcfce7' : '#fee2e2' }}; color: {{ $item['detalles']['tiene_objetivo'] ? '#15803d' : '#dc2626' }}; font-weight: 700;">
                                            {{ $item['detalles']['tiene_objetivo'] ? '✓' : '✗' }} Objetivo
                                        </span>
                                        <span style="font-size: 9px; padding: 2px 6px; border-radius: 4px; background: {{ $item['detalles']['tiene_alcance'] ? '#dcfce7' : '#fee2e2' }}; color: {{ $item['detalles']['tiene_alcance'] ? '#15803d' : '#dc2626' }}; font-weight: 700;">
                                            {{ $item['detalles']['tiene_alcance'] ? '✓' : '✗' }} Alcance
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 2px;">
                                    <i class="fas {{ $item['ok'] ? 'fa-check-circle' : 'fa-times-circle' }}" style="font-size: 1.1rem; color: {{ $item['ok'] ? '#22c55e' : '#ef4444' }};"></i>
                                    <span style="font-size: 9px; font-weight: 800; color: var(--text-lighter);">{{ $item['peso'] }}pts</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                <div style="display: flex; align-items: center; gap: 8px; margin: 16px 0 12px; padding-bottom: 8px; border-bottom: 1px solid var(--border);">
                    <span style="font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px;">Criterios Opcionales</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    @foreach($calidad['detalles'] as $feature => $item)
                        @if(isset($item['opcional']) && $item['opcional'])
                        <div style="padding: 8px; border-radius: 8px; background: #f8fafc; border: 1px solid var(--border); text-align: center;">
                            <i class="fas {{ $item['ok'] ? 'fa-check' : 'fa-minus' }}" style="font-size: 0.9rem; color: {{ $item['ok'] ? '#22c55e' : '#94a3b8' }};"></i>
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-light); margin-top: 4px;">
                                {{ match($feature) {
                                    'ubicacion' => 'Ubicación',
                                    'imagen' => 'Imagen',
                                    default => $feature
                                } }}
                            </div>
                            <div style="font-size: 9px; color: #94a3b8;">{{ $item['peso'] > 0 ? $item['peso'].'pts' : '0pts' }}</div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="glass-card" style="padding: 28px; background: var(--text); color: #fff; border: none;">
                <h3 style="font-size: 14px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; opacity: 0.7; letter-spacing: 1px;">Veredicto Final</h3>
                
                @if($calidad['puede_publicarse'])
                    <div style="background: rgba(34, 197, 94, 0.2); border: 1px solid rgba(34, 197, 94, 0.4); border-radius: 12px; padding: 16px; margin-bottom: 16px; text-align: center;">
                        <i class="fas fa-check-circle" style="font-size: 2rem; color: #4ade80; margin-bottom: 8px;"></i>
                        <div style="font-weight: 800; font-size: 14px; color: #4ade80;">PROYECTO VIABLE</div>
                        <div style="font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 4px; font-weight: 600;">Cumple con todos los criterios de calidad</div>
                    </div>
                @else
                    <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 12px; padding: 16px; margin-bottom: 16px; text-align: center;">
                        <i class="fas fa-times-circle" style="font-size: 2rem; color: #f87171; margin-bottom: 8px;"></i>
                        <div style="font-weight: 800; font-size: 14px; color: #f87171;">PROYECTO NO VIABLE</div>
                        <div style="font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 4px; font-weight: 600;">Corrija los errores antes de publicar</div>
                    </div>
                @endif
                
                <div style="display: grid; gap: 12px;">
                    @if($calidad['puede_publicarse'])
                    <form action="{{ route('admin.proyectos.estado', $proyecto->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="estado" value="aprobado">
                        <button type="submit" class="btn-premium" style="width: 100%; background: #22c55e; color: #fff; font-weight: 800; padding: 16px; font-size: 15px; justify-content: center; border: none; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.4);">
                            <i class="fas fa-check-double" style="margin-right: 10px;"></i> Publicar Proyecto
                        </button>
                    </form>
                    @endif

                    @if(count($calidad['fallos']) > 0 && $proyecto->estado == 'pendiente')
                    <form action="{{ route('admin.proyectos.estado', $proyecto->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="estado" value="rechazado">
                        <button type="submit" class="btn-premium" style="width: 100%; background: #ef4444; color: #fff; font-weight: 800; padding: 16px; font-size: 15px; justify-content: center; border: none;">
                            <i class="fas fa-ban" style="margin-right: 10px;"></i> Rechazar Proyecto
                        </button>
                    </form>
                    @endif
                </div>

                <p style="font-size: 11px; margin-top: 20px; opacity: 0.5; text-align: center; font-weight: 600; line-height: 1.5;">
                    La aprobación activará la visibilidad pública y notificará a la empresa proponente.
                </p>
            </div>
        </div>
    </div>
</div>

@if($proyecto->latitud && $proyecto->longitud)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/maps.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initViewMap('revisar-map', {{ $proyecto->latitud }}, {{ $proyecto->longitud }}, 'Ubicación Propuesta');
});
</script>
@endif
@endsection
