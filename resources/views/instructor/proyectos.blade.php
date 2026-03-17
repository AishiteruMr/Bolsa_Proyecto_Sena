@extends('layouts.dashboard')

@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.aprendices') }}" class="nav-item {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">Mis Proyectos</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Proyectos en los que estás participando como instructor.</p>
    </div>

    <div class="card">
        @forelse($proyectos as $p)
            <div style="display:flex; align-items:center; gap:20px; padding:20px; border-bottom:1px solid #f0f0f0; transition:background .2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                <div style="width:60px; height:60px; border-radius:12px; overflow:hidden; flex-shrink:0; background:linear-gradient(135deg, #2980b9, #1a6090); display:flex; align-items:center; justify-content:center;">
                    @if($p->pro_imagen_url)
                        <img src="{{ $p->pro_imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <i class="fas fa-project-diagram" style="color:#fff; font-size:20px;"></i>
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <h4 style="font-size:15px; font-weight:600; margin-bottom:4px;">{{ $p->pro_titulo_proyecto }}</h4>
                    <p style="font-size:13px; color:#666; margin-bottom:6px;">
                        <i class="fas fa-building" style="color:#2980b9; margin-right:6px;"></i>{{ $p->emp_nombre }}
                    </p>
                    <p style="font-size:12px; color:#888;">
                        <i class="fas fa-tag" style="margin-right:6px;"></i>{{ $p->pro_categoria }}
                        <span style="margin:0 8px;">|</span>
                        <i class="fas fa-calendar" style="margin-right:6px;"></i>{{ $p->pro_fecha_inicio ? \Carbon\Carbon::parse($p->pro_fecha_inicio)->format('d/m/Y') : 'Sin fecha' }}
                    </p>
                </div>
                <div style="flex-shrink:0; text-align:right;">
                    @switch($p->pro_estado)
                        @case('Activo')
                            <span class="badge badge-success">Activo</span>
                            @break
                        @case('Inactivo')
                            <span class="badge badge-warning">Inactivo</span>
                            @break
                        @case('Aprobado')
                            <span class="badge badge-success">Aprobado</span>
                            @break
                        @case('Rechazado')
                            <span class="badge badge-danger">Rechazado</span>
                            @break
                        @default
                            <span class="badge badge-info">{{ $p->pro_estado }}</span>
                    @endswitch
                    <div style="margin-top:8px;">
                        <span style="font-size:12px; color:#666;">
                            <i class="fas fa-users" style="margin-right:4px;"></i>{{ $p->pro_num_postulantes ?? 0 }} postulantes
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:60px 20px;">
                <i class="fas fa-project-diagram" style="font-size:48px; color:#ddd; margin-bottom:16px;"></i>
                <h4 style="color:#666; margin-bottom:8px;">No hay proyectos asignados</h4>
                <p style="color:#999; font-size:14px;">No tienes proyectos como instructor aún.</p>
            </div>
        @endforelse
    </div>
@endsection
