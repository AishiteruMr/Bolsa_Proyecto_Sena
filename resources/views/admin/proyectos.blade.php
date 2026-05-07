@extends('layouts.dashboard')

@section('title', 'Banco de Proyectos - Admin')
@section('page-title', 'Banco de Proyectos')

@section('styles')
    @vite(['resources/css/admin.css'])
@endsection
@section('sidebar-nav')
    @include('admin.partials.sidebar-nav')
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
                <div class="admin-filter-grid" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 16px; align-items: end;">
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
                @php
                    $hasCalidad = !empty($p->calidad_aprobada);
                    $statusStyles = match($p->estado) {
                        'completado' => ['bg' => '#065f46', 'color' => '#ffffff', 'icon' => 'fa-check'],
                        'aprobado' => ['bg' => '#10b981', 'color' => '#ffffff', 'icon' => 'fa-check'],
                        'pendiente' => ['bg' => '#f59e0b', 'color' => '#ffffff', 'icon' => 'fa-clock'],
                        'rechazado' => ['bg' => '#ef4444', 'color' => '#ffffff', 'icon' => 'fa-ban'],
                        'cerrado' => ['bg' => '#64748b', 'color' => '#ffffff', 'icon' => 'fa-lock'],
                        'en_progreso' => ['bg' => '#3b82f6', 'color' => '#ffffff', 'icon' => 'fa-spinner'],
                        default => ['bg' => '#64748b', 'color' => '#ffffff', 'icon' => 'fa-info-circle']
                    };
                @endphp

                <div class="admin-project-card-header">
                    <span class="admin-project-badge" style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }};">
                        <i class="fas {{ $statusStyles['icon'] }}"></i>
                        {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                    </span>
                    <h3>{{ Str::limit($p->titulo, 55) }}</h3>
                    <p class="admin-project-company">
                        <i class="fas fa-building" style="font-size: 10px; opacity: 0.5;"></i>
                        {{ $p->empresa_nombre }}
                    </p>
                </div>

                <div class="admin-project-card-body">
                    <div class="admin-mentor-section">
                        <div class="admin-mentor-header">
                            <span class="admin-mentor-label">Mentor Asignado</span>
                            @if(!$hasCalidad)
                                <span class="admin-mentor-badge status-pending-validation">Pendiente Validación</span>
                            @elseif($p->instructor_nombre)
                                <span class="admin-mentor-badge status-assigned">Asignado</span>
                            @else
                                <span class="admin-mentor-badge status-unassigned">Sin Asignar</span>
                            @endif
                        </div>
                        
                        <form action="{{ route('admin.proyectos.asignar', $p->id) }}" method="POST">
                            @csrf
                            <div class="admin-mentor-form">
                                <select name="instructor_usuario_id" class="admin-mentor-select" required {{ !$hasCalidad ? 'disabled' : '' }}>
                                    <option value="" disabled selected>{{ $hasCalidad ? 'Seleccionar Instructor...' : 'Validar calidad primero' }}</option>
                                    @if($hasCalidad)
                                        @foreach($instructores as $ins)
                                            <option value="{{ $ins->usuario->id ?? '' }}" {{ $p->instructor_usuario_id == ($ins->usuario->id ?? '') ? 'selected' : '' }}>
                                                {{ $ins->nombres }} {{ $ins->apellidos }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <button type="submit" class="admin-mentor-save" {{ !$hasCalidad ? 'disabled' : '' }} title="{{ $hasCalidad ? 'Guardar asignación' : 'Valida la calidad del proyecto primero' }}">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="admin-project-card-footer">
                    <div class="admin-card-actions" style="grid-template-columns: {{ $p->estado == 'aprobado' ? '1fr 1fr' : '1fr' }};">
                        <a href="{{ route('admin.proyectos.revisar', $p->id) }}" class="admin-action-btn primary">
                            Ver Detalles <i class="fas fa-arrow-right"></i>
                        </a>
                        @if($p->estado == 'aprobado')
                        <form action="{{ route('admin.proyectos.estado', $p->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="estado" value="cerrado">
                            <button type="submit" class="admin-action-btn danger">
                                Pausar Proyecto <i class="fas fa-pause"></i>
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
