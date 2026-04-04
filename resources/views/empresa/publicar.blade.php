@extends('layouts.dashboard')
@section('title', 'Publicar Proyecto')
@section('page-title', 'Publicar Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
@endsection

@section('content')
<div class="animate-fade-in" style="max-width: 900px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero" style="margin-bottom: 32px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-paper-plane"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Nueva Convocatoria</span>
            </div>
            <h1 class="instructor-title">Publicar <span style="color: var(--primary);">Proyecto</span></h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 15px; font-weight: 500;">Completa los campos para crear un nuevo proyecto.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="glass-card" style="padding: 20px; margin-bottom: 24px; background: #f0fdf4; border-color: #bbf7d0;">
            <p style="color: #16a34a; font-weight: 700; margin: 0;"><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('empresa.publicar.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="glass-card" style="padding: 32px;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid rgba(62,180,137,0.1);">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Detalles del Proyecto</h3>
                    <p style="font-size: 13px; color: var(--text-light); font-weight: 500; margin-top: 2px;">Completa todos los campos.</p>
                </div>
            </div>

            <div style="display: grid; gap: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Título del Proyecto *</label>
                        <input type="text" name="titulo" required style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Categoría *</label>
                        <select name="categoria" required style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                            <option value="">Seleccionar...</option>
                            <option value="Agrícola">Agrícola</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Tecnología">Tecnología</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Descripción *</label>
                    <textarea name="descripcion" rows="4" required style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Requisitos</label>
                        <textarea name="requisitos" rows="3" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;"></textarea>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Habilidades</label>
                        <textarea name="habilidades" rows="3" style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 500; outline: none; resize: vertical;"></textarea>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Fecha de Publicación *</label>
                        <input type="date" name="fecha_publicacion" required style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Duración (días) *</label>
                        <input type="number" name="duracion" required style="width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 16px; justify-content: flex-end; margin-top: 28px; padding-top: 24px; border-top: 1px solid #f1f5f9;">
                <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 14px 28px;">
                    Cancelar
                </a>
                <button type="submit" class="btn-premium" style="padding: 14px 32px;">
                    <i class="fas fa-paper-plane"></i> Publicar Proyecto
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
