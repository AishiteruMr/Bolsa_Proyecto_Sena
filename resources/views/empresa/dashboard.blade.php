@extends('layouts.dashboard')
@section('title', 'Dashboard Empresa')
@section('page-title', 'Panel Empresa')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
@endsection

@section('content')
    <div class="animate-fade-in">
        
        <!-- Hero Header -->
        <div class="instructor-hero">
            <div class="instructor-hero-bg-icon"><i class="fas fa-building"></i></div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
                    <span class="instructor-tag">Portal Corporativo</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 600;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F') }}</span>
                </div>
                <h1 class="instructor-title">Panel de <span style="color: var(--primary);">{{ session('nombre') }}</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 16px; max-width: 650px; line-height: 1.6; font-weight: 500;">Impulsa la innovación y conecta con el mejor talento del SENA gestionando tus proyectos estratégicos.</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="instructor-stat-grid">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-folder-plus"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: var(--text); line-height: 1;">{{ $totalProyectos }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Proyectos Totales</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #2d9d74; line-height: 1;">{{ $proyectosActivos }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">En Ejecución</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #3b82f6; line-height: 1;">{{ $totalPostulaciones }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Postulaciones</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: white;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(255,255,255,0.2); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; line-height: 1;">{{ $postulacionesPendientes }}</div>
                    <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; opacity: 0.9;">Pendientes</div>
                </div>
            </div>
        </div>

        <!-- Recent Projects Table -->
        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px 32px; background: linear-gradient(135deg, rgba(62,180,137,0.05), rgba(62,180,137,0.02)); border-bottom: 1px solid rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: space-between;">
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 14px;">
                    <span style="width: 42px; height: 42px; border-radius: 12px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-list-ul"></i>
                    </span>
                    Proyectos Publicados Recientemente
                </h3>
                <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">
                    <i class="fas fa-plus-circle"></i> Nueva Oferta
                </a>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Proyecto</th>
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Categoría</th>
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Estado</th>
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Postulaciones</th>
                            <th style="padding: 16px 24px; text-align: center; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proyectosRecientes as $p)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 20px 24px;">
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #f8fafc; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            @if($p->pro_evidencia_foto)
                                                <img src="{{ asset('storage/' . $p->pro_evidencia_foto) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <i class="fas fa-briefcase" style="color: var(--text-lighter); font-size: 20px;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text); font-size: 14px;">{{ Str::limit($p->titulo, 40) }}</div>
                                            <div style="font-size: 12px; color: var(--text-lighter); font-weight: 500;">
                                                Expira: {{ \Carbon\Carbon::parse($p->fecha_finalizacion)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 20px 24px;">
                                    <span style="background: #f1f5f9; color: var(--text-light); padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                        {{ $p->categoria }}
                                    </span>
                                </td>
                                <td style="padding: 20px 24px;">
                                    @php
                                        $statusClass = match($p->estado) {
                                            'aprobado' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a'],
                                            'pendiente' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706'],
                                            default => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#ef4444'],
                                        };
                                    @endphp
                                    <span style="background: {{ $statusClass['bg'] }}; border: 1px solid {{ $statusClass['border'] }}; color: {{ $statusClass['text'] }}; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">
                                        {{ $p->estado }}
                                    </span>
                                </td>
                                <td style="padding: 20px 24px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="display: flex;">
                                            @foreach($p->postulaciones->take(3) as $post)
                                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3eb489, #2d9d74); border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; font-weight: 800; margin-left: -10px;">
                                                    {{ substr($post->aprendiz->nombres ?? 'A', 0, 1) }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <span style="font-weight: 800; color: var(--text); font-size: 14px;">{{ $p->postulaciones_count }}</span>
                                    </div>
                                </td>
                                <td style="padding: 20px 24px; text-align: center;">
                                    <a href="{{ route('empresa.proyectos') }}" style="width: 36px; height: 36px; border-radius: 10px; background: #f8fafc; color: var(--text-light); display: inline-flex; align-items: center; justify-content: center; border: 1px solid #f1f5f9; transition: all 0.2s; text-decoration: none;" onmouseover="this.style.background='#3eb489'; this.style.color='white'; this.style.borderColor='#3eb489'" onmouseout="this.style.background='#f8fafc'; this.style.color='var(--text-light)'; this.style.borderColor='#f1f5f9'">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 80px;">
                                    <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: center; font-size: 32px; color: #3eb489; margin: 0 auto 24px;">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 8px;">No has publicado proyectos aún</h4>
                                    <p style="color: var(--text-light); margin-bottom: 24px; font-weight: 500;">Comienza ahora y conecta con el mejor talento técnico y tecnológico.</p>
                                    <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">Publicar Primer Proyecto</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
