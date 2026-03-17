@extends('layouts.dashboard')

@section('title', 'Postulantes')
@section('page-title', 'Postulantes del Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <a href="{{ route('empresa.proyectos') }}" style="color:#666; font-size:13px; display:inline-flex; align-items:center; gap:6px; margin-bottom:8px;">
            <i class="fas fa-arrow-left"></i> Volver a proyectos
        </a>
        <h2 style="font-size:22px; font-weight:700;">{{ $proyecto->pro_titulo_proyecto }}</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Postulantes al proyecto</p>
    </div>

    <div class="card">
        @forelse($postulantes as $p)
            <div style="display:flex; align-items:center; gap:20px; padding:20px; border-bottom:1px solid #f0f0f0; transition:background .2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                <div style="width:50px; height:50px; border-radius:50%; background:linear-gradient(135deg, #39a900, #2d8500); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <span style="color:#fff; font-size:18px; font-weight:700;">{{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}</span>
                </div>
                <div style="flex:1; min-width:0;">
                    <h4 style="font-size:15px; font-weight:600; margin-bottom:4px;">{{ $p->apr_nombre ?? '' }} {{ $p->apr_apellido ?? '' }}</h4>
                    <p style="font-size:13px; color:#666; margin-bottom:4px;">
                        <i class="fas fa-graduation-cap" style="color:#39a900; margin-right:6px;"></i>{{ $p->apr_programa ?? 'Sin programa' }}
                    </p>
                    <p style="font-size:12px; color:#888;">
                        <i class="fas fa-envelope" style="margin-right:6px;"></i>{{ $p->usr_correo ?? 'Sin correo' }}
                    </p>
                </div>
                <div style="flex-shrink:0; display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
                    @switch($p->pos_estado)
                        @case('Pendiente')
                            <span class="badge badge-warning">{{ $p->pos_estado }}</span>
                            @break
                        @case('Aprobada')
                            <span class="badge badge-success">{{ $p->pos_estado }}</span>
                            @break
                        @case('Rechazada')
                            <span class="badge badge-danger">{{ $p->pos_estado }}</span>
                            @break
                        @default
                            <span class="badge badge-info">{{ $p->pos_estado }}</span>
                    @endswitch
                    <p style="font-size:11px; color:#888;">
                        <i class="fas fa-calendar" style="margin-right:4px;"></i>{{ \Carbon\Carbon::parse($p->pos_fecha)->format('d/m/Y') }}
                    </p>
                    <div style="display:flex; gap:6px;">
                        <form action="{{ route('empresa.postulaciones.estado', $p->pos_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="estado" value="Aprobada">
                            <button type="submit" class="btn btn-sm btn-primary">Aprobar</button>
                        </form>
                        <form action="{{ route('empresa.postulaciones.estado', $p->pos_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="estado" value="Rechazada">
                            <button type="submit" class="btn btn-sm btn-danger">Rechazar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:60px 20px;">
                <i class="fas fa-users" style="font-size:48px; color:#ddd; margin-bottom:16px;"></i>
                <h4 style="color:#666; margin-bottom:8px;">No hay postulantes</h4>
                <p style="color:#999; font-size:14px;">Aún no hay aprendices postulados a este proyecto.</p>
            </div>
        @endforelse
    </div>
@endsection
