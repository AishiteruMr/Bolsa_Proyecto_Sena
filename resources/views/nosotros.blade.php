@extends('layouts.app')

@section('title', 'Inspírate SENA - Nosotros')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        color: #2c3e50;
        background: #fff;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* ── NAVBAR ── */
    .navbar {
        background: #fff;
        padding: 0 48px;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo img {
        width: 40px;
    }

    .logo span {
        font-weight: 700;
        font-size: 18px;
        color: #1a5c00;
    }

    .menu a {
        margin-left: 28px;
        font-size: 14px;
        font-weight: 600;
        color: #555;
        transition: color .2s;
    }

    .menu a:hover,
    .menu a.active {
        color: #39a900;
    }

    .btn-login {
        background: #39a900;
        color: #fff;
        padding: 9px 22px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        transition: background .2s;
    }

    .btn-login:hover {
        background: #2d8500;
    }

    /* ── HERO ── */
    .hero-nosotros {
        background: linear-gradient(135deg, #1a5c00 0%, #39a900 100%);
        padding: 80px 80px;
        color: #fff;
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
        background: #fff;
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
        color: #555;
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
        background: #f4f6f9;
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
        background: #fff;
        border-radius: 16px;
        padding: 36px 32px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
        border-top: 4px solid #39a900;
        text-align: left;
    }

    .mv-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .mv-card p {
        font-size: 14px;
        color: #555;
        line-height: 1.8;
    }

    /* ── CTA FINAL ── */
    .cta-final {
        background: linear-gradient(135deg, #39a900, #2d8500);
        padding: 64px 80px;
        text-align: center;
    }

    .cta-final h2 {
        font-size: 30px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 24px;
    }

    .cta-final a {
        display: inline-block;
        padding: 13px 32px;
        background: #fff;
        color: #39a900;
        border-radius: 30px;
        font-size: 15px;
        font-weight: 700;
        transition: all .2s;
    }

    .cta-final a:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .2);
    }

    /* ── FOOTER ── */
    .footer {
        background: #1a1a1a;
        color: #ccc;
        padding: 48px 80px 24px;
    }

    .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 32px;
        margin-bottom: 32px;
    }

    .footer-col h3 {
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .footer-col p,
    .footer-col a {
        font-size: 13px;
        color: #888;
        display: block;
        margin-bottom: 6px;
    }

    .footer-col a:hover {
        color: #39a900;
    }

    .footer-col ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-col ul li {
        margin-bottom: 6px;
    }

    .footer-bottom {
        border-top: 1px solid #333;
        padding-top: 16px;
        text-align: center;
        font-size: 13px;
        color: #555;
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 0 20px;
        }

        .hero-nosotros {
            padding: 48px 24px;
        }

        .hero-nosotros h1 {
            font-size: 28px;
        }

        .about {
            padding: 48px 24px;
        }

        .about-content {
            flex-direction: column;
            gap: 32px;
        }

        .mision-vision {
            padding: 48px 24px;
        }

        .mv-container {
            grid-template-columns: 1fr;
        }

        .cta-final {
            padding: 48px 24px;
        }

        .footer {
            padding: 40px 24px 20px;
        }
    }
</style>
@endsection

@section('content')

{{-- ══ NAVBAR ══ --}}
<header class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo SENA">
        </a>
        <span>Inspírate SENA</span>
    </div>

    <nav class="menu">
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('nosotros') }}" class="active">Nosotros</a>
    </nav>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
    </div>
</header>

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

{{-- ══ FOOTER ══ --}}
<footer class="footer">
    <div class="footer-container">
        <div class="footer-col">
            <h3>SENA - Servicio Nacional de Aprendizaje</h3>
            <p>
                El SENA es un establecimiento público del orden nacional, con personería jurídica,
                patrimonio propio e independiente, adscrito al Ministerio del Trabajo de Colombia.
            </p>
        </div>
        <div class="footer-col">
            <h3>Contáctanos</h3>
            <p>📍 Calle 57 No. 8-69, Bogotá D.C., Colombia</p>
            <p>📧 <a href="mailto:atencionalciudadano@sena.edu.co">atencionalciudadano@sena.edu.co</a></p>
            <p>📞 PBX: (601) 5461500</p>
            <p>☎ Línea gratuita: 018000-910-270</p>
        </div>
        <div class="footer-col">
            <h3>Enlaces oficiales</h3>
            <ul>
                <li><a href="https://www.sena.edu.co" target="_blank" rel="noopener noreferrer">Portal SENA</a></li>
                <li><a href="https://oferta.senasofiaplus.edu.co" target="_blank" rel="noopener noreferrer">Sofía Plus</a></li>
                <li><a href="https://sciudadanos.sena.edu.co" target="_blank" rel="noopener noreferrer">PQRS</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Servicio Nacional de Aprendizaje - SENA. Todos los derechos reservados.</p>
    </div>
</footer>

@endsection