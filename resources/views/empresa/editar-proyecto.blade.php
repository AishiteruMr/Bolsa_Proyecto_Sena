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
    @vite(['resources/css/empresa.css'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .oferta-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 24px 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            text-align: center;
            position: relative;
            user-select: none;
        }
        .oferta-card:hover {
            border-color: #c4b5fd;
            background: #faf5ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139,92,246,0.1);
        }
        .oferta-card.selected {
            border-color: #8b5cf6;
            background: linear-gradient(135deg, #faf5ff, #f3e8ff);
            box-shadow: 0 8px 30px rgba(139,92,246,0.15);
        }
        .oferta-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .oferta-check {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
            transition: all 0.3s ease;
        }
        .oferta-card.selected .oferta-check {
            background: #8b5cf6;
            border-color: #8b5cf6;
            box-shadow: 0 2px 8px rgba(139,92,246,0.3);
        }
        .oferta-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        .oferta-card.selected .oferta-icon {
            box-shadow: 0 4px 15px rgba(139,92,246,0.3);
        }
        .oferta-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--text);
        }
        .oferta-card.selected .oferta-title {
            color: #6d28d9;
        }
        .oferta-desc {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            line-height: 1.3;
        }
        .oferta-card.selected .oferta-desc {
            color: #7c3aed;
        }
        @media (max-width: 640px) {
            .oferta-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('empresa.dashboard')], ['label' => 'Proyectos', 'url' => route('empresa.proyectos')], ['label' => 'Editar']]; @endphp
@section('content')
<div class="animate-fade-in" style="max-width: 1200px; margin: 0 auto; padding-bottom: 40px;">
    
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
                <span class="instructor-tag">Editar Convocatoria</span>
            </div>
            <h1 class="instructor-title">Editar <span style="color: var(--primary);">Proyecto</span></h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 16px; font-weight: 500;">Actualiza la información y requerimientos de tu proyecto.</p>
        </div>
    </div>

    <form action="{{ route('empresa.proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data" id="editar-proyecto-form">
        @csrf
        @method('PUT')
        
        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <!-- Header Banner -->
            <div style="background: linear-gradient(135deg, #0a1a15, #1a2e28); padding: 32px 48px; position: relative; overflow: hidden;">
                <div style="position: absolute; right: -20px; top: -20px; font-size: 120px; color: rgba(62,180,137,0.08); transform: rotate(-10deg);">
                    <i class="fas fa-file-signature"></i>
                </div>
