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
            <div class="about-badge">
                <div style="font-size: 36px; font-weight: 900; color: var(--secondary);">+200</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light);">Proyectos Exitosos</div>
            </div>
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
        <div class="section-header">
            <h2>Nuestra Ubicación Estratégica</h2>
            <p>Visítanos en nuestra sede principal de innovación y tecnología.</p>
        </div>
        <div class="map-container">
            <div class="map-info">
                <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 16px;">Sede Metalmecánica</h3>
                <p style="color: var(--text-light); font-size: 15px; margin-bottom: 32px;">Un espacio diseñado para la colabaración técnica y el desarrollo industrial.</p>
                
                <div class="loc-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <div style="font-weight: 800; color: var(--secondary);">Dirección</div>
                        <div style="font-size: 14px; color: var(--text-light);">Dg. 18 #111, Malambo, Atlántico</div>
                    </div>
                </div>

                <div id="user-location-info" class="loc-card" style="display: none; border-color: var(--primary-glow); background: #fff;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0;">
                        <i class="fas fa-location-arrow"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; color: var(--secondary);">Tu Ubicación</div>
                        <div id="user-address" style="font-size: 14px; color: var(--text-light);">Calculando...</div>
                    </div>
                </div>
            </div>
            <div id="nosotros-map"></div>
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
<script src="{{ asset('js/maps.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initMissionMap('nosotros-map', 10.8642, -74.7777); 
});
</script>
@endsection
