@extends('layouts.dashboard')

@section('title', 'Perfil Empresa')
@section('page-title', 'Mi Perfil')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
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
        <h2 style="font-size:22px; font-weight:700;">Perfil de la Empresa</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Actualiza la información de tu empresa.</p>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 2fr; gap:24px;">
        <div class="card" style="text-align:center;">
            <div style="width:100px; height:100px; border-radius:50%; background:linear-gradient(135deg, #8e44ad, #6c3483); margin:0 auto 16px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-building" style="color:#fff; font-size:36px;"></i>
            </div>
            <h3 style="font-size:18px; font-weight:600; margin-bottom:4px;">{{ $empresa->emp_nombre ?? '' }}</h3>
            <p style="color:#666; font-size:14px; margin-bottom:8px;">{{ $empresa->emp_correo ?? '' }}</p>
            <span class="badge badge-success" style="font-size:12px; padding:6px 14px;">
                <i class="fas fa-check-circle" style="margin-right:6px;"></i>Empresa Verificada
            </span>
            <div style="margin-top:20px; text-align:left; background:#f8f9fa; padding:16px; border-radius:10px;">
                <p style="font-size:13px; color:#666; margin-bottom:8px;">
                    <i class="fas fa-id-card" style="margin-right:8px; color:#8e44ad;"></i>
                    <strong>NIT:</strong> {{ $empresa->emp_nit ?? '' }}
                </p>
                <p style="font-size:13px; color:#666;">
                    <i class="fas fa-user-tie" style="margin-right:8px; color:#8e44ad;"></i>
                    <strong>Representante:</strong> {{ $empresa->emp_representante ?? '' }}
                </p>
            </div>
        </div>

        <div class="card">
            <h3 style="font-size:16px; font-weight:600; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f0f0f0;">
                <i class="fas fa-edit" style="color:#8e44ad; margin-right:8px;"></i>Editar Información
            </h3>

            <form action="{{ route('empresa.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nombre de la Empresa</label>
                    <input type="text" name="nombre_empresa" class="form-control" value="{{ old('nombre_empresa', $empresa->emp_nombre ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Representante Legal</label>
                    <input type="text" name="representante" class="form-control" value="{{ old('representante', $empresa->emp_representante ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" class="form-control" value="{{ $empresa->emp_correo ?? '' }}" disabled style="background:#f8f9fa;">
                    <small style="color:#888; font-size:12px;">El correo no se puede cambiar.</small>
                </div>

                <div class="form-group">
                    <label>NIT</label>
                    <input type="text" class="form-control" value="{{ $empresa->emp_nit ?? '' }}" disabled style="background:#f8f9fa;">
                    <small style="color:#888; font-size:12px;">El NIT no se puede cambiar.</small>
                </div>

                <div style="background:#f5eef8; padding:16px; border-radius:10px; margin-top:20px;">
                    <h4 style="font-size:14px; font-weight:600; margin-bottom:12px; color:#6c3483;">
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
