@extends('layouts.dashboard')
@section('title', 'Panel Empresa')
@section('content')
<div class="welcome">
    <h1>¡Bienvenido de nuevo, {{ $empresa->emp_representante }} 👋</h1>
    <p>Panel empresarial - Inspírate SENA</p>
</div>

<main class="cards-container">
    @forelse($proyectos as $proyecto)
        <div class="card">
            <div class="card-header"><h4>{{ $empresa->emp_nombre }}</h4></div>
            <h3>{{ $proyecto->pro_titulo_proyecto }}</h3>
            <img src="{{ $proyecto->pro_imagen_url ?: '' }}" alt="">
            <p>{{ $proyecto->pro_descripcion }}</p>
            <p class="fecha">Publicado el: {{ $proyecto->pro_fecha_publi }}</p>
            <div class="tags">
                <span class="tag">{{ $proyecto->pro_categoria }}</span>
            </div>
            <a href="{{ route('empresa.detalle', ['id' => $proyecto->pro_id]) }}" class="RevProyecto">Revisar Proyecto</a>
        </div>
    @empty
        <p>No tienes proyectos publicados todavía.</p>
    @endforelse
</main>
<div class="add-project">
    <button onclick="window.location.href='{{ route('empresa.publicar') }}'">Agregar nuevo proyecto</button>
</div>
@endsection