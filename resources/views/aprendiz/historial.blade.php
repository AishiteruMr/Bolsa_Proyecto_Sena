@extends('layouts.dashboard')
@section('title', 'Historial de Proyectos')
@section('page-title', 'Historial')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">

    {{-- HEADER --}}
    <div style="margin-bottom: 32px; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: var(--text); letter-spacing: -0.5px;">
                Historial de <span style="color: var(--primary);">Postulaciones</span>
            </h2>
            <p style="color: var(--text-light); font-size: 15px; margin-top: 4px; font-weight: 500;">
                Todos los proyectos a los que te has postulado — tu trayectoria académica completa.
            </p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            @php
                $total = collect($proyectos)->count();
                $aprobadas = collect($proyectos)->where('pos_estado','Aprobada')->count();
                $pendientes = collect($proyectos)->where('pos_estado','Pendiente')->count();
                $rechazadas = collect($proyectos)->where('pos_estado','Rechazada')->count();
            @endphp
            <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 14px; padding: 10px 20px; text-align: center;">
                <div style="font-size: 22px; font-weight: 900; color: #16a34a;">{{ $aprobadas }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Aprobadas</div>
            </div>
            <div style="background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 14px; padding: 10px 20px; text-align: center;">
                <div style="font-size: 22px; font-weight: 900; color: #d97706;">{{ $pendientes }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Pendientes</div>
            </div>
            <div style="background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 14px; padding: 10px 20px; text-align: center;">
                <div style="font-size: 22px; font-weight: 900; color: #ef4444;">{{ $rechazadas }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Rechazadas</div>
            </div>
        </div>
    </div>

    @if($total > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
            @foreach($proyectos as $p)
                @php
                    $estadoColor = match($p->pos_estado) {
                        'Aprobada'  => ['bg' => '#f0fdf4', 'border' => '#86efac', 'text' => '#16a34a', 'icon' => 'fa-check-circle'],
                        'Rechazada' => ['bg' => '#fef2f2', 'border' => '#fca5a5', 'text' => '#ef4444', 'icon' => 'fa-times-circle'],
                        default     => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-clock'],
                    };
                    $diasRestantes = \Carbon\Carbon::parse($p->pro_fecha_finalizacion)->diffInDays(now(), false);
                    $esFinalizado  = $diasRestantes >= 0;
                @endphp
                <div class="glass-card" style="padding: 0; overflow: hidden; transition: transform 0.25s, box-shadow 0.25s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='';this.style.boxShadow=''">

                    {{-- TOP COLOR BAR --}}
                    <div style="height: 5px; background: linear-gradient(90deg, {{ $estadoColor['text'] }}, {{ $estadoColor['border'] }});"></div>

                    {{-- IMAGEN / PLACEHOLDER --}}
                    @if($p->pro_imagen_url)
                        <img src="{{ $p->pro_imagen_url }}" alt="Imagen del proyecto" style="width:100%; height:120px; object-fit:cover;">
                    @else
                        <div style="height:80px; background: linear-gradient(135deg, var(--primary-soft), #e0f2fe); display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-project-diagram" style="font-size:32px; color:var(--primary); opacity:0.4;"></i>
                        </div>
                    @endif

                    <div style="padding: 24px;">
                        {{-- ESTADO BADGE --}}
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px; gap:12px;">
                            <h4 style="font-size:16px; font-weight:800; color:var(--text); line-height:1.3; flex:1;">{{ $p->pro_titulo_proyecto }}</h4>
                            <span style="background:{{ $estadoColor['bg'] }}; border:1.5px solid {{ $estadoColor['border'] }}; color:{{ $estadoColor['text'] }}; border-radius:20px; padding:4px 12px; font-size:11px; font-weight:800; white-space:nowrap; display:flex; align-items:center; gap:5px; flex-shrink:0;">
                                <i class="fas {{ $estadoColor['icon'] }}"></i> {{ $p->pos_estado }}
                            </span>
                        </div>

                        {{-- META INFO --}}
                        <div style="display:grid; gap:8px; margin-bottom:16px;">
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-building" style="width:16px; color:var(--primary);"></i>
                                <span>{{ $p->emp_nombre }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-tag" style="width:16px; color:#8b5cf6;"></i>
                                <span>{{ $p->pro_categoria }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-chalkboard-teacher" style="width:16px; color:#0ea5e9;"></i>
                                <span>{{ $p->instructor_nombre }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-calendar-alt" style="width:16px; color:#f59e0b;"></i>
                                <span>Postulé el {{ \Carbon\Carbon::parse($p->pos_fecha)->format('d M, Y') }}</span>
                            </div>
                        </div>

                        {{-- PROYECTO STATUS PILL --}}
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:12px 16px; margin-bottom:18px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase;">Estado del Proyecto</span>
                            <span style="font-size:12px; font-weight:800; color:var(--primary);">
                                @if($esFinalizado) ✅ Finalizado @else ⏳ En progreso @endif
                            </span>
                        </div>

                        {{-- CTA --}}
                        @if($p->pos_estado === 'Aprobada')
                            <a href="{{ route('aprendiz.entregas') }}" class="btn-premium" style="width:100%; text-align:center; display:block; padding:12px;">
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
        {{-- EMPTY STATE --}}
        <div class="glass-card" style="padding: 80px 40px; text-align: center;">
            <div style="width:90px; height:90px; background:var(--primary-soft); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; font-size:40px; color:var(--primary);">
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
