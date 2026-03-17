@extends('layouts.dashboard')

@section('title', 'Proyectos')
@section('page-title', 'Gestión de Proyectos')

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Proyectos
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">Gestión de Proyectos</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Administra todos los proyectos del sistema.</p>
    </div>

    <div class="card">
        @forelse($proyectos as $p)
            <div style="display:flex; align-items:center; gap:20px; padding:20px; border-bottom:1px solid #f0f0f0; transition:background .2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                <div style="width:60px; height:60px; border-radius:12px; overflow:hidden; flex-shrink:0; background:linear-gradient(135deg, #39a900, #2d8500); display:flex; align-items:center; justify-content:center;">
                    @if($p->pro_imagen_url)
                        <img src="{{ $p->pro_imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <i class="fas fa-project-diagram" style="color:#fff; font-size:20px;"></i>
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <h4 style="font-size:15px; font-weight:600; margin-bottom:4px;">{{ $p->pro_titulo_proyecto }}</h4>
                    <p style="font-size:13px; color:#666; margin-bottom:4px;">
                        <i class="fas fa-building" style="color:#39a900; margin-right:6px;"></i>{{ $p->emp_nombre }}
                    </p>
                    <p style="font-size:12px; color:#888;">
                        <i class="fas fa-tag" style="margin-right:6px;"></i>{{ $p->pro_categoria }}
                    </p>
                </div>
                <div style="flex-shrink:0; display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
                    @switch($p->pro_estado)
                        @case('Activo')
                            <span class="badge badge-success">{{ $p->pro_estado }}</span>
                            @break
                        @case('Inactivo')
                            <span class="badge badge-warning">{{ $p->pro_estado }}</span>
                            @break
                        @case('Aprobado')
                            <span class="badge badge-success">{{ $p->pro_estado }}</span>
                            @break
                        @case('Rechazado')
                            <span class="badge badge-danger">{{ $p->pro_estado }}</span>
                            @break
                        @default
                            <span class="badge badge-info">{{ $p->pro_estado }}</span>
                    @endswitch
                    <div style="display:flex; gap:6px;">
                        <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="estado" value="Activo">
                            <button type="submit" class="btn btn-sm btn-primary" {{ $p->pro_estado == 'Activo' ? 'disabled' : '' }}>Activar</button>
                        </form>
                        <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="estado" value="Inactivo">
                            <button type="submit" class="btn btn-sm btn-warning" {{ $p->pro_estado == 'Inactivo' ? 'disabled' : '' }} style="color:#fff;">Inactivar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:60px 20px;">
                <i class="fas fa-project-diagram" style="font-size:48px; color:#ddd; margin-bottom:16px;"></i>
                <h4 style="color:#666; margin-bottom:8px;">No hay proyectos</h4>
                <p style="color:#999; font-size:14px;">No hay proyectos publicados aún.</p>
            </div>
        @endforelse
    </div>
@endsection
