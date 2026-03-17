@extends('layouts.dashboard')

@section('title', 'Mis Entregas')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 style="color: #005a87; font-weight: 600;">📤 Mis Entregas y Evidencias</h2>
            <p style="color: #666; margin-top: 5px;">Seguimiento de tus entregas en proyectos aprobados</p>
        </div>
    </div>

    @if($proyectos->count() > 0)
        @foreach($proyectos as $proyecto)
            <div class="card mb-4" style="border-left: 4px solid #005a87; box-shadow: 0 2px 8px rgba(0,90,135,0.1);">
                <div class="card-body">
                    <h5 style="color: #005a87; font-weight: 600; margin-bottom: 15px;">📌 {{ $proyecto->pro_titulo_proyecto }}</h5>
                    
                    <p style="color: #666; margin-bottom: 15px;">
                        <strong>Empresa:</strong> {{ $proyecto->emp_nombre }}<br>
                        <strong>Categoría:</strong> {{ $proyecto->pro_categoria }}<br>
                        <strong>Finalización:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}
                    </p>

                    @php
                        $entregas_proyecto = $entregas->where('pro_id', $proyecto->pro_id);
                        $evidencias_proyecto = $evidencias->where('pro_id', $proyecto->pro_id);
                    @endphp

                    <ul class="nav nav-tabs mb-3" style="border-bottom: 2px solid #e9ecef;">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#entregas{{ $proyecto->pro_id }}" style="color: #005a87; font-weight: 500;">
                                📦 Entregas ({{ $entregas_proyecto->count() }})
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#evidencias{{ $proyecto->pro_id }}" style="color: #005a87; font-weight: 500;">
                                ✓ Evidencias ({{ $evidencias_proyecto->count() }})
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB ENTREGAS -->
                        <div class="tab-pane fade show active" id="entregas{{ $proyecto->pro_id }}">
                            @if($entregas_proyecto->count() > 0)
                                <div style="display: grid; gap: 12px;">
                                    @foreach($entregas_proyecto as $entrega)
                                        <div style="background: #f8f9fa; padding: 12px; border-radius: 5px; border-left: 3px solid #007bff;">
                                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                                <strong style="color: #005a87;">{{ $entrega->eta_nombre }}</strong>
                                                <span class="badge" style="background-color: 
                                                    @if($entrega->ene_estado === 'Entregada') #28a745
                                                    @elseif($entrega->ene_estado === 'Aprobada') #17a2b8
                                                    @elseif($entrega->ene_estado === 'Rechazada') #dc3545
                                                    @else #ffc107
                                                    @endif; color: white;">
                                                    {{ $entrega->ene_estado }}
                                                </span>
                                            </div>
                                            <small style="color: #666; display: block; margin-bottom: 8px;">
                                                <strong>Etapa {{ $entrega->eta_orden }}</strong> - 
                                                {{ \Carbon\Carbon::parse($entrega->ene_fecha)->format('d/m/Y H:i') }}
                                            </small>
                                            @if($entrega->ene_descripcion)
                                                <p style="color: #666; margin: 8px 0; font-size: 14px;">{{ $entrega->ene_descripcion }}</p>
                                            @endif
                                            @if($entrega->ene_archivo_url)
                                                <a href="{{ $entrega->ene_archivo_url }}" target="_blank" class="btn btn-sm" style="background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; padding: 4px 8px;">
                                                    📎 Ver Archivo
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color: #999; text-align: center; padding: 20px;">Sin entregas registradas</p>
                            @endif
                        </div>

                        <!-- TAB EVIDENCIAS -->
                        <div class="tab-pane fade" id="evidencias{{ $proyecto->pro_id }}">
                            @if($evidencias_proyecto->count() > 0)
                                <div style="display: grid; gap: 12px;">
                                    @foreach($evidencias_proyecto as $evidencia)
                                        <div style="background: #f8f9fa; padding: 12px; border-radius: 5px; border-left: 3px solid #6c757d;">
                                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                                <strong style="color: #005a87;">{{ $evidencia->eta_nombre }}</strong>
                                                <span class="badge" style="background-color: 
                                                    @if($evidencia->evid_estado === 'Aprobada') #28a745
                                                    @elseif($evidencia->evid_estado === 'Rechazada') #dc3545
                                                    @else #ffc107
                                                    @endif; color: white;">
                                                    {{ $evidencia->evid_estado }}
                                                </span>
                                            </div>
                                            <small style="color: #666; display: block; margin-bottom: 8px;">
                                                <strong>Etapa {{ $evidencia->eta_orden }}</strong> - 
                                                {{ \Carbon\Carbon::parse($evidencia->evid_fecha)->format('d/m/Y H:i') }}
                                            </small>
                                            @if($evidencia->evid_comentario)
                                                <p style="color: #666; margin: 8px 0; font-size: 14px;">
                                                    <strong>Comentario:</strong> {{ $evidencia->evid_comentario }}
                                                </p>
                                            @endif
                                            <a href="{{ $evidencia->evid_archivo }}" target="_blank" class="btn btn-sm" style="background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; padding: 4px 8px;">
                                                📎 Ver Archivo
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color: #999; text-align: center; padding: 20px;">Sin evidencias registradas</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div style="text-align: center; padding: 60px 20px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #999; font-size: 16px; margin: 0;">
                📭 No tienes proyectos aprobados aún
            </p>
        </div>
    @endif

    <!-- Resumen General -->
    @if($proyectos->count() > 0)
        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card text-center" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; border: none;">
                    <div class="card-body">
                        <h3 style="margin: 0; font-weight: 600;">{{ $entregas->count() }}</h3>
                        <small>Entregas Totales</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white; border: none;">
                    <div class="card-body">
                        <h3 style="margin: 0; font-weight: 600;">{{ $entregas->where('ene_estado', 'Aprobada')->count() }}</h3>
                        <small>Entregas Aprobadas</small>
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
                <div class="card text-center" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white; border: none;">
                    <div class="card-body">
                        <h3 style="margin: 0; font-weight: 600;">{{ $evidencias->where('evid_estado', 'Aprobada')->count() }}</h3>
                        <small>Evidencias Aprobadas</small>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .card {
        border: none;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
    }

    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #005a87;
        background: none;
    }

    .badge {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .btn-sm {
        font-size: 12px;
    }
</style>
@endsection
