@extends('layouts.dashboard')

@section('title', 'Historial de Proyectos')
@section('page-title', 'Historial de Proyectos')

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
            <h2 style="color: #005a87; font-weight: 600;">📋 Historial de Proyectos</h2>
            <p style="color: #666; margin-top: 5px;">Todos los proyectos que has supervisado</p>
        </div>
    </div>

    @if($proyectos->count() > 0)
        <div class="row">
            @foreach($proyectos as $proyecto)
                <div class="col-md-6 mb-4">
                    <div class="card h-100" style="border-left: 4px solid #005a87; box-shadow: 0 2px 8px rgba(0,90,135,0.1);">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                <h5 style="margin: 0; color: #005a87; font-weight: 600;">{{ $proyecto->pro_titulo_proyecto }}</h5>
                                <span class="badge" style="background-color: 
                                    @if($proyecto->pro_estado === 'Activo') #28a745
                                    @elseif($proyecto->pro_estado === 'Completado') #17a2b8
                                    @else #6c757d
                                    @endif; color: white;">
                                    {{ $proyecto->pro_estado }}
                                </span>
                            </div>

                            <div style="margin-bottom: 12px;">
                                <small style="color: #666;">
                                    <strong>Empresa:</strong> {{ $proyecto->emp_nombre }}<br>
                                    <strong>Categoría:</strong> {{ $proyecto->pro_categoria }}<br>
                                    <strong>Publicado:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}<br>
                                    <strong>Finalización:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}
                                </small>
                            </div>

                            <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 12px;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; text-align: center;">
                                    <div>
                                        <strong style="color: #005a87; font-size: 18px;">{{ $proyecto->total_aprendices }}</strong>
                                        <small style="color: #666; display: block;">Postulaciones</small>
                                    </div>
                                    <div>
                                        <strong style="color: #28a745; font-size: 18px;">{{ $proyecto->aprendices_aprobados }}</strong>
                                        <small style="color: #666; display: block;">Aprobadas</small>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('instructor.reporte', $proyecto->pro_id) }}" class="btn btn-sm btn-primary" style="background-color: #005a87; border: none; width: 100%;">
                                📊 Ver Reporte de Seguimiento
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #999; font-size: 16px; margin: 0;">
                📭 No hay proyectos en tu historial aún
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
</style>
@endsection
