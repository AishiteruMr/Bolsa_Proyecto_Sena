@extends('layouts.dashboard')
@section('title', 'Editar Proyecto')
@section('page-title', 'Editar Proyecto')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
<div class="animate-fade-in" style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 32px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
            <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 8px 16px; font-size: 13px;">
                <i class="fas fa-chevron-left"></i> Volver al Portafolio
            </a>
        </div>
        <h2 style="font-size:28px; font-weight:800; color:var(--text); letter-spacing:-0.5px;">
            Editar <span style="color: var(--primary);">Convocatoria</span>
        </h2>
        <p style="color:var(--text-light); font-size:15px; margin-top:4px; font-weight: 500;">Actualiza la información y requerimientos de tu proyecto.</p>
    </div>

    <form action="{{ route('empresa.proyectos.update', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" name="titulo" value="{{ old('titulo', $proyecto->pro_titulo_proyecto) }}" required class="empresa-form-control" placeholder="Título descriptivo de la convocatoria">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="empresa-form-label">Categoría / Sector *</label>
                        <div class="empresa-input-container">
                            <i class="fas fa-layer-group empresa-input-icon"></i>
                            <input type="text" name="categoria" value="{{ old('categoria', $proyecto->pro_categoria) }}" required class="empresa-form-control" placeholder="Ej: Tecnología, Salud...">
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
                    <textarea name="descripcion" required class="empresa-textarea" rows="5" placeholder="Objetivos, alcance e impacto del proyecto...">{{ old('descripcion', $proyecto->pro_descripcion) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="empresa-form-label">Perfil Técnico (Hardskills) *</label>
                        <textarea name="requisitos" required class="empresa-textarea" rows="3" placeholder="Herramientas, lenguajes o conocimientos específicos...">{{ old('requisitos', $proyecto->pro_requisitos_especificos) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="empresa-form-label">Cualidades de Equipo (Softskills) *</label>
                        <textarea name="habilidades" required class="empresa-textarea" rows="3" placeholder="Liderazgo, comunicación, resolución de problemas...">{{ old('habilidades', $proyecto->pro_habilidades_requerida) }}</textarea>
                    </div>
                </div>
            </section>

            {{-- SECCIÓN 3: CRONOGRAMA + MAPA (2 columnas) --}}
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px;">

                {{-- CRONOGRAMA --}}
                <section>
                    <div class="empresa-form-section">
                        <span class="empresa-form-step-number">3</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Planificación Temporal</h3>
                    </div>
                    <div style="background: #f8fafc; padding: 24px; border-radius: 20px; border: 1.5px solid #e2e8f0; display: grid; gap: 16px;">
                        <div class="form-group">
                            <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Apertura de Convocatoria *</label>
                            <div class="empresa-input-container" style="margin-top: 8px;">
                                <i class="far fa-calendar-alt empresa-input-icon" style="top: 16px;"></i>
                                <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', $proyecto->pro_fecha_publi) }}" required class="empresa-form-control">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div class="form-group">
                                <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Duración</label>
                                <input type="text" id="duracion" readonly class="empresa-form-control" style="background: var(--primary-soft); border-color: var(--primary-glow); font-weight: 800; color: var(--primary-hover); text-align: center; margin-top: 8px;">
                            </div>
                            <div class="form-group">
                                <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Cierre Estimado</label>
                                <input type="text" id="fecha_finalizacion" readonly class="empresa-form-control" style="background: white; font-weight: 700; text-align: center; margin-top: 8px;">
                            </div>
                        </div>
                    </div>
                </section>

                {{-- MAPA --}}
                <section>
                    <div class="empresa-form-section" style="justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span class="empresa-form-step-number">4</span>
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

                    <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', $proyecto->pro_latitud) }}">
                    <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', $proyecto->pro_longitud) }}">

                    <p style="font-size: 12px; color: var(--text-lighter); margin-top: 10px; font-weight: 600; text-align: center;">
                        <i class="fas fa-hand-pointer"></i> Haz clic en el mapa o arrastra el PIN para ajustar la ubicación.
                    </p>
                </section>
            </div>

            {{-- SECCIÓN 5: IMAGEN --}}
            <section>
                <div class="empresa-form-section">
                    <span class="empresa-form-step-number">5</span>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Material Visual</h3>
                </div>

                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    @if($proyecto->pro_imagen_url)
                        <img src="{{ $proyecto->pro_imagen_url }}" style="width: 120px; height: 120px; border-radius: 16px; object-fit: cover; border: 2px solid var(--border); flex-shrink: 0;">
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
        lat: {{ old('latitud', $proyecto->pro_latitud ?? 10.8642) }},
        lng: {{ old('longitud', $proyecto->pro_longitud ?? -74.7777) }},
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

    // ── FECHAS ───────────────────────────────────────────────────
    const fechaInput   = document.getElementById('fecha_publi');
    const durInput     = document.getElementById('duracion');
    const finInput     = document.getElementById('fecha_finalizacion');

    function calcularFechas() {
        const d = new Date(fechaInput.value);
        if (!isNaN(d)) {
            const fin = new Date(d);
            fin.setMonth(fin.getMonth() + 6);
            const dias = Math.ceil((fin - d) / 86400000);
            if (durInput) durInput.value = dias + ' días (6 meses)';
            if (finInput) finInput.value = fin.toLocaleDateString('es-ES', { year:'numeric', month:'short', day:'numeric' });
        }
    }
    if (fechaInput) { fechaInput.addEventListener('change', calcularFechas); calcularFechas(); }
});
</script>
@endsection
