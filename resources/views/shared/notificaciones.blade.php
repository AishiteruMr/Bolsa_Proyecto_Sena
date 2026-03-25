@extends('layouts.dashboard')

@section('title', 'Notificaciones')
@section('page-title', 'Mis Notificaciones')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 700;">Centro de Notificaciones</h2>
        @if($notificaciones->where('read_at', null)->count() > 0)
            <form action="{{ route('notificaciones.leer_todas') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline" style="padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-check-double"></i> Marcar todas como leídas
                </button>
            </form>
        @endif
    </div>

    @if($notificaciones->isEmpty())
        <div style="text-align: center; padding: 48px 20px;">
            <div style="width: 64px; height: 64px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: var(--text-light);">
                <i class="fas fa-bell-slash" style="font-size: 24px;"></i>
            </div>
            <p style="color: var(--text-light); font-weight: 500;">No tienes notificaciones por el momento.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($notificaciones as $notificacion)
                <div class="stat-card" style="padding: 20px; @if($notificacion->read_at) opacity: 0.7; @endif border-left: 4px solid @if($notificacion->read_at) var(--border) @else var(--primary) @endif; display: flex; align-items: flex-start; gap: 16px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: @if($notificacion->read_at) var(--bg) @else var(--primary-soft) @endif; display: flex; align-items: center; justify-content: center; color: @if($notificacion->read_at) var(--text-light) @else var(--primary) @endif; flex-shrink: 0;">
                        @if(str_contains($notificacion->type, 'Postulacion'))
                            <i class="fas fa-file-contract"></i>
                        @else
                            <i class="fas fa-tasks"></i>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <p style="font-size: 15px; font-weight: 600; color: var(--text); margin-bottom: 4px;">{{ $notificacion->data['mensaje'] }}</p>
                            <span style="font-size: 12px; color: var(--text-light); white-space: nowrap;">{{ \Carbon\Carbon::parse($notificacion->data['fecha'])->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 13px; color: var(--text-light);">En el proyecto: <strong>{{ $notificacion->data['proyecto'] }}</strong></p>
                        
                        @if(!$notificacion->read_at)
                            <form action="{{ route('notificaciones.leer', $notificacion->id) }}" method="POST" style="margin-top: 12px;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">
                                    Marcar como leída
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 24px;">
            {{ $notificaciones->links() }}
        </div>
    @endif
</div>
@endsection
