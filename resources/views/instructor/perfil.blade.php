@extends('layouts.dashboard')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')

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
        <h2 style="font-size:22px; font-weight:700;">Mi Perfil</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Actualiza tu información personal y contraseña.</p>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 2fr; gap:24px;">
        <div class="card" style="text-align:center;">
            <div style="width:100px; height:100px; border-radius:50%; background:linear-gradient(135deg, #2980b9, #1a6090); margin:0 auto 16px; display:flex; align-items:center; justify-content:center;">
                <span style="color:#fff; font-size:36px; font-weight:700;">{{ strtoupper(substr($instructor->ins_nombre ?? 'I', 0, 1)) }}</span>
            </div>
            <h3 style="font-size:18px; font-weight:600; margin-bottom:4px;">{{ $instructor->ins_nombre ?? '' }} {{ $instructor->ins_apellido ?? '' }}</h3>
            <p style="color:#666; font-size:14px; margin-bottom:16px;">{{ $usuario->usr_correo ?? '' }}</p>
            <span class="badge badge-info" style="font-size:12px; padding:6px 14px;">
                <i class="fas fa-chalkboard-teacher" style="margin-right:6px;"></i>{{ $instructor->ins_especialidad ?? 'Sin especialidad' }}
            </span>
        </div>

        <div class="card">
            <h3 style="font-size:16px; font-weight:600; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f0f0f0;">
                <i class="fas fa-edit" style="color:#2980b9; margin-right:8px;"></i>Editar Información
            </h3>

            <form action="{{ route('instructor.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $instructor->ins_nombre ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $instructor->ins_apellido ?? '') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Especialidad</label>
                    <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $instructor->ins_especialidad ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" class="form-control" value="{{ $usuario->usr_correo ?? '' }}" disabled style="background:#f8f9fa;">
                    <small style="color:#888; font-size:12px;">El correo no se puede cambiar.</small>
                </div>

                <div style="background:#e8f0f8; padding:16px; border-radius:10px; margin-top:20px;">
                    <h4 style="font-size:14px; font-weight:600; margin-bottom:12px; color:#1a6090;">
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
