@extends('layouts.dashboard')

@section('title', 'Postulantes')
@section('page-title', 'Candidatos al Proyecto')

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
<div style="margin-bottom: 32px;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
        <a href="{{ route('empresa.proyectos') }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 500;">
            <i class="fas fa-arrow-left"></i> Volver a mis proyectos
        </a>
    </div>
    <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">{{ $proyecto->pro_titulo_proyecto }}</h2>
    <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Revisa las solicitudes de los aprendices interesados en este proyecto.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 1.5rem;">
    @forelse($postulantes as $p)
        <div class="glass-card" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; transition: transform 0.2s ease;">
            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; flex-shrink: 0; box-shadow: 0 4px 12px rgba(41, 133, 100, 0.2);">
                    {{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $p->apr_nombre }} {{ $p->apr_apellido }}
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--primary); font-weight: 600; margin-bottom: 8px;">
                        <i class="fas fa-graduation-cap" style="margin-right: 6px;"></i> {{ $p->apr_programa ?? 'Técnico/Tecnólogo' }}
                    </p>
                    <p style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-envelope"></i> {{ $p->usr_correo }}
                    </p>
                </div>
            </div>

            <div style="background: var(--bg-main); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); font-weight: 700;">Fecha de Postulación</span>
                        <span style="font-size: 0.9rem; font-weight: 600; color: var(--text-main);">{{ \Carbon\Carbon::parse($p->pos_fecha)->format('d M, Y') }}</span>
                    </div>
                    <div>
                        @switch($p->pos_estado)
                            @case('Pendiente')
                                <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); font-size: 10px; padding: 4px 10px;">Pendiente</span>
                                @break
                            @case('Aprobada')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); font-size: 10px; padding: 4px 10px;">Aprobado</span>
                                @break
                            @case('Rechazada')
                                <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); font-size: 10px; padding: 4px 10px;">Rechazado</span>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: auto;">
                <button class="btn-ver" style="flex: 1; padding: 0.7rem; font-size: 0.85rem; border-radius: 30px; justify-content: center; background: #3b82f6;">
                    <i class="fas fa-file-pdf" style="margin-right: 8px;"></i> Ver CV
                </button>
                <div style="display: flex; gap: 0.5rem;">
                    @if($p->pos_estado == 'Pendiente')
                        <form action="{{ route('empresa.postulacion.estado', [$p->pos_id, 'Aprobada']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-ver" style="width: 38px; height: 38px; border-radius: 50%; padding: 0; justify-content: center;" title="Aprobar">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form action="{{ route('empresa.postulacion.estado', [$p->pos_id, 'Rechazada']) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-ver" style="width: 38px; height: 38px; border-radius: 50%; padding: 0; justify-content: center; background: #ef4444;" title="Rechazar">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 5rem 2rem;">
            <i class="fas fa-user-clock" style="font-size: 4rem; color: var(--border); margin-bottom: 1.5rem;"></i>
            <h4 style="color: var(--text-main); font-size: 1.5rem; margin-bottom: 8px;">Esperando Candidatos</h4>
            <p style="color: var(--text-muted);">Tu proyecto está publicado. En cuanto haya aprendices interesados, aparecerán en este panel.</p>
        </div>
    @endforelse
</div>

<style>
    .glass-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }
</style>
@endsection
