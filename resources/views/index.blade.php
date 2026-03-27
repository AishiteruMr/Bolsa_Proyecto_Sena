@extends('layouts.app')

@section('title', 'Inspírate SENA - Inicio')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

    <section class="hero-section">
        <div class="hero-bg-blobs">
            <div class="hero-blob" style="top:-100px; right: -100px;"></div>
            <div class="hero-blob" style="bottom:-100px; left: -100px; background: rgba(59,130,246,0.1)"></div>
        </div>

        <div class="hero-layout">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-sparkles" style="margin-right: 8px;"></i> Portal de Innovación SENA
                </div>
                <h1 class="hero-title">
                    Conectamos <span>Talento</span>,<br>
                    Liderazgo y<br>
                    <span>Empresa</span>
                </h1>
                <p class="hero-desc">
                    La plataforma definitiva donde aprendices e instructores colaboran en proyectos reales que transforman el ecosistema empresarial de Colombia.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Comenzar Ahora <i class="fas fa-rocket" style="margin-left: 10px;"></i>
                    </a>
                    <a href="{{ route('nosotros') }}" class="btn btn-outline" style="border-radius: 16px;">
                        Ver Nosotros <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('assets/sena1.png') }}" alt="SENA" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80'">
                </div>
                <!-- Mini Floatings -->
                <div class="floating-card" style="top: 10%; right: -20px; animation-delay: 0s;">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 16px; color: var(--secondary);">+150 Casos</div>
                        <div style="font-size: 11px; color: var(--text-light);">Proyectos Validados</div>
                    </div>
                </div>
                <div class="floating-card" style="bottom: 15%; left: -40px; animation-delay: 1s;">
                    <div style="width: 44px; height: 44px; background: #eff6ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 16px; color: var(--secondary);">500+ Alumnos</div>
                        <div style="font-size: 11px; color: var(--text-light);">Talento Certificado</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bento-grid">
        <div class="bento-item">
            <div class="bento-icon"><i class="fas fa-briefcase"></i></div>
            <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">Empresas</h3>
            <p style="color: var(--text-light); line-height: 1.6; margin-bottom: 32px;">
                Encuentra soluciones innovadoras para tus desafíos técnicos encargando proyectos a equipos de aprendices calificados.
            </p>
            <a href="{{ route('registro.empresa') }}" style="color: var(--primary); font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                Registrar empresa <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="bento-item">
            <div class="bento-icon" style="color: #f59e0b; background: rgba(245, 158, 11, 0.1);"><i class="fas fa-chalkboard-teacher"></i></div>
            <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">Instructores</h3>
            <p style="color: var(--text-light); line-height: 1.6; margin-bottom: 32px;">
                Lidera el desarrollo de competencias prácticas guiando a los aprendices en la ejecución de proyectos de alto valor.
            </p>
            <a href="{{ route('registro.instructor') }}" style="color: #f59e0b; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                Unirme como guía <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="bento-item">
            <div class="bento-icon" style="color: #3b82f6; background: rgba(59, 130, 246, 0.1);"><i class="fas fa-user-graduate"></i></div>
            <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 16px;">Aprendices</h3>
            <p style="color: var(--text-light); line-height: 1.6; margin-bottom: 32px;">
                Participa en retos reales, adquiere experiencia certificable y conecta directamente con empresas aliadas.
            </p>
            <a href="{{ route('registro.aprendiz') }}" style="color: #3b82f6; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                Postular talento <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <section style="padding: 100px 8%; background: var(--secondary); border-radius: 60px; margin: 0 40px 80px; text-align: center; position :relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at center, rgba(62, 180, 137, 0.1), transparent); pointer-events: none;"></div>
        <h2 style="color: #fff; font-size: 48px; font-weight: 900; letter-spacing: -2px; margin-bottom: 24px;">¿Listo para transformar el futuro?</h2>
        <p style="color: rgba(255,255,255,0.6); font-size: 19px; max-width: 600px; margin: 0 auto 48px;">Únete hoy a la mayor comunidad de innovación técnica y comienza a generar valor real en la industria.</p>
        <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 20px 60px; font-size: 18px;">
            Comenzar Ahora <i class="fas fa-rocket" style="margin-left: 12px;"></i>
        </a>
    </section>
@endsection
