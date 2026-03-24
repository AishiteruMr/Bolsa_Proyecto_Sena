@extends('layouts.dashboard')

@section('title', 'Explorar Proyectos - Inspírate SENA')
@section('page-title', 'Banco de Talento y Proyectos')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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

@section('content')
<div class="search-container" style="max-width: 1200px; margin: 0 auto; padding-bottom: 60px;">
    
    <!-- SEARCH HERO SECTION -->
    <div class="search-hero" style="background: linear-gradient(135deg, #004b4d, #002b2d); border-radius: 40px; padding: 60px 40px; text-align: center; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 20px 50px rgba(0, 43, 45, 0.2);">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: rgba(57, 169, 0, 0.1); border-radius: 50%; blur: 80px;"></div>
        
        <h2 style="color: white; font-size: 38px; font-weight: 800; margin-bottom: 12px; letter-spacing: -1px;">Descubre tu Siguiente Desafío</h2>
        <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">Explora cientos de proyectos de empresas líderes buscando el talento SENA que tú representas.</p>

        <!-- Centered Search Bar -->
        <form action="{{ route('aprendiz.proyectos') }}" method="GET" style="max-width: 700px; margin: 0 auto; position: relative;">
            <div class="search-input-wrapper" style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 24px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 20px;"></i>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="¿Qué quieres aprender hoy? (ej. React, Marketing, Diseño...)" 
                    style="width: 100%; padding: 22px 30px 22px 64px; border-radius: 20px; border: none; background: white; font-size: 16px; font-weight: 600; box-shadow: 0 10px 30px rgba(0,0,0,0.1); outline: none;">
                <button type="submit" class="hero-search-btn" style="position: absolute; right: 10px; top: 10px; bottom: 10px; background: var(--primary); color: white; border: none; padding: 0 24px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: all 0.3s;">
                    Buscar Ahora
                </button>
            </div>
            
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
        
        <div class="category-pills" style="display: flex; flex-wrap: wrap; gap: 12px; padding: 2px;">
            <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => ''])) }}" 
               class="pill {{ !request('categoria') ? 'active' : '' }}">
                Todos los Proyectos
            </a>
            @foreach($categorias as $cat)
                <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => $cat])) }}" 
                   class="pill {{ request('categoria') == $cat ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- RESULTS FEEDBACK -->
    <div style="margin-bottom: 24px; padding: 0 10px; display: flex; align-items: center; gap: 12px;">
        <span style="font-size: 15px; color: #1e293b; font-weight: 700;">
            {{ $proyectos->total() }} Proyectos encontrados
        </span>
        @if(request('buscar'))
            <span style="background: rgba(57, 169, 0, 0.1); color: var(--primary); padding: 4px 12px; border-radius: 8px; font-size: 13px; font-weight: 700;">
                "{{ request('buscar') }}"
            </span>
        @endif
    </div>

    <!-- GRID DE PROYECTOS -->
    @if($proyectos->isEmpty())
        <div class="glass-card" style="text-align: center; padding: 80px 40px; background: white;">
            <div style="width: 120px; height: 120px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 48px; color: #cbd5e1;">
                <i class="fas fa-search"></i>
            </div>
            <h3 style="font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 8px;">No encontramos lo que buscas</h3>
            <p style="color: #64748b; max-width: 400px; margin: 0 auto;">Intenta con otros términos de búsqueda o explora nuestras categorías destacadas.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px;">
            @foreach($proyectos as $p)
                <div class="premium-project-card" style="background: white; border-radius: 30px; border: 1.5px solid #f1f5f9; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column;">
                    <div style="height: 200px; position: relative; overflow: hidden;">
                        <img src="{{ $p->imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                        <div style="position: absolute; top: 20px; right: 20px;">
                            <span style="background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); color: #1e293b; padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                                {{ $p->pro_categoria }}
                            </span>
                        </div>
                    </div>
                    
                    <div style="padding: 28px; flex: 1; display: flex; flex-direction: column;">
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
                                <div style="background: #ecfdf5; color: #059669; padding: 14px; border-radius: 16px; text-align: center; font-size: 14px; font-weight: 700; border: 1.5px solid #d1fae5;">
                                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> ¡Ya te has postulado!
                                </div>
                            @else
                                <form action="{{ route('aprendiz.postular', $p->pro_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="apply-btn" style="width: 100%; padding: 16px; border-radius: 16px; background: var(--primary); color: white; border: none; font-weight: 700; font-size: 15px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;">
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

<style>
    .pill {
        padding: 10px 24px;
        background: white;
        border: 1.5px solid #e2e8f0;
        border-radius: 30px;
        color: #64748b;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pill:hover {
        border-color: var(--primary-light);
        color: var(--primary);
        transform: translateY(-2px);
    }

    .pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 10px 20px rgba(57, 169, 0, 0.2);
    }

    .premium-project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.08);
        border-color: var(--primary-light);
    }

    .premium-project-card:hover img {
        transform: scale(1.08);
    }

    .apply-btn:hover {
        background: var(--primary-dark);
        box-shadow: 0 10px 25px rgba(57, 169, 0, 0.3);
    }

    .hero-search-btn:hover {
        background: white;
        color: var(--primary);
        transform: scale(1.05);
    }

    /* Paginación Styling Override */
    .pagination {
        display: flex;
        gap: 8px;
    }
    .page-item .page-link {
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 700;
        color: #1e293b;
        border: 1.5px solid #e2e8f0;
    }
    .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }
</style>
@endsection
