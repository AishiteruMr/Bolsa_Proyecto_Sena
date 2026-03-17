@extends('layouts.dashboard')

@section('title', 'Editar Proyecto')
@section('page-title', 'Editar Proyecto')

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
        <h2 style="font-size:22px; font-weight:700;">Editar Proyecto</h2>
        <p style="color:#666; font-size:14px; margin-top:4px;">Actualiza la información del proyecto.</p>
    </div>

    <div class="card">
        <form action="{{ route('empresa.proyectos.update', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Título del Proyecto</label>
                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $proyecto->pro_titulo_proyecto) }}" required>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <input type="text" name="categoria" class="form-control" value="{{ old('categoria', $proyecto->pro_categoria) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $proyecto->pro_descripcion) }}</textarea>
            </div>

            <div class="form-group">
                <label>Requisitos Específicos</label>
                <textarea name="requisitos" class="form-control" rows="3" required>{{ old('requisitos', $proyecto->pro_requisitos_especificos) }}</textarea>
            </div>

            <div class="form-group">
                <label>Habilidades Requeridas</label>
                <input type="text" name="habilidades" class="form-control" value="{{ old('habilidades', $proyecto->pro_habilidades_requerida) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Fecha de Publicación</label>
                    <input type="date" name="fecha_publi" class="form-control" value="{{ old('fecha_publi', $proyecto->pro_fecha_publi) }}" required>
                </div>
                <div class="form-group">
                    <label>Duración Estimada (días)</label>
                    <input type="number" name="duracion" class="form-control" value="{{ old('duracion', $proyecto->pro_duracion_estimada) }}" min="1" required>
                </div>
            </div>

            <div class="form-group">
                <label>Imagen del Proyecto</label>
                @if($proyecto->pro_imagen_url)
                    <div style="margin-bottom:10px;">
                        <img src="{{ $proyecto->pro_imagen_url }}" alt="Proyecto" style="max-width:200px; border-radius:8px;">
                    </div>
                @endif
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small style="color:#888;">Deja vacío para mantener la imagen actual</small>
            </div>

            <div style="margin-top:24px; display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('empresa.proyectos') }}" class="btn btn-outline">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
