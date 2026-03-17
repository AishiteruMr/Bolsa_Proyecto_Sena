@extends('layouts.dashboard')
@section('title', 'Publicar Proyecto')
@section('content')
<div class="container">
    <h2>Publicar Nuevo Proyecto</h2>
    <p>Completa los campos para crear un nuevo proyecto o práctica.</p>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('empresa.publicar.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="box">
            <h3>Detalles Básicos del Proyecto</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="titulo">Título del Proyecto *</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoría *</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccionar...</option>
                        <option value="Agrícola">Agrícola</option>
                        <option value="Industrial">Industrial</option>
                        <option value="Tecnología">Tecnología</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción del Proyecto *</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
        </div>
        <div class="box">
            <h3>Requisitos y Habilidades</h3>
            <div class="form-group">
                <label>Requisitos Específicos</label>
                <textarea name="requisitos" rows="2"></textarea>
            </div>
            <label>Habilidades Requeridas</label>
            <input type="text" name="habilidades" placeholder="Agregar etiqueta">
        </div>
        <div class="box">
            <h3>Fechas Clave</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_publicacion">Fecha de Publicación *</label>
                    <input type="date" id="fecha_publicacion" name="fecha_publicacion" required>
                </div>
                <div class="form-group">
                    <label for="duracion">Duración Estimada (días) *</label>
                    <input type="number" id="duracion" name="duracion" required>
                </div>
            </div>
        </div>
        <div class="actions">
            <a href="{{ route('empresa.principal') }}" class="btn cancel">Cancelar</a>
            <button type="submit" class="btn submit">Publicar Proyecto</button>
        </div>
    </form>
</div>
@endsection