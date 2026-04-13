@extends('layouts.dashboard')
@section('title', 'Publicar Proyecto')
@section('page-title', 'Publicar Proyecto')

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
<div class="animate-fade-in" style="max-width: 1200px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero" style="margin-bottom: 32px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-paper-plane"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                    <i class="fas fa-arrow-left"></i> Volver al Portafolio
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Nueva Convocatoria</span>
            </div>
            <h1 class="instructor-title">Publicar <span style="color: var(--primary);">Proyecto</span></h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 16px; font-weight: 500;">Conecta con el ecosistema de talento más grande del país.</p>
        </div>
    </div>

    <form action="{{ route('empresa.proyectos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <!-- Header Banner -->
            <div style="background: linear-gradient(135deg, #0a1a15, #1a2e28); padding: 32px 48px; position: relative; overflow: hidden;">
                <div style="position: absolute; right: -20px; top: -20px; font-size: 120px; color: rgba(62,180,137,0.08); transform: rotate(-10deg);">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; color: white; display: flex; align-items: center; gap: 14px;">
                    <i class="fas fa-file-signature" style="color: #3eb489;"></i>
                    Especificaciones del Proyecto
                </h3>
                <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin-top: 4px; font-weight: 500;">Completa los campos</p>
            </div>

            <div style="padding: 48px; display: grid; gap: 48px;">
                
                <!-- Step 1: Identidad -->
                <div>
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">1</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Identidad y Clasificación</h3>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Título Descriptivo</label>
                            <div style="position: relative;">
                                <i class="fas fa-tag" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                <input type="text" name="titulo" value="{{ old('titulo') }}" required style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;" placeholder="Ej: Rediseño de Plataforma Logística">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Sector Económico</label>
                            <div style="position: relative;">
                                <i class="fas fa-layer-group" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                <select name="categoria" required style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: white; appearance: none;">
                                    <option value="">Seleccionar Sector...</option>
                                    <option value="Tecnología">Tecnología e Información</option>
                                    <option value="Agrícola">Gestión Agrícola</option>
                                    <option value="Industrial">Manufactura Industrial</option>
                                    <option value="Salud">Salud y Bienestar</option>
                                    <option value="Ambiental">Sostenibilidad Ambiental</option>
                                    <option value="Otro">Otros Sectores</option>
                                </select>
                                <i class="fas fa-chevron-down" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Definición -->
                <div>
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">2</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Definición y Requisitos</h3>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Memoria Descriptiva</label>
                        <textarea name="descripcion" required rows="5" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;" placeholder="Describe los objetivos, alcance y el impacto esperado...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Perfil Técnico (Hardskills)</label>
                            <textarea name="requisitos" required rows="3" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;" placeholder="Herramientas, lenguajes o conocimientos específicos...">{{ old('requisitos') }}</textarea>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Cualidades de Equipo (Softskills)</label>
                            <textarea name="habilidades" required rows="3" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;" placeholder="Liderazgo, comunicación, resolución de problemas...">{{ old('habilidades') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Steps 3 & 4 -->
                <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 48px;">
                    
                    <!-- Step 3: Planificación -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                            <span style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">3</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Planificación Temporal</h3>
                        </div>
                        
                        <div style="background: #f8fafc; padding: 28px; border-radius: 20px; border: 1.5px solid #e2e8f0; display: grid; gap: 20px;">
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Fecha de Apertura</label>
                                <div style="position: relative;">
                                    <i class="far fa-calendar-alt" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                    <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', date('Y-m-d')) }}" required style="width: 100%; padding: 12px 16px 12px 48px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Duración</label>
                                    <input type="text" id="duracion" readonly style="width: 100%; padding: 12px; border: 1px solid rgba(62,180,137,0.2); border-radius: 12px; font-size: 14px; font-weight: 700; color: #3eb489; background: rgba(62,180,137,0.1); text-align: center;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">Cierre</label>
                                    <input type="text" id="fecha_finalizacion" readonly style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 700; color: var(--text); background: white; text-align: center;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Localización -->
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">4</span>
                                <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Localización</h3>
                            </div>
                            <button type="button" id="btn-detectar" style="display: inline-flex; align-items: center; gap: 8px; background: white; color: #3eb489; border: 1px solid rgba(62,180,137,0.2); padding: 8px 16px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer;">
                                <i class="fas fa-location-arrow"></i> GPS
                            </button>
                        </div>
                        
                        <div style="border: 2px dashed #e2e8f0; border-radius: 16px; overflow: hidden; margin-bottom: 12px;">
                            <div id="map" style="width: 100%; height: 180px;"></div>
                        </div>
                        <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
                        <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">
                        <p style="font-size: 12px; color: var(--text-lighter); font-weight: 600; text-align: center;">
                            <i class="fas fa-hand-pointer"></i> Haz clic o arrastra el PIN para precisar la sede.
                        </p>
                    </div>
                </div>

                <!-- Step 5: Material Visual -->
                <div>
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">5</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Material de Referencia</h3>
                    </div>

                    <div id="image-upload-container" style="border: 2px dashed #cbd5e1; border-radius: 20px; padding: 60px 40px; text-align: center; background: #f8fafc; transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.borderColor='#3eb489'; this.style.background='rgba(62,180,137,0.02)'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'">
                        <div id="upload-placeholder">
                            <div style="width: 80px; height: 80px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                                <i class="fas fa-cloud-arrow-up" style="font-size: 32px; color: #3eb489;"></i>
                            </div>
                            <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 8px;">Identity Branding del Proyecto</h4>
                            <p style="font-size: 14px; color: var(--text-light); font-weight: 500;">Sube una imagen de alta calidad para destacar tu convocatoria.</p>
                            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 12px;">
                                <span style="background: white; padding: 6px 14px; border-radius: 30px; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; color: #64748b;">PNG, JPG</span>
                                <span style="background: white; padding: 6px 14px; border-radius: 30px; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 800; color: #64748b;">MÁX 3MB</span>
                            </div>
                        </div>
                        <img id="image-preview" style="display: none; max-width: 100%; max-height: 350px; border-radius: 16px; margin: 0 auto; box-shadow: 0 20px 50px -12px rgba(62,180,137,0.3);">
                        <input type="file" name="imagen" id="imagen-input" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 5;">
                    </div>
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 20px; justify-content: flex-end; padding-top: 32px; border-top: 2px solid #f1f5f9;">
                    <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 14px 28px;">
                        Descartar
                    </a>
                    <button type="submit" class="btn-premium" style="padding: 14px 40px;">
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
    // Map
    const config = {
        lat: {{ old('latitud') ?? 10.8642 }},
        lng: {{ old('longitud') ?? -74.7777 }},
        canEdit: true,
        latInput: 'latitud',
        lngInput: 'longitud',
        onUpdate: function() {}
    };
    initEditorMap('map', config);

    // Fecha calculations
    const fechaInput = document.getElementById('fecha_publi');
    const durInput = document.getElementById('duracion');
    const finInput = document.getElementById('fecha_finalizacion');

    function calcularFechas() {
        const d = new Date(fechaInput.value);
        if (!isNaN(d)) {
            const fin = new Date(d);
            fin.setMonth(fin.getMonth() + 6);
            const dias = Math.ceil((fin - d) / 86400000);
            if (durInput) durInput.value = dias + ' días';
            if (finInput) finInput.value = fin.toLocaleDateString('es-ES', { year:'numeric', month:'short', day:'numeric' });
        }
    }
    if (fechaInput) { fechaInput.addEventListener('change', calcularFechas); calcularFechas(); }

    // Image preview
    const input = document.getElementById('imagen-input');
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');
    if (input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
