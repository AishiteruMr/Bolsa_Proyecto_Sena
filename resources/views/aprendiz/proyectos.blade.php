@extends('layouts.dashboard')

@section('title', 'Explorar Proyectos')
@section('page-title', 'Explorar Proyectos')

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
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('content')
<div style="margin-bottom: 32px;">
    <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">Banco de Proyectos</h2>
    <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Encuentra y postúlate a los proyectos que impulsarán tu carrera profesional.</p>
</div>

<!-- Filtros Premium -->
<div class="glass-card" style="margin-bottom: 32px; padding: 1.5rem;">
    <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: end;">
        <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 8px; display: block;">Buscar Proyecto</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Título, empresa..." class="form-control" style="background: var(--bg-main); border: 1px solid var(--border); padding: 12px; border-radius: 8px;">
        </div>
        
        <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 8px; display: block;">Filtrar por Categoría</label>
            <select name="categoria" class="form-control" style="background: var(--bg-main); border: 1px solid var(--border); padding: 12px; border-radius: 8px; height: 46px;">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 0.75rem;">
            <button type="submit" class="btn-ver" style="flex: 1; justify-content: center; height: 46px; border-radius: 8px;">
                <i class="fas fa-search" style="margin-right: 8px;"></i> Buscar
            </button>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn-ver" style="background: #64748b; width: 46px; height: 46px; border-radius: 8px; justify-content: center; padding: 0;" title="Limpiar filtros">
                <i class="fas fa-undo"></i>
            </a>
        </div>
    </form>
</div>

<!-- Grid de proyectos -->
@if($proyectos->isEmpty())
    <div class="glass-card" style="text-align:center; padding: 5rem 2rem;">
        <i class="fas fa-search" style="font-size: 4rem; color: var(--border); margin-bottom: 1.5rem;"></i>
        <h3 style="color: var(--text-main); font-size: 1.5rem; margin-bottom: 8px;">No se encontraron proyectos</h3>
        <p style="color: var(--text-muted);">Intenta ajustar tus criterios de búsqueda o explora otras categorías.</p>
    </div>
@else
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
        @foreach($proyectos as $p)
            <div class="project-card glass-card" style="display: flex; flex-direction: column; height: 100%; transition: transform 0.3s ease;">
                <div class="project-image" style="height: 180px; position: relative;">
                    <img src="{{ $p->pro_imagen_url ?? asset('assets/default-project.jpg') }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                    <div class="status-badge" style="background: var(--primary); font-size: 10px; position: absolute; top: 1rem; right: 1rem;">{{ $p->pro_categoria }}</div>
                </div>
                
                <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                    <h4 style="font-size: 1.2rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.75rem; line-height: 1.3;">{{ $p->pro_titulo_proyecto }}</h4>
                    
                    <div style="margin-bottom: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <i class="fas fa-building" style="color:var(--primary); width: 16px;"></i>
                            <span style="font-weight: 500; color: var(--text-main);">{{ $p->emp_nombre }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-clock" style="color:var(--primary); width: 16px;"></i>
                            <span>{{ $p->pro_duracion_estimada }} días de duración</span>
                        </div>
                    </div>

                    <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 1.5rem; flex: 1;">
                        {{ Str::limit($p->pro_descripcion, 120) }}
                    </p>

                    <div style="margin-top: auto;">
                        @if(in_array($p->pro_id, $postulados))
                            <div style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 0.8rem; border-radius: 8px; text-align: center; font-size: 0.9rem; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.2);">
                                <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Ya te has postulado
                            </div>
                        @else
                            <form action="{{ route('aprendiz.postular', $p->pro_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-ver" style="width: 100%; padding: 0.8rem; border-radius: 8px; justify-content: center;">
                                    <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Postularme Ahora
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginación Premium -->
    <div style="margin-top: 40px; display: flex; justify-content: center;">
        {{ $proyectos->withQueryString()->links() }}
    </div>
@endif
@endsection
