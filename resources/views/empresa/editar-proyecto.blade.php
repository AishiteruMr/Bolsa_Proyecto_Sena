@extends('layouts.dashboard')
@section('title', 'Editar Proyecto')
@section('page-title', 'Editar Proyecto')

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
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
<div class="animate-fade-in" style="max-width: 900px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero" style="margin-bottom: 32px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-edit"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                    <i class="fas fa-arrow-left"></i> Volver al Portafolio
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Editar Proyecto</span>
            </div>
            <h1 class="instructor-title">Editar <span style="color: var(--primary);">Convocatoria</span></h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 15px; font-weight: 500;">Actualiza la información y requerimientos de tu proyecto.</p>
        </div>
    </div>

    <form action="{{ route('empresa.proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="glass-card" style="padding: 40px; display: grid; gap: 32px;">

            {{-- SECCIÓN 1: IDENTIDAD --}}
            <section>
                <div class="empresa-form-section">
                    <span class="empresa-form-step-number">1</span>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Identidad y Clasificación</h3>
                </div>
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="empresa-form-label">Título del Proyecto *</label>
                        <div class="empresa-input-container">
                            <i class="fas fa-tag empresa-input-icon"></i>
                            <input type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}" required class="empresa-form-control" placeholder="Título descriptivo de la convocatoria">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="empresa-form-label">Categoría / Sector *</label>
                        <div class="empresa-input-container">
                            <i class="fas fa-layer-group empresa-input-icon"></i>
                            <input type="text" name="categoria" value="{{ old('categoria', $proyecto->categoria) }}" required class="empresa-form-control" placeholder="Ej: Tecnología, Salud...">
                        </div>
                    </div>
                </div>
            </section>

            {{-- SECCIÓN 2: DESCRIPCIÓN --}}
            <section>
                <div class="empresa-form-section">
                    <span class="empresa-form-step-number">2</span>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Alcance y Requisitos</h3>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="empresa-form-label">Descripción Detallada *</label>
                    <textarea name="descripcion" required class="empresa-textarea" rows="5" placeholder="Objetivos, alcance e impacto del proyecto...">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="empresa-form-label">Perfil Técnico (Hardskills) *</label>
                        <textarea name="requisitos" required class="empresa-textarea" rows="3" placeholder="Herramientas, lenguajes o conocimientos específicos...">{{ old('requisitos', $proyecto->requisitos_especificos) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="empresa-form-label">Cualidades de Equipo (Softskills) *</label>
                        <textarea name="habilidades" required class="empresa-textarea" rows="3" placeholder="Liderazgo, comunicación, resolución de problemas...">{{ old('habilidades', $proyecto->habilidades_requeridas) }}</textarea>
                    </div>
                </div>
            </section>

            {{-- SECCIÓN 3: MAPA --}}
            <div style="margin-bottom: 32px;">
                {{-- MAPA --}}
                <section>
                    <div class="empresa-form-section" style="justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span class="empresa-form-step-number">3</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Localización</h3>
                        </div>
                        <button type="button" id="btn-detectar" class="btn-premium" style="background: white; color: var(--primary); border: 1px solid var(--primary-soft); font-size: 11px; padding: 6px 14px; box-shadow: none;">
                            <i class="fas fa-location-arrow"></i> Sincronizar GPS
                        </button>
                    </div>

                    <div class="empresa-map-wrapper" style="margin-top: 16px;">
                        <div id="map-editar" style="width: 100%; height: 210px;"></div>
                        <div id="location-overlay" class="empresa-location-overlay" style="display: none;">
                            <i class="fas fa-circle-check"></i> Coordenadas establecidas
                        </div>
                    </div>

                    <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', $proyecto->latitud) }}">
                    <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', $proyecto->longitud) }}">

                    <p style="font-size: 12px; color: var(--text-lighter); margin-top: 10px; font-weight: 600; text-align: center;">
                        <i class="fas fa-hand-pointer"></i> Haz clic en el mapa o arrastra el PIN para ajustar la ubicación.
                    </p>
                </section>
            </div>

            {{-- SECCIÓN 4: IMAGEN --}}
            <section>
                <div class="empresa-form-section">
                    <span class="empresa-form-step-number">4</span>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Material Visual</h3>
                </div>

                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    @if($proyecto->imagen_url)
                        <img src="{{ $proyecto->imagen_url }}" style="width: 120px; height: 120px; border-radius: 16px; object-fit: cover; border: 2px solid var(--border); flex-shrink: 0;">
                    @endif
                    <div class="empresa-upload-box" style="flex: 1; position: relative; padding: 28px;">
                        <div class="empresa-upload-icon-wrapper">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 28px; color: var(--primary);"></i>
                        </div>
                        <p style="font-size: 14px; font-weight: 700; color: var(--text);">Cambiar imagen del proyecto</p>
                        <input type="file" name="imagen" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 5;">
                    </div>
                </div>
            </section>

            {{-- ACTIONS --}}
            <div style="display: flex; gap: 16px; justify-content: flex-end; padding-top: 24px; border-top: 2px solid #f1f5f9;">
                <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 14px 28px;">
                    Cancelar
                </a>
                <button type="submit" class="btn-premium" style="padding: 14px 40px;">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/maps.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── MAP ──────────────────────────────────────────────────────
    const instancia = initEditorMap('map-editar', {
        lat: {{ old('latitud', $proyecto->latitud ?? 10.8642) }},
        lng: {{ old('longitud', $proyecto->longitud ?? -74.7777) }},
        canEdit: true,
        latInput: 'latitud',
        lngInput: 'longitud',
        onUpdate: function() {
            const ov = document.getElementById('location-overlay');
            if (ov) {
                ov.style.display = 'block';
                ov.style.opacity = '1';
                setTimeout(() => { ov.style.opacity = '0'; setTimeout(() => ov.style.display = 'none', 400); }, 2500);
            }
        }
    });
    window._editorMapInstance = instancia;

    document.getElementById('btn-detectar')
        ?.addEventListener('click', () => detectarUbicacion('btn-detectar'));
});
</script>
@endsection
