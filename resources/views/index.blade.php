@extends('layouts.app')

@section('title', 'Inspírate SENA - Inicio')

@section('styles')
    <style>
        body {
            margin: 0;
            background: #fff;
            overflow-x: hidden;
        }

        /* HERO */
        .hero {
            min-height: 85vh;
            display: flex;
            align-items: center;
            padding: 60px 80px;
            background: linear-gradient(135deg, #f8fff4 0%, #e8f5e0 50%, #d4edbc 100%);
            gap: 60px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(57,169,0,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-text {
            flex: 1;
            z-index: 1;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-text h1 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.15;
            color: #1a1a1a;
            margin-bottom: 24px;
        }

        .hero-text h1 span {
            color: #298564;
            position: relative;
        }

        .hero-text h1 span::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 8px;
            background: rgba(36, 129, 90, 0.3);
            border-radius: 4px;
            z-index: -1;
        }

        .hero-text p {
            font-size: 18px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 500px;
        }

        .hero-buttons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            transition: all .3s;
            border: none;
            cursor: pointer;
        }

        .btn.primary {
            background: linear-gradient(135deg, #298564, #298564);
            color: #fff;
            box-shadow: 0 8px 25px rgba(91, 156, 140, 0.35);
        }

        .btn.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(57, 169, 0, 0.45);
        }

        .btn.outline {
            background: transparent;
            border: 2px solid #298564;
            color: #298564;
        }

        .btn.outline:hover {
            background: #48b48d;
            color: #fff;
            transform: translateY(-3px);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            z-index: 1;
            animation: fadeInRight 1s ease-out 0.3s both;
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-image img {
            max-width: 500px;
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
            transition: transform .3s;
        }

        .hero-image img:hover {
            transform: scale(1.02);
        }

        /* BENEFITS */
        .benefits {
            padding: 100px 80px;
            text-align: center;
            background: #fff;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 36px 28px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            text-align: center;
            transition: all .3s;
            border: 1px solid #f0f0f0;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            border-color: #39a900;
        }

        .card-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e8f5e0, #d4edbc);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
        }

        .card h3 {
            font-size: 20px;
            margin-bottom: 12px;
            color: #1a1a1a;
        }

        .card p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-card {
            display: inline-block;
            padding: 10px 24px;
            background: #d5ffe5;
            color: #298564;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            transition: all .3s;
        }

        .btn-card:hover {
            background: #298564;
            color: #fff;
            transform: scale(1.05);
        }

        /* STATS */
        .stats {
            background: linear-gradient(135deg, #298564 0%, #36b184 50%, #298564 100%);
            padding: 80px 80px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 40px;
            position: relative;
            overflow: hidden;
        }

        .stats::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .stat {
            text-align: center;
            color: #fff;
            z-index: 1;
        }

        .stat-icon {
            font-size: 36px;
            margin-bottom: 12px;
            opacity: 0.9;
        }

        .stat h3 {
            font-size: 48px;
            font-weight: 800;
        }

        .stat p {
            font-size: 15px;
            opacity: .85;
            margin-top: 4px;
        }

        /* CTA */
        .cta {
            background: linear-gradient(135deg, #f8fff4 0%, #e8f5e0 100%);
            padding: 100px 80px;
            text-align: center;
        }

        .cta h2 {
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #1a1a1a;
        }

        .cta p {
            font-size: 17px;
            color: #555;
            max-width: 650px;
            margin: 0 auto 36px;
            line-height: 1.7;
        }

        @media (max-width: 900px) {
            .hero {
                flex-direction: column;
                padding: 50px 24px;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 32px;
            }

            .hero-text p {
                margin: 0 auto 30px;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-image img {
                max-width: 100%;
            }

            .benefits,
            .stats,
            .cta {
                padding: 60px 24px;
            }
        }
    </style>
@endsection

@section('content')
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
        <p>Conectamos el talento con las oportunidades. Una plataforma diseñada para transformar vidas profesionales.</p>
        <div class="cards">
            <div class="card">
                <div class="card-icon">💼</div>
                <h3>Empresas</h3>
                <p>Publica proyectos reales y conecta con el talento del SENA para impulsar innovación dentro de tu empresa.</p>
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
        <p>Empresas, instructores y aprendices trabajando en proyectos reales que generan innovación y crecimiento profesional.</p>
        <a href="{{ route('registro.aprendiz') }}" class="btn primary">Comenzar ahora</a>
    </section>
@endsection