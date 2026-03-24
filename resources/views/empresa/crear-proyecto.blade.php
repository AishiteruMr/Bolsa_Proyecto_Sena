@extends('layouts.dashboard')
@section('title', 'Publicar Proyecto')
@section('page-title', 'Publicar Proyecto')

@section('sidebar-nav')
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
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 32px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
            <a href="{{ route('empresa.proyectos') }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 500;">
                <i class="fas fa-arrow-left"></i> Volver a mis proyectos
            </a>
        </div>
        <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">Publicar Nueva Convocatoria</h2>
        <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Define los requerimientos de tu proyecto para atraer al mejor talento SENA.</p>
    </div>

    <form action="{{ route('empresa.proyectos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="glass-card" style="padding: 2.5rem; display: grid; gap: 2rem;">
            
            <section>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-info-circle" style="color: var(--primary);"></i> Información General
                </h3>
                
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 8px; display: block;">Título del Proyecto *</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" required class="form-control" placeholder="Ej: Rediseño de Plataforma E-commerce" style="padding: 12px; border-radius: 8px;">
                    </div>
                    <div class="form-group">
                        <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 8px; display: block;">Categoría *</label>
                        <select name="categoria" required class="form-control" style="padding: 12px; border-radius: 8px; height: 46px;">
                            <option value="">Seleccionar...</option>
                            <option value="Tecnología">Tecnología</option>
                            <option value="Agrícola">Agrícola</option>
                            <option value="Industrial">Industrial</option>
                            <option value="Salud">Salud</option>
                            <option value="Ambiental">Ambiental</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
            </section>

            <section>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-align-left" style="color: var(--primary);"></i> Alcance y Requisitos
                </h3>
                
                <div class="form-group">
                    <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 8px; display: block;">Descripción Detallada *</label>
                    <textarea name="descripcion" required class="form-control" rows="5" placeholder="Explica el objetivo y metas del proyecto..." style="padding: 12px; border-radius: 8px;">{{ old('descripcion') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
                    <div class="form-group">
                        <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 8px; display: block;">Requisitos Específicos *</label>
                        <textarea name="requisitos" required class="form-control" rows="3" placeholder="Herramientas, tecnologías o conocimientos previos..." style="padding: 12px; border-radius: 8px;">{{ old('requisitos') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 8px; display: block;">Habilidades Blandas *</label>
                        <textarea name="habilidades" required class="form-control" rows="3" placeholder="Ej: Comunicación asertiva, Trabajo bajo presión..." style="padding: 12px; border-radius: 8px;">{{ old('habilidades') }}</textarea>
                    </div>
                </div>
            </section>

            <section>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-calendar-alt" style="color: var(--primary);"></i> Cronograma Estimado
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; background: var(--bg-main); padding: 1.5rem; border-radius: 12px; border: 1px dashed var(--border);">
                    <div class="form-group">
                        <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Apertura *</label>
                        <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', date('Y-m-d')) }}" required class="form-control" style="border: 1px solid var(--border);">
                    </div>
                    <div class="form-group">
                        <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Duración</label>
                        <input type="text" id="duracion" readonly class="form-control" style="background: white; border: 1px solid var(--border); font-weight: 600; color: var(--primary);">
                    </div>
                    <div class="form-group">
                        <label style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Cierre Estimado</label>
                        <input type="text" id="fecha_finalizacion" readonly class="form-control" style="background: white; border: 1px solid var(--border); font-weight: 600;">
                    </div>
                </div>
            </section>

            <section>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-image" style="color: var(--primary);"></i> Media del Proyecto
                </h3>
                <div style="border: 2px dashed var(--border); border-radius: 12px; padding: 2rem; text-align: center; background: var(--bg-main); position: relative; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
                    <p style="font-size: 0.9rem; color: var(--text-main); font-weight: 600;">Haz clic o arrastra una imagen aquí</p>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">Formatos soportados: JPG, PNG (Max 2MB)</p>
                    <input type="file" name="imagen" class="form-control" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                </div>
            </section>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border);">
                <a href="{{ route('empresa.proyectos') }}" class="btn-ver" style="background: #64748b; padding: 0.8rem 2rem; border-radius: 8px;">
                    Cancelar
                </a>
                <button type="submit" class="btn-ver" style="padding: 0.8rem 2.5rem; border-radius: 8px;">
                    <i class="fas fa-paper-plane" style="margin-right: 10px;"></i> Publicar Convocatoria
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fechaPubliInput = document.getElementById('fecha_publi');
    const duracionInput = document.getElementById('duracion');
    const fechaFinalizacionInput = document.getElementById('fecha_finalizacion');

    function calcularFechas() {
        const fechaPubli = new Date(fechaPubliInput.value);
        if (!isNaN(fechaPubli.getTime())) {
            const fechaFinalizacion = new Date(fechaPubli);
            fechaFinalizacion.setMonth(fechaFinalizacion.getMonth() + 6);
            const duracionDias = Math.ceil((fechaFinalizacion - fechaPubli) / (1000 * 60 * 60 * 24));
            const opcionesFormato = { year: 'numeric', month: 'short', day: 'numeric' };
            duracionInput.value = duracionDias + ' días (6 meses)';
            fechaFinalizacionInput.value = fechaFinalizacion.toLocaleDateString('es-ES', opcionesFormato);
        }
    }
    fechaPubliInput.addEventListener('change', calcularFechas);
    calcularFechas();
});
</script>
@endsection
style>
@endsection