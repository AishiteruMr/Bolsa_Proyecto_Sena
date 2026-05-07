@extends('layouts.dashboard')

@section('title', 'Notificaciones')
@section('page-title', 'Mis Notificaciones')

@section('sidebar-nav')
    @switch(session('rol'))
        @case(1)
            <span class="nav-label">Principal</span>
            <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> <span>Principal</span>
            </a>
            <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i> <span>Explorar Proyectos</span>
            </a>
            <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
                <i class="fas fa-paper-plane"></i> <span>Mis Postulaciones</span>
            </a>
            <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
                <i class="fas fa-history"></i> <span>Historial</span>
            </a>
            <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> <span>Mis Entregas</span>
            </a>
            <span class="nav-label">Cuenta</span>
            <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
                <i class="fas fa-user"></i> <span>Mi Perfil</span>
            </a>
            @break
        @case(2)
            <span class="nav-label">Principal</span>
            <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Principal
            </a>
            <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos') ? 'active' : '' }}">
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
                <i class="fas fa-user-circle"></i> Perfil
            </a>
            @break
        @case(3)
            <span class="nav-label">Portal Empresa</span>
            <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Principal
            </a>
            <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
                <i class="fas fa-project-diagram"></i> Mis Proyectos
            </a>
            <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i> Publicar Proyecto
            </a>
            <span class="nav-label">Configuración</span>
            <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Perfil Empresa
            </a>
            @break
        @case(4)
            @include('admin.partials.sidebar-nav')
            @break
        @default
            <span class="nav-label">Navegación</span>
            <a href="{{ route('home') }}" class="nav-item">
                <i class="fas fa-home"></i> Inicio
            </a>
    @endswitch
@endsection

@php
    $defaultDashboard = route('home');
    if (auth()->check()) {
        $defaultDashboard = match(auth()->user()->rol_id) {
            1 => route('aprendiz.dashboard'),
            2 => route('instructor.dashboard'),
            3 => route('empresa.dashboard'),
            4 => route('admin.dashboard'),
            default => route('home'),
        };
    }
    $returnUrl = session('notificaciones_return_url', $defaultDashboard);
    $collection = $notificaciones->getCollection();
    $unreadCount = $usuario->unreadNotifications()->count();
    $readCount = $usuario->notifications()->whereNotNull('read_at')->count();
    $totalCount = $notificaciones->total();
@endphp

@section('content')
<div class="notifications-container">

    {{-- Ambient Background --}}
    <div class="notif-ambient">
        <div class="notif-blob blob-1"></div>
        <div class="notif-blob blob-2"></div>
    </div>

    {{-- HERO SECTION --}}
    <div class="notif-hero notif-animate">
        <div class="notif-hero-content">
            <h1>Mis Notificaciones</h1>
            <p>
                @if($unreadCount > 0)<span class="unread-dot"></span>@endif
                Tienes <strong id="hero-unread-count">{{ $unreadCount }}</strong> mensajes sin leer.
            </p>
        </div>
        <div class="notif-hero-actions">
            <div class="user-info-notif">
                <div class="user-avatar-notif">{{ strtoupper(substr(session('nombre', 'U'), 0, 1)) }}</div>
                <div class="user-details-notif">
                    <div class="user-name-notif">{{ session('nombre') }} {{ session('apellido') }}</div>
                    <div class="user-role-notif">
                        @switch(session('rol'))
                            @case(1) Aprendiz @break
                            @case(2) Instructor @break
                            @case(3) Empresa @break
                            @case(4) Administrador @break
                        @endswitch
                    </div>
                </div>
            </div>
            <a href="{{ $returnUrl }}" class="btn-premium outline">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            @if($unreadCount > 0)
                <button onclick="markAllAsRead()" id="mark-all-btn" class="btn-premium">
                    <i class="fas fa-check-double"></i> Marcar todas
                </button>
            @endif
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="notif-stats-grid notif-animate" style="--anim-delay: 0.1s">
        <div class="stat-card">
            <div class="stat-icon unread"><i class="fas fa-envelope-open"></i></div>
            <div class="stat-info">
                <span class="value" id="stat-unread">{{ $unreadCount }}</span>
                <span class="label">Sin leer</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon read"><i class="fas fa-envelope-open-text"></i></div>
            <div class="stat-info">
                <span class="value">{{ $readCount }}</span>
                <span class="label">Leídas</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-bell"></i></div>
            <div class="stat-info">
                <span class="value">{{ $totalCount }}</span>
                <span class="label">Total</span>
            </div>
        </div>
    </div>

    {{-- SEARCH BAR --}}
    <div class="notif-controls notif-animate" style="--anim-delay: 0.2s">
        <div class="notif-filters">
            <a href="{{ route('notificaciones.index', ['filter' => 'all']) }}" class="filter-btn {{ ($filter ?? 'all') == 'all' ? 'active' : '' }}">
                Todas <span class="count">{{ $totalCount }}</span>
            </a>
            <a href="{{ route('notificaciones.index', ['filter' => 'unread']) }}" class="filter-btn {{ ($filter ?? '') == 'unread' ? 'active' : '' }}">
                Sin leer <span class="count">{{ $unreadCount }}</span>
            </a>
        </div>
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" id="notif-search" placeholder="Buscar notificaciones..." autocomplete="off">
        </div>
    </div>

    {{-- SKELETON --}}
    <div id="notif-loading" style="display:none;">
        <div class="notif-skeleton"></div>
        <div class="notif-skeleton"></div>
        <div class="notif-skeleton"></div>
    </div>

    {{-- NOTIFICATIONS LIST --}}
    <div id="notif-list" class="notif-animate" style="--anim-delay: 0.3s">
        @include('shared.partials.notif-cards', ['notificaciones' => $notificaciones, 'filter' => $filter])
    </div>

    {{-- LOAD MORE --}}
    @if($notificaciones->hasMorePages())
        <div id="load-more-container" class="text-center mt-5">
            <button onclick="loadMore()" id="load-more-btn" class="btn-premium">
                <i class="fas fa-plus"></i> Cargar más
            </button>
        </div>
    @endif

    {{-- SCROLL TOP --}}
    <button class="scroll-top" id="scroll-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <i class="fas fa-chevron-up"></i>
    </button>

