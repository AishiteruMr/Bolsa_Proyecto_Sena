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
    @vite(['resources/css/empresa.css'])
@endsection

@section('content')
    <div class="animate-fade-in">
        
<!-- Hero Header -->
<div class="glass-card" style="position: relative; overflow: hidden; background: linear-gradient(135deg, rgba(62,180,137,0.1), rgba(62,180,137,0.05)); backdrop-filter: var(--glass); -webkit-backdrop-filter: blur(14px) saturate(190%); border: 1px solid var(--border-glass); box-shadow: var(--shadow);">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, transparent 0%, rgba(62,180,137,0.03) 50%, transparent 100%); pointer-events: none;"></div>
    <div style="position: relative; z-index: 1; padding: 32px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
            <span class="instructor-tag">Portal Corporativo</span>
            <span style="color: rgba(255,255,255,0.7); font-size: var(--text-sm); font-weight: var(--font-medium);"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F') }}</span>
        </div>
        <h1 class="instructor-title" style="font-size: var(--text-2xl); font-weight: var(--font-black); margin-bottom: 16px;">Panel de <span style="color: var(--primary);">{{ session('nombre') }}</span></h1>
        <p style="color: rgba(255,255,255,0.8); font-size: var(--text-base); max-width: 650px; line-height: 1.6; font-weight: var(--font-medium);">Impulsa la innovación y conecta con el mejor talento del SENA gestionando tus proyectos estratégicos.</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="instructor-stat-grid">
    <div class="glass-card" style="padding: 28px; display: flex; align-items: center; gap: 24px; transition: all 0.3s ease; border: 1px solid var(--border-glass);">
        <div style="width: 60px; height: 60px; border-radius: 16px; background: rgba(62,180,137,0.08); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0;">
            <i class="fas fa-folder-plus"></i>
        </div>
        <div>
            <div style="font-size: 36px; font-weight: var(--font-black); color: var(--text); line-height: 1;">{{ $totalProyectos }}</div>
            <div style="font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 6px;">Proyectos Totales</div>
        </div>
    </div>

    <div class="glass-card" style="padding: 28px; display: flex; align-items: center; gap: 24px; transition: all 0.3s ease; border: 1px solid var(--border-glass);">
        <div style="width: 60px; height: 60px; border-radius: 16px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0;">
            <i class="fas fa-flag-checkered"></i>
        </div>
        <div>
            <div style="font-size: 36px; font-weight: var(--font-black); color: #2d9d74; line-height: 1;">{{ $proyectosActivos }}</div>
            <div style="font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 6px;">En Ejecución</div>
        </div>
    </div>

    <div class="glass-card" style="padding: 28px; display: flex; align-items: center; gap: 24px; transition: all 0.3s ease; border: 1px solid var(--border-glass);">
        <div style="width: 60px; height: 60px; border-radius: 16px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0;">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div>
            <div style="font-size: 36px; font-weight: var(--font-black); color: #3b82f6; line-height: 1;">{{ $totalPostulaciones }}</div>
            <div style="font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 6px;">Postulaciones</div>
        </div>
    </div>

    <div class="glass-card" style="padding: 28px; display: flex; align-items: center; gap: 24px; transition: all 0.3s ease; border: 1px solid var(--border-glass);">
        <div style="width: 60px; height: 60px; border-radius: 16px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0;">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <div style="font-size: 36px; font-weight: var(--font-black); line-height: 1;">{{ $postulacionesPendientes }}</div>
            <div style="font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 6px; opacity: 0.9;">Pendientes</div>
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
                                            'completado' => ['bg' => '#065f46', 'border' => '#065f46', 'text' => '#ffffff', 'icon' => 'fa-check'],
                                            'aprobado' => ['bg' => '#10b981', 'border' => '#bbf7d0', 'text' => '#ffffff', 'icon' => 'fa-check'],
                                            'pendiente' => ['bg' => '#f59e0b', 'border' => '#fde68a', 'text' => '#ffffff', 'icon' => 'fa-clock'],
                                            'rechazado' => ['bg' => '#ef4444', 'border' => '#fecaca', 'text' => '#ffffff', 'icon' => 'fa-xmark'],
                                            'cerrado' => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-lock'],
                                            'en_progreso' => ['bg' => '#3b82f6', 'border' => '#bfdbfe', 'text' => '#ffffff', 'icon' => 'fa-spinner'],
                                            default => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-info-circle'],
                                        };
                                    @endphp
                                    <span style="background: {{ $statusClass['bg'] }}; border: 1px solid {{ $statusClass['border'] }}; color: {{ $statusClass['text'] }}; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fas {{ $statusClass['icon'] }}" style="color: {{ $statusClass['text'] }};"></i> {{ Str::title(str_replace('_', ' ', $p->estado)) }}
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
