@extends('layouts.dashboard')

@section('title', 'Historial de Proyectos')
@section('page-title', 'Historial de Proyectos')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos', 'instructor.proyecto.detalle', 'instructor.evidencias.ver', 'instructor.reporte') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
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
    <div style="margin-bottom: 32px;">
        <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">Historial de Proyectos</h2>
        <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Registro histórico de todos los proyectos supervisados y completados.</p>
    </div>

    @if($proyectos->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 2rem;">
            @foreach($proyectos as $proyecto)
                <div class="glass-card" style="display: flex; flex-direction: column; height: 100%;">
                    <div style="padding: 1.5rem; flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <span class="badge" style="background: {{ $proyecto->pro_estado === 'Activo' ? 'var(--primary-light)' : '#64748b' }}; color: white; border: none;">
                                {{ $proyecto->pro_estado }}
                            </span>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">
                                <i class="fas fa-calendar-alt" style="margin-right: 4px;"></i>
                                {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d M, Y') }}
                            </span>
                        </div>
                        
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 0.75rem; line-height: 1.4;">
                            {{ $proyecto->pro_titulo_proyecto }}
                        </h3>

                        <div style="display: grid; gap: 8px; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-building" style="color: var(--primary); width: 14px;"></i>
                                <span>{{ $proyecto->empresa_nombre }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-tag" style="color: var(--primary); width: 14px;"></i>
                                <span>{{ $proyecto->pro_categoria }}</span>
                            </div>
                        </div>

                        <div style="background: var(--bg-main); padding: 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border); display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: center;">
                            <div>
                                <p style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin: 0;">{{ $proyecto->countPostulaciones() }}</p>
                                <p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Postulaciones</p>
                            </div>
                            <div style="border-left: 1px solid var(--border);">
                                <p style="font-size: 1.1rem; font-weight: 700; color: #10b981; margin: 0;">{{ $proyecto->countPostulantesAprobados() }}</p>
                                <p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Aprobadas</p>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 1.25rem; border-top: 1px solid var(--border); background: rgba(0,0,0,0.02);">
                        <a href="{{ route('instructor.reporte', $proyecto->pro_id) }}" class="btn-ver" style="width: 100%; justify-content: center; background: #3b82f6; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);">
                            <i class="fas fa-chart-pie" style="margin-right: 8px;"></i> Ver Reporte de Seguimiento
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="glass-card" style="padding: 5rem 2rem; text-align: center;">
            <i class="fas fa-history" style="font-size: 4rem; color: var(--border); margin-bottom: 1.5rem;"></i>
            <h4 style="color: var(--text-main); font-size: 1.5rem; margin-bottom: 8px;">Historial vacío</h4>
            <p style="color: var(--text-muted);">Aún no tienes proyectos finalizados o registrados en tu historial.</p>
        </div>
    @endif
@endsection
