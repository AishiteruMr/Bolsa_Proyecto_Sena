@extends('layouts.dashboard')

@section('title', 'Historial de Proyectos')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 style="color: #005a87; font-weight: 600;">📋 Historial de Proyectos</h2>
            <p style="color: #666; margin-top: 5px;">Todos los proyectos en los que te has postulado</p>
        </div>
    </div>

    @if($proyectos->count() > 0)
        <div class="row">
            @foreach($proyectos as $proyecto)
                <div class="col-md-6 mb-4">
                    <div class="card h-100" style="border-left: 4px solid #005a87; box-shadow: 0 2px 8px rgba(0,90,135,0.1);">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                <div>
                                    <h5 style="margin: 0; color: #005a87; font-weight: 600;">{{ $proyecto->pro_titulo_proyecto }}</h5>
                                    <small style="color: #999;">{{ $proyecto->emp_nombre }}</small>
                                </div>
                                <span class="badge" style="background-color: 
                                    @if($proyecto->pos_estado === 'Aprobada') #28a745
                                    @elseif($proyecto->pos_estado === 'Rechazada') #dc3545
                                    @else #ffc107
                                    @endif; color: white; white-space: nowrap;">
                                    {{ $proyecto->pos_estado }}
                                </span>
                            </div>

                            <div style="margin-bottom: 12px;">
                                <small style="color: #666;">
                                    <strong>Categoría:</strong> {{ $proyecto->pro_categoria }}<br>
                                    <strong>Instructor:</strong> {{ $proyecto->instructor_nombre }}<br>
                                    <strong>Postulación:</strong> {{ \Carbon\Carbon::parse($proyecto->pos_fecha)->format('d/m/Y H:i') }}<br>
                                    <strong>Finalización:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}
                                </small>
                            </div>

                            <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 12px;">
                                @php
                                    $estado_proyecto = $proyecto->pro_estado;
                                    $dias_restantes = max(0, \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->diffInDays(now(), false));
                                @endphp
                                <strong style="color: #005a87; display: block; margin-bottom: 5px;">
                                    Estado Proyecto: {{ $estado_proyecto }}
                                </strong>
                                <small style="color: #666;">
                                    @if($dias_restantes > 0)
                                        ⏳ {{ $dias_restantes }} días para finalizar
                                    @else
                                        ✓ Proyecto finalizado
                                    @endif
                                </small>
                            </div>

                            @if($proyecto->pos_estado === 'Aprobada')
                                <a href="{{ route('aprendiz.entregas') }}" class="btn btn-sm btn-primary" style="background-color: #005a87; border: none; width: 100%;">
                                    📤 Ver Mis Entregas
                                </a>
                            @else
                                <button class="btn btn-sm btn-secondary" style="width: 100%; cursor: default;">
                                    🔒 Acceso restringido
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #999; font-size: 16px; margin: 0;">
                📭 No tienes historial de postulaciones aún
            </p>
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
        box-shadow: 0 4px 12px rgba(0,90,135,0.15) !important;
    }

    .badge {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .btn-primary {
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #003d5c !important;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #e9ecef;
        border: none;
        color: #6c757d;
    }
</style>
@endsection
