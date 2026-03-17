@extends('layouts.dashboard')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')

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
        <h2 style="font-size:22px; font-weight:700;">Mi Perfil</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Actualiza tu información personal y contraseña.</p>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 2fr; gap:24px;">
        <!-- Info Card -->
        <div class="card" style="text-align:center;">
            <div style="width:100px; height:100px; border-radius:50%; background:linear-gradient(135deg, #39a900, #2d8500); margin:0 auto 16px; display:flex; align-items:center; justify-content:center;">
                <span style="color:#fff; font-size:36px; font-weight:700;">{{ strtoupper(substr($aprendiz->apr_nombre ?? 'A', 0, 1)) }}</span>
            </div>
            <h3 style="font-size:18px; font-weight:600; margin-bottom:4px;">{{ $aprendiz->apr_nombre ?? '' }} {{ $aprendiz->apr_apellido ?? '' }}</h3>
            <p style="color:#666; font-size:14px; margin-bottom:16px;">{{ $usuario->usr_correo ?? '' }}</p>
            <span class="badge badge-success" style="font-size:12px; padding:6px 14px;">
                <i class="fas fa-graduation-cap" style="margin-right:6px;"></i>{{ $aprendiz->apr_programa ?? 'Sin programa' }}
            </span>
        </div>

        <!-- Form -->
        <div class="card">
            <h3 style="font-size:16px; font-weight:600; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f0f0f0;">
                <i class="fas fa-edit" style="color:#39a900; margin-right:8px;"></i>Editar Información
            </h3>

            <form action="{{ route('aprendiz.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $aprendiz->apr_nombre ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $aprendiz->apr_apellido ?? '') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Programa de Formación</label>
                    <input type="text" name="programa" class="form-control" value="{{ old('programa', $aprendiz->apr_programa ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" class="form-control" value="{{ $usuario->usr_correo ?? '' }}" disabled style="background:#f8f9fa;">
                    <small style="color:#888; font-size:12px;">El correo no se puede cambiar.</small>
                </div>

                <div style="background:#f8fff4; padding:16px; border-radius:10px; margin-top:20px;">
                    <h4 style="font-size:14px; font-weight:600; margin-bottom:12px; color:#1a5c00;">
                        <i class="fas fa-lock" style="margin-right:8px;"></i>Cambiar Contraseña
                    </h4>
                    <div class="form-group" style="margin-bottom:12px;">
                        <label>Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres">
                    </div>
                </div>

                <div style="margin-top:24px; display:flex; gap:12px; justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .pagination { display:flex; gap:6px; }
    .pagination a, .pagination span { padding:8px 14px; border-radius:8px; font-size:13px; }
    .pagination a { background:#fff; color:#2c3e50; border:1px solid #e8edf0; }
    .pagination a:hover { background:#39a900; color:#fff; border-color:#39a900; }
    .pagination span { background:#39a900; color:#fff; }
</style>
@endsection
