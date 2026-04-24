<?php $__env->startSection('title', 'Historial de Proyectos'); ?>
<?php $__env->startSection('page-title', 'Historial'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Principal</span>
    <a href="<?php echo e(route('aprendiz.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-home"></i> <span>Principal</span>
    </a>
    <a href="<?php echo e(route('aprendiz.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.proyectos') ? 'active' : ''); ?>">
        <i class="fas fa-briefcase"></i> <span>Explorar Proyectos</span>
    </a>
    <a href="<?php echo e(route('aprendiz.postulaciones')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.postulaciones') ? 'active' : ''); ?>">
        <i class="fas fa-paper-plane"></i> <span>Mis Postulaciones</span>
    </a>
    <a href="<?php echo e(route('aprendiz.historial')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.historial') ? 'active' : ''); ?>">
        <i class="fas fa-history"></i> <span>Historial</span>
    </a>
    <a href="<?php echo e(route('aprendiz.entregas')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.entregas') ? 'active' : ''); ?>">
        <i class="fas fa-tasks"></i> <span>Mis Entregas</span>
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="<?php echo e(route('aprendiz.perfil')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.perfil') ? 'active' : ''); ?>">
        <i class="fas fa-user"></i> <span>Mi Perfil</span>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/aprendiz.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="animate-fade-in" style="padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-history"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span class="instructor-tag">Historial</span>
            </div>
            <h1 class="instructor-title">Historial de <span style="color: var(--primary);">Postulaciones</span></h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; font-weight: 500;">Tu trayectoria académica completa — todos los proyectos a los que te has postulado.</p>
        </div>
    </div>

    <?php
        $total = collect($proyectos)->count();
        $aprobadas = collect($proyectos)->where('estado','aceptada')->count();
        $pendientes = collect($proyectos)->where('estado','pendiente')->count();
        $rechazadas = collect($proyectos)->where('estado','rechazada')->count();
    ?>

    <?php if($total > 0): ?>
        <div class="instructor-stat-grid" style="margin-bottom: 32px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-inbox"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: var(--text); line-height: 1;"><?php echo e($total); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Total</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #bbf7d0;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #16a34a; line-height: 1;"><?php echo e($aprobadas); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Aprobadas</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fde68a;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #d97706; line-height: 1;"><?php echo e($pendientes); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Pendientes</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fecaca;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #ef4444; line-height: 1;"><?php echo e($rechazadas); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Rechazadas</div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px;">
            <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $estadoColor = match($p->estado) {
                        'aceptada'  => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a', 'icon' => 'fa-check-circle'],
                        'rechazada' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#ef4444', 'icon' => 'fa-times-circle'],
                        default     => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-clock'],
                    };
                    $diasRestantes = \Carbon\Carbon::parse($p->fecha_finalizacion)->diffInDays(now(), false);
                    $esFinalizado  = $diasRestantes >= 0;
                ?>
                <div class="glass-card" style="padding: 0; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 40px rgba(62,180,137,0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(62,180,137,0.06)'">
                    <div style="height: 5px; background: linear-gradient(90deg, <?php echo e($estadoColor['text']); ?>, <?php echo e($estadoColor['border']); ?>);"></div>

                    <?php if($p->imagen_url): ?>
                        <img src="<?php echo e($p->imagen_url); ?>" alt="Imagen del proyecto" style="width:100%; height:140px; object-fit:cover;">
                    <?php else: ?>
                        <div style="height: 100px; background: linear-gradient(135deg, rgba(62,180,137,0.15), rgba(62,180,137,0.05)); display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-project-diagram" style="font-size:36px; color:#3eb489; opacity:0.5;"></i>
                        </div>
                    <?php endif; ?>

                    <div style="padding: 24px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px; gap:12px;">
                            <h4 style="font-size:16px; font-weight:800; color:var(--text); line-height:1.3; flex:1;"><?php echo e($p->titulo); ?></h4>
                            <span style="background:<?php echo e($estadoColor['bg']); ?>; border:1.5px solid <?php echo e($estadoColor['border']); ?>; color:<?php echo e($estadoColor['text']); ?>; border-radius:20px; padding:6px 14px; font-size:11px; font-weight:800; white-space:nowrap; display:flex; align-items:center; gap:6px; flex-shrink:0;">
                                <i class="fas <?php echo e($estadoColor['icon']); ?>"></i> <?php echo e($p->estado); ?>

                            </span>
                        </div>

                        <div style="display:grid; gap:10px; margin-bottom:20px;">
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-building" style="width:16px; color:#3eb489;"></i>
                                <span><?php echo e($p->nombre); ?></span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-tag" style="width:16px; color:#8b5cf6;"></i>
                                <span><?php echo e($p->categoria); ?></span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-chalkboard-teacher" style="width:16px; color:#0ea5e9;"></i>
                                <span><?php echo e($p->instructor_nombre); ?></span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13px; color:var(--text-light); font-weight:600;">
                                <i class="fas fa-calendar-alt" style="width:16px; color:#f59e0b;"></i>
                                <span>Postulé el <?php echo e(\Carbon\Carbon::parse($p->fecha_postulacion)->format('d M, Y')); ?></span>
                            </div>
                        </div>

                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:12px 16px; margin-bottom:18px; display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase;">Estado del Proyecto</span>
                            <span style="font-size:12px; font-weight:800; color:#3eb489;">
                                <?php if($esFinalizado): ?> Finalizado <?php else: ?> En progreso <?php endif; ?>
                            </span>
                        </div>

                        <?php if($p->estado === 'aceptada'): ?>
                            <a href="<?php echo e(route('aprendiz.entregas')); ?>" class="btn-premium" style="width:100%; justify-content:center; padding:12px;">
                                <i class="fas fa-upload"></i> Ir a Mis Entregas
                            </a>
                        <?php else: ?>
                            <div style="width:100%; background:#f1f5f9; border-radius:12px; padding:12px; text-align:center; font-size:13px; font-weight:700; color:#94a3b8;">
                                <i class="fas fa-lock"></i> Acceso restringido
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="glass-card" style="padding: 80px 40px; text-align: center;">
            <div style="width:100px; height:100px; background:rgba(62,180,137,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; font-size:40px; color:#3eb489;">
                <i class="fas fa-history"></i>
            </div>
            <h3 style="font-size:22px; font-weight:800; color:var(--text); margin-bottom:10px;">Sin historial aún</h3>
            <p style="font-size:15px; color:var(--text-light); font-weight:500; max-width:400px; margin:0 auto 28px; line-height:1.6;">
                Aún no te has postulado a ningún proyecto. Explora las convocatorias disponibles y da el primer paso en tu carrera.
            </p>
            <a href="<?php echo e(route('aprendiz.proyectos')); ?>" class="btn-premium" style="display:inline-flex;">
                <i class="fas fa-search"></i> Explorar Proyectos
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/aprendiz/historial.blade.php ENDPATH**/ ?>