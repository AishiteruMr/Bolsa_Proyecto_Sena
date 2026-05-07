@extends('layouts.dashboard')

@section('title', 'Notificaciones')
@section('page-title', 'Mis Notificaciones')

@section('styles')
<style>
@media (max-width: 768px) {
    .notificaciones-container {
        max-width: 100% !important;
        margin: 0 16px !important;
        padding: 16px !important;
    }
    .notificaciones-header {
        flex-direction: column !important;
        gap: 16px !important;
        text-align: center !important;
    }
    .notificaciones-header h2 {
        font-size: 24px !important;
    }
    .notificacion-item {
        padding: 16px !important;
        flex-direction: column !important;
        gap: 12px !important;
    }
    .notificacion-item .notificacion-icon {
        width: 40px !important;
        height: 40px !important;
    }
    .notificacion-content {
        text-align: center !important;
    }
    .notificacion-actions {
        justify-content: center !important;
    }
}
@media (max-width: 480px) {
    .notificaciones-container {
        margin: 0 8px !important;
        padding: 8px !important;
    }
    .notificaciones-header h2 {
        font-size: 20px !important;
    }
    .notificacion-item {
        padding: 12px !important;
    }
}
</style>
@endsection

@section('content')
<div class="animate-fade-in notificaciones-container" style="max-width: 900px; margin: 0 auto; padding: 24px;">

    {{-- HEADER CARD --}}
    <div class="glass-card" style="margin-bottom: 32px; padding: 32px;">
        <div class="notificaciones-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 28px; font-weight: 900; display: inline-flex; align-items: center; gap: 8px; background: var(--surface); backdrop-filter: var(--glass); -webkit-backdrop-filter: blur(14px) saturate(190%); border-radius: var(--radius); padding: 12px 24px; border: 1px solid var(--border-glass); box-shadow: var(--shadow);">
                    <span style="background: linear-gradient(135deg, var(--primary), var(--primary-hover)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Centro de</span> 
                    <span style="color: var(--primary);">Notificaciones</span>
                </h2>
                <p style="font-size: 14px; color: var(--text-light); margin-top: 8px; font-weight: 500; display: inline-block; background: rgba(var(--h), var(--s), var(--l), 0.05); padding: 4px 12px; border-radius: 20px; backdrop-filter: blur(5px);">
                    {{ $notificaciones->where('read_at', null)->count() }} sin leer
                </p>
            </div>
            @if($notificaciones->where('read_at', null)->count() > 0)
                <form action="{{ route('notificaciones.leer_todas') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-premium" style="background: #f1f5f9; color: var(--text); box-shadow: none; border: 1px solid var(--border); font-size: 13px; padding: 10px 20px;">
                        <i class="fas fa-check-double"></i> Marcar todas como leídas
                    </button>
                </form>
            @endif
        </div>
    </div>

    @php
        $defaultDashboard = route('home');
        if (auth()->check()) {
            $defaultDashboard = match(auth()->user()->rol_id) {
                1 => route('aprendiz.dashboard'),
                2 => route('instructor.dashboard'),
                3 => route('empresa.dashboard'),
                4 => route('admin.dashboard'),
                default => route('home'),
            };
        }
        $returnUrl = session('notificaciones_return_url', $defaultDashboard);
    @endphp
    <div style="text-align:right; margin-bottom: 20px;">
        <a href="{{ $returnUrl }}" class="btn-premium" style="background:#e2e8f0; color: var(--text); box-shadow: none; border: 1px solid var(--border); font-size: 13px; padding: 10px 20px;">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>

    {{-- LIST --}}
    @if($notificaciones->isEmpty())
        <div class="glass-card" style="text-align: center; padding: 80px 20px;">
            <div style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #cbd5e1;">
                <i class="fas fa-bell-slash"></i>
            </div>
            <h4 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 8px;">Todo al día</h4>
            <p style="color: var(--text-light); font-weight: 500;">No tienes notificaciones por el momento.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($notificaciones as $notificacion)
                @php
                    $leida = !is_null($notificacion->read_at);
                    $iconColor = $leida ? '#94a3b8' : 'var(--primary)';
                    $iconBg   = $leida ? '#f8fafc' : 'var(--primary-soft)';
                    $borderColor = $leida ? 'var(--border)' : 'var(--primary-soft)';
                    $icon = $notificacion->data['icono'] ?? 'fa-bell';
                @endphp
                <div class="glass-card notificacion-item" style="padding: 24px; border-color: {{ $borderColor }}; {{ $leida ? 'opacity: 0.8;' : '' }} display: flex; align-items: flex-start; gap: 16px; transition: all 0.2s;">
                    <div class="notificacion-icon" style="width: 48px; height: 48px; border-radius: 16px; background: {{ $iconBg }}; display: flex; align-items: center; justify-content: center; color: {{ $iconColor }}; font-size: 20px; flex-shrink: 0;">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div class="notificacion-content" style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 8px;">
                            <p style="font-size: 16px; font-weight: {{ $leida ? '600' : '700' }}; color: var(--text); margin: 0;">
                                {{ $notificacion->data['titulo'] ?? 'Notificación del sistema' }}
                            </p>
                            <span style="font-size: 12px; color: var(--text-lighter); white-space: nowrap; font-weight: 600; flex-shrink: 0;">
                                {{ $notificacion->created_at ? $notificacion->created_at->diffForHumans() : '' }}
                            </span>
                        </div>
                        <p style="font-size: 14px; color: var(--text-light); margin: 0 0 12px; line-height: 1.5;">
                            {{ $notificacion->data['mensaje'] ?? 'Sin detalles.' }}
                        </p>
                        <div class="notificacion-actions" style="display: flex; gap: 12px; align-items: center;">
                            @if(isset($notificacion->data['url']) && $notificacion->data['url'])
                                <a href="{{ $notificacion->data['url'] }}" style="font-size: 12px; font-weight: 700; color: var(--primary); text-decoration: none; padding: 6px 12px; background: var(--primary-soft); border-radius: 8px;">Ver Detalles</a>
                            @endif
                            
                            @if(!$leida)
                                <form action="{{ route('notificaciones.leer', $notificacion->id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; padding: 0; font-size: 12px; font-weight: 700; color: var(--primary); cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-check"></i> Marcar como leída
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 11px; font-weight: 700; color: var(--text-lighter); display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-check-double"></i> Leída
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 32px;">
            {{ $notificaciones->links() }}
        </div>
    @endif
</div>
@endsection