<<<<<<< HEAD
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="empresa-form-label">Título del Proyecto *</label>
                        <div class="empresa-input-container">
                            <i class="fas fa-tag empresa-input-icon"></i>
                            <input type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}" required class="empresa-form-control" placeholder="Título descriptivo de la convocatoria">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="empresa-form-label">Área de Formación *</label>
                        <div class="empresa-input-container">
                            <i class="fas fa-layer-group empresa-input-icon"></i>
                            <select name="categoria" required class="empresa-form-control" style="appearance:auto; cursor:pointer;">
                                <option value="">Seleccionar Área...</option>
                                @foreach(array_keys(config('programas')) as $cat)
                                    <option value="{{ $cat }}" {{ old('categoria', $proyecto->categoria) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
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
=======
                <h3 style="font-size: 22px; font-weight: 800; color: white; display: flex; align-items: center; gap: 14px;">
                    <i class="fas fa-edit" style="color: #3eb489;"></i>
                    Editar Especificaciones
                </h3>
                <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin-top: 4px; font-weight: 500;">Actualiza los campos que necesites</p>
>>>>>>> b9a8d24711bfe5df046b2e0111a713b6193dc5ed
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
                                <input type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}" required style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;" placeholder="Ej: Rediseño de Plataforma Logística">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Sector Económico</label>
                            <div style="position: relative;">
                                <i class="fas fa-layer-group" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                <select name="categoria" required style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: white; appearance: none;">
                                    <option value="">Seleccionar Sector...</option>
                                    <option value="Tecnología" {{ old('categoria', $proyecto->categoria) == 'Tecnología' ? 'selected' : '' }}>Tecnología e Información</option>
                                    <option value="Agrícola" {{ old('categoria', $proyecto->categoria) == 'Agrícola' ? 'selected' : '' }}>Gestión Agrícola</option>
                                    <option value="Industrial" {{ old('categoria', $proyecto->categoria) == 'Industrial' ? 'selected' : '' }}>Manufactura Industrial</option>
                                    <option value="Salud" {{ old('categoria', $proyecto->categoria) == 'Salud' ? 'selected' : '' }}>Salud y Bienestar</option>
                                    <option value="Ambiental" {{ old('categoria', $proyecto->categoria) == 'Ambiental' ? 'selected' : '' }}>Sostenibilidad Ambiental</option>
                                    <option value="Otro" {{ old('categoria', $proyecto->categoria) == 'Otro' ? 'selected' : '' }}>Otros Sectores</option>
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
                        <textarea name="descripcion" required rows="5" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;" placeholder="Describe los objetivos, alcance y el impacto esperado...">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Perfil Técnico (Hardskills)</label>
                            <textarea name="requisitos" required rows="3" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;" placeholder="Herramientas, lenguajes o conocimientos específicos...">{{ old('requisitos', $proyecto->requisitos_especificos) }}</textarea>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Cualidades de Equipo (Softskills)</label>
                            <textarea name="habilidades" required rows="3" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;" placeholder="Liderazgo, comunicación, resolución de problemas...">{{ old('habilidades', $proyecto->habilidades_requeridas) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Localización -->
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <span style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">3</span>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Localización</h3>
                        </div>
                        <button type="button" id="btn-detectar" style="display: inline-flex; align-items: center; gap: 8px; background: white; color: #3eb489; border: 1px solid rgba(62,180,137,0.2); padding: 8px 16px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer;">
                            <i class="fas fa-location-arrow"></i> GPS
                        </button>
                    </div>
                    
                    <div style="border: 2px dashed #e2e8f0; border-radius: 16px; overflow: hidden; margin-bottom: 12px;">
                        <div id="map-editar" style="width: 100%; height: 180px;"></div>
                    </div>
                    <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', $proyecto->latitud) }}">
                    <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', $proyecto->longitud) }}">
                    <p style="font-size: 12px; color: var(--text-lighter); font-weight: 600; text-align: center;">
                        <i class="fas fa-hand-pointer"></i> Haz clic o arrastra el PIN para precisar la sede.
                    </p>
                </div>

                <!-- Step 4: Material Visual -->
                <div>
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">4</span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Material de Referencia</h3>
                    </div>

                    <div style="display: flex; gap: 1.5rem; align-items: center;">
                        @if($proyecto->imagen_url)
                            <img src="{{ $proyecto->imagen_url }}" loading="lazy" style="width: 120px; height: 120px; border-radius: 16px; object-fit: cover; border: 2px solid var(--border); flex-shrink: 0;">
                        @endif
                        <div id="image-upload-container" style="flex: 1; border: 2px dashed #cbd5e1; border-radius: 20px; padding: 40px 30px; text-align: center; background: #f8fafc; transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.borderColor='#3eb489'; this.style.background='rgba(62,180,137,0.02)'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'">
                            <div id="upload-placeholder">
                                <div style="width: 64px; height: 64px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                                    <i class="fas fa-cloud-arrow-up" style="font-size: 26px; color: #3eb489;"></i>
                                </div>
                                <h4 style="font-size: 15px; font-weight: 800; color: var(--text); margin-bottom: 4px;">Cambiar imagen del proyecto</h4>
                                <p style="font-size: 12px; color: var(--text-light); font-weight: 500;">PNG, JPG — Máx 3MB</p>
                            </div>
                            <img id="image-preview" style="display: none; max-width: 100%; max-height: 250px; border-radius: 12px; margin: 0 auto; box-shadow: 0 20px 50px -12px rgba(62,180,137,0.3);">
                            <input type="file" name="imagen" id="imagen-input" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 5;">
                        </div>
                    </div>
                </div>

                <!-- Step 5: Oferta -->
                <div>
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(139,92,246,0.1);">
                        <span style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; box-shadow: 0 4px 10px rgba(139,92,246,0.3);">
                            <i class="fas fa-gift" style="font-size: 15px;"></i>
                        </span>
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Beneficio y Oferta del Proyecto</h3>
                    </div>

                    <div class="oferta-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 20px;">
                        <label class="oferta-card {{ old('oferta', $proyecto->oferta) === 'pasantias' ? 'selected' : '' }}">
                            <input type="radio" name="oferta" value="pasantias" {{ old('oferta', $proyecto->oferta) === 'pasantias' ? 'checked' : '' }} required>
                            <span class="oferta-check"><i class="fas fa-check"></i></span>
                            <span class="oferta-icon"><i class="fas fa-briefcase"></i></span>
                            <span class="oferta-title">Pasantías</span>
                            <span class="oferta-desc">Experiencia laboral formativa en tu empresa</span>
                        </label>
                        <label class="oferta-card {{ old('oferta', $proyecto->oferta) === 'contrato_aprendizaje' ? 'selected' : '' }}">
                            <input type="radio" name="oferta" value="contrato_aprendizaje" {{ old('oferta', $proyecto->oferta) === 'contrato_aprendizaje' ? 'checked' : '' }} required>
                            <span class="oferta-check"><i class="fas fa-check"></i></span>
                            <span class="oferta-icon"><i class="fas fa-file-contract"></i></span>
                            <span class="oferta-title">Contrato de aprendizaje</span>
                            <span class="oferta-desc">Vinculación formal con contrato de aprendizaje</span>
                        </label>
                        <label class="oferta-card {{ old('oferta', $proyecto->oferta) === 'auxilio_transporte' ? 'selected' : '' }}">
                            <input type="radio" name="oferta" value="auxilio_transporte" {{ old('oferta', $proyecto->oferta) === 'auxilio_transporte' ? 'checked' : '' }} required>
                            <span class="oferta-check"><i class="fas fa-check"></i></span>
                            <span class="oferta-icon"><i class="fas fa-bus"></i></span>
                            <span class="oferta-title">Auxilio de transporte</span>
                            <span class="oferta-desc">Apoyo económico para movilidad</span>
                        </label>
                        <label class="oferta-card {{ old('oferta', $proyecto->oferta) === 'otro' ? 'selected' : '' }}">
                            <input type="radio" name="oferta" value="otro" {{ old('oferta', $proyecto->oferta) === 'otro' ? 'checked' : '' }} required>
                            <span class="oferta-check"><i class="fas fa-check"></i></span>
                            <span class="oferta-icon"><i class="fas fa-gift"></i></span>
                            <span class="oferta-title">Otro</span>
                            <span class="oferta-desc">Otro tipo de beneficio u oferta</span>
                        </label>
                    </div>

                    <div id="otro-oferta-container" style="display: {{ old('oferta', $proyecto->oferta) === 'otro' ? 'block' : 'none' }}; margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">¿Cuál oferta? *</label>
                        <div style="position: relative;">
                            <i class="fas fa-pen" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #8b5cf6;"></i>
                            <input type="text" name="oferta_otro" id="oferta_otro" value="{{ old('oferta_otro', $proyecto->oferta_otro) }}" style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;" placeholder="Ej: Bolsa de estudio, Bonificación...">
                        </div>
                    </div>

                    <div style="padding: 16px 20px; background: linear-gradient(135deg, rgba(139,92,246,0.08), rgba(124,58,237,0.04)); border: 1.5px solid rgba(139,92,246,0.15); border-radius: 12px; font-size: 13px; color: #6d28d9; font-weight: 700; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(139,92,246,0.06);">
                        <div style="width: 28px; height: 28px; border-radius: 8px; background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-star" style="font-size: 11px;"></i>
                        </div>
                        <span>La oferta seleccionada se otorgará únicamente al aprendiz que logre el mejor desempeño en el proyecto.</span>
                    </div>
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 20px; justify-content: flex-end; padding-top: 32px; border-top: 2px solid #f1f5f9;">
                    <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 14px 28px;">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-premium" style="padding: 14px 40px;">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@vite(['resources/js/maps.js', 'resources/js/forms.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Oferta cards
    const ofertaRadios = document.querySelectorAll('input[name="oferta"]');
    const otroContainer = document.getElementById('otro-oferta-container');
    const otroInput = document.getElementById('oferta_otro');

    ofertaRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.oferta-card').forEach(c => c.classList.remove('selected'));
            if (this.checked) {
                this.closest('.oferta-card').classList.add('selected');
            }
            if (this.value === 'otro') {
                otroContainer.style.display = 'block';
                otroInput.setAttribute('required', 'required');
            } else {
                otroContainer.style.display = 'none';
                otroInput.removeAttribute('required');
                otroInput.value = '';
            }
        });
    });

    // Form confirmation
    const form = document.getElementById('editar-proyecto-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const selectedRadio = document.querySelector('input[name="oferta"]:checked');
            let ofertaTexto = 'No especificada';
            if (selectedRadio) {
                const card = selectedRadio.closest('.oferta-card');
                if (selectedRadio.value === 'otro') {
                    ofertaTexto = otroInput.value.trim() ? otroInput.value.trim() : 'la oferta especificada';
                } else {
                    ofertaTexto = card.querySelector('.oferta-title').textContent;
                }
            }

            const msg = `¿Está de acuerdo con la oferta seleccionada ("${ofertaTexto}")? Este beneficio se otorgará únicamente al aprendiz con el mejor desempeño en el proyecto.`;
            
            openConfirm(
                'Confirmar Edición',
                msg,
                function() {
                    form.submit();
                }
            );
        });
    }

    // Map
    const config = {
        lat: {{ old('latitud', $proyecto->latitud ?? 10.8642) }},
        lng: {{ old('longitud', $proyecto->longitud ?? -74.7777) }},
        canEdit: true,
        latInput: 'latitud',
        lngInput: 'longitud',
        onUpdate: function() {}
    };
    initEditorMap('map-editar', config);

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
