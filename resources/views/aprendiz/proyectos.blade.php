@extends('layouts.dashboard')

@section('title', 'Explorar Proyectos')
@section('page-title', 'Explorar Proyectos')

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
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
    <!-- Filtros -->
    <div class="card" style="margin-bottom:20px;">
        <form method="GET" style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
            <div style="flex:1; min-width:200px;">
                <label style="font-size:12px; font-weight:600; display:block; margin-bottom:4px;">Buscar</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Título del proyecto..." class="form-control" style="padding:9px 12px;">
            </div>
            <div style="min-width:160px;">
                <label style="font-size:12px; font-weight:600; display:block; margin-bottom:4px;">Categoría</label>
                <select name="categoria" class="form-control" style="padding:9px 12px;">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
            <a href="{{ route('aprendiz.proyectos') }}" class="btn btn-outline">Limpiar</a>
        </form>
    </div>

    <!-- Grid de proyectos -->
    @if($proyectos->isEmpty())
        <div class="card" style="text-align:center; padding:48px;">
            <div style="font-size:48px; margin-bottom:12px;">🔍</div>
            <h3 style="font-weight:600; margin-bottom:8px;">No se encontraron proyectos</h3>
            <p style="color:#666; font-size:14px;">Intenta con otra búsqueda o categoría.</p>
        </div>
    @else
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px;">
            @foreach($proyectos as $p)
                <div class="card" style="padding:0; overflow:hidden; display:flex; flex-direction:column;">
                    @if($p->pro_imagen_url)
                        <img src="{{ $p->pro_imagen_url }}" alt="" style="width:100%; height:160px; object-fit:cover;">
                    @else
                        <div style="width:100%; height:160px; background:linear-gradient(135deg,#39a900,#5cb800); display:flex; align-items:center; justify-content:center; font-size:40px;">💼</div>
                    @endif
                    <div style="padding:18px; flex:1; display:flex; flex-direction:column;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                            <span class="badge badge-info">{{ $p->pro_categoria }}</span>
                            <span style="font-size:11px; color:#666;"><i class="fas fa-clock"></i> {{ $p->pro_duracion_estimada }} días</span>
                        </div>
                        <h4 style="font-size:15px; font-weight:600; margin-bottom:6px; line-height:1.3;">{{ $p->pro_titulo_proyecto }}</h4>
                        <p style="font-size:12px; color:#888; margin-bottom:8px;"><i class="fas fa-building"></i> {{ $p->emp_nombre }}</p>
                        <p style="font-size:13px; color:#555; margin-bottom:14px; flex:1;">{{ Str::limit($p->pro_descripcion, 100) }}</p>

                        @if(in_array($p->pro_id, $postulados))
                            <span class="badge badge-success" style="padding:8px 16px; text-align:center; font-size:12px;">✅ Ya postulado</span>
                        @else
                            <form action="{{ route('aprendiz.postular', $p->pro_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                                    <i class="fas fa-paper-plane"></i> Postularme
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div style="margin-top:24px; display:flex; justify-content:center;">
            {{ $proyectos->withQueryString()->links() }}
        </div>
    @endif
@endsection
