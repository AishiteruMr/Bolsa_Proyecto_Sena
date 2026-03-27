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
<div class="dashboard-wrapper" style="animation: fadeIn 0.8s ease-out;">
    
    <!-- HEADER PREMIUM -->
    <div style="background: linear-gradient(135deg, #0f172a, #1e293b); padding: 48px; border-radius: var(--radius-lg); margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: var(--shadow-premium);">
        <div style="position: absolute; right: -30px; bottom: -30px; font-size: 240px; color: rgba(62,180,137,0.05); transform: rotate(-15deg); pointer-events: none;">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <span style="background: var(--primary); color: white; padding: 6px 16px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; box-shadow: 0 4px 12px var(--primary-glow);">SENA INNOVACIÓN</span>
                <span id="current-time" style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 600;"></span>
            </div>
            <h1 style="font-size: 48px; font-weight: 800; color: white; margin-bottom: 12px; letter-spacing: -1.5px;">¡Bienvenido, <span style="color: var(--primary);">{{ session('nombre') }}</span>! 👋</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 600px; line-height: 1.6; font-weight: 400;">Tu centro de mando para la excelencia académica y la gestión de proyectos de impacto.</p>
        </div>
    </div>

    <!-- BENTO STATS GRID -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 48px;">
        
        <!-- Large Stat Card -->
        <div class="glass-card" style="grid-column: span 2; display: flex; align-items: center; gap: 32px; padding: 40px; border-color: var(--primary-soft); background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(62, 180, 137, 0.05));">
            <div style="width: 80px; height: 80px; border-radius: 24px; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 32px; box-shadow: 0 12px 24px var(--primary-glow);">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div>
                <div style="font-size: 44px; font-weight: 800; color: var(--text); line-height: 1;">{{ $proyectosAsignados }}</div>
                <div style="font-size: 14px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Proyectos Bajo tu Guía</div>
            </div>
        </div>

        <!-- Warning Stat Card -->
        <div class="glass-card" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: white; display: flex; flex-direction: column; justify-content: space-between;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-clock"></i>
                </div>
                <span style="font-size: 10px; font-weight: 800; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px;">ACCIÓN REQUERIDA</span>
            </div>
            <div style="margin-top: 24px;">
                <div style="font-size: 36px; font-weight: 800;">{{ $evidenciasPendientes }}</div>
                <div style="font-size: 13px; font-weight: 600; opacity: 0.9;">Evidencias sin calificar</div>
            </div>
        </div>

        <!-- Success Stat Card -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div style="width: 48px; height: 48px; border-radius: 14px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div style="margin-top: 24px;">
                <div style="font-size: 36px; font-weight: 800; color: var(--text);">{{ $totalAprendices }}</div>
                <div style="font-size: 13px; font-weight: 600; color: var(--text-light);">Aprendices Aprobados</div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID: PROJECTS + QUICK ACTIONS -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        
        <!-- Left: Active Projects -->
        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <span style="width: 8px; height: 24px; background: var(--primary); border-radius: 4px;"></span>
                    Proyectos en Ejecución
                </h3>
                <a href="{{ route('instructor.proyectos') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 14px; transition: gap 0.3s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                    Ver catálogo <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                </a>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                @forelse($proyectos as $p)
                    <div class="glass-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                        <div style="height: 160px; position: relative;">
                            <img src="{{ $p->imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 16px; left: 16px; background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(8px); padding: 5px 12px; border-radius: 30px; color: white; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                {{ $p->pro_categoria }}
                            </div>
                        </div>
                        <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                            <h4 style="font-size: 17px; font-weight: 800; color: var(--text); line-height: 1.4; margin-bottom: 16px; height: 48px; overflow: hidden;">{{ $p->pro_titulo_proyecto }}</h4>
                            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                                <div style="flex: 1; background: #f8fafc; padding: 10px; border-radius: 12px; text-align: center; border: 1px solid #f1f5f9;">
                                    <span style="display: block; font-size: 16px; font-weight: 800;">{{ $p->postulaciones->where('pos_estado', 'Aprobada')->count() }}</span>
                                    <span style="font-size: 10px; color: var(--text-lighter); font-weight: 700; text-transform: uppercase;">Activos</span>
                                </div>
                                <div style="flex: 1; background: #f8fafc; padding: 10px; border-radius: 12px; text-align: center; border: 1px solid #f1f5f9;">
                                    <span style="display: block; font-size: 16px; font-weight: 800;">{{ $p->postulaciones->where('pos_estado', 'Pendiente')->count() }}</span>
                                    <span style="font-size: 10px; color: var(--text-lighter); font-weight: 700; text-transform: uppercase;">Nuevos</span>
                                </div>
                            </div>
                            <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-premium" style="width: 100%; justify-content: center; font-size: 13px; padding: 10px;">
                                Gestionar <i class="fas fa-play" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="glass-card" style="grid-column: span 2; padding: 48px; text-align: center; border-style: dashed;">
                        <i class="fas fa-folder-open" style="font-size: 40px; color: var(--text-lighter); margin-bottom: 16px;"></i>
                        <p style="color: var(--text-light); font-weight: 600;">No tienes proyectos asignados actualmente.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Activity & Quick Actions -->
        <div>
            <h3 style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 24px;">Centro de Notificaciones</h3>
            
            <div class="glass-card" style="padding: 24px; margin-bottom: 24px;">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600;">Postulaciones (48h)</div>
                            <div style="font-size: 16px; font-weight: 800; color: var(--text);">{{ $nuevasPostulaciones }} Recientes</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff1f2; color: #e11d48; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600;">Próximo Hito</div>
                            <div style="font-size: 16px; font-weight: 800; color: var(--text);">
                                {{ $proximoCierre ? $proximoCierre->pro_fecha_finalizacion->diffForHumans() : 'Sin eventos' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 32px; background: var(--secondary); color: white; border: none; box-shadow: var(--shadow-premium);">
                <h4 style="font-size: 18px; font-weight: 800; margin-bottom: 16px; letter-spacing: -0.5px;">Acceso Rápido</h4>
                <div style="display: grid; gap: 12px;">
                    <a href="{{ route('instructor.aprendices') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; background: rgba(255,255,255,0.05); border-radius: 14px; text-decoration: none; color: white; transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                        <i class="fas fa-users" style="color: var(--primary);"></i>
                        <span style="font-size: 14px; font-weight: 600;">Base de Aprendices</span>
                    </a>
                    <a href="{{ route('instructor.perfil') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; background: rgba(255,255,255,0.05); border-radius: 14px; text-decoration: none; color: white; transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                        <i class="fas fa-cog" style="color: var(--primary);"></i>
                        <span style="font-size: 14px; font-weight: 600;">Ajustes de Perfil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    .glass-card {
        border: 1px solid var(--border);
    }
</style>

<script>
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        const dateStr = now.toLocaleDateString('es-ES', options);
        document.getElementById('current-time').textContent = dateStr;
    }
    updateDateTime();
</script>
@endsection