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
                <div class="hero-badge" style="font-size: 11px; padding: 6px 12px;">
                    <i class="fas fa-bolt" style="margin-right: 6px;"></i> Portal de Innovación
                </div>
                <h1 class="hero-title">
                    Conectamos <span>Talento</span> con<br><span>Empresa</span>
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
               
              
            </div>
        </div>
    </section>

    <section class="bento-grid">
        <div class="bento-item bento-stats" style="grid-column: span 3; display: flex; justify-content: center; gap: 120px; padding: 40px 0; border: none; background: linear-gradient(135deg, var(--primary-soft) 0%, rgba(255,255,255,0.8) 100%); box-shadow: inset 0 2px 20px rgba(62,180,137,0.1);">
            <div style="text-align: center;">
                <div style="font-size: 64px; font-weight: 900; color: var(--primary); line-height: 1; text-shadow: 0 4px 20px rgba(62,180,137,0.3);">{{ $totalProyectos }}</div>
                <div style="color: var(--text-light); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-top: 12px; padding-top: 12px; border-top: 3px solid var(--primary); display: inline-block;">Proyectos</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 64px; font-weight: 900; color: var(--secondary); line-height: 1; text-shadow: 0 4px 20px rgba(26,46,26,0.2);">{{ $totalEmpresas }}</div>
                <div style="color: var(--text-light); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-top: 12px; padding-top: 12px; border-top: 3px solid var(--secondary); display: inline-block;">Empresas</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 64px; font-weight: 900; color: var(--primary); line-height: 1; text-shadow: 0 4px 20px rgba(62,180,137,0.3);">{{ $totalAprendices }}</div>
                <div style="color: var(--text-light); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-top: 12px; padding-top: 12px; border-top: 3px solid var(--primary); display: inline-block;">Aprendices</div>
            </div>
        </div>
        <div class="bento-item" style="background: linear-gradient(145deg, #ffffff 0%, #f0fdf4 100%);">
            <div class="bento-icon" style="background: linear-gradient(135deg, var(--primary), #059669); color: #fff;"><i class="fas fa-building"></i></div>
            <h3 style="font-size: 26px; font-weight: 800; margin-bottom: 16px; color: var(--secondary);">Empresas</h3>
            <p style="color: var(--text-light); line-height: 1.7; margin-bottom: 32px; font-size: 15px;">
                Encuentra soluciones innovadoras para tus desafíos técnicos encargando proyectos a equipos de aprendices calificados.
            </p>
            <a href="{{ route('registro.empresa') }}" style="background: linear-gradient(135deg, var(--primary), #059669); color: #fff; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; border-radius: 14px; box-shadow: 0 8px 25px rgba(62,180,137,0.35);">
                Registrar empresa <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="bento-item" style="background: linear-gradient(145deg, #ffffff 0%, #fffbeb 100%);">
            <div class="bento-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff;"><i class="fas fa-chalkboard-teacher"></i></div>
            <h3 style="font-size: 26px; font-weight: 800; margin-bottom: 16px; color: var(--secondary);">Instructores</h3>
            <p style="color: var(--text-light); line-height: 1.7; margin-bottom: 32px; font-size: 15px;">
                Lidera el desarrollo de competencias prácticas guiando a los aprendices en la ejecución de proyectos de alto valor.
            </p>
            <a href="{{ route('registro.instructor') }}" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; border-radius: 14px; box-shadow: 0 8px 25px rgba(245,158,11,0.35);">
                Unirme como guía <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="bento-item" style="background: linear-gradient(145deg, #ffffff 0%, #eff6ff 100%);">
            <div class="bento-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff;"><i class="fas fa-user-graduate"></i></div>
            <h3 style="font-size: 26px; font-weight: 800; margin-bottom: 16px; color: var(--secondary);">Aprendices</h3>
            <p style="color: var(--text-light); line-height: 1.7; margin-bottom: 32px; font-size: 15px;">
                Participa en retos reales, adquiere experiencia certificable y conecta directamente con empresas aliadas.
            </p>
            <a href="{{ route('registro.aprendiz') }}" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; border-radius: 14px; box-shadow: 0 8px 25px rgba(59,130,246,0.35);">
                Postular talento <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <section class="cta-section">
        <div style="position: absolute; top: -50%; right: -20%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%);"></div>
        <div style="position: absolute; bottom: -30%; left: -10%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);"></div>
        <div style="position: relative; z-index: 1;">
            <h2>¿Listo para transformar el futuro?</h2>
            <p>Únete hoy a la mayor comunidad de innovación técnica y comienza a generar valor real en la industria.</p>
            <a href="{{ route('login') }}">
                Comenzar Ahora <i class="fas fa-rocket" style="margin-left: 12px;"></i>
            </a>
        </div>
    </section>
@endsection
