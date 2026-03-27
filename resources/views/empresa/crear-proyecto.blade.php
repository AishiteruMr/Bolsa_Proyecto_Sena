@extends('layouts.dashboard')
@section('title', 'Publicar Proyecto')
@section('page-title', 'Publicar Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
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
<div class="animate-fade-in" style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-chevron-left"></i> Volver al Portafolio
                </a>
            </div>
            <h2 class="empresa-hero-title" style="color:var(--text); letter-spacing: -1.5px;">Publicar <span style="color: var(--primary);">Nueva Convocatoria</span></h2>
            <p style="color:var(--text-light); font-size:16px; margin-top:6px; font-weight: 500;">Conecta con el ecosistema de talento más grande del país.</p>
        </div>
        <div class="glass-card" style="padding: 12px 24px; border-radius: 16px; border-color: var(--primary-soft); background: rgba(255,255,255,0.9); display: flex; align-items: center; gap: 12px;">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-shield-halved"></i>
            </div>
            <span style="font-size: 13px; font-weight: 800; color: var(--text); letter-spacing: 0.5px;">Validación de Seguridad Activa</span>
        </div>
    </div>

    <form action="{{ route('empresa.proyectos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="glass-card" style="padding: 0; overflow: hidden; background: white; border: none; box-shadow: var(--shadow-premium);">
            <!-- Header Banner -->
            <div style="background: linear-gradient(135deg, var(--secondary) 0%, #0f172a 100%); padding: 32px 48px; position: relative; overflow: hidden;">
                <div style="position: absolute; right: -20px; top: -20px; font-size: 120px; color: rgba(255,255,255,0.03); transform: rotate(-10deg);">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; color: white; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-file-signature" style="color: var(--primary);"></i>
                    Especificaciones Técnicas del Proyecto
                </h3>
                <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin-top: 4px; font-weight: 500;">Por favor, completa todos los campos marcados con asterisco (*)</p>
            </div>

            <div style="padding: 48px; display: grid; gap: 48px;">
                
                {{-- SECCIÓN 1: IDENTIDAD DEL PROYECTO --}}
                <section>
                    <div class="empresa-form-section">
                        <span class="empresa-form-step-number">1</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Identidad y Clasificación</h3>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                        <div class="form-group">
                            <label class="empresa-form-label">Título Descriptivo *</label>
                            <div class="empresa-input-container">
                                <i class="fas fa-tag empresa-input-icon"></i>
                                <input type="text" name="titulo" value="{{ old('titulo') }}" required class="empresa-form-control" placeholder="Ej: Rediseño de Plataforma Logística">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="empresa-form-label">Sector Económico *</label>
                            <div class="empresa-input-container">
                                <i class="fas fa-layer-group empresa-input-icon"></i>
                                <select name="categoria" required class="empresa-form-control" style="appearance: none;">
                                    <option value="">Seleccionar Sector...</option>
                                    <option value="Tecnología">Tecnología e Información</option>
                                    <option value="Agrícola">Gestión Agrícola</option>
                                    <option value="Industrial">Manufactura Industrial</option>
                                    <option value="Salud">Salud y Bienestar</option>
                                    <option value="Ambiental">Sostenibilidad Ambiental</option>
                                    <option value="Otro">Otros Sectores</option>
                                </select>
                                <i class="fas fa-chevron-down" style="position: absolute; right: 18px; top: 22px; color: #94a3b8; font-size: 12px; pointer-events: none;"></i>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- SECCIÓN 2: DEFINICIÓN E IMPACTO --}}
                <section>
                    <div class="empresa-form-section">
                        <span class="empresa-form-step-number">2</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Definición y Requisitos</h3>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="empresa-form-label">Memoria Descriptiva del Proyecto *</label>
                        <textarea name="descripcion" required class="empresa-textarea" rows="5" placeholder="Describe los objetivos, alcance y el impacto esperado del proyecto...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div class="form-group">
                            <label class="empresa-form-label">Perfil Técnico (Hardskills) *</label>
                            <textarea name="requisitos" required class="empresa-textarea" rows="3" placeholder="Herramientas, lenguajes o conocimientos específicos...">{{ old('requisitos') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="empresa-form-label">Cualidades de Equipo (Softskills) *</label>
                            <textarea name="habilidades" required class="empresa-textarea" rows="3" placeholder="Liderazgo, comunicación, resolución de problemas...">{{ old('habilidades') }}</textarea>
                        </div>
                    </div>
                </section>

                <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 48px;">
                    {{-- SECCIÓN 3: LOGÍSTICA --}}
                    <section>
                        <div class="empresa-form-section">
                            <span class="empresa-form-step-number">3</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Planificación Temporal</h3>
                        </div>
                        
                        <div style="background: #f8fafc; padding: 28px; border-radius: 24px; border: 1.5px solid #e2e8f0; display: grid; gap: 20px;">
                            <div class="form-group">
                                <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Apertura Convocatoria</label>
                                <div class="empresa-input-container">
                                    <i class="far fa-calendar-alt empresa-input-icon" style="top: 16px;"></i>
                                    <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', date('Y-m-d')) }}" required class="form-control" style="padding-left: 44px; height: 50px; border-radius: 12px; background: white; width: 100%; border: 1px solid #e2e8f0;">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div class="form-group">
                                    <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Duración Proyectada</label>
                                    <input type="text" id="duracion" readonly class="form-control" style="background: var(--primary-soft); border-color: var(--primary-glow); font-weight: 800; color: var(--primary-hover); height: 50px; border-radius: 12px; text-align: center; width:100%;">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Cierre de Ciclo</label>
                                    <input type="text" id="fecha_finalizacion" readonly class="form-control" style="background: white; border-color: #e2e8f0; font-weight: 700; color: var(--text); height: 50px; border-radius: 12px; text-align: center; width: 100%;">
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- SECCIÓN 4: GEORREFERENCIACIÓN --}}
                    <section>
                         <div class="empresa-form-section" style="justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span class="empresa-form-step-number">4</span>
                                <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Localización</h3>
                            </div>
                            <button type="button" id="btn-detectar" class="btn-premium" style="background: white; color: var(--primary); border: 1px solid var(--primary-soft); font-size: 11px; padding: 6px 14px; box-shadow: none;">
                                <i class="fas fa-location-arrow"></i> Sincronizar GPS
                            </button>
                        </div>
                        
                        <div class="empresa-map-wrapper">
                            <div id="map" style="width: 100%; height: 210px;"></div>
                            <div id="location-overlay" class="empresa-location-overlay" style="display: none;">
                                <i class="fas fa-circle-check"></i> Coordenadas establecidas con precisión
                            </div>
                        </div>
                        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
                        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">
                        <p id="map-help" style="font-size: 12px; color: var(--text-lighter); margin-top: 12px; font-weight: 600; text-align: center;">
                            @if(in_array(session('rol'), [2, 4]))
                                <i class="fas fa-hand-pointer"></i> Haz clic o arrastra el PIN para precisar la sede.
                            @else
                                <i class="fas fa-lock"></i> Ubicación vinculada al registro corporativo oficial.
                            @endif
                        </p>
                    </section>
                </div>

                {{-- SECCIÓN 5: SOPORTE VISUAL --}}
                <section>
                    <div class="empresa-form-section">
                        <span class="empresa-form-step-number">5</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Material de Referencia</h3>
                    </div>

                    <div id="image-upload-container" class="empresa-upload-box">
                        <div id="upload-placeholder">
                            <div class="empresa-upload-icon-wrapper">
                                <i class="fas fa-cloud-arrow-up" style="font-size: 32px; color: var(--primary);"></i>
                            </div>
                            <h4 style="font-size: 18px; font-weight: 800; color: var(--text);">Identity Branding del Proyecto</h4>
                            <p style="font-size: 14px; color: var(--text-light); margin-top: 6px; font-weight: 500;">Sube una imagen de alta calidad para destacar tu convocatoria.</p>
                            <div style="margin-top: 24px; display: flex; justify-content: center; gap: 12px;">
                                <span style="background: white; padding: 6px 14px; border-radius: 30px; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; color: #64748b;">FORMATO: PNG, JPG</span>
                                <span style="background: white; padding: 6px 14px; border-radius: 30px; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; color: #64748b;">PESO: MÁX 3MB</span>
                            </div>
                        </div>
                        <img id="image-preview" style="display: none; max-width: 100%; max-height: 400px; border-radius: 20px; margin: 0 auto; box-shadow: var(--shadow-premium); border: 4px solid white;">
                        <input type="file" name="imagen" id="imagen-input" accept="image/*" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer; z-index: 5;">
                    </div>
                </section>

                <div style="display: flex; gap: 20px; justify-content: flex-end; padding-top: 32px; border-top: 2px solid #f1f5f9;">
                    <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 16px 32px;">
                        Descartar Borrador
                    </a>
                    <button type="submit" class="btn-premium" style="padding: 16px 48px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);">
                        <i class="fas fa-rocket"></i> Lanzar Convocatoria
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/maps.js') }}"></script>
<script src="{{ asset('js/forms.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const config = {
        lat: {{ old('latitud') ?? 10.8642 }},
        lng: {{ old('longitud') ?? -74.7777 }},
        canEdit: @json(in_array(session('rol'), [2, 4])),
        latInput: 'latitud',
        lngInput: 'longitud',
        onUpdate: function(lat, lng) {
            const overlay = document.getElementById('location-overlay');
            if (overlay) {
                overlay.style.display = 'block';
                overlay.style.opacity = '1';
                setTimeout(() => { 
                    overlay.style.opacity = '0'; 
                    setTimeout(() => overlay.style.display = 'none', 500); 
                }, 3000);
            }
        }
    };
    
    initEditorMap('map', config);

    const btnDetectar = document.getElementById('btn-detectar');
    if (btnDetectar) {
        btnDetectar.addEventListener('click', () => detectarUbicacion('btn-detectar'));
    }
});
</script>
@endsection
