@extends('layouts.dashboard')

@section('title', 'Dashboard Aprendiz')
@section('page-title', 'Mi Dashboard')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
    <!-- Bienvenida Premium -->
    <div style="margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase;">Portal del Talento</span>
            <span style="color: var(--text-muted); font-size: 13px;">{{ now()->translatedFormat('l, d F') }}</span>
        </div>
        <h2 style="font-size:32px; font-weight:800; color: #1e293b; letter-spacing: -1px;">¡Hola de nuevo, {{ session('nombre') }}! 👋</h2>
        <p style="color: #64748b; font-size: 16px;">Sigue impulsando tu carrera participando en proyectos reales de la industria.</p>
    </div>

    <!-- BENTO DASHBOARD -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
        <!-- Status Card -->
        <div class="glass-card stat-card-premium" style="grid-column: span 2; background: linear-gradient(135deg, #064e3b, #065f46); color: white; border: none; display: flex; align-items: center; gap: 24px; padding: 32px;">
            <div style="width: 64px; height: 64px; border-radius: 20px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-size: 28px;">
                <i class="fas fa-rocket"></i>
            </div>
            <div>
                <h3 style="font-size: 24px; font-weight: 800;">{{ $postulacionesAprobadas }} Proyectos Activos</h3>
                <p style="font-size: 14px; color: rgba(255,255,255,0.7);">Sigue así, estás construyendo tu futuro profesional.</p>
            </div>
        </div>

        <!-- Info Card 1 -->
        <div class="glass-card stat-card-premium">
            <p style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 12px;">Próximo Cierre</p>
            @if($proximoCierre)
                <h4 style="font-size: 18px; font-weight: 800; color: #ef4444;">{{ \Carbon\Carbon::parse($proximoCierre->pro_fecha_finalizacion)->diffForHumans() }}</h4>
                <p style="font-size: 11px; color: #94a3b8; margin-top: 4px;">{{ $proximoCierre->pro_titulo_proyecto }}</p>
            @else
                <h4 style="font-size: 18px; font-weight: 800; color: #94a3b8;">Sin cierres</h4>
                <p style="font-size: 11px; color: #94a3b8; margin-top: 4px;">No tienes proyectos activos.</p>
            @endif
        </div>

        <!-- Info Card 2 -->
        <div class="glass-card stat-card-premium">
            <p style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 12px;">Postulaciones</p>
            <h4 style="font-size: 24px; font-weight: 800; color: #1e293b;">{{ $totalPostulaciones }}</h4>
            <div style="width: 100%; height: 6px; background: #f1f5f9; border-radius: 10px; margin-top: 12px; overflow: hidden;">
                <div style="width: 65%; height: 100%; background: var(--primary); border-radius: 10px;"></div>
            </div>
        </div>
    </div>

    <!-- Proyectos Feed -->
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 22px; font-weight: 700; color: #1e293b;">Oportunidades Destacadas</h3>
        <a href="{{ route('aprendiz.proyectos') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 14px;">Explorar todas las vacantes <i class="fas fa-chevron-right" style="margin-left: 5px; font-size: 12px;"></i></a>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(320px,1fr)); gap:24px;">
        @forelse($proyectosRecientes as $p)
            <div class="glass-card project-card-aprendiz" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <div style="height: 180px; position: relative;">
                    <img src="{{ $p->imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                    <div style="position: absolute; top: 16px; right: 16px; background: rgba(255,255,255,0.9); padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; color: var(--primary);">
                        {{ $p->pro_categoria }}
                    </div>
                </div>
                <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                    <p style="font-size: 12px; font-weight: 600; color: var(--primary); margin-bottom: 8px;">{{ $p->emp_nombre }}</p>
                    <h4 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 12px; line-height: 1.4;">{{ $p->pro_titulo_proyecto }}</h4>
                    
                    <div style="margin-top: auto; padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #94a3b8;"><i class="fas fa-users" style="margin-right: 6px;"></i> Popular</span>
                        @if(in_array($p->pro_id, $proyectosAprobados))
                            <a href="{{ route('aprendiz.proyecto.detalle', $p->pro_id) }}" class="btn-primary-sm">Gestionar Proyecto</a>
                        @else
                            <a href="{{ route('aprendiz.proyectos') }}" class="btn-outline-sm">Ver Detalles</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 60px;">
                <i class="fas fa-search" style="font-size: 48px; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h4 style="color: #64748b;">No hay proyectos disponibles en este momento.</h4>
            </div>
        @endforelse
    </div>

    <style>
        .stat-card-premium {
            padding: 32px;
            transition: all 0.4s ease;
        }
        .stat-card-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        }
        .project-card-aprendiz {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .project-card-aprendiz:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 40px -10px rgba(0,0,0,0.1);
        }
        .btn-primary-sm {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
        }
        .btn-outline-sm {
            border: 2px solid #e2e8f0;
            color: #64748b;
            padding: 6px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.3s;
        }
        .btn-outline-sm:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
    </style>
@endsection
