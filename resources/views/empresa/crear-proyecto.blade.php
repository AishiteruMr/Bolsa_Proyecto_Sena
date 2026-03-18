@extends('layouts.dashboard')
@section('title', 'Publicar Proyecto')
@section('page-title', 'Publicar Nuevo Proyecto')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item"><i class="fas fa-project-diagram"></i> Mis Proyectos</a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item active"><i class="fas fa-plus-circle"></i> Publicar Proyecto</a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item"><i class="fas fa-building"></i> Perfil Empresa</a>
@endsection

@section('content')
<div style="max-width:760px;">
    <div class="card">
        <h3 style="font-size:17px; font-weight:600; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f0f0f0;">
            <i class="fas fa-plus-circle" style="color:#39a900;"></i> Detalles del Proyecto
        </h3>

        <form action="{{ route('empresa.proyectos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Título del Proyecto </label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" class="form-control" placeholder="Ej: Optimización de procesos..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Categoría </label>
                    <select name="categoria" class="form-control" required>
                        <option value="">Seleccionar...</option>
                        <option value="Agrícola" {{ old('categoria') == 'Agrícola' ? 'selected' : '' }}>Agrícola</option>
                        <option value="Industrial" {{ old('categoria') == 'Industrial' ? 'selected' : '' }}>Industrial</option>
                        <option value="Tecnología" {{ old('categoria') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                        <option value="Salud" {{ old('categoria') == 'Salud' ? 'selected' : '' }}>Salud</option>
                        <option value="Educación" {{ old('categoria') == 'Educación' ? 'selected' : '' }}>Educación</option>
                        <option value="Ambiental" {{ old('categoria') == 'Ambiental' ? 'selected' : '' }}>Ambiental</option>
                        <option value="Otro" {{ old('categoria') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Descripción </label>
                <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe el proyecto..." required>{{ old('descripcion') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Requisitos Específicos </label>
                <textarea name="requisitos" class="form-control" rows="3" placeholder="Conocimientos necesarios..." required>{{ old('requisitos') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Habilidades Requeridas </label>
                <input type="text" name="habilidades" value="{{ old('habilidades') }}" class="form-control" placeholder="Ej: Trabajo en equipo, Excel..." required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Fecha de Publicación </label>
                    <input type="date" name="fecha_publi" id="fecha_publi" value="{{ old('fecha_publi', date('Y-m-d')) }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Duración Estimada </label>
                    <input type="text" id="duracion" class="form-control" readonly style="background-color:#f5f5f5;">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Fecha de Finalización Estimada</label>
                <input type="text" id="fecha_finalizacion" class="form-control" readonly style="background-color:#f5f5f5;">
            </div>

            <div class="form-group">
                <label class="form-label">Imagen del Proyecto</label>
                <input type="file" name="imagen" class="form-control" accept="image/jpg,image/jpeg,image/png">
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:8px;">
                <a href="{{ route('empresa.proyectos') }}" class="btn btn-outline">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Publicar Proyecto
                </button>
            </div>
        </form>
    </div>
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

            const opcionesFormato = { year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFinFormatted = fechaFinalizacion.toLocaleDateString('es-ES', opcionesFormato);

            duracionInput.value = duracionDias + ' días (6 meses)';
            fechaFinalizacionInput.value = fechaFinFormatted;
        }
    }

    fechaPubliInput.addEventListener('change', calcularFechas);
    calcularFechas();
});
</script>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection