@extends('layouts.app')

@section('title', 'Inspírate SENA - Inicio')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo SENA" width="120">
            <span>Inspírate SENA</span>
        </div>
        <nav class="menu">
            <a href="{{ route('home') }}" class="active">Inicio</a>
            <a href="{{ route('nosotros') }}">Nosotros</a>
        </nav>
        <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Conectamos <span>Empresas</span>,<br><span>Instructores</span> y<br><span>Aprendices</span></h1>
                <p>Publica, gestiona y participa en proyectos reales que transforman el futuro 🚀</p>
                <div class="hero-buttons">
                    <a href="{{ route('registro.empresa') }}" class="btn primary">Publicar Proyecto</a>
                    <a href="{{ route('registro.aprendiz') }}" class="btn outline">Buscar Proyecto</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('assets/sena1.png') }}" alt="SENA proyectos" onerror="this.style.display='none'">
            </div>
        </section>

        <section class="benefits">
            <h2>¿Por qué usar Inspírate SENA?</h2>
            <p>Conectamos el talento con las oportunidades. Una plataforma diseñada para transformar vidas profesionales.
            </p>
            <div class="cards">
                <div class="card">
                    <div class="card-icon">💼</div>
                    <h3>Empresas</h3>
                    <p>Publica proyectos reales y conecta con el talento del SENA para impulsar innovación dentro de tu
                        empresa.</p>
                    <a href="{{ route('registro.empresa') }}" class="btn-card">Registrarme</a>
                </div>
                <div class="card">
                    <div class="card-icon">👨‍🏫</div>
                    <h3>Instructores</h3>
                    <p>Coordina proyectos, guía aprendices y transforma el aprendizaje en experiencias reales.</p>
                    <a href="{{ route('registro.instructor') }}" class="btn-card">Registrarme</a>
                </div>
                <div class="card">
                    <div class="card-icon">👨‍🎓</div>
                    <h3>Aprendices</h3>
                    <p>Participa en proyectos reales, adquiere experiencia y fortalece tu perfil profesional.</p>
                    <a href="{{ route('registro.aprendiz') }}" class="btn-card">Registrarme</a>
                </div>
            </div>
        </section>

        <section class="stats">
            <div class="stat">
                <div class="stat-icon">📊</div>
                <h3>100+</h3>
                <p>Proyectos publicados</p>
            </div>
            <div class="stat">
                <div class="stat-icon">👥</div>
                <h3>250+</h3>
                <p>Aprendices activos</p>
            </div>
            <div class="stat">
                <div class="stat-icon">🏢</div>
                <h3>50+</h3>
                <p>Empresas aliadas</p>
            </div>
        </section>

        <section class="cta">
            <h2>Construyamos el futuro juntos</h2>
            <p>Empresas, instructores y aprendices trabajando en proyectos reales que generan innovación y crecimiento
                profesional.</p>
            <a href="{{ route('registro.aprendiz') }}" class="btn primary">Comenzar ahora</a>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <h3>SENA</h3>
                <p>Servicio Nacional de Aprendizaje encargado de la formación profesional en Colombia.</p>
            </div>
            <div class="footer-col">
                <h3>Contacto</h3>
                <p>Bogotá D.C.</p>
                <p>PBX: (601) 5461500</p>
                <p>atencionalciudadano@sena.edu.co</p>
            </div>
            <div class="footer-col">
                <h3>Enlaces</h3>
                <a href="https://www.sena.edu.co" target="_blank">Portal SENA</a>
                <a href="https://oferta.senasofiaplus.edu.co" target="_blank">Sofía Plus</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} SENA — Inspírate SENA. Todos los derechos reservados.</p>
        </div>
    </footer>

@endsection