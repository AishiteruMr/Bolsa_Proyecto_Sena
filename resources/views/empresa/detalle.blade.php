@extends('layouts.dashboard')
@section('title', 'Mis Proyectos - ' . $empresa->emp_nombre)
@section('content')
<div class="container">
    <div class="project-content">
        <img src="{{ $proyecto->pro_imagen_url ?: asset('assets/proyecto_default.jpg') }}" alt="Proyecto">
    </div>
    <h1>{{ $proyecto->pro_titulo_proyecto }}</h1>
    <div class="content">
        <div class="info">
            <p>{!! nl2br(e($proyecto->pro_descripcion)) !!}</p>
            <div class="tags"><span class="tag">{{ $proyecto->pro_categoria }}</span></div>
            <div class="publicado-por">
                <p><strong>Publicado Por:</strong> {{ $proyecto->emp_nombre }} | El {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}</p>
            </div>
            <hr class="separator">
            <div class="datos-generales">
                <div class="dato-item"><span class="etiqueta">Estado</span><span class="valor">{{ $proyecto->pro_estado }}</span></div>
                <div class="dato-item"><span class="etiqueta">Duración Estimada</span><span class="valor">{{ $proyecto->pro_duracion_estimada }}</span></div>
                <div class="dato-item"><span class="etiqueta">Requisitos</span><span class="valor">{{ $proyecto->pro_requisitos_especificos }}</span></div>
                <div class="dato-item">
                    <span class="etiqueta">Instructor Asignado</span>
                    <span class="valor">
                        @if($proyecto->ins_nombre)
                            {{ $proyecto->ins_nombre }} {{ $proyecto->ins_apellido }}
                        @else
                            No Asignado
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="seguimiento-card">
        <h2 class="titulo-finalizacion">Finalización del Proyecto</h2>
        <div class="progreso-circulo"><div class="circle">3%</div></div>
        <h2 class="etapas-titulo">Etapas Del Proyecto</h2>
        <div class="etapas-lista">
            @forelse($etapas as $etapa)
                <div class="etapa-item">
                    <span class="icono-etapa">💡</span>
                    <p>{{ $etapa->eta_nombre }}</p>
                    <p>{{ $etapa->eta_descripcion }}</p>
                </div>
            @empty
                <p class="no-etapas">Aún no se han agregado etapas a este proyecto.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection