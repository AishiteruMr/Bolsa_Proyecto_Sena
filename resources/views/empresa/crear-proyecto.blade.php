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

@section('content')<div style="max-width: 1200px; margin: 0 auto; animation: fadeIn 0.8s ease-out;">
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-chevron-left"></i> Volver al Portafolio
                </a>
            </div>
            <h2 style="font-size:36px; font-weight:800; color:var(--text); letter-spacing: -1.5px;">Publicar <span style="color: var(--primary);">Nueva Convocatoria</span></h2>
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
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">1</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Identidad y Clasificación</h3>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                        <div class="form-group">
                            <label style="font-size: 13px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Título Descriptivo *</label>
                            <div style="position: relative;">
                                <i class="fas fa-tag" style="position: absolute; left: 18px; top: 18px; color: #94a3b8;"></i>
                                <input type="text" name="titulo" value="{{ old('titulo') }}" required class="form-control" placeholder="Ej: Rediseño de Plataforma Logística" style="padding-left: 50px; height: 56px; border-radius: 16px; border: 1.5px solid #e2e8f0; font-weight: 600;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 13px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Sector Económico *</label>
                            <div style="position: relative;">
                                <i class="fas fa-layer-group" style="position: absolute; left: 18px; top: 18px; color: #94a3b8;"></i>
                                <select name="categoria" required class="form-control" style="padding-left: 50px; height: 56px; border-radius: 16px; border: 1.5px solid #e2e8f0; font-weight: 600; appearance: none;">
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
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">2</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Definición y Requisitos</h3>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 24px;">
                        <label style="font-size: 13px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Memoria Descriptiva del Proyecto *</label>
                        <textarea name="descripcion" required class="form-control" rows="5" placeholder="Describe los objetivos, alcance y el impacto esperado del proyecto..." style="padding: 20px; border-radius: 16px; border: 1.5px solid #e2e8f0; font-weight: 500; line-height: 1.6;">{{ old('descripcion') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div class="form-group">
                            <label style="font-size: 13px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Perfil Técnico (Hardskills) *</label>
                            <textarea name="requisitos" required class="form-control" rows="3" placeholder="Herramientas, lenguajes o conocimientos específicos..." style="padding: 16px; border-radius: 16px; border: 1.5px solid #e2e8f0; font-weight: 500;">{{ old('requisitos') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 13px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Cualidades de Equipo (Softskills) *</label>
                            <textarea name="habilidades" required class="form-control" rows="3" placeholder="Liderazgo, comunicación, resolución de problemas..." style="padding: 16px; border-radius: 16px; border: 1.5px solid #e2e8f0; font-weight: 500;">{{ old('habilidades') }}</textarea>
                        </div>
                    </div>
                </section>

                <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 48px;">
                    {{-- SECCIÓN 3: LOGÍSTICA --}}
                    <section>
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
                            <span style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">3</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Planificación Temporal</h3>
                        </div>
                        
                        <div style="background: #f8fafc; padding: 28px; border-radius: 24px; border: 1.5px solid #e2e8f0; display: grid; gap: 20px;">
                            <div class="form-group">
                                <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Apertura Convocatoria</label>
                                <div style="position: relative;">
                                    <i class="far fa-calendar-alt" style="position: absolute; left: 16px; top: 16px; color: #94a3b8;"></i>
                                    <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', date('Y-m-d')) }}" required class="form-control" style="padding-left: 44px; height: 50px; border-radius: 12px; background: white;">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div class="form-group">
                                    <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Duración Proyectada</label>
                                    <input type="text" id="duracion" readonly class="form-control" style="background: var(--primary-soft); border-color: var(--primary-glow); font-weight: 800; color: var(--primary-dark); height: 50px; border-radius: 12px; text-align: center;">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Cierre de Ciclo</label>
                                    <input type="text" id="fecha_finalizacion" readonly class="form-control" style="background: white; border-color: #e2e8f0; font-weight: 700; color: var(--text); height: 50px; border-radius: 12px; text-align: center;">
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- SECCIÓN 4: GEORREFERENCIACIÓN --}}
                    <section>
                         <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 32px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">4</span>
                                <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Localización</h3>
                            </div>
                            <button type="button" id="btn-detectar" class="btn-premium" style="background: white; color: var(--primary); border: 1px solid var(--primary-soft); font-size: 11px; padding: 6px 14px; box-shadow: none;">
                                <i class="fas fa-location-arrow"></i> Sincronizar GPS
                            </button>
                        </div>
                        
                        <div id="map-container" style="position: relative;">
                            <div id="map" style="width: 100%; height: 210px; border-radius: 20px; border: 2px solid #e2e8f0; box-shadow: 0 10px 20px rgba(0,0,0,0.05);"></div>
                            <div id="location-overlay" style="display: none; position: absolute; bottom: 12px; left: 12px; right: 12px; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 10px 16px; border-radius: 12px; font-size: 12px; font-weight: 800; border: 1.5px solid var(--primary); color: var(--primary-dark); display: flex; align-items: center; gap: 8px; animation: slideUp 0.3s ease;">
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
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">5</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Material de Referencia</h3>
                    </div>

                    <div id="image-upload-container" style="border: 2.5px dashed #cbd5e1; border-radius: 24px; padding: 60px 40px; text-align: center; background: #f8fafc; position: relative; transition: all 0.3s ease; cursor: pointer; overflow: hidden;">
                        <div id="upload-placeholder">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.03);">
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
                    <button type="submit" class="btn-premium" style="padding: 16px 48px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
                        <i class="fas fa-rocket"></i> Lanzar Convocatoria
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
  </div>
    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ---- LÓGICA DE FECHAS ----
    const fechaPubliInput = document.getElementById('fecha_publi');
    const duracionInput = document.getElementById('duracion');
    const fechaFinalizacionInput = document.getElementById('fecha_finalizacion');

    function calcularFechas() {
        const fechaPubli = new Date(fechaPubliInput.value);
        if (!isNaN(fechaPubli.getTime())) {
            const fechaFinalizacion = new Date(fechaPubli);
            fechaFinalizacion.setMonth(fechaFinalizacion.getMonth() + 6);
            const duracionDias = Math.ceil((fechaFinalizacion - fechaPubli) / (1000 * 60 * 60 * 24));
            const opcionesFormato = { year: 'numeric', month: 'short', day: 'numeric' };
            duracionInput.value = duracionDias + ' días (6 meses)';
            fechaFinalizacionInput.value = fechaFinalizacion.toLocaleDateString('es-ES', opcionesFormato);
        }
    }
    fechaPubliInput.addEventListener('change', calcularFechas);
    calcularFechas();

    // ---- LÓGICA DE MAPA Y GEOLOCALIZACIÓN ----
    const canEditLocation = @json(in_array(session('rol'), [2, 4]));
    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');
    const btnDetectar = document.getElementById('btn-detectar');
    const overlay = document.getElementById('location-overlay');
    
    let defaultLat = 10.8642; // SENA Malambo por defecto si falla todo
    let defaultLng = -74.7777;

    const map = L.map('map').setView([defaultLat, defaultLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker([defaultLat, defaultLng], {
        draggable: canEditLocation
    }).addTo(map);

    function updateFields(lat, lng) {
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
        overlay.style.display = 'block';
        setTimeout(() => { overlay.style.opacity = '0'; setTimeout(() => overlay.style.display = 'none', 500); }, 3000);
    }

    marker.on('dragend', function(e) {
        const pos = marker.getLatLng();
        updateFields(pos.lat, pos.lng);
    });

    if (canEditLocation) {
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateFields(e.latlng.lat, e.latlng.lng);
        });
    }

    function detectarUbicacion() {
        if ("geolocation" in navigator) {
            btnDetectar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detectando...';
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                updateFields(lat, lng);
                btnDetectar.innerHTML = '<i class="fas fa-location-crosshairs"></i> Detectar de nuevo';
            }, function(error) {
                console.warn("Error de geolocalización:", error);
                btnDetectar.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Falló detección';
                setTimeout(() => btnDetectar.innerHTML = '<i class="fas fa-location-crosshairs"></i> Detectar de nuevo', 2000);
            });
        }
    }

    // Ejecutar detección automática al inicio
    detectarUbicacion();
    btnDetectar.addEventListener('click', detectarUbicacion);

    // Ajustar mapa
    setTimeout(() => { map.invalidateSize(); }, 500);

    // ---- VISTA PREVIA IMAGEN ----
    const imagenInput = document.getElementById('imagen-input');
    const imagePreview = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');

    imagenInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
