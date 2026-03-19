@extends('layouts.dashboard')

@section('title', 'Reporte de Seguimiento')
@section('page-title', 'Reporte de Seguimiento')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial', 'instructor.reporte') ? 'active' : '' }}">
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
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <a href="{{ route('instructor.historial') }}" style="text-decoration: none; color: #005a87;">← Volver</a>
            <h2 style="color: #005a87; font-weight: 600; margin-top: 10px;">📊 Reporte de Seguimiento</h2>
            <p style="color: #666; margin-top: 5px;">{{ $proyecto->pro_titulo_proyecto }}</p>
        </div>
    </div>

    <!-- Información del Proyecto -->
    <div class="card mb-4" style="border-left: 4px solid #005a87; box-shadow: 0 2px 8px rgba(0,90,135,0.1);">
        <div class="card-body">
            <h5 style="color: #005a87; font-weight: 600; margin-bottom: 15px;">📌 Información del Proyecto</h5>
            <div class="row">
                <div class="col-md-6">
                    <strong>Empresa:</strong> {{ $proyecto->emp_nombre }}<br>
                    <strong>Categoría:</strong> {{ $proyecto->pro_categoria }}<br>
                    <strong>Estado:</strong> <span class="badge" style="background-color: 
                        @if($proyecto->pro_estado === 'Activo') #28a745
                        @elseif($proyecto->pro_estado === 'Completado') #17a2b8
                        @else #6c757d
                        @endif; color: white;">{{ $proyecto->pro_estado }}</span>
                </div>
                <div class="col-md-6">
                    <strong>Publicado:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}<br>
                    <strong>Finalización:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}<br>
                    <strong>Duración:</strong> {{ $proyecto->pro_duracion_estimada }} días
                </div>
            </div>
        </div>
    </div>

    <!-- Aprendices Asignados -->
    @if($aprendices->count() > 0)
        <div class="card mb-4" style="border-left: 4px solid #28a745;">
            <div class="card-body">
                <h5 style="color: #28a745; font-weight: 600; margin-bottom: 15px;">👥 Aprendices Asignados ({{ $aprendices->count() }})</h5>
                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0;">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="color: #005a87; font-weight: 600;">Nombre</th>
                                <th style="color: #005a87; font-weight: 600;">Email</th>
                                <th style="color: #005a87; font-weight: 600;">Entregas</th>
                                <th style="color: #005a87; font-weight: 600;">Evidencias</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aprendices as $aprendiz)
                                @php
                                    $entregas_count = $entregas->where('ene_apr_id', $aprendiz->apr_id)->count();
                                    $evidencias_count = $evidencias->where('evid_apr_id', $aprendiz->apr_id)->count();
                                @endphp
                                <tr>
                                    <td>{{ $aprendiz->apr_nombre }} {{ $aprendiz->apr_apellido }}</td>
                                    <td>{{ $aprendiz->usr_correo }}</td>
                                    <td>
                                        <span class="badge" style="background-color: #007bff; color: white;">
                                            {{ $entregas_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: #6c757d; color: white;">
                                            {{ $evidencias_count }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Etapas del Proyecto -->
    @if($etapas->count() > 0)
        <div class="card mb-4" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <h5 style="color: #ffc107; font-weight: 600; margin-bottom: 15px;">📋 Etapas del Proyecto ({{ $etapas->count() }})</h5>
                <div class="accordion" id="etapasAccordion">
                    @foreach($etapas as $index => $etapa)
                        <div class="accordion-item" style="border: 1px solid #ddd; margin-bottom: 10px; border-radius: 5px;">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#etapa{{ $etapa->eta_id }}" style="background-color: #f8f9fa; color: #005a87; font-weight: 600;">
                                    Etapa {{ $etapa->eta_orden }}: {{ $etapa->eta_nombre }}
                                </button>
                            </h2>
                            <div id="etapa{{ $etapa->eta_id }}" class="accordion-collapse collapse" data-bs-parent="#etapasAccordion">
                                <div class="accordion-body" style="background-color: #fafbfc;">
                                    <p style="margin-bottom: 10px; color: #666;">{{ $etapa->eta_descripcion }}</p>
                                    
                                    @php
                                        $entregas_etapa = $entregas->where('ene_eta_id', $etapa->eta_id);
                                        $evidencias_etapa = $evidencias->where('evid_eta_id', $etapa->eta_id);
                                    @endphp

                                    @if($entregas_etapa->count() > 0)
                                        <strong style="color: #005a87; margin-top: 15px; display: block;">Entregas:</strong>
                                        @foreach($entregas_etapa as $entrega)
                                            <div style="background: white; padding: 10px; margin: 8px 0; border-radius: 4px; border-left: 3px solid #007bff;">
                                                <strong>{{ $entrega->apr_nombre }} {{ $entrega->apr_apellido }}</strong><br>
                                                <small style="color: #666;">
                                                    Estado: <span class="badge" style="background-color: 
                                        @if($entrega->ene_estado === 'Entregada') #28a745
                                        @elseif($entrega->ene_estado === 'Aprobada') #17a2b8
                                        @elseif($entrega->ene_estado === 'Rechazada') #dc3545
                                        @else #ffc107
                                        @endif; color: white;">{{ $entrega->ene_estado }}</span><br>
                                                    Fecha: {{ \Carbon\Carbon::parse($entrega->ene_fecha)->format('d/m/Y H:i') }}<br>
                                                    @if($entrega->ene_descripcion)
                                                        Descripción: {{ $entrega->ene_descripcion }}<br>
                                                    @endif
                                                    @if($entrega->ene_archivo_url)
                                                        <a href="{{ $entrega->ene_archivo_url }}" target="_blank" style="color: #005a87; text-decoration: none;">📎 Ver archivo</a>
                                                    @endif
                                                </small>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if($evidencias_etapa->count() > 0)
                                        <strong style="color: #005a87; margin-top: 15px; display: block;">Evidencias:</strong>
                                        @foreach($evidencias_etapa as $evidencia)
                                            <div style="background: white; padding: 10px; margin: 8px 0; border-radius: 4px; border-left: 3px solid #6c757d;">
                                                <strong>{{ $evidencia->apr_nombre }} {{ $evidencia->apr_apellido }}</strong><br>
                                                <small style="color: #666;">
                                                    Estado: <span class="badge" style="background-color: 
                                        @if($evidencia->evid_estado === 'Aprobada') #28a745
                                        @elseif($evidencia->evid_estado === 'Rechazada') #dc3545
                                        @else #ffc107
                                        @endif; color: white;">{{ $evidencia->evid_estado }}</span><br>
                                                    Fecha: {{ \Carbon\Carbon::parse($evidencia->evid_fecha)->format('d/m/Y H:i') }}<br>
                                                    @if($evidencia->evid_comentario)
                                                        Comentario: {{ $evidencia->evid_comentario }}<br>
                                                    @endif
                                                    <a href="{{ $evidencia->evid_archivo }}" target="_blank" style="color: #005a87; text-decoration: none;">📎 Ver archivo</a>
                                                </small>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if($entregas_etapa->count() === 0 && $evidencias_etapa->count() === 0)
                                        <p style="color: #999; font-style: italic; margin: 10px 0;">Sin entregas ni evidencias</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Resumen General -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-center" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; border: none;">
                <div class="card-body">
                    <h3 style="margin: 0; font-weight: 600;">{{ $aprendices->count() }}</h3>
                    <small>Aprendices Asignados</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white; border: none;">
                <div class="card-body">
                    <h3 style="margin: 0; font-weight: 600;">{{ $entregas->count() }}</h3>
                    <small>Entregas Totales</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none;">
                <div class="card-body">
                    <h3 style="margin: 0; font-weight: 600;">{{ $evidencias->count() }}</h3>
                    <small>Evidencias Totales</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: white; border: none;">
                <div class="card-body">
                    <h3 style="margin: 0; font-weight: 600;">{{ $etapas->count() }}</h3>
                    <small>Etapas Totales</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .accordion-button {
        font-weight: 500 !important;
    }

    .accordion-button:not(.collapsed) {
        background-color: #e8f4ff !important;
        color: #005a87 !important;
    }

    .badge {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
