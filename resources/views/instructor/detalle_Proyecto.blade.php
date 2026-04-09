@extends('layouts.dashboard')

@section('title', 'Gestión de Proyecto | ' . $proyecto->titulo)
@section('page-title', 'Gestión Técnica')

@section('sidebar-nav')
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos*') ? 'active' : '' }}">
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
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/instructor.css') }}">
@endsection

@section('content')
<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
    
    <!-- Main Management Pillar -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Project Hero Card -->
        <div style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid rgba(62,180,137,0.1);">
            <div class="instructor-project-hero">
                <img src="{{ $proyecto->imagen_url }}?t={{ time() }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                <div class="instructor-hero-overlay"></div>
                
                <div class="instructor-hero-content">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                        <div>
                            <span style="background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-bottom: 8px; display: inline-block;">{{ $proyecto->categoria }}</span>
                            <h2 style="color: white; font-size: 2rem; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.3); margin: 0;">{{ $proyecto->titulo }}</h2>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.95rem; margin-top: 8px; font-weight: 500;"><i class="fas fa-building" style="margin-right: 8px;"></i>{{ $proyecto->nombre }}</p>
                        </div>
                        <button type="button" onclick="document.getElementById('uploadForm').classList.toggle('active')" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white; padding: 10px 18px; border: 1px solid rgba(255,255,255,0.25); border-radius: 12px; font-weight: 700; cursor: pointer;">
                            <i class="fas fa-camera" style="margin-right: 8px;"></i> Editar Visual
                        </button>
                    </div>
                </div>
            </div>

            <div id="uploadForm" class="instructor-collapsible" style="display: none;">
                <form action="{{ route('instructor.proyectos.imagen', $proyecto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="file" name="imagen" accept="image/*" required class="aprendiz-input-control" style="flex: 1; padding: 10px;">
                        <button type="submit" class="btn-premium" style="width: auto; padding: 10px 24px;">Actualizar Portada</button>
                    </div>
                </form>
            </div>

            <div style="padding: 2rem;">
                {{-- Stats row: 3 clean chips --}}
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: rgba(62,180,137,0.05); padding: 1.25rem; border-radius: 14px; border: 1px solid rgba(62,180,137,0.1); display:flex; align-items:center; gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:rgba(62,180,137,0.1);color:#3eb489;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-rocket" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <p style="font-size:0.65rem;color:var(--text-light);text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;font-weight:700;">Publicación</p>
                            <p style="font-weight:800;color:var(--text);font-size:0.9rem;">{{ $proyecto->fecha_publicacion ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d M, Y') : 'No definida' }}</p>
                        </div>
                    </div>
                    <div style="background:rgba(62,180,137,0.05);padding:1.25rem;border-radius:14px;border:1px solid rgba(62,180,137,0.1);display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:rgba(62,180,137,0.1);color:#3eb489;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-hourglass-half" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <p style="font-size:0.65rem;color:var(--text-light);text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;font-weight:700;">Duración</p>
                            <p style="font-weight:800;color:var(--text);font-size:0.9rem;">{{ $proyecto->duracion_estimada_dias }} días</p>
                        </div>
                    </div>
                    <div style="background:#fef2f2;padding:1.25rem;border-radius:14px;border:1px solid #fecaca;display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:#fee2e2;color:#ef4444;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-flag-checkered" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <p style="font-size:0.65rem;color:#ef4444;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;font-weight:700;">Cierre estimado</p>
                            <p style="font-weight:800;color:#ef4444;font-size:0.9rem;">{{ $proyecto->fecha_publicacion ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias ?? 0)->format('d M, Y') : 'No estimado' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Mapa de ubicación --}}
                @if($proyecto->latitud && $proyecto->longitud)
                <div style="margin-bottom:1.5rem;border-radius:16px;overflow:hidden;border:1px solid rgba(62,180,137,0.2);">
                    <div style="background:rgba(62,180,137,0.05);padding:10px 16px;display:flex;align-items:center;gap:8px;border-bottom:1px solid rgba(62,180,137,0.1);">
                        <i class="fas fa-map-marker-alt" style="color:#ef4444;font-size:13px;"></i>
                        <span style="font-size:0.7rem;font-weight:800;color:var(--text);text-transform:uppercase;letter-spacing:0.5px;">Ubicación de la empresa</span>
                    </div>
                    <div id="instructor-map" style="width:100%;height:220px;"></div>
                </div>
                @else
                <div style="margin-bottom:1.5rem;display:flex;align-items:center;gap:10px;background:#f8fafc;border:1px dashed #e2e8f0;border-radius:12px;padding:12px 16px;">
                    <i class="fas fa-map-marker-alt" style="color:#94a3b8;"></i>
                    <span style="font-size:0.85rem;color:var(--text-light);font-weight:500;">Ubicación geográfica no registrada para este proyecto.</span>
                </div>
                @endif

                <div style="color: var(--text-light); line-height: 1.7; font-size: 0.95rem;">
                    <h4 style="color: var(--text); font-weight: 800; margin-bottom: 0.75rem;">Descripción Técnica</h4>
                    {!! nl2br(e($proyecto->pro_description ?? $proyecto->descripcion)) !!}
                </div>
            </div>
        </div>

        <!-- Working Plan (Stages) -->
        <div style="background: white; padding: 2rem; border-radius: 20px; border: 1px solid rgba(62,180,137,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--text);">Mapa de Ruta Académica</h3>
                    <p style="color: var(--text-light); font-size: 0.9rem; font-weight: 500;">Define las etapas y hitos del proyecto.</p>
                </div>
                <button type="button" onclick="document.getElementById('stageForm').classList.toggle('active')" class="btn-premium" style="width: auto; padding: 10px 24px;">
                    <i class="fas fa-plus" style="margin-right: 8px;"></i> Nueva Etapa
                </button>
            </div>

            <div id="stageForm" class="instructor-collapsible" style="display: none; margin-bottom: 2rem;">
                <form action="{{ route('instructor.etapas.crear', $proyecto->id) }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 80px 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <input type="number" name="orden" placeholder="N°" required class="aprendiz-input-control">
                        <input type="text" name="nombre" placeholder="Título de la etapa..." required class="aprendiz-input-control">
                    </div>
                    <textarea name="descripcion" placeholder="¿Qué deben entregar los aprendices en esta fase?" required class="aprendiz-input-control" style="min-height: 100px; margin-bottom: 1.5rem;"></textarea>
                    <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                        <button type="button" onclick="document.getElementById('stageForm').classList.toggle('active')" style="background: transparent; border: none; font-weight: 700; color: var(--text-light); cursor: pointer;">Cancelar</button>
                        <button type="submit" class="btn-premium" style="width: auto; padding: 10px 32px;">Lanzar Etapa</button>
                    </div>
                </form>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($etapas as $index => $etapa)
                    <div class="instructor-stage-card" id="stage-card-{{ $etapa->id }}">
                        {{-- Vista normal de la etapa --}}
                        <div class="instructor-stage-view" id="stage-view-{{ $etapa->id }}">
                            <div class="instructor-stage-number" style="background: {{ $index == 0 ? 'linear-gradient(135deg, #3eb489, #2d9d74)' : 'rgba(62,180,137,0.08)' }}; color: {{ $index == 0 ? 'white' : '#3eb489' }};">
                                {{ $etapa->orden }}
                            </div>
                            <div style="flex: 1;">
                                <h4 style="font-weight: 800; color: var(--text); margin-bottom: 6px; font-size: 1.1rem;">{{ $etapa->nombre }}</h4>
                                <p style="font-size: 0.9rem; color: var(--text-light); line-height: 1.6; font-weight: 500;">{{ $etapa->descripcion }}</p>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" onclick="toggleEditStage({{ $etapa->id }})" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(62,180,137,0.1); color: #3eb489; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" title="Editar etapa">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('instructor.etapas.eliminar', $etapa->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta etapa?')" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;" class="btn-del-hover">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Formulario inline de edición (oculto por defecto) --}}
                        <div id="stage-edit-{{ $etapa->id }}" style="display: none; width: 100%;">
                            <form action="{{ route('instructor.etapas.editar', $etapa->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div style="display: grid; grid-template-columns: 80px 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <input type="number" name="orden" value="{{ $etapa->orden }}" placeholder="N°" required class="aprendiz-input-control">
                                    <input type="text" name="nombre" value="{{ $etapa->nombre }}" placeholder="Título de la etapa..." required class="aprendiz-input-control">
                                </div>
                                <textarea name="descripcion" placeholder="Descripción de la etapa..." required class="aprendiz-input-control" style="min-height: 80px; margin-bottom: 1rem;">{{ $etapa->descripcion }}</textarea>
                                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                                    <button type="button" onclick="toggleEditStage({{ $etapa->id }})" style="background: transparent; border: none; font-weight: 700; color: var(--text-light); cursor: pointer; padding: 8px 16px;">Cancelar</button>
                                    <button type="submit" class="btn-premium" style="width: auto; padding: 10px 24px;">
                                        <i class="fas fa-save" style="margin-right: 6px;"></i>Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="instructor-empty-state">
                        <i class="fas fa-project-diagram" style="font-size: 32px; color: #3eb489; margin-bottom: 12px; opacity: 0.5;"></i>
                        <h4>Comienza definiendo el plan de trabajo para que los aprendices puedan entregar evidencias.</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar Management Pillar -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 2rem;">
        
        <!-- Quick Stats -->
        <div class="instructor-sidebar-card" style="text-align: center;">
            <p style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: var(--text-light); margin-bottom: 1rem;">Estado del Proyecto</p>
            <span style="background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; padding: 10px 20px; border-radius: 20px; font-size: 0.9rem; font-weight: 700; display: inline-block;">
                 <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ $proyecto->estado }}
            </span>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 1.5rem; border-top: 1px solid rgba(62,180,137,0.1); padding-top: 1.5rem;">
                <div>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #3eb489;">{{ $integrantes->count() }}</p>
                    <p style="font-size: 0.7rem; color: var(--text-light); font-weight: 700; text-transform: uppercase;">Equipo</p>
                </div>
                <div>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #3eb489;">{{ $etapas->count() }}</p>
                    <p style="font-size: 0.7rem; color: var(--text-light); font-weight: 700; text-transform: uppercase;">Etapas</p>
                </div>
            </div>
        </div>

        <!-- Suite de Seguimiento -->
        <div class="instructor-sidebar-card">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text); margin-bottom: 1.25rem;">Suite de Seguimiento</h4>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="{{ route('instructor.reporte', $proyecto->id) }}" class="btn-premium" style="justify-content: center;">
                    <i class="fas fa-chart-bar"></i> Dashboard de Métricas
                </a>
                <a href="{{ route('instructor.evidencias.ver', $proyecto->id) }}" class="btn-premium" style="justify-content: center;">
                    <i class="fas fa-tasks"></i> Calificar Entregas
                </a>
            </div>
        </div>

        <!-- Postulations Pool -->
        <div class="instructor-sidebar-card">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text); margin-bottom: 1rem;">Solicitudes Pendientes ({{ $postulaciones->where('estado', 'pendiente')->count() }})</h4>
            <div style="display: flex; flex-direction: column; gap: 4px;">
                @forelse($postulaciones->where('estado', 'pendiente') as $p)
                    <div class="instructor-postulant-item">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; box-shadow: 0 4px 8px rgba(62,180,137,0.3);">
                                {{ substr($p->aprendiz->nombres ?? 'A', 0, 1) }}
                            </div>
                            <div style="overflow: hidden;">
                                <p style="font-size: 0.85rem; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->aprendiz->nombres }}</p>
                                <p style="font-size: 0.7rem; color: var(--text-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600;">{{ $p->aprendiz->programa_formacion }}</p>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <form action="{{ route('instructor.postulaciones.estado', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="aceptada">
                                <button type="submit" style="width: 100%; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; border: none; padding: 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">Aceptar</button>
                            </form>
                            <form action="{{ route('instructor.postulaciones.estado', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="rechazada">
                                <button type="submit" style="width: 100%; background: rgba(62,180,137,0.08); color: #3eb489; border: 1px solid rgba(62,180,137,0.2); padding: 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">Omitir</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: var(--text-light); font-size: 0.85rem; padding: 1rem; font-weight: 500;">Sin solicitudes pendientes.</p>
                @endforelse
            </div>
        </div>

        <!-- Current Team -->
        <div class="instructor-sidebar-card">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text); margin-bottom: 1rem;">Equipo de Trabajo ({{ $integrantes->count() }})</h4>
            <div style="display: flex; flex-direction: column; gap: 4px;">
                @forelse($integrantes as $i)
                    <div class="instructor-team-member">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem; border: 1px solid rgba(62,180,137,0.2);">
                            {{ substr($i->aprendiz->nombres, 0, 1) }}
                        </div>
                        <div style="overflow: hidden;">
                            <p style="font-size: 0.8rem; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $i->aprendiz->nombres }} {{ $i->aprendiz->apellidos }}</p>
                            <p style="font-size: 0.65rem; color: var(--text-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600;">{{ $i->aprendiz->usuario->correo }}</p>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: var(--text-light); font-size: 0.85rem; font-weight: 500;">Equipo vacío.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function toggleEditStage(id) {
    const viewEl = document.getElementById('stage-view-' + id);
    const editEl = document.getElementById('stage-edit-' + id);
    if (editEl.style.display === 'none') {
        viewEl.style.display = 'none';
        editEl.style.display = 'block';
    } else {
        viewEl.style.display = 'flex';
        editEl.style.display = 'none';
    }
}
</script>
@endsection

@section('scripts')
@if($proyecto->latitud && $proyecto->longitud)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/maps.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initViewMap('instructor-map', {{ $proyecto->latitud }}, {{ $proyecto->longitud }}, '{{ $proyecto->nombre }}');
});
</script>
@endif
@endsection
