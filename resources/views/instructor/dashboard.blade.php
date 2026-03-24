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
<div class="dashboard-wrapper" style="padding-bottom: 50px;">
    
    <!-- HEADER DINÁMICO -->
    <div style="background: linear-gradient(135deg, #0f766e, #115e59); padding: 48px; border-radius: 32px; margin-bottom: 32px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(15, 118, 110, 0.15);">
        <div style="position: absolute; right: -20px; bottom: -20px; font-size: 200px; color: rgba(255,255,255,0.05); transform: rotate(-15deg);">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                <span style="background: rgba(255,255,255,0.1); color: white; padding: 6px 16px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">SENA Colombia</span>
                <span id="current-time" style="color: rgba(255,255,255,0.7); font-size: 13px; font-weight: 500;"></span>
            </div>
            <h1 style="font-size: 42px; font-weight: 800; color: white; margin-bottom: 12px; letter-spacing: -1px;">¡Hola, Instructor <span style="color: var(--primary-light);">{{ session('nombre') }}</span>! 👋</h1>
            <p style="color: rgba(255,255,255,0.8); font-size: 17px; max-width: 600px; line-height: 1.5;">Monitoriza el progreso de tus aprendices, gestiona los proyectos vinculados y califica evidencias en un solo lugar.</p>
        </div>
    </div>

    <!-- STATS BENTO GRID -->
    <div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 24px; margin-bottom: 40px;">
        
        <!-- Main Stats -->
        <div class="glass-card" style="grid-column: span 1; padding: 0; overflow: hidden; display: flex; flex-direction: column;">
            <div style="padding: 24px; background: rgba(57, 169, 0, 0.1); border-bottom: 1px solid rgba(57, 169, 0, 0.1);">
                <h4 style="font-size: 13px; font-weight: 800; color: #1a5c00; text-transform: uppercase; letter-spacing: 1px;">Estado del Programa</h4>
            </div>
            <div style="flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: var(--border);">
                <div style="background: white; padding: 24px; display: flex; flex-direction: column; justify-content: center;">
                    <span style="font-size: 36px; font-weight: 800; color: #1e293b;">{{ count($proyectos) }}</span>
                    <span style="font-size: 14px; font-weight: 600; color: #64748b;">Proyectos Activos</span>
                </div>
                <div style="background: white; padding: 24px; display: flex; flex-direction: column; justify-content: center;">
                    <span style="font-size: 36px; font-weight: 800; color: #1e293b;">{{ $totalAprendices ?? '0' }}</span>
                    <span style="font-size: 14px; font-weight: 600; color: #64748b;">Aprendices A cargo</span>
                </div>
            </div>
        </div>

        <!-- Evidencias Pending Card -->
        <div class="glass-card" style="padding: 32px; display: flex; flex-direction: column; justify-content: space-between; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div style="width: 50px; height: 50px; border-radius: 14px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    <i class="fas fa-file-signature"></i>
                </div>
                <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase;">Por Calificar</span>
            </div>
            <div>
                <h3 style="font-size: 40px; font-weight: 800; margin-bottom: 4px;">{{ $evidenciasPendientes ?? '0' }}</h3>
                <p style="font-size: 15px; font-weight: 600; color: rgba(255,255,255,0.9);">Revisiones pendientes</p>
            </div>
            <a href="{{ route('instructor.proyectos') }}" style="margin-top: 20px; color: white; text-decoration: none; font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                Ver todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Quick Info -->
        <div class="glass-card" style="padding: 32px; background: #fff;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h4 style="font-size: 16px; font-weight: 700; color: #1e293b;">Resumen Diario</h4>
            </div>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 14px; color: #64748b; font-weight: 500;">Nuevas Postulaciones</span>
                    <span style="font-size: 14px; font-weight: 700; color: var(--primary);">+3</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-size: 14px; color: #64748b; font-weight: 500;">Siguientes Cierres</span>
                    <span style="font-size: 14px; font-weight: 700; color: #64748b;">Esta semana</span>
                </div>
            </div>
        </div>
    </div>

    <!-- PROYECTOS RECIENTES -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-rocket" style="color: var(--primary);"></i> Gestión de Proyectos en Curso
        </h2>
        <a href="{{ route('instructor.proyectos') }}" class="btn" style="background: #fff; border: 1.5px solid var(--border); color: #64748b; font-weight: 700; font-size: 13px; border-radius: 12px;">
            Ver todos los proyectos
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px;">
        @forelse($proyectos as $p)
            <div class="project-card-premium" style="background: white; border-radius: 28px; overflow: hidden; border: 1px solid #e2e8f0; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); display: flex; flex-direction: column;">
                <div style="height: 180px; position: relative;">
                    <img src="{{ $p->imagen_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 16px; left: 16px; background: rgba(15, 118, 110, 0.9); backdrop-filter: blur(8px); padding: 6px 14px; border-radius: 30px; color: white; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $p->pro_categoria }}
                    </div>
                </div>
                
                <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <i class="fas fa-building" style="color: #64748b; font-size: 13px;"></i>
                        <span style="font-size: 13px; font-weight: 700; color: #64748b;">{{ $p->empresa_nombre }}</span>
                    </div>
                    <h3 style="font-size: 19px; font-weight: 800; color: #1e293b; line-height: 1.4; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $p->pro_titulo_proyecto }}
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px;">
                        <div style="background: #f8fafc; padding: 12px; border-radius: 14px; text-align: center;">
                            <span style="display: block; font-size: 18px; font-weight: 800; color: #1e293b;">{{ $p->postulaciones->where('pos_estado', 'Aprobada')->count() }}</span>
                            <span style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">Aprobados</span>
                        </div>
                        <div style="background: #f8fafc; padding: 12px; border-radius: 14px; text-align: center;">
                            <span style="display: block; font-size: 18px; font-weight: 800; color: #1e293b;">{{ $p->postulaciones->where('pos_estado', 'Pendiente')->count() }}</span>
                            <span style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">Pendientes</span>
                        </div>
                    </div>

                    <a href="{{ route('instructor.proyecto.detalle', $p->pro_id) }}" class="btn-primary" style="margin-top: auto; justify-content: center; padding: 14px; border-radius: 14px; background: #0f766e; text-decoration: none; display: flex; align-items: center; gap: 10px; color: white; font-weight: 700; transition: all 0.3s ease;">
                        Gestionar <i class="fas fa-arrow-right" style="font-size: 13px;"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="glass-card" style="padding: 80px; text-align: center; grid-column: 1/-1;">
                <div style="width: 100px; height: 100px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; color: #cbd5e1; margin: 0 auto 24px;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Sin proyectos vigentes</h3>
                <p style="color: #64748b; max-width: 400px; margin: 0 auto;">Actualmente no tienes proyectos asignados en fase de ejecución. Los nuevos proyectos aparecerán aquí.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .glass-card {
        background: #ffffff;
        border: 1.5px solid #f1f5f9;
        border-radius: 28px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
    }

    .project-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.03);
        border-color: var(--primary-light);
    }

    .project-card-premium:hover .btn-primary {
        background: var(--primary) !important;
        transform: scale(1.02);
    }

    #current-time {
        font-family: 'Outfit', sans-serif;
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