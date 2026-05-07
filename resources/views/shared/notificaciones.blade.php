@extends('layouts.dashboard')

@section('title', 'Notificaciones')
@section('page-title', 'Mis Notificaciones')

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
