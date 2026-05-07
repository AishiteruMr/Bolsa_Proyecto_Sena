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
 
    {{-- ── Hero ── --}}
    <div class="emp-hero">
        <div class="emp-hero-bg-icon"><i class="fas fa-building"></i></div>
        <div class="emp-hero-inner">
            <div class="emp-hero-top">
                <span class="emp-badge">Portal Corporativo</span>
                <span class="emp-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ now()->translatedFormat('l, d F') }}
                </span>
            </div>
            <h1 class="emp-title">Panel de <span class="emp-title-accent">{{ session('nombre') }}</span></h1>
            <p class="emp-subtitle">Impulsa la innovación y conecta con el mejor talento del SENA.</p>
        </div>
    </div>
 
    {{-- ── Stats ── --}}
    <div class="emp-stats">
 
        <div class="emp-stat-card">
            <div class="emp-stat-icon" style="background:rgba(62,180,137,0.08); color:var(--primary);">
                <i class="fas fa-folder-plus"></i>
            </div>
            <div class="emp-stat-number">{{ $totalProyectos }}</div>
            <div class="emp-stat-label">Proyectos Totales</div>
        </div>
 
        <div class="emp-stat-card">
            <div class="emp-stat-icon" style="background:var(--primary-soft); color:var(--primary);">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <div class="emp-stat-number" style="color:#2d9d74;">{{ $proyectosActivos }}</div>
            <div class="emp-stat-label">En Ejecución</div>
        </div>
 
        <div class="emp-stat-card">
            <div class="emp-stat-icon" style="background:rgba(59,130,246,0.08); color:#3b82f6;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="emp-stat-number" style="color:#3b82f6;">{{ $totalPostulaciones }}</div>
            <div class="emp-stat-label">Postulaciones</div>
        </div>
 
        <div class="emp-stat-card">
            <div class="emp-stat-icon" style="background:rgba(245,158,11,0.08); color:#f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="emp-stat-number" style="color:#f59e0b;">{{ $postulacionesPendientes }}</div>
            <div class="emp-stat-label">Pendientes</div>
        </div>
 
    </div>
 
    {{-- ── Tabla proyectos recientes ── --}}
    <div class="glass-card emp-table-card">
 
        <div class="emp-table-header">
            <h3 class="emp-table-title">
                <span class="emp-table-icon"><i class="fas fa-list-ul"></i></span>
                Proyectos Recientes
            </h3>
            <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">
                <i class="fas fa-plus-circle"></i> Nueva Oferta
            </a>
        </div>
 
        <div class="emp-table-scroll">
            <table class="emp-table">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Postulaciones</th>
                        <th style="text-align:center;">Ver</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyectosRecientes as $p)
                        <tr>
                            <td>
                                <div class="emp-proj-cell">
                                    <div class="emp-proj-thumb">
                                        @if($p->pro_evidencia_foto)
                                            <img src="{{ asset('storage/' . $p->pro_evidencia_foto) }}" alt="">
                                        @else
                                            <i class="fas fa-briefcase"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="emp-proj-name">{{ Str::limit($p->titulo, 38) }}</div>
                                        <div class="emp-proj-date">Expira: {{ \Carbon\Carbon::parse($p->fecha_finalizacion)->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="emp-category">{{ $p->categoria }}</span>
                            </td>
                            <td>
                                @php
                                    $s = match($p->estado) {
                                        'completado'  => ['bg'=>'#065f46','text'=>'#fff','icon'=>'fa-check'],
                                        'aprobado'    => ['bg'=>'#10b981','text'=>'#fff','icon'=>'fa-check'],
                                        'pendiente'   => ['bg'=>'#f59e0b','text'=>'#fff','icon'=>'fa-clock'],
                                        'rechazado'   => ['bg'=>'#ef4444','text'=>'#fff','icon'=>'fa-xmark'],
                                        'cerrado'     => ['bg'=>'#64748b','text'=>'#fff','icon'=>'fa-lock'],
                                        'en_progreso' => ['bg'=>'#3b82f6','text'=>'#fff','icon'=>'fa-spinner'],
                                        default       => ['bg'=>'#64748b','text'=>'#fff','icon'=>'fa-info-circle'],
                                    };
                                @endphp
                                <span class="emp-status" style="background:{{ $s['bg'] }}; color:{{ $s['text'] }};">
                                    <i class="fas {{ $s['icon'] }}"></i>
                                    {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                                </span>
                            </td>
                            <td>
                                <div class="emp-avatars">
                                    @foreach($p->postulaciones->take(3) as $post)
                                        <div class="emp-avatar">{{ substr($post->aprendiz->nombres ?? 'A', 0, 1) }}</div>
                                    @endforeach
                                    <span class="emp-avatars-count">{{ $p->postulaciones_count }}</span>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <a href="{{ route('empresa.proyectos') }}" class="emp-view-btn">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="emp-empty">
                                    <div class="emp-empty-icon"><i class="fas fa-folder-open"></i></div>
                                    <h4>No has publicado proyectos aún</h4>
                                    <p>Comienza ahora y conecta con el mejor talento técnico.</p>
                                    <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">Publicar Primer Proyecto</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
 
    </div>
 
</div>
@endsection
 