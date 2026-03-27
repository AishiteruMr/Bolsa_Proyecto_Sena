@extends('layouts.dashboard')

@section('title', 'Postulantes')
@section('page-title', 'Candidatos al Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('content')
<div style="margin-bottom: 40px; animation: fadeIn 0.8s ease-out;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" class="btn-premium" style="background: white; color: var(--text-light); border: 1px solid #e2e8f0; box-shadow: none; padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-arrow-left"></i> Volver al Portafolio
                </a>
            </div>
            <h2 style="font-size:30px; font-weight:800; color:var(--text); letter-spacing: -1px;">Gestión de <span style="color: var(--primary);">Candidatos</span></h2>
            <p style="color:var(--text-light); font-size:16px; margin-top:4px; font-weight: 500;">{{ $proyecto->pro_titulo_proyecto }}</p>
        </div>
        <div style="background: var(--primary-soft); padding: 12px 24px; border-radius: 16px; border: 1px solid var(--primary-glow); display: flex; flex-direction: column; align-items: flex-end;">
            <span style="font-size: 11px; font-weight: 800; color: var(--primary-hover); text-transform: uppercase; letter-spacing: 1px;">Total Postulaciones</span>
            <span style="font-size: 24px; font-weight: 900; color: var(--primary-hover);">{{ count($postulantes) }}</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 24px;">
        @forelse($postulantes as $p)
            <div class="glass-card candidate-card" style="padding: 28px; display: flex; flex-direction: column; gap: 24px; border: 1px solid rgba(255,255,255,0.8); background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden;">
                
                <!-- Status Ribbon -->
                @php
                    $statusConfig = match($p->pos_estado) {
                        'Pendiente' => ['bg' => '#f59e0b', 'label' => 'Por Revisar'],
                        'Aprobada' => ['bg' => '#10b981', 'label' => 'Aprobado'],
                        'Rechazada' => ['bg' => '#ef4444', 'label' => 'No seleccionado'],
                        default => ['bg' => '#64748b', 'label' => $p->pos_estado]
                    };
                @endphp
                <div style="position: absolute; top: 12px; right: 12px; background: {{ $statusConfig['bg'] }}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 10px {{ $statusConfig['bg'] }}40;">
                    {{ $statusConfig['label'] }}
                </div>

                <div style="display: flex; align-items: center; gap: 18px;">
                    <div style="width: 70px; height: 70px; border-radius: 20px; background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; flex-shrink: 0; box-shadow: 0 10px 20px var(--primary-glow);">
                        {{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <h4 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; letter-spacing: -0.5px;">
                            {{ $p->apr_nombre }} {{ $p->apr_apellido }}
                        </h4>
                        <div style="font-size: 0.9rem; color: var(--primary); font-weight: 700; display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                            <i class="fas fa-graduation-cap"></i> {{ $p->apr_programa ?? 'Especialidad SENA' }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-lighter); display: flex; align-items: center; gap: 8px; font-weight: 600;">
                            <i class="fas fa-envelope-open-text" style="color: #94a3b8;"></i> {{ $p->usr_correo }}
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div style="background: #f8fafc; padding: 14px; border-radius: 16px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Fecha Aplicación</span>
                        <span style="font-size: 13px; font-weight: 700; color: var(--text);">{{ \Carbon\Carbon::parse($p->pos_fecha)->translatedFormat('d M, Y') }}</span>
                    </div>
                    <div style="background: #f8fafc; padding: 14px; border-radius: 16px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Disponibilidad</span>
                        <span style="font-size: 13px; font-weight: 700; color: var(--text);">Inmediata</span>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 4px;">
                    <button class="btn-premium" style="flex: 1; justify-content: center; background: #3b82f6; box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25); border: none;">
                        <i class="fas fa-file-pdf"></i> Revisar Hoja de Vida
                    </button>
                    
                    @if($p->pos_estado == 'Pendiente')
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('empresa.postulacion.estado', [$p->pos_id, 'Aprobada']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-premium" style="width: 44px; height: 44px; padding: 0; justify-content: center; background: #10b981; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); border: none;" title="Aceptar Candidato">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('empresa.postulacion.estado', [$p->pos_id, 'Rechazada']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-premium" style="width: 44px; height: 44px; padding: 0; justify-content: center; background: #ef4444; box-shadow: 0 8px 16px rgba(239, 68, 68, 0.25); border: none;" title="Declinar Solicitud">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 80px 40px; background: white; border: 1px dashed var(--border);">
                <div style="width: 100px; height: 100px; margin: 0 auto 24px; background: var(--bg-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                    <i class="fas fa-user-clock" style="font-size: 40px;"></i>
                </div>
                <h4 style="color: var(--text); font-size: 20px; font-weight: 800; margin-bottom: 8px;">Buscando el Match Perfecto</h4>
                <p style="color: var(--text-light); font-size: 16px; max-width: 500px; margin: 0 auto;">Tu proyecto está en el radar de nuestros aprendices. En cuanto recibas una postulación, te lo notificaremos aquí.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
