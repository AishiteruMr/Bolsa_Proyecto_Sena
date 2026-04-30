@extends('layouts.dashboard')
@section('title', 'Historial de Proyectos')
@section('page-title', 'Historial')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> <span>Principal</span>
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> <span>Explorar Proyectos</span>
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> <span>Mis Postulaciones</span>
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> <span>Historial</span>
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> <span>Mis Entregas</span>
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> <span>Mi Perfil</span>
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-history"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span class="instructor-tag">Historial</span>
            </div>
            <h1 class="instructor-title">Historial de <span style="color: var(--primary);">Postulaciones</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; font-weight: 500;">Tu trayectoria académica completa — todos los proyectos a los que te has postulado.</p>
        </div>
    </div>

    @php
        $total = collect($proyectos)->count();
        $aprobadas = collect($proyectos)->where('estado','aceptada')->count();
        $pendientes = collect($proyectos)->where('estado','pendiente')->count();
        $rechazadas = collect($proyectos)->where('estado','rechazada')->count();
    @endphp

    @if($total > 0)
        <div class="instructor-stat-grid" style="margin-bottom: 32px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-inbox"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: var(--text); line-height: 1;">{{ $total }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Total</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #bbf7d0;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #10b981; line-height: 1;">{{ $aprobadas }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Aprobadas</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fde68a;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #f59e0b; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #f59e0b; line-height: 1;">{{ $pendientes }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">pendientes</div>
                </div>
            </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #d97706; line-height: 1;">{{ $pendientes }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Pendientes</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fecaca;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #ef4444; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #ef4444; line-height: 1;">{{ $rechazadas }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Rechazadas</div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
            @foreach($proyectos as $p)
                @php
                    $estadoColor = match($p->estado) {
                        'completado' => ['bg' => '#065f46', 'border' => '#065f46', 'text' => '#ffffff', 'icon' => 'fa-check'],
                        'aceptada' => ['bg' => '#10b981', 'border' => '#bbf7d0', 'text' => '#ffffff', 'icon' => 'fa-check'],
                        'rechazada' => ['bg' => '#ef4444', 'border' => '#fecaca', 'text' => '#ffffff', 'icon' => 'fa-ban'],
                        'en_progreso' => ['bg' => '#3b82f6', 'border' => '#bfdbfe', 'text' => '#ffffff', 'icon' => 'fa-spinner'],
                        'pendiente' => ['bg' => '#f59e0b', 'border' => '#fde68a', 'text' => '#ffffff', 'icon' => 'fa-clock'],
                        'cerrado' => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-lock'],
                        default => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-info-circle'],
                    };
                    $diasRestantes = \Carbon\Carbon::parse($p->fecha_finalizacion)->diffInDays(now(), false);
                    $esFinalizado  = $diasRestantes >= 0;
                @endphp
                <div class="glass-card" style="padding: 0; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 40px rgba(62,180,137,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(62,180,137,0.06)'">
                    <div style="height: 5px; background: linear-gradient(90deg, {{ $estadoColor['text'] }}, {{ $estadoColor['border'] }});"></div>

                    @if($p->imagen_url)
                        <img src="{{ $p->imagen_url }}" alt="Imagen del proyecto" style="width:100%; height:140px; object-fit:cover;">
                    @else
                        <div style="height: 100px; background: linear-gradient(135deg, rgba(62,180,137,0.15), rgba(62,180,137,0.05)); display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-project-diagram" style="font-size:36px; color:#3eb489; opacity:0.5;"></i>
                        </div>
                    @endif

                    <div style="padding: 24px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px; gap:12px;">
                            <h4 style="font-size:16px; font-weight:800; color:var(--text); line-height:1.3; flex:1;">{{ $p->titulo }}</h4>
                            <span style="background:{{ $estadoColor['bg'] }}; border:1.5px solid {{ $estadoColor['border'] }}; color:{{ $estadoColor['text'] }}; border-radius:20px; padding:6px 14px; font-size:11px; font-weight:800; white-space:nowrap; display:flex; align-items:center; gap:6px; flex-shrink:0;">
                                <i class="fas {{ $estadoColor['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                            </span>
                        </div>

                        <div style="display:grid; gap:10px; margin-bottom:20px;">
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-building" style="width:16px; color:#3eb489;"></i>
                                <span>{{ $p->nombre }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-tag" style="width:16px; color:#8b5cf6;"></i>
                                <span>{{ $p->categoria }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-chalkboard-teacher" style="width:16px; color:#0ea5e9;"></i>
                                <span>{{ $p->instructor_nombre }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-calendar-alt" style="width:16px; color:#f59e0b;"></i>
                                <span>Postulé el {{ \Carbon\Carbon::parse($p->fecha_postulacion)->format('d M, Y') }}</span>
                            </div>
                        </div>

                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:12px 16px; margin-bottom:18px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase;">Estado del Proyecto</span>
                            <span style="font-size:12px; font-weight:800; color:#3eb489;">
                                @if($esFinalizado) Finalizado @else En progreso @endif
                            </span>
                        </div>

                        @if($p->estado === 'aceptada')
                            <a href="{{ route('aprendiz.entregas') }}" class="btn-premium" style="width:100%; justify-content:center; padding:12px;">
                                <i class="fas fa-upload"></i> Ir a Mis Entregas
                            </a>
                        @else
                            <div style="width:100%; background:#f1f5f9; border-radius:12px; padding:12px; text-align:center; font-size:13px; font-weight:700; color:#94a3b8;">
                                <i class="fas fa-lock"></i> Acceso restringido
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="glass-card" style="padding: 80px 40px; text-align: center;">
            <div style="width:100px; height:100px; background:rgba(62,180,137,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; font-size:40px; color:#3eb489;">
                <i class="fas fa-history"></i>
            </div>
            <h3 style="font-size:22px; font-weight:800; color:var(--text); margin-bottom:10px;">Sin historial aún</h3>
            <p style="font-size:15px; color:var(--text-light); font-weight:500; max-width:400px; margin:0 auto 28px; line-height:1.6;">
                Aún no te has postulado a ningún proyecto. Explora las convocatorias disponibles y da el primer paso en tu carrera.
            </p>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="display:inline-flex;">
                <i class="fas fa-search"></i> Explorar Proyectos
            </a>
        </div>
    @endif
</div>
@endsection
