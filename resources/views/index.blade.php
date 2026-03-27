@extends('layouts.app')

@section('title', 'Inspírate SENA - Inicio')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <section class="hero">
        <div class="hero-text" style="animation: slideInLeft 1s ease-out;">
            <div style="margin-bottom: 24px;">
                <span style="background: var(--primary-soft); color: var(--primary-dark); padding: 8px 18px; border-radius: 30px; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; border: 1px solid var(--primary-glow);">Portal de Innovación SENA</span>
            </div>
            <h1 style="font-size: 72px; font-weight: 900; line-height: 1.1; letter-spacing: -3px; margin-bottom: 32px;">Conectamos <span style="color: var(--primary);">Talento</span>,<br><span style="color: var(--primary);">Liderazgo</span> y<br><span>Empresa</span></h1>
            <p style="font-size: 20px; color: var(--text-light); margin-bottom: 48px; line-height: 1.7; max-width: 550px;">La plataforma definitiva donde aprendices e instructores colaboran en proyectos reales que transforman el ecosistema empresarial de Colombia.</p>
            <div class="hero-buttons">
                <a href="{{ route('registro.empresa') }}" class="btn primary" style="padding: 22px 44px; font-size: 17px; border-radius: 20px; box-shadow: 0 20px 40px rgba(62, 180, 137, 0.25);">
                    Publicar Proyecto <i class="fas fa-plus-circle" style="margin-left: 10px;"></i>
                </a>
                <a href="{{ route('registro.aprendiz') }}" class="btn outline" style="padding: 22px 44px; font-size: 17px; border-radius: 20px; margin-left: 20px;">
                    Explorar Talento <i class="fas fa-search" style="margin-left: 10px;"></i>
                </a>
            </div>
        </div>
        <div class="hero-image" style="animation: slideInRight 1s ease-out;">
            <img src="{{ asset('assets/sena1.png') }}" alt="SENA Innovación" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80'">
            <!-- Floating badge -->
            <div style="position: absolute; bottom: 40px; left: -40px; background: white; padding: 20px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 14px; animation: floatBadge 4s ease-in-out infinite;">
                <div style="width: 44px; height: 44px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-weight: 800; font-size: 16px; color: var(--secondary);">+150 Casos de Éxito</div>
                    <div style="font-size: 12px; color: var(--text-light);">Proyectos validados 2024</div>
                </div>
            </div>
        </div>
    </section>

    <section class="benefits">
        <div style="margin-bottom: 80px;">
            <h2>Ecosistema de Impacto Real</h2>
            <p>Conectamos las necesidades de la industria con el potencial creativo del SENA a través de una metodología ágil y profesional.</p>
        </div>
        
        <div class="cards">
            <div class="card">
                <div class="card-icon" style="color: #3b82f6;">💼</div>
                <h3>Empresas</h3>
                <p>Encuentra soluciones innovadoras para tus desafíos técnicos encargando proyectos a equipos de aprendices altamente calificados.</p>
                <a href="{{ route('registro.empresa') }}" class="btn-card">Registrar mi empresa <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card">
                <div class="card-icon" style="color: #f59e0b;">👨‍🏫</div>
                <h3>Instructores</h3>
                <p>Lidera el desarrollo de competencias prácticas guiando a los aprendices en la ejecución de proyectos de alto valor tecnológico.</p>
                <a href="{{ route('registro.instructor') }}" class="btn-card">Unirme como guía <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card">
                <div class="card-icon" style="color: var(--primary);">👨‍🎓</div>
                <h3>Aprendices</h3>
                <p>Participa en retos reales, adquiere experiencia certificable y conecta directamente con empresas aliadas del SENA.</p>
                <a href="{{ route('registro.aprendiz') }}" class="btn-card">Postular mi talento <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="stat">
            <div style="font-size: 64px; margin-bottom: 24px;">🚀</div>
            <h3>{{ $totalProyectos }}</h3>
            <p>Retos Activos</p>
        </div>
        <div class="stat">
            <div style="font-size: 64px; margin-bottom: 24px;">🏆</div>
            <h3>{{ $totalAprendices }}</h3>
            <p>Talento Certificado</p>
        </div>
        <div class="stat">
            <div style="font-size: 64px; margin-bottom: 24px;">🏢</div>
            <h3>{{ $totalEmpresas }}</h3>
            <p>Aliados Corporativos</p>
        </div>
    </section>

    <section class="cta">
        <div style="background: linear-gradient(135deg, #0f172a, #1e293b); padding: 100px 40px; border-radius: 40px; color: white; position: relative; overflow: hidden; box-shadow: 0 40px 80px rgba(15, 23, 42, 0.2); animation: fadeIn 1s ease-out;">
            <div style="position: absolute; right: -50px; bottom: -50px; width: 350px; height: 350px; background: rgba(62, 180, 137, 0.05); border-radius: 50%;"></div>
            <h2 style="color: white; margin-bottom: 24px; font-size: 44px; font-weight: 900; letter-spacing: -2px;">¿Listo para transformar el futuro?</h2>
            <p style="color: rgba(255,255,255,0.6); max-width: 650px; margin: 0 auto 48px; font-size: 19px;">Únete hoy a la mayor comunidad de innovación técnica y comienza a generar valor real en la industria.</p>
            <a href="{{ route('registro.aprendiz') }}" class="btn primary" style="padding: 24px 64px; font-size: 20px; border-radius: 20px; box-shadow: 0 20px 40px rgba(62, 180, 137, 0.2);">
                Comenzar Ahora <i class="fas fa-rocket" style="margin-left: 12px;"></i>
            </a>
        </div>
    </section>

    <style>
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes floatBadge { 0%, 100% { transform: translateY(0) translateX(-40px); } 50% { transform: translateY(-15px) translateX(-40px); } }
    </style>
@endsection