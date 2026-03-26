@extends('layouts.dashboard')

@section('title', 'Empresas')
@section('page-title', 'Gestión de Empresas')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users-cog"></i> Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Proyectos
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px;">
            <div>
                <h2 style="font-size:28px; font-weight:800; letter-spacing: -1px;">Gestión de Empresas</h2>
                <p style="color:var(--text-light); font-size:15px; margin-top:4px;">Administra las empresas registradas en el sistema.</p>
            </div>
        </div>
        <div style="display: flex; gap: 16px;">
            <div style="background: linear-gradient(135deg, #3EB489 0%, #2d9a6f 100%); border-radius: 12px; padding: 16px 24px; color: white; flex: 1; box-shadow: 0 4px 12px rgba(62, 180, 137, 0.3);">
                <div style="font-size: 13px; opacity: 0.9;">Total Empresas</div>
                <div style="font-size: 28px; font-weight: 700;">{{ $empresas->count() }}</div>
            </div>
            <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; padding: 16px 24px; color: white; flex: 1; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                <div style="font-size: 13px; opacity: 0.9;">Activas</div>
                <div style="font-size: 28px; font-weight: 700;">{{ $empresas->where('emp_estado', 1)->count() }}</div>
            </div>
            <div style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); border-radius: 12px; padding: 16px 24px; color: white; flex: 1; box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);">
                <div style="font-size: 13px; opacity: 0.9;">Inactivas</div>
                <div style="font-size: 28px; font-weight: 700;">{{ $empresas->where('emp_estado', 0)->count() }}</div>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: 1px solid var(--border); border-radius: 12px;">
        <div style="padding: 24px; border-bottom: 1px solid var(--border); background: linear-gradient(to right, #f8fafc, #fff);">
            <h3 style="font-size:18px; font-weight:700; display: flex; align-items: center;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #3EB489, #2d9a6f); border-radius: 10px; margin-right: 12px;">
                    <i class="fas fa-building" style="color: white; font-size: 16px;"></i>
                </span>
                Empresas Aliadas
            </h3>
        </div>
        <div class="table-container" style="border:none; border-radius:0;">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">NIT</th>
                        <th>Nombre</th>
                        <th>Representante</th>
                        <th>Correo</th>
                        <th style="width: 100px;">Estado</th>
                        <th style="width: 130px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empresas as $e)
                        <tr>
                            <td style="font-weight: 600; color: #3EB489;">{{ $e->emp_nit }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #e0f2e9, #d1ede5); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-building" style="color: #3EB489; font-size: 16px;"></i>
                                    </div>
                                    <span style="font-weight: 600;">{{ $e->emp_nombre }}</span>
                                </div>
                            </td>
                            <td style="color: var(--text-light);">
                                <i class="fas fa-user-tie" style="margin-right: 8px; color: #9ca3af;"></i>
                                {{ $e->emp_representante }}
                            </td>
                            <td style="font-size: 13px; color: #6b7280;">
                                <i class="fas fa-envelope" style="margin-right: 6px; color: #9ca3af;"></i>
                                {{ $e->emp_correo }}
                            </td>
                            <td>
                                <span class="status-badge {{ $e->emp_estado == 1 ? 'active' : 'inactive' }}">
                                    <span class="status-dot"></span>
                                    {{ $e->emp_estado == 1 ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.empresas.estado', $e->emp_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="estado" value="{{ $e->emp_estado == 1 ? 0 : 1 }}">
                                    <button type="submit" class="btn-action {{ $e->emp_estado == 1 ? 'deactivate' : 'activate' }}">
                                        <i class="fas {{ $e->emp_estado == 1 ? 'fa-ban' : 'fa-check' }}"></i>
                                        {{ $e->emp_estado == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 60px; color: var(--text-light);">
                                <div style="font-size: 48px; margin-bottom: 16px; color: #d1d5db;">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div style="font-size: 16px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">No hay empresas registradas</div>
                                <div style="font-size: 14px; color: #9ca3af;">Las empresas aparerán aquí cuando se registren en el sistema.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-badge.active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .status-badge.active .status-dot {
            background: #10b981;
        }
        
        .status-badge.inactive .status-dot {
            background: #ef4444;
        }
        
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-action.activate {
            background: linear-gradient(135deg, #3EB489, #2d9a6f);
            color: white;
        }
        
        .btn-action.activate:hover {
            background: linear-gradient(135deg, #2d9a6f, #238b5d);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(62, 180, 137, 0.3);
        }
        
        .btn-action.deactivate {
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
        
        .btn-action.deactivate:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }
        
        .styled-table tbody tr {
            transition: background 0.2s;
        }
        
        .styled-table tbody tr:hover {
            background: #f9fafb;
        }
    </style>
@endsection
