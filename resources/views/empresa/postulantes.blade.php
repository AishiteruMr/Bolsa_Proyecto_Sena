@extends('layouts.dashboard')

@section('title', 'Postulantes')
@section('page-title', 'Candidatos al Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    @vite(['resources/css/empresa.css'])
    <style>
        .filter-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        .filter-tab {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            border: 1.5px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .filter-tab:hover {
            transform: translateY(-1px);
        }
        .filter-tab-active {
            border-color: #3eb489;
            color: #3eb489;
            background: rgba(62,180,137,0.08);
        }
        .filter-tab-inactive {
            background: #f8fafc;
            color: #64748b;
            border-color: #e2e8f0;
        }
        .filter-tab-inactive:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        .profile-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 10000;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(4px);
        }
        .profile-modal.open {
            display: flex;
        }
        .profile-modal-content {
            background: #fff;
            border-radius: 24px;
            padding: 36px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 24px 64px rgba(0,0,0,0.18);
            position: relative;
            animation: fadeIn 0.3s ease;
        }
        .profile-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #f8fafc;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s;
        }
        .profile-modal-close:hover {
            background: #f1f5f9;
            color: #1e293b;
        }
        .stat-item {
            background: #f8fafc;
            padding: 14px;
            border-radius: 14px;
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .stat-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .card-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            padding: 0;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            color: white;
        }
        .card-action-btn:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('empresa.dashboard')], ['label' => 'Proyectos', 'url' => route('empresa.proyectos')], ['label' => 'Postulantes']]; @endphp
