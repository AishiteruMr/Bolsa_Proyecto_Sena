@extends('layouts.dashboard')

@section('title', 'Panel de Control - Inspírate SENA')
@section('page-title', 'Centro de Mando del Instructor')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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
@endsection

@section('content')
<div class="dashboard-wrapper">
    
    <!-- HEADER DINÁMICO -->
    <div class="welcome-banner">
        <div class="banner-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="banner-content">
            <div class="banner-badge">
                <span class="badge-sena">SENA Colombia</span>
                <span id="current-time-full" class="banner-time"></span>
            </div>
            <h1 class="welcome-text">¡Hola, Instructor <span class="highlight-text">{{ session('nombre') }}</span>! 👋</h1>
            <p class="welcome-subtext">Monitoriza el progreso de tus aprendices, gestiona los proyectos vinculados y califica evidencias en un solo lugar.</p>
        </div>
    </div>

    <!-- STATS BENTO GRID -->
    <div class="bento-grid">
        
        <!-- Main Stats -->
        <div class="glass-card stat-card-main">
            <div class="card-header-mini">
                <h4>Estado del Programa</h4>
            </div>
            <div class="stats-split">
                <div class="stat-item">
                    <span class="stat-value">{{ $proyectosAsignados }}</span>
                    <span class="stat-label">Proyectos Activos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $totalAprendices }}</span>
                    <span class="stat-label">Aprendices A cargo</span>
                </div>
            </div>
        </div>

        <!-- Evidencias Pending Card -->
        <div class="glass-card stat-card-pending">
            <div class="pending-header">
                <div class="icon-box">
                    <i class="fas fa-file-signature"></i>
                </div>
                <span class="tag-pending">Por Calificar</span>
            </div>
            <div class="pending-body">
                <h3 class="pending-count">{{ $evidenciasPendientes }}</h3>
                <p class="pending-label">Revisiones pendientes</p>
            </div>
            <a href="{{ route('instructor.proyectos') }}" class="pending-link">
                Ir a calificar <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Quick Info -->
        <div class="glass-card info-card">
            <div class="info-header">
                <div class="icon-circle">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h4>Resumen Diario</h4>
            </div>
            <div class="info-list">
                <div class="info-item">
                    <span class="label">Nuevas Postulaciones</span>
                    <span class="value-highlight">
                        {{ $nuevasPostulaciones > 0 ? '+' . $nuevasPostulaciones : '0' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="label">Siguiente Cierre</span>
                    <span class="value-normal">
                        {{ $proximoCierre ? $proximoCierre->pro_fecha_finalizacion->diffForHumans() : 'Sin pendientes' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- PROYECTOS RECIENTES -->
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-rocket"></i> Gestión de Proyectos en Curso
        </h2>
        <a href="{{ route('instructor.proyectos') }}" class="btn-all">
            Ver todos los proyectos
        </a>
    </div>

    <div class="projects-grid">
        @forelse($proyectos as $p)
            <div class="project-card-premium">
                <div class="card-image-box">
                    <img src="{{ $p->imagen_url }}" alt="{{ $p->pro_titulo_proyecto }}">
                    <div class="category-badge">
                        {{ $p->pro_categoria }}
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="empresa-info">
                        <i class="fas fa-building"></i>
                        <span>{{ $p->empresa_nombre }}</span>
                    </div>
                    <h3 class="project-title">
                        {{ $p->pro_titulo_proyecto }}
                    </h3>
                    
                    <div class="project-stats-mini">
                        <div class="stat-mini">
                            <span class="val">{{ $p->postulacionesAprobadas()->count() }}</span>
                            <span class="lbl">Aprobados</span>
                        </div>
                        <div class="stat-mini">
                            <span class="val">{{ $p->postulacionesPendientes()->count() }}</span>
                            <span class="lbl">Pendientes</span>
                        </div>
                    </div>

                    <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-manage">
                        Gestionar <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h3>Sin proyectos vigentes</h3>
                <p>Actualmente no tienes proyectos asignados en fase de ejecución. Los nuevos proyectos aparecerán aquí.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .dashboard-wrapper {
        padding-bottom: 50px;
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #0f766e, #115e59);
        padding: 48px;
        border-radius: 32px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(15, 118, 110, 0.15);
    }

    .banner-icon {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 200px;
        color: rgba(255,255,255,0.05);
        transform: rotate(-15deg);
        pointer-events: none;
    }

    .banner-badge {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .badge-sena {
        background: rgba(255,255,255,0.1);
        color: white;
        padding: 6px 16px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,0.2);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .banner-time {
        color: rgba(255,255,255,0.7);
        font-size: 13px;
        font-weight: 500;
        font-family: 'Outfit', sans-serif;
    }

    .welcome-text {
        font-size: clamp(28px, 5vw, 42px);
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
        letter-spacing: -1px;
    }

    .highlight-text {
        color: #5eead4;
    }

    .welcome-subtext {
        color: rgba(255,255,255,0.8);
        font-size: 17px;
        max-width: 600px;
        line-height: 1.5;
    }

    /* Bento Grid */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }

    @media (max-width: 1024px) {
        .bento-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .bento-grid { grid-template-columns: 1fr; }
    }

    .glass-card {
        background: white;
        border: 1.5px solid #f1f5f9;
        border-radius: 28px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }

    .stat-card-main {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .card-header-mini {
        padding: 20px 24px;
        background: rgba(57, 169, 0, 0.05);
        border-bottom: 1px solid #f1f5f9;
    }

    .card-header-mini h4 {
        font-size: 12px;
        font-weight: 800;
        color: #1a5c00;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stats-split {
        flex: 1;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: #f1f5f9;
    }

    .stat-item {
        background: white;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .stat-card-pending {
        padding: 32px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-card-pending:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(217, 119, 6, 0.3);
    }

    .pending-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .icon-box {
        width: 44px;
        height: 44px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .tag-pending {
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .pending-count {
        font-size: 48px;
        font-weight: 800;
        margin: 10px 0 0;
    }

    .pending-label {
        font-size: 14px;
        font-weight: 500;
        opacity: 0.9;
    }

    .pending-link {
        color: white;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 15px;
    }

    .info-card {
        padding: 32px;
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f9ff;
        color: #0369a1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-header h4 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding-bottom: 12px;
        border-bottom: 1px solid #f8fafc;
    }

    .info-item .label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .value-highlight {
        color: #0f766e;
        font-weight: 700;
    }

    .value-normal {
        color: #475569;
        font-weight: 600;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title i { color: #0f766e; }

    .btn-all {
        padding: 10px 18px;
        background: white;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        font-weight: 700;
        font-size: 13px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-all:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Projects Grid */
    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }

    .project-card-premium {
        background: white;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    .project-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);
        border-color: #0f766e;
    }

    .card-image-box {
        height: 180px;
        position: relative;
    }

    .card-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .category-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(15, 118, 110, 0.9);
        backdrop-filter: blur(8px);
        padding: 6px 14px;
        border-radius: 30px;
        color: white;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-body {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .empresa-info {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
    }

    .project-title {
        font-size: 19px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.4;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-stats-mini {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-mini {
        background: #f8fafc;
        padding: 12px;
        border-radius: 14px;
        text-align: center;
    }

    .stat-mini .val {
        display: block;
        font-size: 18px;
        font-weight: 800;
        color: #111827;
    }

    .stat-mini .lbl {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .btn-manage {
        margin-top: auto;
        justify-content: center;
        padding: 14px;
        border-radius: 14px;
        background: #0f766e;
        color: white;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .btn-manage:hover {
        background: #115e59;
        transform: scale(1.02);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        grid-column: 1 / -1;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #94a3b8;
        margin: 0 auto 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #64748b;
        max-width: 400px;
        margin: 0 auto;
    }
</style>

<script>
    function updateRealTimeClock() {
        const now = new Date();
        
        // Fecha completa
        const dateOptions = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        const dateStr = now.toLocaleDateString('es-ES', dateOptions);
        
        // Hora con segundos
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
        const timeStr = now.toLocaleTimeString('es-ES', timeOptions);
        
        document.getElementById('current-time-full').textContent = `${dateStr} • ${timeStr}`;
    }

    // Actualizar inmediatamente y luego cada segundo
    updateRealTimeClock();
    setInterval(updateRealTimeClock, 1000);
</script>
@endsection
