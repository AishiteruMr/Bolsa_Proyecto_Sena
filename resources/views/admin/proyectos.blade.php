@extends('layouts.dashboard')

@section('title', 'Proyectos')
@section('page-title', 'Gestión de Proyectos')

@section('sidebar-nav')
<span class="nav-label">Administración</span>
<a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-home"></i> Principal
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

        {{-- Imagen --}}
        <div style="width:60px; height:60px; border-radius:12px; overflow:hidden; flex-shrink:0; background:linear-gradient(135deg, #39a900, #2d8500); display:flex; align-items:center; justify-content:center;">
            @if($p->pro_imagen_url)
                <img src="{{ $p->pro_imagen_url }}" style="width:100%; height:100%; object-fit:cover;">
            @else
                <i class="fas fa-project-diagram" style="color:#fff; font-size:20px;"></i>
            @endif
        </div>

        {{-- Info --}}
        <div style="flex:1;">
            <h4 style="font-size:15px; font-weight:600;">{{ $p->pro_titulo_proyecto }}</h4>

            <p style="font-size:13px; color:#666;">
                <i class="fas fa-building"></i> {{ $p->emp_nombre }}
            </p>

            <p style="font-size:12px; color:#888;">
                <i class="fas fa-tag"></i> {{ $p->pro_categoria }}
            </p>

            {{-- 🔥 Instructor --}}
            <p style="font-size:12px; color:#444; margin-top:5px;">
                <strong>Instructor:</strong> {{ $p->ins_nombre ?? 'No asignado' }}
            </p>
        </div>

        {{-- Acciones --}}
        <div style="display:flex; flex-direction:column; align-items:flex-end; gap:8px;">

            {{-- Estado --}}
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

            {{-- Botones --}}
            <div style="display:flex; gap:6px;">
                @if($p->pro_estado != 'Activo')
                <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="estado" value="Activo">
                    <button type="submit" class="btn btn-sm btn-primary">Activar</button>
                </form>
                @endif

                @if($p->pro_estado != 'Inactivo')
                <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="estado" value="Inactivo">
                    <button type="submit" class="btn btn-sm btn-warning" style="color:#fff;">Inactivar</button>
                </form>
                @endif
            </div>

            {{-- 🔥 ASIGNAR INSTRUCTOR --}}
            <form action="{{ route('admin.proyectos.asignar', $p->pro_id) }}" method="POST" style="margin-top:5px;">
                @csrf

                <select name="ins_usr_documento" class="form-control" style="font-size:11px;">
                    <option value="">Seleccionar...</option>

                    @foreach($instructores as $ins)
                        <option value="{{ $ins->usr_documento }}"
                            {{ $p->ins_usr_documento == $ins->usr_documento ? 'selected' : '' }}>
                            
                            {{ $ins->ins_nombre }} ({{ $ins->usr_documento }})
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-sm btn-info" style="margin-top:4px;">
                    Asignar
                </button>
            </form>

        </div>
    </div>
    @empty
    <div style="text-align:center; padding:60px;">
        <i class="fas fa-project-diagram" style="font-size:48px; color:#ddd;"></i>
        <h4>No hay proyectos</h4>
        <p>No hay proyectos publicados aún.</p>
    </div>
    @endforelse
</div>
@endsection