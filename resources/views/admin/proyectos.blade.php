@extends('layouts.dashboard')

@section('title', 'Banco de Proyectos - Admin')
@section('page-title', 'Banco de Proyectos')

@section('styles')
    @vite(['resources/css/admin.css'])
@endsection
@section('scripts')
@parent
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('adminSearchInput');
    if (searchInput) {
        // Keyboard shortcut "/" to focus search
        document.addEventListener('keydown', function (e) {
            if (e.key === '/' && !['INPUT', 'SELECT', 'TEXTAREA'].includes(e.target.tagName)) {
                e.preventDefault();
                searchInput.focus();
            }
        });
        // Escape to blur
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') searchInput.blur();
        });
    }
});
</script>
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
        <div class="admin-filter-section" id="adminFilterSection">
            <form method="GET" action="{{ route('admin.proyectos') }}">
                <!-- Tier 1: Search + Quick filters -->
                <div class="admin-filter-main">
                    <div class="admin-filter-search-wrap">
                        <i class="fas fa-search admin-search-icon"></i>
                        <input
                            type="text"
                            name="buscar"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar por título, empresa o descripción..."
                            class="admin-filter-search-input"
                            id="adminSearchInput"
                            autocomplete="off"
                        >
                        @if(request('buscar'))
                            <a href="{{ route('admin.proyectos', array_merge(request()->except(['buscar', 'page']))) }}" class="admin-search-clear">&times;</a>
                        @endif
                        <kbd class="admin-search-hint">/</kbd>
                    </div>
                    <div class="admin-filter-badges">
                        <span class="admin-filter-badge {{ !request('estado') ? 'active' : '' }}">
                            <a href="{{ route('admin.proyectos', array_merge(request()->except(['estado', 'page']))) }}">Todos</a>
                        </span>
                        <span class="admin-filter-badge {{ request('estado') == 'pendiente' ? 'active' : '' }}" style="{{ request('estado') == 'pendiente' ? '--badge-bg: #fef3c7; --badge-color: #92400e; --badge-border: #f59e0b;' : '' }}">
                            <a href="{{ route('admin.proyectos', array_merge(request()->except(['estado', 'page']), ['estado' => request('estado') == 'pendiente' ? '' : 'pendiente'])) }}">Pendiente</a>
                        </span>
                        <span class="admin-filter-badge {{ request('estado') == 'aprobado' ? 'active' : '' }}" style="{{ request('estado') == 'aprobado' ? '--badge-bg: #d1fae5; --badge-color: #065f46; --badge-border: #10b981;' : '' }}">
                            <a href="{{ route('admin.proyectos', array_merge(request()->except(['estado', 'page']), ['estado' => request('estado') == 'aprobado' ? '' : 'aprobado'])) }}">Aprobado</a>
                        </span>
                        <span class="admin-filter-badge {{ request('estado') == 'en_progreso' ? 'active' : '' }}" style="{{ request('estado') == 'en_progreso' ? '--badge-bg: #dbeafe; --badge-color: #1e40af; --badge-border: #3b82f6;' : '' }}">
                            <a href="{{ route('admin.proyectos', array_merge(request()->except(['estado', 'page']), ['estado' => request('estado') == 'en_progreso' ? '' : 'en_progreso'])) }}">En Progreso</a>
                        </span>
                        <span class="admin-filter-badge {{ request('estado') == 'rechazado' ? 'active' : '' }}" style="{{ request('estado') == 'rechazado' ? '--badge-bg: #fee2e2; --badge-color: #991b1b; --badge-border: #ef4444;' : '' }}">
                            <a href="{{ route('admin.proyectos', array_merge(request()->except(['estado', 'page']), ['estado' => request('estado') == 'rechazado' ? '' : 'rechazado'])) }}">Rechazado</a>
                        </span>
                        <span class="admin-filter-badge {{ request('estado') == 'cerrado' ? 'active' : '' }}" style="{{ request('estado') == 'cerrado' ? '--badge-bg: #f1f5f9; --badge-color: #475569; --badge-border: #64748b;' : '' }}">
                            <a href="{{ route('admin.proyectos', array_merge(request()->except(['estado', 'page']), ['estado' => request('estado') == 'cerrado' ? '' : 'cerrado'])) }}">Cerrado</a>
                        </span>
                    </div>
                </div>

                <!-- Tier 2: Advanced filters (collapsible) -->
                <div class="admin-filter-advanced-toggle" onclick="this.classList.toggle('open'); document.getElementById('adminAdvancedFilters').classList.toggle('visible')">
                    <i class="fas fa-sliders-h"></i>
                    <span>Filtros avanzados</span>
                    <i class="fas fa-chevron-down adv-arrow"></i>
                </div>
                <div class="admin-filter-advanced" id="adminAdvancedFilters">
                    <div class="admin-filter-advanced-grid">
                        <div class="admin-filter-group">
                            <label class="admin-filter-label"><i class="fas fa-tag"></i> Categoría</label>
                            <div class="admin-filter-input-wrap">
                                <select name="categoria" class="admin-filter-select">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categorias ?? [] as $cat)
                                        <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                        </div>
                        <div class="admin-filter-group">
                            <label class="admin-filter-label"><i class="fas fa-calendar-alt"></i> Desde</label>
                            <div class="admin-filter-input-wrap">
                                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="admin-filter-input">
                            </div>
                        </div>
                        <div class="admin-filter-group">
                            <label class="admin-filter-label"><i class="fas fa-calendar-check"></i> Hasta</label>
                            <div class="admin-filter-input-wrap">
                                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="admin-filter-input">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer: results + actions -->
                <div class="admin-filter-footer">
                    <div class="admin-filter-count">
                        <i class="fas fa-layer-group"></i>
                        <span><strong>{{ $proyectos->count() }}</strong> proyecto(s) encontrados</span>
                        @if(request()->hasAny(['buscar', 'estado', 'categoria', 'fecha_inicio', 'fecha_fin']))
                            <span class="admin-filter-count-dot"></span>
                            <span class="admin-filter-count-active">Filtro activo</span>
                        @endif
                    </div>
                    <div class="admin-filter-footer-actions">
                        @if(request()->hasAny(['buscar', 'estado', 'categoria', 'fecha_inicio', 'fecha_fin']))
                            <a href="{{ route('admin.proyectos') }}" class="admin-filter-footer-btn clear">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        @endif
                        <button type="submit" class="admin-filter-footer-btn apply">
                            <i class="fas fa-search"></i> Aplicar filtros
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="admin-project-grid">
            @forelse($proyectos as $p)
            @php
                $hasCalidad = !empty($p->calidad_aprobada);
                $isPendiente = $p->estado === 'pendiente';
                $isAprobado = $p->estado === 'aprobado';
                $isEnProgreso = $p->estado === 'en_progreso';
                $isRechazado = $p->estado === 'rechazado';
                $isCerrado = $p->estado === 'cerrado';
                $isCompletado = $p->estado === 'completado';
                $statusStyles = match($p->estado) {
                    'completado' => ['bg' => '#065f46', 'color' => '#ffffff', 'icon' => 'fa-check', 'bar' => '#065f46'],
                    'aprobado' => ['bg' => '#10b981', 'color' => '#ffffff', 'icon' => 'fa-check', 'bar' => '#10b981'],
                    'pendiente' => ['bg' => '#f59e0b', 'color' => '#ffffff', 'icon' => 'fa-clock', 'bar' => '#f59e0b'],
                    'rechazado' => ['bg' => '#ef4444', 'color' => '#ffffff', 'icon' => 'fa-ban', 'bar' => '#ef4444'],
                    'cerrado' => ['bg' => '#64748b', 'color' => '#ffffff', 'icon' => 'fa-lock', 'bar' => '#64748b'],
                    'en_progreso' => ['bg' => '#3b82f6', 'color' => '#ffffff', 'icon' => 'fa-spinner', 'bar' => '#3b82f6'],
                    default => ['bg' => '#64748b', 'color' => '#ffffff', 'icon' => 'fa-info-circle', 'bar' => '#64748b']
                };
                $catColors = match(strtolower($p->categoria ?? '')) {
                    'tecnologia' => ['bg' => '#e0f2fe', 'text' => '#0369a1'],
                    'diseño' => ['bg' => '#fae8ff', 'text' => '#a21caf'],
                    'marketing' => ['bg' => '#fef3c7', 'text' => '#b45309'],
                    'ingenieria' => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
                    'educacion' => ['bg' => '#d1fae5', 'text' => '#047857'],
                    'salud' => ['bg' => '#fce7f3', 'text' => '#be185d'],
                    'comunicacion' => ['bg' => '#ede9fe', 'text' => '#6d28d9'],
                    'finanzas' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                    default => ['bg' => '#f1f5f9', 'text' => '#475569']
                };
                $showTwoActions = $isAprobado || $isPendiente || $isEnProgreso;
            @endphp
            <div class="glass-card admin-project-card" data-estado="{{ $p->estado }}">
                <div class="admin-card-bar" style="background: {{ $statusStyles['bar'] }};"></div>

                <div class="admin-project-card-header">
                    <div class="admin-card-top-row">
                        <span class="admin-project-badge" style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }};">
                            <i class="fas {{ $statusStyles['icon'] }}"></i>
                            {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                        </span>
                        @if($hasCalidad)
                            <span class="admin-calidad-badge" title="Calidad aprobada">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                        @else
                            <span class="admin-calidad-badge no" title="Pendiente de validación de calidad">
                                <i class="fas fa-hourglass-half"></i>
                            </span>
                        @endif
                    </div>
                    <h3>{{ Str::limit($p->titulo, 55) }}</h3>
                    <p class="admin-project-company">
                        <i class="fas fa-building"></i>
                        {{ $p->empresa_nombre }}
                    </p>
                </div>

                <div class="admin-project-card-meta">
                    <span class="admin-meta-item">
                        <i class="fas fa-tag"></i>
                        <span class="admin-cat-pill" style="background: {{ $catColors['bg'] }}; color: {{ $catColors['text'] }};">
                            {{ ucfirst($p->categoria ?? 'Sin categoría') }}
                        </span>
                    </span>
                    <span class="admin-meta-item">
                        <i class="fas fa-users"></i>
                        {{ $p->postulaciones_count ?? 0 }} postulante(s)
                    </span>
                    <span class="admin-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($p->fecha_publicacion)->format('d/m/Y') }}
                    </span>
                </div>

                <div class="admin-project-card-body">
                    @if($isEnProgreso && $p->instructor_nombre)
                        <div class="admin-progress-info">
                            <div class="admin-progress-instructor">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span><strong>Instructor:</strong> {{ $p->instructor_nombre }}</span>
                            </div>
                            <div class="admin-progress-aprendices">
                                <i class="fas fa-user-graduate"></i>
                                <span><strong>Aprendices:</strong> {{ $p->postulaciones_aprobadas_count ?? 0 }} asignado(s)</span>
                            </div>
                        </div>
                    @else
                        <div class="admin-mentor-section">
                            <div class="admin-mentor-header">
                                <span class="admin-mentor-label">
                                    <i class="fas fa-chalkboard-teacher"></i> Mentor Asignado
                                </span>
                                @if($isRechazado || $isCerrado || $isCompletado)
                                    <span class="admin-mentor-badge status-unassigned"><i class="fas fa-ban"></i> No aplica</span>
                                @elseif(!$hasCalidad)
                                    <span class="admin-mentor-badge status-pending-validation"><i class="fas fa-exclamation-triangle"></i> Pendiente Validación</span>
                                @elseif($p->instructor_nombre)
                                    <span class="admin-mentor-badge status-assigned"><i class="fas fa-check-circle"></i> Asignado</span>
                                @else
                                    <span class="admin-mentor-badge status-unassigned"><i class="fas fa-user-slash"></i> Sin Asignar</span>
                                @endif
                            </div>

                            @if(!$isRechazado && !$isCerrado && !$isCompletado && !$isEnProgreso)
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
                            @endif
                        </div>
                    @endif
                </div>

                <div class="admin-project-card-footer">
                    <div class="admin-card-actions" style="grid-template-columns: {{ $showTwoActions ? '1fr 1fr' : '1fr' }};">
                        <a href="{{ route('admin.proyectos.revisar', $p->id) }}" class="admin-action-btn primary">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </a>

                        @if($isPendiente)
                        <form action="{{ route('admin.proyectos.estado', $p->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de rechazar este proyecto? Esta acción no se puede deshacer.');">
                            @csrf
                            <input type="hidden" name="estado" value="rechazado">
                            <button type="submit" class="admin-action-btn danger">
                                <i class="fas fa-ban"></i> Rechazar
                            </button>
                        </form>
                        @elseif($isAprobado)
                        <form action="{{ route('admin.proyectos.estado', $p->id) }}" method="POST" onsubmit="return confirm('¿Pausar este proyecto? Se desasignará el instructor y notificará a la empresa.');">
                            @csrf
                            <input type="hidden" name="estado" value="cerrado">
                            <button type="submit" class="admin-action-btn danger">
                                <i class="fas fa-pause"></i> Pausar
                            </button>
                        </form>
                        @elseif($isEnProgreso)
                        <form action="{{ route('admin.proyectos.estado', $p->id) }}" method="POST" onsubmit="return confirm('¿Cerrar este proyecto? Se desasignará el instructor y notificará a la empresa.');">
                            @csrf
                            <input type="hidden" name="estado" value="cerrado">
                            <button type="submit" class="admin-action-btn danger">
                                <i class="fas fa-lock"></i> Cerrar
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="glass-card admin-empty-state">
                <div class="admin-empty-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3>No hay registros</h3>
                <p>Aún no se han recibido propuestas de proyectos en la plataforma.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
