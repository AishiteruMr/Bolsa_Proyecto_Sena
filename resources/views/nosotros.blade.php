@extends('layouts.app')

@section('title', 'Inspírate SENA - Nosotros')

@section('styles')
<style>
    /* ── HERO ── */
    .hero-nosotros {
        background: linear-gradient(135deg, #1a5c00 0%, var(--verde) 100%);
        padding: 80px 80px;
        color: var(--blanco);
    }

    .hero-nosotros h1 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .hero-nosotros p {
        font-size: 17px;
        max-width: 600px;
        line-height: 1.7;
        opacity: .9;
    }

    /* ── ABOUT ── */
    .about {
        padding: 80px;
        background: var(--blanco);
    }

    .about-content {
        display: flex;
        gap: 60px;
        align-items: center;
        max-width: 1100px;
        margin: 0 auto;
    }

    .about-text {
        flex: 1;
    }

    .about-text h2 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 18px;
        color: #1a5c00;
    }

    .about-text p {
        font-size: 15px;
        color: var(--texto-suave);
        line-height: 1.8;
        margin-bottom: 14px;
    }

    .about-img {
        flex: 1;
    }

    .about-img img {
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .12);
        object-fit: cover;
        max-height: 340px;
    }

    /* ── MISIÓN Y VISIÓN ── */
    .mision-vision {
        background: var(--gris);
        padding: 80px;
        text-align: center;
    }

    .mision-vision h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 48px;
        color: #1a1a1a;
    }

    .mv-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        max-width: 900px;
        margin: 0 auto;
    }

    .mv-card {
        background: var(--blanco);
        border-radius: 16px;
        padding: 36px 32px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
        border-top: 4px solid var(--verde);
        text-align: left;
    }

    .mv-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .mv-card p {
        font-size: 14px;
        color: var(--texto-suave);
        line-height: 1.8;
    }

    /* ── CTA FINAL ── */
    .cta-final {
        background: linear-gradient(135deg, var(--verde), var(--verde-dark));
        padding: 64px 80px;
        text-align: center;
    }

    .cta-final h2 {
        font-size: 30px;
        font-weight: 700;
        color: var(--blanco);
        margin-bottom: 24px;
    }

    .cta-final a {
        display: inline-block;
        padding: 13px 32px;
        background: var(--blanco);
        color: var(--verde);
        border-radius: 30px;
        font-size: 15px;
        font-weight: 700;
        transition: all .2s;
    }

    .cta-final a:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .2);
    }

    @media (max-width: 768px) {
        .hero-nosotros { padding: 48px 24px; }
        .hero-nosotros h1 { font-size: 28px; }
        .about { padding: 48px 24px; }
        .about-content { flex-direction: column; gap: 32px; }
        .mision-vision { padding: 48px 24px; }
        .mv-container { grid-template-columns: 1fr; }
        .cta-final { padding: 48px 24px; }
    }
</style>
@endsection

@section('content')

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