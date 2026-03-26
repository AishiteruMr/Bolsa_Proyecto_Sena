@extends('layouts.app')

@section('title', 'Inspírate SENA - Nosotros')

@section('content')
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/nosotros.css') }}">
    @endsection
    {{-- ══ HERO ══ --}}
    <section class="hero-nosotros">
        <div class="hero-text">
            <h1>Quiénes Somos</h1>
            <p>
                Creamos una plataforma digital que conecta estudiantes, instructores y
                empresas a través de proyectos reales que transforman el aprendizaje.
            </p>
        </div>
    </section>

    {{-- ══ NUESTRA HISTORIA ══ --}}
    <section class="about">
        <div class="about-content">
            <div class="about-text">
                <h2>Nuestra Historia</h2>
                <p>
                    Uno de los principales desafíos de la educación es ofrecer a los
                    estudiantes <strong>experiencias prácticas significativas</strong>
                    que complementen su formación teórica. Con esta convicción nace
                    nuestra iniciativa: una plataforma digital tipo
                    <strong>Bolsa de Proyectos y Prácticas</strong>, diseñada para
                    conectar a los estudiantes con retos reales provenientes de
                    empresas, instituciones y proyectos de investigación.
                </p>
                <p>
                    Nuestro propósito es vincular el conocimiento académico con las
                    necesidades del entorno, permitiendo que los estudiantes participen
                    activamente en la solución de problemas de acuerdo con su nivel y
                    área de estudio, siempre con el acompañamiento de sus docentes.
                </p>
            </div>
            <div class="about-img">
                <img src="{{ asset('assets/web1.jpg') }}" alt="Equipo de trabajo">
            </div>
        </div>
    </section>

    {{-- ══ MISIÓN Y VISIÓN ══ --}}
    <section id="mision-vision" class="mision-vision">
        <h2>Nuestra Esencia</h2>
        <div class="mv-container">
            <div class="mv-card">
                <h3>🌟 Misión</h3>
                <p>
                    Contribuir al desarrollo social y económico de Colombia a través de
                    la formación integral gratuita de los ciudadanos, fortaleciendo
                    competencias que respondan a las demandas del mercado laboral,
                    promoviendo la equidad, la innovación y el emprendimiento, y
                    fomentando la construcción de una sociedad más justa e incluyente.
                </p>
            </div>
            <div class="mv-card">
                <h3>🚀 Visión</h3>
                <p>
                    Ser la entidad líder en formación para el trabajo en América Latina,
                    reconocida por su calidad, pertinencia e innovación, y por ser un
                    motor del desarrollo sostenible del país. Una institución que genera
                    oportunidades, impulsa la productividad y acompaña a Colombia hacia
                    los retos del siglo XXI.
                </p>
            </div>
        </div>
    </section>

    {{-- ══ CTA FINAL ══ --}}
    <section class="cta-final">
        <h2>¿Quieres ser parte de la transformación?</h2>
        <a href="{{ route('registro.aprendiz') }}">Únete ahora</a>
    </section>

@endsection