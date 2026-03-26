@extends('layouts.dashboard')
@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')

@section('sidebar-nav')
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}"><i class="fas fa-project-diagram"></i> Mis Proyectos</a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i> Publicar Proyecto</a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}"><i class="fas fa-building"></i> Perfil Empresa</a>
@endsection

@section('content')
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="font-size:28px; font-weight:800; letter-spacing: -1px;">Mis Proyectos</h2>
            <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Gestiona todos tus proyectos publicados.</p>
        </div>
        <a href="{{ route('empresa.proyectos.crear') }}" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px;">
            <i class="fas fa-plus"></i> Nuevo Proyecto
        </a>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px;">
        <div style="background: linear-gradient(135deg, #3EB489, #2d9a6f); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 24px rgba(62, 180, 137, 0.25);">
            <div style="font-size: 13px; opacity: 0.9; margin-bottom: 8px;">Total Proyectos</div>
            <div style="font-size: 32px; font-weight: 800;">{{ $proyectos->count() }}</div>
        </div>
        <div style="background: white; border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Activos</div>
            <div style="font-size: 32px; font-weight: 800; color: #10b981;">{{ $proyectos->where('pro_estado', 'Activo')->count() }}</div>
        </div>
        <div style="background: white; border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Pendientes</div>
            <div style="font-size: 32px; font-weight: 800; color: #f59e0b;">{{ $proyectos->where('pro_estado', 'Pendiente')->count() }}</div>
        </div>
        <div style="background: white; border: 1px solid var(--border); border-radius: 16px; padding: 24px;">
            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Finalizados</div>
            <div style="font-size: 32px; font-weight: 800; color: #6b7280;">{{ $proyectos->where('pro_estado', 'Finalizado')->count() }}</div>
        </div>
    </div>

    <div class="card" style="border-radius: 16px; overflow: hidden; border: 1px solid var(--border);">
        <div style="background: linear-gradient(to right, #f8fafc, #fff); padding: 24px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 12px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: linear-gradient(135deg, #3EB489, #2d9a6f); border-radius: 12px;">
                    <i class="fas fa-project-diagram" style="color: white; font-size: 18px;"></i>
                </span>
                Lista de Proyectos
            </h3>
        </div>
        
        @if($proyectos->isNotEmpty())
            <table class="styled-table-empresa">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Duración</th>
                        <th>Fecha Publicación</th>
                        <th style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proyectos as $proyecto)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #e0f2e9, #d1ede5); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-briefcase" style="color: #3EB489; font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b;">{{ Str::limit($proyecto->pro_titulo_proyecto, 35) }}</div>
                                        <div style="font-size: 11px; color: #94a3b8;">{{ $proyecto->pro_categoria }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #f1f5f9; color: #64748b;">
                                    {{ $proyecto->pro_categoria }}
                                </span>
                            </td>
                            <td>
                                @if($proyecto->pro_estado === 'Activo')
                                    <span class="status-badge active"><span class="status-dot"></span> Activo</span>
                                @elseif($proyecto->pro_estado === 'Pendiente')
                                    <span class="status-badge pending"><span class="status-dot"></span> Pendiente</span>
                                @else
                                    <span class="status-badge finished"><span class="status-dot"></span> Finalizado</span>
                                @endif
                            </td>
                            <td style="color: #64748b; font-size: 13px;">
                                <i class="fas fa-clock" style="margin-right: 6px; color: #94a3b8;"></i>
                                {{ $proyecto->pro_duracion_estimada }} días
                            </td>
                            <td style="font-size: 13px; color: #64748b;">
                                <i class="fas fa-calendar" style="margin-right: 6px; color: #94a3b8;"></i>
                                {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d M, Y') }}
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('empresa.proyectos.edit', $proyecto->pro_id) }}" class="btn-icon-edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('empresa.proyectos.destroy', $proyecto->pro_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este proyecto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 80px 24px; color: #999;">
                <div style="width: 100px; height: 100px; margin: 0 auto 24px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-folder-open" style="font-size: 40px; color: #94a3b8;"></i>
                </div>
                <div style="font-size: 18px; font-weight: 600; color: #64748b; margin-bottom: 8px;">No hay proyectos publicados</div>
                <p style="font-size: 14px; color: #94a3b8; margin-bottom: 24px;">Crea tu primer proyecto para comenzar a recibir postulaciones.</p>
                <a href="{{ route('empresa.proyectos.crear') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #3EB489, #2d9a6f); color: white; padding: 14px 28px; border-radius: 12px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-plus"></i> Publicar Primer Proyecto
                </a>
            </div>
        @endif
    </div>

    <style>
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-badge.active { background: #d1fae5; color: #065f46; }
        .status-badge.pending { background: #fef3c7; color: #92400e; }
        .status-badge.finished { background: #f3f4f6; color: #6b7280; }
        
        .status-dot { width: 8px; height: 8px; border-radius: 50%; }
        .status-badge.active .status-dot { background: #10b981; }
        .status-badge.pending .status-dot { background: #f59e0b; }
        .status-badge.finished .status-dot { background: #9ca3af; }
        
        .btn-icon-edit {
            width: 38px; height: 38px; border-radius: 10px;
            background: #f1f5f9; border: none; color: #64748b;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-icon-edit:hover { background: #3EB489; color: white; }
        
        .btn-icon-delete {
            width: 38px; height: 38px; border-radius: 10px;
            background: #fef2f2; border: none; color: #ef4444;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-icon-delete:hover { background: #ef4444; color: white; }
        
        .styled-table-empresa tbody tr {
            transition: background 0.2s;
        }
        .styled-table-empresa tbody tr:hover {
            background: #f9fafb;
        }
    </style>
@endsection
