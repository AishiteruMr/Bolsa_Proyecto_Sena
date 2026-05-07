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

@section('content')
    <div class="soporte-wrapper">
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
