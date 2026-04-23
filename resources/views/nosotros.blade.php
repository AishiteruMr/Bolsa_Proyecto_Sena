@extends('layouts.app')

@section('title', 'Inspírate SENA - Nosotros')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/nosotros.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
    {{-- ══ HERO NOSOTROS ══ --}}

    <section class="hero-nosotros">
        <span class="hero-badge" style="margin-bottom: 24px; display: inline-flex;">Nuestra Esencia</span>
        <h1>Transformando el <br><span>Futuro del Talento</span></h1>
        <p>Somos el puente digital que conecta la pasión de los aprendices con la experiencia de los instructores y las necesidades reales del mundo empresarial.</p>
    </section>

    <section class="about-grid">
        <div class="about-text">
            <h2 style="font-size: 40px; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 24px;">Misión Educativa de <span style="color: var(--primary);">Impacto</span></h2>
            <p style="font-size: 18px; color: var(--text-light); line-height: 1.8; margin-bottom: 24px;">
                En el corazón de la educación moderna se encuentra el desafío de convertir la teoría en <strong>acción tangible</strong>. Nuestra plataforma nace con la visión de crear un ecosistema donde cada proyecto sea una oportunidad de crecimiento.
            </p>
            <p style="font-size: 18px; color: var(--text-light); line-height: 1.8;">
                Diseñada como una <strong>Bolsa de Proyectos de alto impacto</strong>, conectamos a nuestra comunidad con retos de la industria, siempre bajo la guía experta de nuestros instructores.
            </p>
        </div>
        <div class="about-image">
            <img src="{{ asset('assets/web1.jpg') }}" alt="SENA" onerror="this.src='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80'">
        
        </div>
    </section>

    <section class="values-grid">
        <div class="value-card">
            <div class="value-icon">🎯</div>
            <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">Misión</h3>
            <p style="color: var(--text-light); line-height: 1.7;">Fomentar la innovación social y económica de Colombia a través de la formación integral, capacitando ciudadanos con competencias disruptivas que respondan a los desafíos globales.</p>
        </div>
        <div class="value-card">
            <div class="value-icon">🔭</div>
            <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">Visión</h3>
            <p style="color: var(--text-light); line-height: 1.7;">Liderar la transformación digital del talento humano en Latinoamérica, siendo reconocidos como el motor que impulsa la productividad y el desarrollo sostenible del país.</p>
        </div>
    </section>

    <section class="map-section">
        <!-- Elementos decorativos de fondo -->
        <div class="map-bg-blob blob-1"></div>
        <div class="map-bg-blob blob-2"></div>

        <div class="section-header">
            <span class="hero-badge" style="margin-bottom: 16px;">¿Dónde estamos?</span>
            <h2>Nuestra Ubicación Estratégica</h2>
            <p>Visítanos en nuestra sede principal de innovación y tecnología.</p>
        </div>

        <div class="map-wrapper">
            <div class="map-container-premium">
                <div class="map-info-glass">
                    <div class="info-header">
                        <div class="icon-box">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h3>Sede Metalmecánica</h3>
                            <p>Centro de formación industrial</p>
                        </div>
                    </div>
                    
                    <p class="info-description">Un espacio diseñado para la colaboración técnica, el desarrollo industrial y la formación de talento humano de clase mundial.</p>
                    
                    <div class="location-cards">
                        <div class="loc-card-premium">
                            <div class="card-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="card-content">
                                <span class="card-label">Dirección Principal</span>
                                <span class="card-value">Dg. 18 #111, Malambo, Atlántico</span>
                            </div>
                        </div>

                        <div id="user-location-info" class="loc-card-premium user-loc" style="display: none;">
                            <div class="card-icon">
                                <i class="fas fa-location-arrow"></i>
                            </div>
                            <div class="card-content">
                                <span class="card-label">Tu Ubicación Actual</span>
                                <span id="user-address" class="card-value">Calculando...</span>
                            </div>
                        </div>
                    </div>

                    <button id="detect-user-location-btn" class="btn-detect">
                        <div class="btn-icon">
                            <i class="fas fa-crosshairs"></i>
                        </div>
                        <span id="detect-btn-text">Encontrar mi ubicación</span>
                        <div class="btn-shine"></div>
                    </button>

                    <div id="location-error" class="loc-error-msg" style="display: none;"></div>
                </div>
                
                <div class="map-visual">
                    <div id="nosotros-map"></div>
                    <div class="map-overlay"></div>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 100px 8%; text-align: center;">
        <h2 style="font-size: 42px; font-weight: 900; letter-spacing: -2px; margin-bottom: 32px;">¿Listo para ser parte la <span style="text-decoration: underline; color: var(--primary);">Innovación</span>?</h2>
        <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 20px 60px;">
            Comenzar Ahora <i class="fas fa-rocket" style="margin-left: 10px;"></i>
        </a>
    </section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/maps.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initMissionMap('nosotros-map', 10.8642, -74.7777); 
});
</script>
@endsection
