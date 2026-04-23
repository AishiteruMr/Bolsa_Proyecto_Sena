@extends('layouts.dashboard')

@section('title', 'Explorar Proyectos - Inspírate SENA')
@section('page-title', 'Banco de Talento y Proyectos')

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
<div style="max-width: 1200px; margin: 0 auto; padding-bottom: 60px;">
    
    <!-- SEARCH HERO SECTION -->
    <div style="background: linear-gradient(135deg, #0a1a15 0%, #1a2e28 100%); border-radius: 32px; padding: 60px 48px; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 20px 50px -15px rgba(62,180,137,0.3);">
        <div style="position: absolute; right: -30px; bottom: -30px; font-size: 200px; color: rgba(62,180,137,0.06); transform: rotate(-15deg); pointer-events: none;">
            <i class="fas fa-search"></i>
        </div>
        
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <span style="background: #3eb489; color: white; padding: 8px 18px; border-radius: 40px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 8px 16px rgba(62,180,137,0.3);">
                    Banco de Proyectos
                </span>
            </div>
            <h2 style="color: white; font-size: 38px; font-weight: 800; margin-bottom: 12px; letter-spacing: -1px;">Descubre tu Siguiente Desafío</h2>
            <p style="color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 40px; max-width: 600px;">Explora cientos de proyectos de empresas líderes buscando el talento SENA que tú representas.</p>

            <!-- Search Bar -->
            <form action="{{ route('aprendiz.proyectos') }}" method="GET" style="position: relative; max-width: 700px;">
                <i class="fas fa-search" style="position: absolute; left: 24px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 18px;"></i>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="¿Qué quieres aprender hoy? (ej. React, Marketing, Diseño...)" style="width: 100%; padding: 20px 24px 20px 60px; border-radius: 20px; border: none; background: white; font-size: 15px; font-weight: 600; box-shadow: 0 10px 30px rgba(0,0,0,0.1); outline: none;">
                <button type="submit" style="position: absolute; right: 12px; top: 12px; bottom: 12px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; border: none; padding: 0 28px; border-radius: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 8px 16px rgba(62,180,137,0.3);">
                    Buscar
                </button>
                
                @if(request('categoria'))
                    <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                @endif
            </form>
        </div>
    </div> 

    <!-- CATEGORY PILLS -->
    <div style="margin-bottom: 32px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; background: rgba(62,180,137,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-filter" style="color: #3eb489; font-size: 14px;"></i>
                </div>
                <h4 style="font-size: 14px; font-weight: 800; color: var(--text); margin: 0;">Filtrar por Especialidad</h4>
                <span style="font-size: 12px; color: var(--text-light); font-weight: 500;">({{ count($categorias) }} categorías)</span>
            </div>
            @if(request()->anyFilled(['buscar', 'categoria']))
                <a href="{{ route('aprendiz.proyectos') }}" style="font-size: 12px; font-weight: 700; color: #ef4444; text-decoration: none; display: flex; align-items: center; gap: 6px; background: #fef2f2; padding: 8px 14px; border-radius: 20px;">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            @endif
        </div>
        
        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => ''])) }}" 
               style="padding: 12px 20px; background: {{ !request('categoria') ? 'linear-gradient(135deg, #3eb489, #2d9d74)' : 'white' }}; color: {{ !request('categoria') ? 'white' : '#64748b' }}; border: {{ !request('categoria') ? 'none' : '1.5px solid #e2e8f0' }}; border-radius: 12px; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.3s; display: flex; align-items: center; gap: 8px; box-shadow: {{ !request('categoria') ? '0 4px 12px rgba(62,180,137,0.3)' : 'none' }};">
                <i class="fas fa-border-all"></i> Todos
            </a>
            @foreach($categorias as $cat)
                <a href="{{ route('aprendiz.proyectos', array_merge(request()->all(), ['categoria' => $cat])) }}" 
                   style="padding: 12px 20px; background: {{ request('categoria') == $cat ? 'linear-gradient(135deg, #3eb489, #2d9d74)' : 'white' }}; color: {{ request('categoria') == $cat ? 'white' : '#64748b' }}; border: {{ request('categoria') == $cat ? 'none' : '1.5px solid #e2e8f0' }}; border-radius: 12px; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: {{ request('categoria') == $cat ? '0 4px 12px rgba(62,180,137,0.3)' : 'none' }};">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- RESULTS FEEDBACK -->
    <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 20px; font-weight: 800; color: var(--text);">{{ $proyectos->total() }}</span>
            <span style="font-size: 14px; color: var(--text-light); font-weight: 500;">Proyectos encontrados</span>
        </div>
        @if(request('buscar'))
            <span style="background: rgba(62,180,137,0.1); color: #3eb489; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                "{{ request('buscar') }}"
            </span>
        @endif
    </div>

    <!-- GRID DE PROYECTOS -->
    @if($proyectos->isEmpty())
        <div style="padding: 5rem 2rem; text-align: center; background: white; border-radius: 24px; border: 1px dashed rgba(62,180,137,0.2);">
            <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <i class="fas {{ request('buscar') || request('categoria') ? 'fa-search' : 'fa-folder-open' }}" style="font-size: 40px; color: #3eb489;"></i>
            </div>
            @if(request('buscar') || request('categoria'))
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 8px;">Sin resultados</h3>
                <p style="color: var(--text-light); max-width: 400px; margin: 0 auto 24px;">No encontramos proyectos que coincidan con tu búsqueda "{{ request('buscar') ?? request('categoria') }}".</p>
                <a href="{{ route('aprendiz.proyectos') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #3eb489; color: white; border-radius: 12px; font-weight: 700; text-decoration: none;">
                    <i class="fas fa-rotate-left"></i> Limpiar filtros
                </a>
            @else
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 8px;">No hay proyectos disponibles</h3>
                <p style="color: var(--text-light); max-width: 400px; margin: 0 auto;">Próximamente habrá nuevas oportunidades. Revisa más tarde.</p>
            @endif
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
            @foreach($proyectos as $p)
                <div style="background: white; border-radius: 24px; overflow: hidden; border: 1px solid rgba(62,180,137,0.1); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 16px 40px rgba(62,180,137,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                    <div style="height: 200px; position: relative;">
                        <img src="{{ $p->imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                        <div style="position: absolute; top: 16px; left: 16px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">
                            {{ $p->categoria }}
                        </div>
                    </div>
                    
                    <div style="padding: 28px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                            <div style="width: 32px; height: 32px; background: rgba(62,180,137,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-building" style="color: #3eb489; font-size: 12px;"></i>
                            </div>
                            <span style="font-size: 13px; font-weight: 700; color: var(--text-light);">{{ $p->nombre }}</span>
                        </div>
                        
                        <h3 style="font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.4; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $p->titulo }}
                        </h3>

                        <div style="display: flex; gap: 20px; margin-bottom: 24px; padding: 14px; background: rgba(62,180,137,0.03); border-radius: 14px; border: 1px solid rgba(62,180,137,0.08);">
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-light); font-weight: 600;">
                                <i class="fas fa-clock" style="color: #f59e0b;"></i> {{ $p->duracion_estimada_dias }} días
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-light); font-weight: 600;">
                                <i class="fas fa-users" style="color: #3eb489;"></i> {{ $p->postulados_count ?? 0 }} postulados
                            </div>
                        </div>

                        <div style="margin-top: auto;">
                            @if(in_array($p->id, $postulados))
                                <div style="background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; padding: 14px; border-radius: 16px; text-align: center; font-size: 14px; font-weight: 700; box-shadow: 0 8px 20px rgba(62,180,137,0.3);">
                                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> ¡Ya te has postulado!
                                </div>
                            @else
                                <form action="{{ route('aprendiz.postular', $p->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; border: none; border-radius: 14px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 8px 20px rgba(62,180,137,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(62,180,137,0.4)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 20px rgba(62,180,137,0.3)'">
                                        Postularme <i class="fas fa-paper-plane"></i>
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
