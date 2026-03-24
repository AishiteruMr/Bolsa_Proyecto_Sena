@extends('layouts.dashboard')

@section('title', 'Gestión Global de Proyectos')
@section('page-title', 'Centro de Control de Proyectos')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users-cog"></i> Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Proyectos
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="font-size:28px; font-weight:800; letter-spacing: -1px;">Gestión de Proyectos</h2>
            <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Supervisa y asigna instructores a los proyectos publicados.</p>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap:24px;">
        @forelse($proyectos as $p)
        <div class="card" style="display:flex; flex-direction:column; padding:0; overflow:hidden;">
            {{-- Header con Gradiente --}}
            <div style="height:100px; background:linear-gradient(135deg, var(--secondary) 0%, #34495e 100%); position:relative; overflow:hidden; display:flex; align-items:center; padding:0 24px;">
                <div style="position:relative; z-index:1;">
                    <span class="badge" style="background:rgba(255,255,255,0.1); color:#fff; backdrop-filter:blur(4px); margin-bottom:8px; display:inline-block;">
                        {{ $p->pro_estado }}
                    </span>
                    <h3 style="color:#fff; font-size:17px; font-weight:700; line-height:1.2;">{{ Str::limit($p->pro_titulo_proyecto, 45) }}</h3>
                </div>
                <i class="fas fa-project-diagram" style="position:absolute; right:-10px; bottom:-10px; font-size:80px; color:rgba(255,255,255,0.05);"></i>
            </div>

            <div style="padding:24px; flex:1; display:flex; flex-direction:column; gap:16px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:40px; height:40px; background:var(--bg); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fas fa-building" style="color:var(--primary);"></i>
                    </div>
                    <div>
                        <span style="display:block; font-size:11px; font-weight:700; color:var(--text-light); text-transform:uppercase;">Empresa</span>
                        <span style="font-size:14px; font-weight:600;">{{ $p->emp_nombre }}</span>
                    </div>
                </div>

                <div style="padding:16px; background:var(--bg); border-radius:12px; border:1px solid var(--border);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <span style="font-size:12px; font-weight:700; color:var(--text-light); text-transform:uppercase;"><i class="fas fa-user-tag" style="margin-right:4px;"></i> Asignación</span>
                        <span style="font-size:12px; font-weight:600; color:{{ $p->ins_nombre ? 'var(--primary)' : '#e74c3c' }}">
                            {{ $p->ins_nombre ? 'Asignado' : 'Pendiente' }}
                        </span>
                    </div>

                    <form action="{{ route('admin.proyectos.asignar', $p->pro_id) }}" method="POST">
                        @csrf
                        <div style="display:flex; gap:8px;">
                            <select name="ins_usr_documento" class="form-control" style="font-size:13px; flex:1; padding: 8px 12px; background: #fff;" required>
                                <option value="" disabled selected>Elegir Instructor...</option>
                                @foreach($instructores as $ins)
                                    <option value="{{ $ins->usr_documento }}" {{ $p->ins_usr_documento == $ins->usr_documento ? 'selected' : '' }}>
                                        {{ $ins->ins_nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary" style="padding: 10px;" title="Asignar">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div style="margin-top:auto; display:flex; gap:10px;">
                    @if($p->pro_estado != 'Activo')
                    <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST" style="flex:1;">
                        @csrf
                        <input type="hidden" name="estado" value="Activo">
                        <button type="submit" class="btn btn-outline" style="width:100%; justify-content:center; font-size:12px;">Activar</button>
                    </form>
                    @endif

                    @if($p->pro_estado != 'Inactivo')
                    <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST" style="flex:1;">
                        @csrf
                        <input type="hidden" name="estado" value="Inactivo">
                        <button type="submit" class="btn btn-sm" style="width:100%; justify-content:center; background:#eee; font-size:12px;">Inactivar</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="card" style="grid-column: 1 / -1; text-align:center; padding: 60px;">
            <i class="fas fa-folder-open" style="font-size:48px; color:var(--border); margin-bottom:16px;"></i>
            <h3 style="font-size:20px; font-weight:700; color:var(--text-light);">No hay proyectos publicados aún</h3>
        </div>
        @endforelse
    </div>
@endsection