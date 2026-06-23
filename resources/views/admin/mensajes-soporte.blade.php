@extends('layouts.dashboard')

@section('title', 'Soporte Técnico')
@section('page-title', 'Mensajes de Soporte')

@section('styles')
    @vite(['resources/css/admin.css'])
    <style>
        .soporte-wrapper { max-width: 1000px; margin: 0 auto; }
        .response-panel { display: none; }
    </style>
@endsection

@section('sidebar-nav')
    @include('admin.partials.sidebar-nav')
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('admin.dashboard')], ['label' => 'Mensajes de Soporte']]; @endphp
@section('content')
    <div class="soporte-wrapper">
        <div class="admin-header-master">
            <div class="admin-header-icon">
                <i class="fas fa-headset"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="admin-badge-hub">Centro de Ayuda</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="admin-header-title">Soporte <span style="color: var(--primary);">Técnico</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 600px; font-weight: 500;">Atiende y responde las consultas de los usuarios de la plataforma.</p>
            </div>
        </div>

        {{-- KPI STAT CARDS --}}
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin: 24px 0;">
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid var(--primary);">
                <div class="admin-stat-icon" style="background: var(--primary-soft); color: var(--primary); width: 44px; height: 44px;"><i class="fas fa-envelope"></i></div>
                <div><div class="admin-stat-label">Total Mensajes</div><div class="admin-stat-value">{{ $totalMensajes }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #f59e0b;">
                <div class="admin-stat-icon" style="background: #fef3c7; color: #f59e0b; width: 44px; height: 44px;"><i class="fas fa-clock"></i></div>
                <div><div class="admin-stat-label">Pendientes</div><div class="admin-stat-value" style="color: #f59e0b;">{{ $pendientes }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #10b981;">
                <div class="admin-stat-icon" style="background: #f0fdf4; color: #10b981; width: 44px; height: 44px;"><i class="fas fa-check-double"></i></div>
                <div><div class="admin-stat-label">Respondidos</div><div class="admin-stat-value" style="color: #10b981;">{{ $respondidos }}</div></div>
            </div>
        </div>

        {{-- MOTIVOS BAR CHART --}}
        @if($mensajesPorMotivo->count() > 0)
        <div class="glass-card" style="padding: 20px; background: white; margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text);">
                    <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 8px;"></i>
                    Motivos de Contacto
                </h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @php $maxMotivo = $mensajesPorMotivo->max('total'); @endphp
                @foreach($mensajesPorMotivo as $mot)
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 600; margin-bottom: 4px;">
                        <span style="color: var(--text);">{{ ucfirst($mot->motivo) }}</span>
                        <span style="color: var(--primary);">{{ $mot->total }}</span>
                    </div>
                    <div style="height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $maxMotivo > 0 ? ($mot->total / $maxMotivo) * 100 : 0 }}%; background: linear-gradient(90deg, var(--primary), #34d399); border-radius: 4px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 20px;">
            @forelse($mensajes as $m)
                <div class="card-base" style="padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div>
                                <div style="font-weight: 800; color: var(--text);">{{ $m->nombre }}</div>
                                <div style="font-size: 13px; color: var(--text-light);">{{ $m->email }}</div>
                            </div>
                            <span class="inline-pill inline-pill--muted">{{ $m->motivo }}</span>
                        </div>
                        <span class="status-badge-support {{ $m->estado == 'respondido' ? 'respondido' : 'pendiente' }}">
                            {{ ucfirst($m->estado) }}
                        </span>
                    </div>
                    <div style="color: var(--text-light); margin-bottom: 20px; line-height: 1.6;">{{ $m->mensaje }}</div>
                    
                    <button class="btn-premium" onclick="togglePanel('panel-{{ $m->id }}')">
                        <i class="fas {{ $m->estado == 'respondido' ? 'fa-eye' : 'fa-reply' }}"></i> 
                        {{ $m->estado == 'respondido' ? 'Ver Respuesta' : 'Responder' }}
                    </button>
                    
                    <div id="panel-{{ $m->id }}" class="response-panel" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border);">
                        <form action="{{ route('admin.mensajes.soporte.responder', $m->id) }}" method="POST">
                            @csrf
                            <textarea name="respuesta" class="form-control" placeholder="Escribe tu respuesta aquí..." required style="width:100%; height:120px; padding:16px; border: 1px solid var(--border); border-radius:12px; margin-bottom:16px; font-family:inherit;">{{ $m->respuesta }}</textarea>
                            <button type="submit" class="btn-premium">Enviar Respuesta</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card-base" style="padding:40px; text-align:center; color:var(--text-light);">No hay mensajes registrados.</div>
            @endforelse
        </div>
        <div style="margin-top:20px;">{{ $mensajes->links() }}</div>
    </div>

    <script>
        function togglePanel(id) {
            const panel = document.getElementById(id);
            panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
        }
    </script>
@endsection
