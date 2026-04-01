@extends('layouts.dashboard')

@section('title', 'Explorar Proyectos - Inspírate SENA')
@section('page-title', 'Banco de Talento y Proyectos')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-search-plus"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aprendiz.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="max-width: 1200px; margin: 0 auto; padding-bottom: 60px;">
    
    <!-- SEARCH HERO SECTION -->
    <div class="aprendiz-search-hero">
        <div class="aprendiz-search-bg-glow"></div>
        
        <h2 style="color: white; font-size: 38px; font-weight: 800; margin-bottom: 12px; letter-spacing: -1px;">Descubre tu Siguiente Desafío</h2>
        <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">Explora cientos de proyectos de empresas líderes buscando el talento SENA que tú representas.</p>

        <!-- Centered Search Bar -->
        <form action="{{ route('aprendiz.proyectos') }}" method="GET" class="aprendiz-search-input-wrapper">
            <i class="fas fa-search aprendiz-search-input-icon"></i>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="¿Qué quieres aprender hoy? (ej. React, Marketing, Diseño...)" class="aprendiz-search-control">
            <button type="submit" class="aprendiz-search-btn">
                Buscar Ahora
            </button>
            
            @if(request('categoria'))
                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
            @endif
        </form>
    </div>

    <!-- CATEGORY PILLS -->
    <div style="margin-bottom: 32px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding: 0 10px;">
            <h4 style="font-size: 14px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Filtrar por Especialidad</h4>
            @if(request()->anyFilled(['buscar', 'categoria']))
                <a href="{{ route('aprendiz.proyectos') }}" style="font-size: 13px; font-weight: 700; color: #ef4444; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-times-circle"></i> Limpiar Filtros
                </a>
            @endif
        </div>
        
        <div class="aprendiz-pill-container">
            <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => ''])) }}" 
               class="aprendiz-pill {{ !request('categoria') ? 'active' : '' }}">
                Todos los Proyectos
            </a>
            @foreach($categorias as $cat)
                <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => $cat])) }}" 
                   class="aprendiz-pill {{ request('categoria') == $cat ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- RESULTS FEEDBACK -->
    <div style="margin-bottom: 24px; padding: 0 10px; display: flex; align-items: center; gap: 12px;">
        <span class="aprendiz-results-count">
            {{ $proyectos->total() }} Proyectos encontrados
        </span>
        @if(request('buscar'))
            <span class="aprendiz-query-tag">
                "{{ request('buscar') }}"
            </span>
        @endif
    </div>

    <!-- GRID DE PROYECTOS -->
    @if($proyectos->isEmpty())
        <div class="glass-card aprendiz-empty-state" style="background: white;">
            <div style="width: 120px; height: 120px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 48px; color: #cbd5e1;">
                <i class="fas fa-search"></i>
            </div>
            <h3 style="font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 8px;">No encontramos lo que buscas</h3>
            <p style="color: #64748b; max-width: 400px; margin: 0 auto;">Intenta con otros términos de búsqueda o explora nuestras categorías destacadas.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px;">
            @foreach($proyectos as $p)
                <div class="glass-card aprendiz-project-card" style="background: white; border: 1.5px solid #f1f5f9;">
                    <div class="aprendiz-project-image-wrapper" style="height: 200px;">
                        <img src="{{ $p->imagen_url }}" alt="">
                        <div class="aprendiz-project-category">
                            {{ $p->pro_categoria }}
                        </div>
                    </div>
                    
                    <div class="aprendiz-project-body" style="padding: 28px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                            <i class="fas fa-building" style="color: var(--primary); font-size: 14px;"></i>
                            <span style="font-size: 13px; font-weight: 700; color: #64748b;">{{ $p->emp_nombre }}</span>
                        </div>
                        
                        <h3 style="font-size: 20px; font-weight: 800; color: #1e293b; line-height: 1.4; margin-bottom: 16px; min-height: 56px;">
                            {{ $p->pro_titulo_proyecto }}
                        </h3>

                        <div style="margin-bottom: 24px; display: flex; gap: 16px;">
                            <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: #64748b; font-weight: 600;">
                                <i class="fas fa-clock"></i> {{ $p->pro_duracion_estimada }} días
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: #64748b; font-weight: 600;">
                                <i class="fas fa-user-friends"></i> {{ $p->postulados_count ?? 0 }} postulados
                            </div>
                        </div>

                        <div style="margin-top: auto;">
                            @if(in_array($p->pro_id, $postulados))
                                <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); color: #fff; padding: 14px; border-radius: 16px; text-align: center; font-size: 14px; font-weight: 700; border: none; box-shadow: 0 10px 20px rgba(59,180,137,0.2);">
                                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> ¡Ya te has postulado!
                                </div>
                            @else
                                <form action="{{ route('aprendiz.postular', $p->pro_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-premium" style="width: 100%; padding: 16px; border-radius: 16px; justify-content: center; font-size: 15px;">
                                        Postularme <i class="fas fa-arrow-right"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- PAGINACIÓN -->
        <div style="margin-top: 50px; display: flex; justify-content: center;">
            {{ $proyectos->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection
