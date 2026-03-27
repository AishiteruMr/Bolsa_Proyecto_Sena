@extends('layouts.app')

@section('title', 'Inspírate SENA - Nosotros')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/nosotros.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
    {{-- ══ HERO NOSOTROS ══ --}}
    <section class="hero-nosotros" style="animation: fadeIn 1s ease-out;">
        <div class="hero-content">
            <span style="background: var(--primary-soft); color: var(--primary-light); padding: 8px 18px; border-radius: 30px; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; border: 1px solid var(--primary-glow); margin-bottom: 24px; display: inline-block;">Nuestra Identidad</span>
            <h1>Transformando el <br><span style="color: var(--primary);">Futuro del Talento</span></h1>
            <p>Somos el puente digital que conecta la pasión de los aprendices con la experiencia de los instructores y las necesidades reales del mundo empresarial.</p>
        </div>
    </section>

    {{-- ══ HISTORIA ══ --}}
    <section class="about">
        <div class="about-content">
            <div class="about-text" style="animation: slideInLeft 1s ease-out;">
                <h2>Nuestra Misión Educativa</h2>
                <div style="width: 60px; height: 4px; background: var(--primary); border-radius: 2px; margin-bottom: 32px;"></div>
                <p>
                    En el corazón de la educación moderna se encuentra el desafío de convertir la teoría en <strong>acción tangible</strong>. Nuestra plataforma nace con la visión de crear un ecosistema donde cada proyecto sea una oportunidad de crecimiento.
                </p>
                <p>
                    Diseñada como una <strong>Bolsa de Proyectos y Prácticas de alto impacto</strong>, conectamos a nuestra comunidad con retos provenientes de la industria, investigación y desarrollo tecnológico, siempre bajo la guía experta de nuestros instructores.
                </p>
            </div>
            <div class="about-img" style="animation: slideInRight 1s ease-out;">
                <img src="{{ asset('assets/web1.jpg') }}" alt="SENA Innovación" onerror="this.src='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80'">
                <div style="position: absolute; bottom: -30px; left: -30px; background: white; padding: 32px; border-radius: 24px; box-shadow: 0 40px 80px rgba(0,0,0,0.1); border-left: 6px solid var(--primary);">
                    <div style="font-size: 32px; font-weight: 900; color: var(--secondary);">+200</div>
                    <div style="font-size: 14px; color: var(--text-light); font-weight: 700;">Proyectos Validados</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ MISIÓN Y VISIÓN ══ --}}
    <section class="mision-vision">
        <div style="margin-bottom: 80px;">
            <h2>Nuestra <span>Esencia</span> Institucional</h2>
            <p style="color: var(--text-light); max-width: 700px; margin: 0 auto;">Valores que impulsan cada línea de código y cada proyecto que aprobamos.</p>
        </div>
        <div class="mv-container">
            <div class="mv-card">
                <div style="font-size: 40px; margin-bottom: 24px;">🎯</div>
                <h3>Misión</h3>
                <p>Fomentar la innovación social y económica de Colombia a través de la formación integral, capacitando ciudadanos con competencias disruptivas que respondan a los desafíos globales.</p>
            </div>
            <div class="mv-card">
                <div style="font-size: 40px; margin-bottom: 24px;">🔭</div>
                <h3>Visión</h3>
                <p>Liderar la transformación digital del talento humano en Latinoamérica, siendo reconocidos como el motor que impulsa la productividad y el desarrollo sostenible del país.</p>
            </div>
        </div>
    </section>

    {{-- ══ UBICACIÓN ══ --}}
    <section class="location-section">
        <div class="location-container">
            <div class="location-info">
                <h2>Encuéntranos</h2>
                <p>Nuestras puertas están abiertas para la innovación. Visítanos en nuestra sede estratégica en Malambo.</p>
                
                <div class="address-card">
                    <i class="fas fa-map-marked-alt"></i>
                    <div>
                        <h3>Sede Metalmecánica</h3>
                        <p>#16- a 16-123,, Dg. 18 #111, Malambo, Atlántico</p>
                    </div>
                </div>

                <div id="user-location-info" class="user-location-card" style="display: none;">
                    <i class="fas fa-location-arrow"></i>
                    <div>
                        <h3>Tu Radio de Impacto</h3>
                        <p id="user-address">Analizando proximidad...</p>
                    </div>
                </div>
            </div>
            <div class="map-wrapper">
                <div id="nosotros-map"></div>
            </div>
        </div>
    </section>

    {{-- ══ CTA ══ --}}
    <section class="cta-final">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2>¿Listo para ser parte de la <span style="text-decoration: underline;">innovación</span>?</h2>
            <p style="font-size: 20px; opacity: 0.8; margin-bottom: 48px;">Únete a la mayor comunidad de talento técnico en Colombia.</p>
            <a href="{{ route('registro.aprendiz') }}">Comenzar Ahora <i class="fas fa-rocket" style="margin-left: 12px;"></i></a>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sede SENA Coordinates (Malambo)
        const senaLat = 10.8642;
        const senaLng = -74.7777;

        // Initialize Map
        const map = L.map('nosotros-map').setView([senaLat, senaLng], 15);

        // Add OpenStreetMap Tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add SENA Marker
        const senaMarker = L.marker([senaLat, senaLng]).addTo(map)
            .bindPopup('<b>Sede Principal SENA</b><br>Dg. 18 #111, Malambo')
            .openPopup();

        // Prevent common rendering issues in containers with dynamic sizes
        setTimeout(() => { map.invalidateSize(); }, 500);

        // Geolocation for "Where I Am"
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Show info card
                document.getElementById('user-location-info').style.display = 'flex';
                document.getElementById('user-address').innerText = `Lat: ${userLat.toFixed(4)}, Lng: ${userLng.toFixed(4)}`;

                // Add User Marker
                const userMarker = L.marker([userLat, userLng], {
                    icon: L.divIcon({
                        className: 'user-location-marker',
                        html: '<div style="background-color: #3b82f6; width: 15px; height: 15px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3);"></div>'
                    })
                }).addTo(map)
                .bindPopup('Tu ubicación actual');

                // Adjust view to show both markers if possible, or just center a bit
                const group = new L.featureGroup([senaMarker, userMarker]);
                map.fitBounds(group.getBounds().pad(0.1));

            }, function(error) {
                console.warn("Error getting user location:", error.message);
            });
        }
    });
</script>
@endsection