@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-users"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <a href="{{ route('empresa.proyectos') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; transition: color 0.3s;">
                    <i class="fas fa-arrow-left"></i> Volver al Portafolio
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Postulantes</span>
                <span style="background: rgba(62,180,137,0.1); color: #3eb489; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ $postulantes->total() }} candidatos</span>
            </div>
            <h1 class="instructor-title">{{ $proyecto->titulo }}</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 15px; font-weight: 500;">Gestiona las postulaciones de aprendices para este proyecto.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 28px;">
        <div class="stat-item" style="border-left: 3px solid #3eb489;">
            <div class="stat-item-icon" style="background: rgba(62,180,137,0.1); color: #3eb489;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div id="count-total" style="font-size: 22px; font-weight: 800; line-height: 1.2;">{{ $counts['total'] }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.3px;">Total</div>
            </div>
        </div>
        <div class="stat-item" style="border-left: 3px solid #f59e0b;">
            <div class="stat-item-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div id="count-pendiente" style="font-size: 22px; font-weight: 800; line-height: 1.2;">{{ $counts['pendiente'] }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.3px;">Por Revisar</div>
            </div>
        </div>
        <div class="stat-item" style="border-left: 3px solid #10b981;">
            <div class="stat-item-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div id="count-aceptada" style="font-size: 22px; font-weight: 800; line-height: 1.2;">{{ $counts['aceptada'] }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.3px;">Aprobados</div>
            </div>
        </div>
        <div class="stat-item" style="border-left: 3px solid #ef4444;">
            <div class="stat-item-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <div id="count-rechazada" style="font-size: 22px; font-weight: 800; line-height: 1.2;">{{ $counts['rechazada'] }}</div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.3px;">Rechazados</div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="{{ route('empresa.proyectos.postulantes', $proyecto->id) }}" class="filter-tab filter-tab-ajax {{ !$currentFilter ? 'filter-tab-active' : 'filter-tab-inactive' }}" data-estado="">
            <i class="fas fa-list"></i> Todos
        </a>
        <a href="{{ route('empresa.proyectos.postulantes', ['id' => $proyecto->id, 'estado' => 'pendiente']) }}" class="filter-tab filter-tab-ajax {{ $currentFilter === 'pendiente' ? 'filter-tab-active' : 'filter-tab-inactive' }}" data-estado="pendiente">
            <i class="fas fa-clock"></i> Pendientes
        </a>
        <a href="{{ route('empresa.proyectos.postulantes', ['id' => $proyecto->id, 'estado' => 'aceptada']) }}" class="filter-tab filter-tab-ajax {{ $currentFilter === 'aceptada' ? 'filter-tab-active' : 'filter-tab-inactive' }}" data-estado="aceptada">
            <i class="fas fa-check-circle"></i> Aprobados
        </a>
        <a href="{{ route('empresa.proyectos.postulantes', ['id' => $proyecto->id, 'estado' => 'rechazada']) }}" class="filter-tab filter-tab-ajax {{ $currentFilter === 'rechazada' ? 'filter-tab-active' : 'filter-tab-inactive' }}" data-estado="rechazada">
            <i class="fas fa-times-circle"></i> Rechazados
        </a>
    </div>

    <!-- Candidates Grid -->
    <div id="postulantes-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 24px;">
        @forelse($postulantes as $p)
            @php
                $statusConfig = match($p->pos_estado) {
                    'pendiente' => ['bg' => '#f59e0b', 'border' => '#fde68a', 'text' => '#ffffff', 'icon' => 'fa-clock', 'label' => 'Por Revisar'],
                    'aceptada' => ['bg' => '#10b981', 'border' => '#bbf7d0', 'text' => '#ffffff', 'icon' => 'fa-check', 'label' => 'Aprobado'],
                    'rechazada' => ['bg' => '#ef4444', 'border' => '#fecaca', 'text' => '#ffffff', 'icon' => 'fa-times', 'label' => 'Rechazado'],
                    'en_progreso' => ['bg' => '#3b82f6', 'border' => '#bfdbfe', 'text' => '#ffffff', 'icon' => 'fa-spinner', 'label' => 'En Progreso'],
                    default => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-info-circle', 'label' => $p->pos_estado]
                };
            @endphp
            <div class="glass-card" data-pos-id="{{ $p->pos_id }}" data-pos-estado="{{ $p->pos_estado }}" style="padding: 28px; position: relative;">
                <!-- Status Ribbon -->
                <div class="status-ribbon" style="position: absolute; top: 16px; right: 16px; background: {{ $statusConfig['bg'] }}; border: 1px solid {{ $statusConfig['border'] }}; color: {{ $statusConfig['text'] }}; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas {{ $statusConfig['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $statusConfig['label'])) }}
                </div>

                <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 20px;">
                    <div style="width: 70px; height: 70px; border-radius: 20px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 800; flex-shrink: 0; box-shadow: 0 8px 20px rgba(62,180,137,0.3);">
                        {{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $p->apr_nombre ?? '' }} {{ $p->apr_apellido ?? '' }}
                        </h4>
                        <div style="font-size: 13px; color: #3eb489; font-weight: 700; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                            <i class="fas fa-graduation-cap"></i> {{ $p->apr_programa ?? 'Especialidad SENA' }}
                        </div>
                        <div style="font-size: 12px; color: var(--text-lighter); display: flex; align-items: center; gap: 8px; font-weight: 600;">
                            <i class="fas fa-envelope-open-text" style="color: #94a3b8;"></i> {{ $p->usr_correo ?? '' }}
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                    <div style="background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Fecha Aplicación</span>
                        <span style="font-size: 13px; font-weight: 700; color: var(--text);">{{ \Carbon\Carbon::parse($p->pos_fecha)->translatedFormat('d M, Y') }}</span>
                    </div>
                    <div style="background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Programa</span>
                        <span style="font-size: 13px; font-weight: 700; color: var(--text);">{{ Str::limit($p->apr_programa ?? 'N/A', 20) }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="button" class="btn-premium" style="flex: 1; justify-content: center; background: #3b82f6;" onclick="openProfileModal({{ $p->apr_id }})">
                        <i class="fas fa-user"></i> Ver Perfil
                    </button>

                    @if($p->pos_estado == 'pendiente')
                        <div class="acciones-ajax" style="display: flex; gap: 8px;">
                            <button type="button" class="card-action-btn btn-accion-ajax" data-pos-id="{{ $p->pos_id }}" data-estado="aceptada" style="background: #10b981; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);" title="Aprobar">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="card-action-btn btn-accion-ajax" data-pos-id="{{ $p->pos_id }}" data-estado="rechazada" style="background: #ef4444; box-shadow: 0 8px 16px rgba(239, 68, 68, 0.25);" title="Rechazar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 80px 40px;">
                <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3eb489; margin: 0 auto 24px; font-size: 40px;">
                    <i class="fas {{ $currentFilter ? 'fa-filter-circle-xmark' : 'fa-user-clock' }}"></i>
                </div>
                <h4 style="color: var(--text); font-size: 22px; font-weight: 800; margin-bottom: 8px;">
                    {{ $currentFilter ? 'Sin resultados' : 'Buscando el Match Perfecto' }}
                </h4>
                <p style="color: var(--text-light); font-size: 16px; max-width: 500px; margin: 0 auto;">
                    @if($currentFilter)
                        No hay postulaciones con el filtro seleccionado.
                    @else
                        Tu proyecto está en el radar de nuestros aprendices. Recibirás postulaciones pronto.
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    @if($postulantes->hasPages())
        <div id="postulantes-pagination" style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $postulantes->withQueryString()->links() }}
        </div>
    @endif

    <!-- Profile Modal -->
    <div class="profile-modal" id="profileModal">
        <div class="profile-modal-content">
            <button class="profile-modal-close" onclick="closeProfileModal()"><i class="fas fa-xmark"></i></button>
            <div id="profileModalBody" style="text-align: center;">
                <div id="pmAvatar" style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(62,180,137,0.3);"></div>
                <h3 id="pmName" style="font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 4px;"></h3>
                <div id="pmPrograma" style="font-size: 14px; color: #3eb489; font-weight: 700; margin-bottom: 4px;"></div>
                <div id="pmEmail" style="font-size: 13px; color: #94a3b8; font-weight: 600; margin-bottom: 20px;"></div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; text-align: left;">
                    <div style="background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Fecha Postulación</span>
                        <span id="pmFecha" style="font-size: 13px; font-weight: 700; color: #1e293b;"></span>
                    </div>
                    <div style="background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #f1f5f9;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; font-weight: 800; display: block; margin-bottom: 4px;">Estado</span>
                        <span id="pmEstado" style="font-size: 13px; font-weight: 700;"></span>
                    </div>
                </div>
                <div id="pmActions" style="margin-top: 24px; display: flex; gap: 12px; justify-content: center;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const profileModal = document.getElementById('profileModal');
    const profileData = @json($postulantes->items());
    const proyectoId = {{ $proyecto->id }};
    let currentFilter = '{{ $currentFilter ?? '' }}';

    const estadoMap = { pendiente: 'Pendiente', aceptada: 'Aprobado', rechazada: 'Rechazado', en_progreso: 'En Progreso' };
    const colorMap = { pendiente: '#f59e0b', aceptada: '#10b981', rechazada: '#ef4444', en_progreso: '#3b82f6' };
    const bgMap = { pendiente: '#f59e0b', aceptada: '#10b981', rechazada: '#ef4444', en_progreso: '#3b82f6' };
    const iconMap = { pendiente: 'fa-clock', aceptada: 'fa-check', rechazada: 'fa-times', en_progreso: 'fa-spinner' };

    async function cambiarEstadoPostulacion(posId, estado, label) {
        const confirmed = await ajax.confirm('¿Estás seguro de ' + label.toLowerCase() + ' esta postulación?');
        if (!confirmed) return;

        const url = '{{ route('empresa.postulaciones.estado', ['id' => '__ID__']) }}'.replace('__ID__', posId);
        ajax.post(url, { estado: estado }).then(res => {
            const data = res.data;
            ajax.showToast('success', data.message);

            const card = document.querySelector('.glass-card[data-pos-id="' + posId + '"]');
            if (card) {
                card.dataset.posEstado = estado;
                const ribbon = card.querySelector('.status-ribbon');
                if (ribbon) {
                    const sc = data.statusConfig || bgMap;
                    ribbon.style.background = sc.bg || bgMap[estado];
                    ribbon.innerHTML = '<i class="fas ' + (sc.icon || iconMap[estado]) + '"></i> ' + (sc.label || estadoMap[estado] || estado);
                }
                const acciones = card.querySelector('.acciones-ajax');
                if (acciones) acciones.remove();
            }

            if (data.estado === 'aceptada' || data.estado === 'rechazada') {
                const oldCountEl = document.getElementById('count-' + (data.estado === 'aceptada' ? 'aceptada' : 'rechazada'));
                if (oldCountEl) oldCountEl.textContent = parseInt(oldCountEl.textContent) + 1;
                const pendCountEl = document.getElementById('count-pendiente');
                if (pendCountEl && parseInt(pendCountEl.textContent) > 0) pendCountEl.textContent = parseInt(pendCountEl.textContent) - 1;
            }

            closeProfileModal();
        }).catch(err => {
            ajax.showToast('error', err.response?.data?.message || 'Error al cambiar estado.');
        });
    }

    async function cargarPostulantes(url) {
        const grid = document.getElementById('postulantes-grid');
        const pagination = document.getElementById('postulantes-pagination');
        const content = grid.innerHTML;
        grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:60px;"><i class="fas fa-spinner fa-spin" style="font-size:32px;color:#3eb489;"></i></div>';

        try {
            const res = await axios.get(url);
            const html = res.data;
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newGrid = doc.querySelector('#postulantes-grid');
            if (newGrid) grid.innerHTML = newGrid.innerHTML;
            const newPag = doc.querySelector('#postulantes-pagination');
            if (newPag) pagination.innerHTML = newPag.innerHTML;

            bindEventos();
        } catch (e) {
            grid.innerHTML = content;
            ajax.showToast('error', 'Error al cargar postulantes.');
        }
    }

    function bindEventos() {
        document.querySelectorAll('.btn-accion-ajax').forEach(btn => {
            btn.onclick = function() {
                const posId = this.dataset.posId;
                const estado = this.dataset.estado;
                const label = estado === 'aceptada' ? 'Aprobar' : 'Rechazar';
                cambiarEstadoPostulacion(posId, estado, label);
            };
        });

        document.querySelectorAll('.filter-tab-ajax').forEach(tab => {
            tab.onclick = function(e) {
                if (!this.dataset.estado) return;
                e.preventDefault();
                document.querySelectorAll('.filter-tab-ajax').forEach(t => {
                    t.classList.remove('filter-tab-active');
                    t.classList.add('filter-tab-inactive');
                });
                this.classList.add('filter-tab-active');
                this.classList.remove('filter-tab-inactive');
                currentFilter = this.dataset.estado;
                const url = '{{ route('empresa.proyectos.postulantes', ['id' => $proyecto->id]) }}' + (currentFilter ? '?estado=' + currentFilter : '');
                cargarPostulantes(url);
            };
        });

        document.querySelectorAll('#postulantes-pagination a').forEach(a => {
            a.onclick = function(e) {
                e.preventDefault();
                cargarPostulantes(this.href);
            };
        });
    }

    function openProfileModal(id) {
        const p = profileData.find(item => item.apr_id === id);
        if (!p) return;

        document.getElementById('pmAvatar').textContent = (p.apr_nombre?.[0] || 'A').toUpperCase();
        document.getElementById('pmName').textContent = (p.apr_nombre || '') + ' ' + (p.apr_apellido || '');
        document.getElementById('pmPrograma').textContent = p.apr_programa || 'Especialidad SENA';
        document.getElementById('pmEmail').innerHTML = '<i class="fas fa-envelope" style="margin-right: 6px;"></i>' + (p.usr_correo || '');
        document.getElementById('pmFecha').textContent = new Date(p.pos_fecha).toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric' });

        document.getElementById('pmEstado').innerHTML = '<span style="color:' + (colorMap[p.pos_estado] || '#64748b') + ';">' + (estadoMap[p.pos_estado] || p.pos_estado) + '</span>';

        const actions = document.getElementById('pmActions');
        actions.innerHTML = '';
        if (p.pos_estado === 'pendiente') {
            const aprobarBtn = document.createElement('button');
            aprobarBtn.className = 'btn-premium';
            aprobarBtn.style.cssText = 'background: #10b981; box-shadow: 0 8px 16px rgba(16,185,129,0.25);';
            aprobarBtn.innerHTML = '<i class="fas fa-check"></i> Aprobar';
            aprobarBtn.onclick = () => cambiarEstadoPostulacion(p.pos_id, 'aceptada', 'Aprobar');
            actions.appendChild(aprobarBtn);

            const rechazarBtn = document.createElement('button');
            rechazarBtn.className = 'btn-premium';
            rechazarBtn.style.cssText = 'background: #ef4444; box-shadow: 0 8px 16px rgba(239,68,68,0.25);';
            rechazarBtn.innerHTML = '<i class="fas fa-times"></i> Rechazar';
            rechazarBtn.onclick = () => cambiarEstadoPostulacion(p.pos_id, 'rechazada', 'Rechazar');
            actions.appendChild(rechazarBtn);
        }

        profileModal.classList.add('open');
    }

    function closeProfileModal() {
        profileModal.classList.remove('open');
    }

    profileModal.addEventListener('click', function(e) {
        if (e.target === this) closeProfileModal();
    });

    bindEventos();
</script>
@endsection