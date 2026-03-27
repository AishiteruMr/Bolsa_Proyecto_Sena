@extends('layouts.dashboard')

@section('title', 'Banco de Proyectos - Admin')
@section('page-title', 'Banco de Proyectos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection
@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
@endsection

@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-page-header">
            <div>
                <h2 class="admin-title-main">Control Central de <span style="color: var(--primary);">Proyectos</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px; font-weight: 500;">Monitoreo global y asignación estratégica de instructores.</p>
            </div>
        </div>

        <div class="admin-project-grid">
            @forelse($proyectos as $p)
            <div class="glass-card admin-project-card">
                {{-- Header Decorativo --}}
                <div class="admin-project-card-header">
                    <div style="position:relative; z-index:1;">
                        <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                            @php
                                $statusStyles = match($p->pro_estado) {
                                    'Activo' => ['bg' => 'linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%)', 'color' => '#fff', 'icon' => 'fa-check-circle'],
                                    'Pendiente' => ['bg' => '#fff7ed', 'color' => '#ea580c', 'icon' => 'fa-clock'],
                                    'Rechazado' => ['bg' => '#fef2f2', 'color' => '#dc2626', 'icon' => 'fa-times-circle'],
                                    default => ['bg' => '#f8fafc', 'color' => '#64748b', 'icon' => 'fa-info-circle']
                                };
                            @endphp
                            <span class="admin-project-badge" style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }};">
                                <i class="fas {{ $statusStyles['icon'] }}"></i>
                                {{ $p->pro_estado }}
                            </span>
                        </div>
                        <h3 style="color:#fff; font-size:1.25rem; font-weight:800; line-height:1.3; letter-spacing: -0.5px;">{{ Str::limit($p->pro_titulo_proyecto, 50) }}</h3>
                    </div>
                    <i class="fas fa-rocket" style="position:absolute; right:-20px; bottom:-20px; font-size:120px; color:rgba(255,255,255,0.05); transform: rotate(-15deg);"></i>
                </div>

                <div class="admin-project-card-body">
                    <div style="display:flex; align-items:center; gap:16px;">
                        <div style="width:52px; height:52px; background:#f8fafc; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; border: 1px solid var(--border);">
                            <i class="fas fa-building" style="color:var(--primary); font-size: 1.3rem;"></i>
                        </div>
                        <div>
                            <span style="display:block; font-size:11px; font-weight:800; color:var(--text-lighter); text-transform:uppercase; letter-spacing: 1px; margin-bottom: 4px;">Empresa Proponente</span>
                            <span style="font-size:1rem; font-weight:800; color: var(--text);">{{ $p->emp_nombre }}</span>
                        </div>
                    </div>

                    <div class="admin-mentor-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <span style="font-size:12px; font-weight:800; color:var(--text-light);"><i class="fas fa-user-shield" style="margin-right:6px; color:var(--primary);"></i> Mentor Asignado</span>
                            @if($p->ins_nombre)
                                <span class="aprendiz-badge-portal" style="background: var(--primary-soft); color: var(--primary); border-color: transparent; padding: 4px 12px; border-radius: 20px; font-size: 11px;">{{ $p->ins_nombre }}</span>
                            @else
                                <span class="aprendiz-badge-portal" style="background: #fff7ed; color: #f97316; border-color: transparent; padding: 4px 12px; border-radius: 20px; font-size: 11px;">SIN ASIGNAR</span>
                            @endif
                        </div>

                        <form action="{{ route('admin.proyectos.asignar', $p->pro_id) }}" method="POST">
                            @csrf
                            <div style="display:flex; gap:10px;">
                                <select name="ins_usr_documento" class="admin-mentor-select" required>
                                    <option value="" disabled selected>Seleccionar Instructor...</option>
                                    @foreach($instructores as $ins)
                                        <option value="{{ $ins->usuario->usr_documento ?? '' }}" {{ $p->ins_usr_documento == ($ins->usuario->usr_documento ?? '') ? 'selected' : '' }}>
                                            {{ $ins->ins_nombre }} {{ $ins->ins_apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-premium" style="width: 48px; height: 48px; min-width: 48px; padding: 0; justify-content: center; background: #fff; color: var(--primary); border: 2px solid var(--primary-soft); box-shadow: none;" title="Actualizar Asignación">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div style="margin-top:auto; display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                        <a href="{{ route('admin.proyectos.revisar', $p->pro_id) }}" class="btn-premium" style="justify-content:center; padding: 12px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; font-size: 13px; box-shadow: none;">
                            <i class="fas fa-file-shield" style="margin-right: 8px; color: var(--primary);"></i> Auditoría
                        </a>

                        @if($p->pro_estado == 'Activo')
                        <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST" style="width: 100%;">
                            @csrf
                            <input type="hidden" name="estado" value="Inactivo">
                            <button type="submit" class="btn-premium" style="width:100%; justify-content:center; background:#fef2f2; color: #dc2626; box-shadow: none; font-size: 13px; border: 1px solid #fee2e2;">
                                <i class="fas fa-ban" style="margin-right: 8px;"></i> Pausar
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="glass-card admin-empty-state">
                <div style="width: 90px; height: 90px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #cbd5e1; border: 1px solid var(--border);">
                    <i class="fas fa-folder-open" style="font-size:36px;"></i>
                </div>
                <h3 style="font-size:22px; font-weight:800; color:var(--text); margin-bottom: 8px;">No hay registros</h3>
                <p style="color: var(--text-light); font-size:16px; font-weight: 500;">Aún no se han recibido propuestas de proyectos en la plataforma.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
