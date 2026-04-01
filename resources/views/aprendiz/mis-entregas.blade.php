@extends('layouts.dashboard')

@section('title', 'Mis Entregas y Evidencias')
@section('page-title', 'Mis Entregas')

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
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
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
<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto;">

    {{-- PAGE HEADER --}}
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 28px; font-weight: 800; color: var(--text); letter-spacing: -0.5px;">
            Mis <span style="color: var(--primary);">Entregas</span> y Evidencias
        </h2>
        <p style="color: var(--text-light); font-size: 15px; margin-top: 4px; font-weight: 500;">
            Seguimiento de tus entregables en proyectos aprovados.
        </p>
    </div>

    {{-- SUMMARY STATS --}}
    @if($proyectos->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
            <div style="width: 52px; height: 52px; border-radius: 16px; background: #f8fafc; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <div style="font-size: 32px; font-weight: 800; color: var(--text); line-height: 1;">{{ $evidencias->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Evidencias Totales</div>
            </div>
        </div>
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #bbf7d0;">
            <div style="width: 52px; height: 52px; border-radius: 16px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div style="font-size: 32px; font-weight: 800; color: #16a34a; line-height: 1;">{{ $evidencias->where('evid_estado', 'Aprobada')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Aprobadas</div>
            </div>
        </div>
        <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fde68a;">
            <div style="width: 52px; height: 52px; border-radius: 16px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <div style="font-size: 32px; font-weight: 800; color: #d97706; line-height: 1;">{{ $evidencias->where('evid_estado', 'Pendiente')->count() }}</div>
                <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Pendientes</div>
            </div>
        </div>
    </div>
    @endif

    {{-- PROJECT EVIDENCES LIST --}}
    @if($proyectos->count() > 0)
        <div style="display: grid; gap: 32px;">
            @foreach($proyectos as $proyecto)
                @php
                    $evidencias_proyecto = $evidencias->where('evid_pro_id', $proyecto->pro_id);
                @endphp
                <div class="glass-card" style="padding: 0; overflow: hidden;">
                    {{-- Project Header --}}
                    <div style="padding: 24px 32px; background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 17px; font-weight: 800; color: var(--text);">{{ $proyecto->pro_titulo_proyecto }}</h4>
                                <p style="font-size: 13px; color: var(--text-light); margin-top: 2px; font-weight: 600;">
                                    <i class="fas fa-building" style="margin-right: 6px; color: var(--primary);"></i>{{ $proyecto->emp_nombre }}
                                    &nbsp;&middot;&nbsp;
                                    <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>Cierre: {{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <span style="background: white; border: 1px solid var(--border); padding: 6px 16px; border-radius: 30px; font-size: 12px; font-weight: 800; color: var(--text-light);">
                            {{ $evidencias_proyecto->count() }} Evidencias
                        </span>
                    </div>

                    {{-- Evidence Items --}}
                    <div style="padding: 24px 32px; display: grid; gap: 16px;">
                        @if($evidencias_proyecto->count() > 0)
                            @foreach($evidencias_proyecto as $evidencia)
                                @php
                                    $stateColor = match($evidencia->evid_estado) {
                                        'Aprobada'  => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a', 'icon' => 'fa-check-circle'],
                                        'Rechazada' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#dc2626', 'icon' => 'fa-times-circle'],
                                        default     => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-hourglass-half'],
                                    };
                                @endphp
                                <div style="background: {{ $stateColor['bg'] }}; border: 1.5px solid {{ $stateColor['border'] }}; border-radius: 16px; padding: 20px 24px;">
                                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
                                        <div style="flex: 1;">
                                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                                                <span style="width: 28px; height: 28px; border-radius: 8px; background: {{ $stateColor['text'] }}; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0;">
                                                    {{ $evidencia->etapa->eta_orden ?? '?' }}
                                                </span>
                                                <h5 style="font-size: 15px; font-weight: 800; color: var(--text);">
                                                    {{ $evidencia->etapa->eta_nombre ?? 'Etapa sin nombre' }}
                                                </h5>
                                            </div>
                                            <div style="font-size: 12px; color: var(--text-light); font-weight: 600; margin-bottom: 8px;">
                                                <i class="far fa-clock" style="margin-right: 6px;"></i>
                                                Entregado: {{ \Carbon\Carbon::parse($evidencia->evid_fecha)->translatedFormat('d M Y, H:i') }}
                                            </div>
                                            @if($evidencia->evid_comentario)
                                                <div style="background: rgba(255,255,255,0.7); border-radius: 10px; padding: 12px 16px; margin-top: 10px; border: 1px solid rgba(0,0,0,0.05);">
                                                    <p style="font-size: 13px; color: var(--text); font-weight: 600; margin: 0;">
                                                        <i class="fas fa-comment-dots" style="color: var(--primary); margin-right: 8px;"></i>{{ $evidencia->evid_comentario }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 12px; flex-shrink: 0;">
                                            <span style="background: white; color: {{ $stateColor['text'] }}; border: 1.5px solid {{ $stateColor['border'] }}; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; white-space: nowrap; display: flex; align-items: center; gap: 6px;">
                                                <i class="fas {{ $stateColor['icon'] }}"></i> {{ $evidencia->evid_estado }}
                                            </span>
                                            @if($evidencia->evid_archivo)
                                                <a href="{{ asset('storage/' . $evidencia->evid_archivo) }}" target="_blank"
                                                   style="background: white; color: #3b82f6; border: 1.5px solid #dbeafe; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 6px; white-space: nowrap; transition: all 0.2s;">
                                                    <i class="fas fa-file-download"></i> Ver Archivo
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 40px; color: var(--text-lighter);">
                                <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
                                <p style="font-weight: 600;">Sin evidencias registradas aún</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="glass-card aprendiz-empty-state">
            <div style="width: 100px; height: 100px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px; color: var(--text-lighter);">
                <i class="fas fa-inbox"></i>
            </div>
            <h4 style="color: var(--text); font-size: 22px; font-weight: 800; margin-bottom: 8px;">Sin proyectos aprobados</h4>
            <p style="color: var(--text-light); max-width: 450px; margin: 0 auto 32px;">
                Cuando tengas un proyecto aprobado, podrás gestionar y enviar tus evidencias desde aquí.
            </p>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn-premium" style="background: var(--secondary);">
                <i class="fas fa-search"></i> Explorar Proyectos
            </a>
        </div>
    @endif
</div>
@endsection
