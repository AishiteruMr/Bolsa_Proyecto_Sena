@extends('layouts.dashboard')

@section('title', 'Aprendices')
@section('page-title', 'Mis Aprendices')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('instructor.aprendices') }}" class="nav-item {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Perfil
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:22px; font-weight:700;">Aprendices en Proyectos</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Aprendices que están participando en tus proyectos asignados.</p>
    </div>

    <div class="card">
        @forelse($aprendices as $a)
            <div style="display:flex; align-items:center; gap:20px; padding:20px; border-bottom:1px solid #f0f0f0; transition:background .2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                <div style="width:50px; height:50px; border-radius:50%; background:linear-gradient(135deg, #39a900, #2d8500); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <span style="color:#fff; font-size:18px; font-weight:700;">{{ strtoupper(substr($a->apr_nombre ?? 'A', 0, 1)) }}</span>
                </div>
                <div style="flex:1; min-width:0;">
                    <h4 style="font-size:15px; font-weight:600; margin-bottom:4px;">{{ $a->apr_nombre ?? '' }} {{ $a->apr_apellido ?? '' }}</h4>
                    <p style="font-size:13px; color:#666; margin-bottom:4px;">
                        <i class="fas fa-graduation-cap" style="color:#39a900; margin-right:6px;"></i>{{ $a->apr_programa ?? 'Sin programa' }}
                    </p>
                    <p style="font-size:12px; color:#888;">
                        <i class="fas fa-envelope" style="margin-right:6px;"></i>{{ $a->usr_correo ?? 'Sin correo' }}
                    </p>
                </div>
                <div style="flex-shrink:0; text-align:right;">
                    <span class="badge badge-success" style="margin-bottom:6px;">
                        <i class="fas fa-check-circle" style="margin-right:4px;"></i>Aprobado
                    </span>
                    <p style="font-size:11px; color:#888;">
                        <i class="fas fa-briefcase" style="margin-right:4px;"></i>{{ $a->pro_titulo_proyecto ?? 'Sin proyecto' }}
                    </p>
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:60px 20px;">
                <i class="fas fa-users" style="font-size:48px; color:#ddd; margin-bottom:16px;"></i>
                <h4 style="color:#666; margin-bottom:8px;">No hay aprendices</h4>
                <p style="color:#999; font-size:14px;">No hay aprendices aprobados en tus proyectos aún.</p>
            </div>
        @endforelse
    </div>
@endsection