</div>
@endsection

@section('scripts')
<script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ── Mark single notification as read ─────────────────────── */
    function markAsRead(id) {
        const card = document.querySelector(`.notif-card-new[data-id="${id}"]`);
        if (card) {
            card.style.opacity = '0.5';
            card.style.pointerEvents = 'none';
        }

        fetch(`/notificaciones/${id}/leer`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                if (card) {
                    card.classList.remove('unread');
                    card.classList.add('read');
                    card.style.opacity = '1';
                    card.style.pointerEvents = '';
                    // Remove the "Listo" button
                    const btn = card.querySelector('.btn-action-secondary');
                    if (btn) btn.remove();
                    // Remove unread indicator dot
                    const dot = card.querySelector('.unread-indicator');
                    if (dot) dot.remove();
                }
                updateUnreadCounts(-1);
                showToast('success', 'Notificación marcada como leída.');
            } else {
                if (card) {
                    card.style.opacity = '1';
                    card.style.pointerEvents = '';
                }
                showToast('error', 'No se pudo marcar la notificación.');
            }
        })
        .catch(() => {
            if (card) {
                card.style.opacity = '1';
                card.style.pointerEvents = '';
            }
            showToast('error', 'Error de conexión.');
        });
    }

    /* ── Mark ALL notifications as read ───────────────────────── */
    function markAllAsRead() {
        const btn = document.getElementById('mark-all-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        }

        fetch('/notificaciones/leer-todas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                // Update all unread cards visually
                document.querySelectorAll('.notif-card-new.unread').forEach(card => {
                    card.classList.remove('unread');
                    card.classList.add('read');
                    const actionBtn = card.querySelector('.btn-action-secondary');
                    if (actionBtn) actionBtn.remove();
                    const dot = card.querySelector('.unread-indicator');
                    if (dot) dot.remove();
                });
                // Update counts to zero
                updateUnreadCounts(0, true);
                // Remove the button
                if (btn) btn.remove();
                showToast('success', 'Todas las notificaciones marcadas como leídas.');
            } else {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check-double"></i> Marcar todas';
                }
                showToast('error', 'No se pudieron marcar las notificaciones.');
            }
        })
        .catch(() => {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-double"></i> Marcar todas';
            }
            showToast('error', 'Error de conexión.');
        });
    }

    /* ── Update unread count displays ─────────────────────────── */
    function updateUnreadCounts(delta, setZero = false) {
        const heroEl = document.getElementById('hero-unread-count');
        const statEl = document.getElementById('stat-unread');

        if (setZero) {
            if (heroEl) heroEl.textContent = '0';
            if (statEl) statEl.textContent = '0';
        } else {
            if (heroEl) {
                let current = parseInt(heroEl.textContent) || 0;
                heroEl.textContent = Math.max(0, current + delta);
            }
            if (statEl) {
                let current = parseInt(statEl.textContent) || 0;
                statEl.textContent = Math.max(0, current + delta);
            }
        }
    }

    /* ── Load more (pagination via AJAX) ──────────────────────── */
    let currentPage = 1;
    function loadMore() {
        const btn = document.getElementById('load-more-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';
        }

        currentPage++;
        const filter = new URLSearchParams(window.location.search).get('filter') || 'all';

        fetch(`/notificaciones?page=${currentPage}&filter=${filter}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(r => r.text())
        .then(html => {
            // The server returns the full page; extract the notif-cards content
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newCards = doc.getElementById('notif-list');
            if (newCards && newCards.innerHTML.trim()) {
                document.getElementById('notif-list').insertAdjacentHTML('beforeend', newCards.innerHTML);
            }
            // Check if there are more pages
            const moreBtn = doc.getElementById('load-more-container');
            if (!moreBtn) {
                const container = document.getElementById('load-more-container');
                if (container) container.remove();
            } else {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-plus"></i> Cargar más';
                }
            }
        })
        .catch(() => {
            currentPage--;
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-plus"></i> Cargar más';
            }
            showToast('error', 'Error al cargar más notificaciones.');
        });
    }

    /* ── Client-side search filter ────────────────────────────── */
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('notif-search');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const term = this.value.toLowerCase().trim();
                document.querySelectorAll('.notif-card-new').forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(term) ? '' : 'none';
                });
                // Toggle date dividers visibility
                document.querySelectorAll('.date-divider-new').forEach(div => {
                    let next = div.nextElementSibling;
                    let hasVisible = false;
                    while (next && !next.classList.contains('date-divider-new') && !next.classList.contains('mt-4')) {
                        if (next.classList.contains('notif-card-new') && next.style.display !== 'none') {
                            hasVisible = true;
                        }
                        next = next.nextElementSibling;
                    }
                    div.style.display = hasVisible ? '' : 'none';
                });
            });
        }

        // Scroll-to-top button
        const scrollBtn = document.getElementById('scroll-top');
        if (scrollBtn) {
            window.addEventListener('scroll', () => {
                scrollBtn.style.display = window.scrollY > 400 ? 'flex' : 'none';
            });
        }
    });
</script>
@endsection
