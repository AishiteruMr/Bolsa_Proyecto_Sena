@extends('layouts.dashboard')

@section('title', 'Mis Postulaciones')
@section('page-title', 'Mis Postulaciones')

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
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">Mis Postulaciones</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Aquí puedes ver el estado de tus postulaciones a proyectos.</p>
    </div>

    <div class="card">
        @forelse($postulaciones as $post)
            <div style="display:flex; align-items:center; gap:20px; padding:20px; border-bottom:1px solid #f0f0f0; transition:background .2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                <div style="width:60px; height:60px; border-radius:12px; overflow:hidden; flex-shrink:0; background:linear-gradient(135deg, #39a900, #2d8500); display:flex; align-items:center; justify-content:center;">
                    @if($post->pro_imagen_url)
                        <img src="{{ $post->pro_imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <i class="fas fa-briefcase" style="color:#fff; font-size:20px;"></i>
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <h4 style="font-size:15px; font-weight:600; margin-bottom:4px;">{{ $post->pro_titulo_proyecto }}</h4>
                    <p style="font-size:13px; color:#666; margin-bottom:6px;">
                        <i class="fas fa-building" style="color:#39a900; margin-right:6px;"></i>{{ $post->emp_nombre }}
                        <span style="margin:0 8px;">|</span>
                        <i class="fas fa-tag" style="color:#666; margin-right:6px;"></i>{{ $post->pro_categoria }}
                    </p>
                    <p style="font-size:12px; color:#888;">
                        <i class="fas fa-calendar-alt" style="margin-right:6px;"></i>Postulado: {{ \Carbon\Carbon::parse($post->pos_fecha)->format('d/m/Y') }}
                    </p>
                </div>
                <div style="flex-shrink:0;">
                    @switch($post->pos_estado)
                        @case('Pendiente')
                            <span class="badge badge-warning">
                                <i class="fas fa-clock" style="margin-right:4px;"></i>Pendiente
                            </span>
                            @break
                        @case('Aprobada')
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle" style="margin-right:4px;"></i>Aprobada
                            </span>
                            @break
                        @case('Rechazada')
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle" style="margin-right:4px;"></i>Rechazada
                            </span>
                            @break
                        @default
                            <span class="badge badge-info">{{ $post->pos_estado }}</span>
                    @endswitch
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:60px 20px;">
                <i class="fas fa-paper-plane" style="font-size:48px; color:#ddd; margin-bottom:16px;"></i>
                <h4 style="color:#666; margin-bottom:8px;">No tienes postulaciones</h4>
                <p style="color:#999; font-size:14px; margin-bottom:20px;">Explora proyectos y postula a los que te interesen</p>
                <a href="{{ route('aprendiz.proyectos') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Explorar Proyectos
                </a>
            </div>
        @endforelse
    </div>

    @if($postulaciones->hasPages())
        <div style="margin-top:24px; display:flex; justify-content:center;">
            {{ $postulaciones->links() }}
        </div>
    @endif
@endsection
