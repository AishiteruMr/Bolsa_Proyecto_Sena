@extends('layouts.app')

@section('title', 'Inspírate SENA - Inicio')
@section('meta_description', 'Inspírate SENA - Bolsa de Proyectos. Conectamos talento con empresa en Colombia. Plataforma donde aprendices e instructores colaboran en proyectos reales.')
@section('og_title', 'Inspírate SENA - Conectamos Talento con Empresa')

@section('styles')
    @vitebuilt
        @vite(['resources/css/index.css'])
    @endvitebuilt
@endsection

@section('content')

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Inspírate SENA",
        "url": "{{ url('/') }}",
        "description": "Bolsa de Proyectos SENA. Conectamos talento con empresa en Colombia.",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/buscar') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Inspírate SENA",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/logo.webp') }}",
        "description": "Plataforma que conecta talento de aprendices SENA con empresas en Colombia.",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Malambo",
            "addressRegion": "Atlántico",
            "addressCountry": "CO"
        }
    }
    </script>

    <section class="hero-section">
        <div class="hero-bg-blobs">
            <div class="hero-blob" style="top:-100px; right: -101px;"></div>
            <div class="hero-blob" style="bottom:-100px; left: -100px; background: rgba(59,130,246,0.1)"></div>
        </div>

        <div class="hero-layout">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-bolt"></i> Portal de Innovación
                </div>
                <h1 class="hero-title">
                    Conectamos <span>Talento</span> con<br><span>Empresa</span>
                </h1>
                <p class="hero-desc">
                    La plataforma definitiva donde aprendices e instructores colaboran en proyectos reales que transforman el ecosistema empresarial de Colombia. Conectamos el talento de los aprendices SENA con las necesidades de las empresas, creando oportunidades que impulsan el desarrollo profesional y la innovación en cada región del país.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Comenzar Ahora <i class="fas fa-rocket"></i>
                    </a>
                    <a href="{{ route('nosotros') }}" class="btn btn-outline">
                        Ver Nosotros <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('assets/sena1.webp') }}" loading="lazy" alt="SENA" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80'">
                </div>
            </div>
        </div>
    </section>

    <section class="index-stats">
        <div class="bento-stats">
            <div class="bento-stats-item">
                <div class="bento-stats-number">{{ $totalProyectos }}</div>
                <div class="bento-stats-label">Proyectos Activos</div>
            </div>
            <div class="bento-stats-item">
                <div class="bento-stats-number">{{ $totalInstructores }}</div>
                <div class="bento-stats-label">Instructores</div>
            </div>
            <div class="bento-stats-item">
                <div class="bento-stats-number">{{ $totalEmpresas }}</div>
                <div class="bento-stats-label">Empresas Aliadas</div>
            </div>
            <div class="bento-stats-item">
                <div class="bento-stats-number">{{ $totalAprendices }}</div>
                <div class="bento-stats-label">Aprendices</div>
            </div>
        </div>
    </section>

    <section class="bento-grid">
        <div class="bento-item empresas">
            <div class="bento-icon"><i class="fas fa-building"></i></div>
            <h3>Empresas</h3>
            <p>Encuentra soluciones innovadoras para tus desafíos técnicos encargando proyectos a equipos de aprendices calificados. Cada empresa encuentra en nuestra plataforma el talento fresco y capacitado que necesita para crecer y resolver retos reales de la industria colombiana.</p>
            <a href="{{ route('registro.empresa') }}" class="btn">
                Registrar empresa <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="bento-item instructores">
            <div class="bento-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <h3>Instructores</h3>
            <p>Lidera el desarrollo de competencias prácticas guiando a los aprendices en la ejecución de proyectos de alto valor. Los instructores son el puente que conecta el talento emergente con las demandas reales de cada empresa, asegurando resultados de calidad.</p>
            <a href="{{ route('registro.instructor') }}" class="btn">
                Unirme como guía <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="bento-item aprendices">
            <div class="bento-icon"><i class="fas fa-user-graduate"></i></div>
            <h3>Aprendices</h3>
            <p>Participa en retos reales, adquiere experiencia certificable y conecta directamente con empresas aliadas. Cada aprendiz demuestra su talento en proyectos auténticos, construye su portafolio profesional y establece conexiones valiosas con el mundo empresarial.</p>
            <a href="{{ route('registro.aprendiz') }}" class="btn">
                Postular talento <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-content">
            <h2>¿Listo para transformar el futuro?</h2>
            <p>Únete hoy a la mayor comunidad de innovación técnica y comienza a generar valor real en la industria. Empresas, instructores y aprendices trabajando juntos para conectar talento con oportunidades que transforman el futuro laboral de Colombia. La bolsa de proyectos donde el talento SENA encuentra a la empresa ideal y cada proyecto se convierte en una experiencia de crecimiento profesional.</p>
            <a href="{{ route('login') }}" class="btn">
                Comenzar Ahora <i class="fas fa-rocket"></i>
            </a>
        </div>
    </section>
@endsection
