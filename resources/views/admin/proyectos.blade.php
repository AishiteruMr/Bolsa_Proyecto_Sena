@extends('layouts.dashboard')

@section('title', 'Banco de Proyectos - Admin')
@section('page-title', 'Banco de Proyectos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection
@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
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
        <!-- Header tipo dashboard (icono + degradado suave) -->
        <div class="admin-header-master" style="margin-bottom:18px;">
            <div class="admin-header-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                    <span class="admin-badge-hub">Banco Proyectos</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;">Panel de administración</span>
                </div>
                <h1 class="admin-header-title">Control Central de <span style="color: var(--primary);">Proyectos</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 16px; max-width: 700px; font-weight: 500;">Monitoreo global y asignación estratégica de instructores.</p>
            </div>
        </div>

        <!-- FILTROS DE BÚSQUEDA -->
        <div class="glass-card" style="padding: 24px; margin-bottom: 24px; background: white;">
            <form method="GET" action="{{ route('admin.proyectos') }}">
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 16px; align-items: end;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Buscar</label>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Título, descripción o empresa..." style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Estado</label>
                        <select name="estado" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                            <option value="">Todos</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            <option value="en_progreso" {{ request('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Categoría</label>
                        <select name="categoria" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                            <option value="">Todas</option>
                            @foreach($categorias ?? [] as $cat)
                                <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                </div>
                <div style="display: flex; gap: 12px; margin-top: 16px; justify-content: flex-end;">
                    @if(request()->has('buscar') || request()->has('estado') || request()->has('categoria') || request()->has('fecha_inicio') || request()->has('fecha_fin'))
                        <a href="{{ route('admin.proyectos') }}" class="btn-premium" style="padding: 12px 20px; background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; box-shadow: none; font-size: 13px;">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    @endif
                    <button type="submit" class="btn-premium" style="padding: 12px 24px; font-size: 13px;">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>

        @if(request()->has('buscar') || request()->has('estado') || request()->has('categoria') || request()->has('fecha_inicio') || request()->has('fecha_fin'))
        <div style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 13px; font-weight: 700; color: var(--primary);">
                <i class="fas fa-filter"></i> Mostrando {{ $proyectos->count() }} resultado(s)
            </span>
        </div>
        @endif

        <div class="admin-project-grid">
            @forelse($proyectos as $p)
            <div class="glass-card admin-project-card">
                {{-- Header Decorativo --}}
                <div class="admin-project-card-header">
                    <div style="position:relative; z-index:1;">
                        <div style="display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                            @php
                                $statusStyles = match($p->estado) {
                                    'aprobado' => ['bg' => 'linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%)', 'color' => '#fff', 'icon' => 'fa-check-circle'],
                                    'pendiente' => ['bg' => '#fff7ed', 'color' => '#ea580c', 'icon' => 'fa-clock'],
                                    'rechazado' => ['bg' => '#fef2f2', 'color' => '#dc2626', 'icon' => 'fa-times-circle'],
                                    default => ['bg' => '#f8fafc', 'color' => '#64748b', 'icon' => 'fa-info-circle']
                                };
                            @endphp
                            <span class="admin-project-badge" style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }};">
                                <i class="fas {{ $statusStyles['icon'] }}"></i>
                                {{ $p->estado }}
                            </span>
                            @if($p->categoria)
                                <span style="background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 800;">
                                    <i class="fas fa-tag" style="margin-right: 4px;"></i>{{ ucfirst($p->categoria) }}
                                </span>
                            @endif
                            @if($p->fecha_publicacion)
                                <span style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 700;">
                                    <i class="far fa-calendar" style="margin-right: 4px;"></i>{{ \Carbon\Carbon::parse($p->fecha_publicacion)->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                        <h3 class="admin-project-title" style="font-size:1.25rem; font-weight:800; line-height:1.3; letter-spacing: -0.5px;">{{ Str::limit($p->titulo, 50) }}</h3>
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
                            <span style="font-size:1rem; font-weight:800; color: var(--text);">{{ $p->empresa_nombre }}</span>
                        </div>
                    </div>

                    <div class="admin-mentor-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <span style="font-size:12px; font-weight:800; color:var(--text-light);"><i class="fas fa-user-shield" style="margin-right:6px; color:var(--primary);"></i> Mentor Asignado</span>
                            @if($p->instructor_nombre)
                                <span class="aprendiz-badge-portal" style="background: var(--primary-soft); color: var(--primary); border-color: transparent; padding: 4px 12px; border-radius: 20px; font-size: 11px;">{{ $p->instructor_nombre }}</span>
                            @else
                                <span class="aprendiz-badge-portal inline-pill inline-pill--muted" style="background:#fff7ed;color:#f97316;border-color:transparent;padding:4px 12px;border-radius:20px;font-size:11px;">SIN ASIGNAR</span>
                            @endif
                        </div>

                        <form action="{{ route('admin.proyectos.asignar', $p->id) }}" method="POST">
                            @csrf
                            <div style="display:flex; gap:10px;">
                                <select name="instructor_usuario_id" class="admin-mentor-select" required>
                                    <option value="" disabled selected>Seleccionar Instructor...</option>
                                    @foreach($instructores as $ins)
                                        <option value="{{ $ins->usuario->id ?? '' }}" {{ $p->instructor_usuario_id == ($ins->usuario->id ?? '') ? 'selected' : '' }}>
                                            {{ $ins->nombres }} {{ $ins->apellidos }}
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
                        <a href="{{ route('admin.proyectos.revisar', $p->id) }}" class="btn-premium" style="justify-content:center; padding: 12px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; font-size: 13px; box-shadow: none;">
                            <i class="fas fa-file-shield" style="margin-right: 8px; color: var(--primary);"></i> Auditoría
                        </a>

                        @if($p->estado == 'aprobado')
                        <form action="{{ route('admin.proyectos.estado', $p->id) }}" method="POST" style="width: 100%;">
                            @csrf
                            <input type="hidden" name="estado" value="cerrado">
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
