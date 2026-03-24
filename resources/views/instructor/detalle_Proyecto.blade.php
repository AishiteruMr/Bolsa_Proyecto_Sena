@extends('layouts.dashboard')

@section('title', 'Gestión de Proyecto | ' . $proyecto->pro_titulo_proyecto)
@section('page-title', 'Gestión Técnica')

@section('sidebar-nav')
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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

@section('content')
<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
    
    <!-- Main Management Pillar -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Project Hero Card -->
        <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: 20px;">
            <div style="width: 100%; height: 300px; position: relative;">
                <img src="{{ $proyecto->imagen_url }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(0,0,0,0.85) 0%, transparent 60%);"></div>
                
                <div style="position: absolute; bottom: 24px; left: 24px; right: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                        <div>
                            <span class="badge" style="background: var(--primary); color: white; margin-bottom: 8px; border: none;">{{ $proyecto->pro_categoria }}</span>
                            <h2 style="color: white; font-size: 2.2rem; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $proyecto->pro_titulo_proyecto }}</h2>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.95rem; margin-top: 4px;"><i class="fas fa-building" style="margin-right: 8px;"></i>{{ $proyecto->emp_nombre }}</p>
                        </div>
                        <button type="button" onclick="document.getElementById('uploadForm').classList.toggle('active')" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white; padding: 10px 18px; border: 1px solid rgba(255,255,255,0.25); border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                            <i class="fas fa-camera" style="margin-right: 8px;"></i> Editar Visual
                        </button>
                    </div>
                </div>
            </div>

            <div id="uploadForm" style="display: none; padding: 1.5rem; background: var(--bg-main); border-bottom: 1px solid var(--border);" class="collapsible">
                <form action="{{ route('instructor.proyectos.imagen', $proyecto->pro_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="file" name="imagen" accept="image/*" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--border); background: white;">
                        <button type="submit" class="btn-ver" style="width: auto; padding: 10px 24px;">Actualizar Portada</button>
                    </div>
                </form>
            </div>

            <div style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
                    <div style="background: var(--bg-main); padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border);">
                        <p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Publicación</p>
                        <p style="font-weight: 700; color: var(--text-main);">{{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d M, Y') }}</p>
                    </div>
                    <div style="background: var(--bg-main); padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border);">
                        <p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Duración</p>
                        <p style="font-weight: 700; color: var(--text-main);">{{ $proyecto->pro_duracion_estimada }} días</p>
                    </div>
                    <div style="background: var(--bg-main); padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border);">
                        <p style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Ubicación</p>
                        <p style="font-weight: 700; color: var(--text-main);">{{ $proyecto->pro_ubicacion }}</p>
                    </div>
                </div>

                <div style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; text-align: justify;">
                    <h4 style="color: var(--text-main); font-weight: 700; margin-bottom: 0.75rem;">Descripción Técnica</h4>
                    {!! nl2br(e($proyecto->pro_description ?? $proyecto->pro_descripcion)) !!}
                </div>
            </div>
        </div>

        <!-- Working Plan (Stages) -->
        <div class="glass-card" style="padding: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--primary-dark);">Mapa de Ruta Académica</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Define las etapas y hitos del proyecto.</p>
                </div>
                <button type="button" onclick="document.getElementById('stageForm').classList.toggle('active')" class="btn-ver" style="width: auto; padding: 10px 24px; border-radius: 12px;">
                    <i class="fas fa-plus" style="margin-right: 8px;"></i> Nueva Etapa
                </button>
            </div>

            <div id="stageForm" style="display: none; margin-bottom: 2rem; padding: 2rem; background: var(--bg-main); border-radius: 16px; border: 2px dashed var(--border);" class="collapsible">
                <form action="{{ route('instructor.etapas.crear', $proyecto->pro_id) }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 80px 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <input type="number" name="orden" placeholder="N°" required class="form-control" style="padding: 12px;">
                        <input type="text" name="nombre" placeholder="Título de la etapa..." required class="form-control" style="padding: 12px;">
                    </div>
                    <textarea name="descripcion" placeholder="¿Qué deben entregar los aprendices en esta fase?" required class="form-control" style="padding: 12px; min-height: 100px; margin-bottom: 1.5rem;"></textarea>
                    <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                        <button type="button" onclick="document.getElementById('stageForm').classList.toggle('active')" style="background: transparent; border: none; font-weight: 700; color: var(--text-muted); cursor: pointer;">Cancelar</button>
                        <button type="submit" class="btn-ver" style="width: auto; padding: 10px 32px;">Lanzar Etapa</button>
                    </div>
                </form>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @forelse($etapas as $index => $etapa)
                    <div style="display: flex; gap: 1.5rem; padding: 1.5rem; border: 1px solid var(--border); border-radius: 16px; background: white; transition: all 0.3s ease; position: relative;" class="stage-card">
                        <div style="width: 44px; height: 44px; background: {{ $index == 0 ? 'var(--primary)' : 'var(--bg-main)' }}; color: {{ $index == 0 ? 'white' : 'var(--text-muted)' }}; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                            {{ $etapa->eta_orden }}
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-weight: 700; color: var(--text-main); margin-bottom: 6px; font-size: 1.05rem;">{{ $etapa->eta_nombre }}</h4>
                            <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">{{ $etapa->eta_descripcion }}</p>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('instructor.etapas.eliminar', $etapa->eta_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta etapa?')" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" class="btn-del-hover">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 3rem; background: var(--bg-main); border-radius: 20px; border: 2px dashed var(--border);">
                        <i class="fas fa-project-diagram" style="font-size: 3rem; color: var(--border); margin-bottom: 1.5rem;"></i>
                        <h4 style="color: var(--text-muted); font-weight: 600;">Comienza definiendo el plan de trabajo para que los aprendices puedan entregar evidencias.</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar Management Pillar -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 2rem;">
        
        <!-- Quick Stats -->
        <div class="glass-card" style="padding: 1.5rem; text-align: center;">
            <p style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: var(--text-muted); margin-bottom: 1rem;">Estado del Proyecto</p>
            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 1rem; padding: 8px 20px; width: 100%;">
                 <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ $proyecto->pro_estado }}
            </span>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 1.5rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                <div>
                    <p style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">{{ $integrantes->count() }}</p>
                    <p style="font-size: 0.7rem; color: var(--text-muted);">Equipo</p>
                </div>
                <div>
                    <p style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">{{ $etapas->count() }}</p>
                    <p style="font-size: 0.7rem; color: var(--text-muted);">Etapas</p>
                </div>
            </div>
        </div>

        <!-- Management Suite -->
        <div class="glass-card" style="padding: 1.5rem;">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.25rem;">Suite de Seguimiento</h4>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('instructor.reporte', $proyecto->pro_id) }}" class="btn-ver" style="justify-content: center; background: #3b82f6; width: 100%; padding: 12px; border-radius: 12px;">
                    <i class="fas fa-chart-bar" style="margin-right: 10px;"></i> Dashboard de Métricas
                </a>
                <a href="{{ route('instructor.evidencias.ver', $proyecto->pro_id) }}" class="btn-ver" style="justify-content: center; width: 100%; padding: 12px; border-radius: 12px;">
                    <i class="fas fa-tasks" style="margin-right: 10px;"></i> Calificar Entregas
                </a>
            </div>
        </div>

        <!-- Postulations Pool -->
        <div class="glass-card" style="padding: 1.5rem;">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.25rem;">Nuevos Postulantes ({{ $postulaciones->where('pos_estado', 'Pendiente')->count() }})</h4>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @forelse($postulaciones->where('pos_estado', 'Pendiente') as $p)
                    <div style="padding: 12px; background: var(--bg-main); border-radius: 12px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">
                                {{ substr($p->apr_nombre, 0, 1) }}
                            </div>
                            <div style="overflow: hidden;">
                                <p style="font-size: 0.85rem; font-weight: 700; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->apr_nombre }}</p>
                                <p style="font-size: 0.7rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->apr_programa }}</p>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <form action="{{ route('instructor.postulaciones.estado', $p->pos_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="Aprobada">
                                <button type="submit" style="width: 100%; background: var(--primary); color: white; border: none; padding: 6px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer;">Aceptar</button>
                            </form>
                            <form action="{{ route('instructor.postulaciones.estado', $p->pos_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="Rechazada">
                                <button type="submit" style="width: 100%; background: #ef4444; color: white; border: none; padding: 6px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer;">Omitir</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: var(--text-muted); font-size: 0.85rem; padding: 1rem;">Sin solicitudes pendientes.</p>
                @endforelse
            </div>
        </div>

        <!-- Current Team -->
        <div class="glass-card" style="padding: 1.5rem;">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.25rem;">Equipo de Trabajo ({{ $integrantes->count() }})</h4>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($integrantes as $i)
                    <div style="display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 12px; background: white; border: 1px solid var(--border);">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--bg-main); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem; border: 1px solid var(--primary);">
                            {{ substr($i->apr_nombre, 0, 1) }}
                        </div>
                        <div style="overflow: hidden;">
                            <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $i->apr_nombre }} {{ $i->apr_apellido }}</p>
                            <p style="font-size: 0.65rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $i->usr_correo }}</p>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: var(--text-muted); font-size: 0.85rem;">Equipo vacío.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .collapsible.active { display: block !important; }
    .stage-card:hover { transform: translateX(8px); border-color: var(--primary); }
    .btn-del-hover:hover { transform: scale(1.1); background: #ef4444 !important; color: white !important; }
</style>
@endsection
