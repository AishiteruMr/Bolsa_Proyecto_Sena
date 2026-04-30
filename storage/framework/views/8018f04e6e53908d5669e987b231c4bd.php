<?php $__env->startSection('title', 'Historial de Proyectos'); ?>
<?php $__env->startSection('page-title', 'Historial de Proyectos'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Principal</span>
    <a href="<?php echo e(route('instructor.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="<?php echo e(route('instructor.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.proyectos', 'instructor.proyecto.detalle', 'instructor.evidencias.ver', 'instructor.reporte') ? 'active' : ''); ?>">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="<?php echo e(route('instructor.historial')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.historial') ? 'active' : ''); ?>">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="<?php echo e(route('instructor.aprendices')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.aprendices') ? 'active' : ''); ?>">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="<?php echo e(route('instructor.perfil')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.perfil') ? 'active' : ''); ?>">
        <i class="fas fa-user-circle"></i> Perfil
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/instructor.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="instructor-hero" style="padding: 40px 48px; margin-bottom: 32px;">
    <div class="instructor-hero-bg-icon"><i class="fas fa-history"></i></div>
    <div style="position: relative; z-index: 1;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
            <span class="instructor-tag">Historial</span>
        </div>
        <h1 style="font-size: 36px; font-weight: 800; color: white; margin-bottom: 8px;">Historial de Proyectos</h1>
        <p style="color: rgba(255,255,255,0.7); font-size: 15px;">Registro histórico de todos los proyectos supervisados y completados.</p>
    </div>
</div>

    <?php if($proyectos->count() > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 1.5rem;">
            <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid rgba(62,180,137,0.1); transition: all 0.3s; display: flex; flex-direction: column; min-height: 320px;">
                    <div style="padding: 1.5rem; flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <?php
                                $statusStyles = match($proyecto->estado) {
                                    'completado' => ['bg' => '#065f46', 'icon' => 'fa-check'],
                                    'aprobado' => ['bg' => '#10b981', 'icon' => 'fa-check'],
                                    'pendiente' => ['bg' => '#f59e0b', 'icon' => 'fa-clock'],
                                    'rechazado' => ['bg' => '#ef4444', 'icon' => 'fa-ban'],
                                    'cerrado' => ['bg' => '#64748b', 'icon' => 'fa-lock'],
                                    'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner'],
                                    default => ['bg' => '#64748b', 'icon' => 'fa-info-circle'],
                                };
                            ?>
                            <span style="background: <?php echo e($statusStyles['bg']); ?>; color: #ffffff; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas <?php echo e($statusStyles['icon']); ?>"></i> <?php echo e(Str::title(str_replace('_', ' ', $proyecto->estado))); ?>

                            </span>
                            <span style="font-size: 0.75rem; color: var(--text-light);">
                                <i class="fas fa-calendar-alt" style="margin-right: 4px;"></i>
                                <?php echo e(\Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d M, Y')); ?>

                            </span>
                        </div>
                        
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text); margin-bottom: 0.75rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo e($proyecto->titulo); ?>

                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: var(--text-light); margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-building" style="color: #3eb489; width: 16px;"></i>
                                <span style="font-weight: 600;"><?php echo e($proyecto->nombre); ?></span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-tag" style="color: #3eb489; width: 16px;"></i>
                                <span style="font-weight: 600;"><?php echo e($proyecto->categoria); ?></span>
                            </div>
                        </div>

                        <div style="background: rgba(62,180,137,0.05); padding: 1rem; border-radius: 14px; border: 1px solid rgba(62,180,137,0.1); display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; text-align: center;">
                            <div>
                                <p style="font-size: 1.5rem; font-weight: 800; color: #3eb489; margin: 0 0 4px 0;"><?php echo e($proyecto->total_aprendices); ?></p>
                                <p style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin: 0;">Postulaciones</p>
                            </div>
                            <div style="border-left: 1px solid rgba(62,180,137,0.2);">
                                <p style="font-size: 1.5rem; font-weight: 800; color: #10b981; margin: 0 0 4px 0;"><?php echo e($proyecto->aprendices_aprobados); ?></p>
                                <p style="font-size: 0.65rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin: 0;">Aprobadas</p>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(62,180,137,0.1); background: rgba(62,180,137,0.02);">
                        <a href="<?php echo e(route('instructor.reporte', $proyecto->id)); ?>" class="btn-premium" style="width: 100%; justify-content: center; padding: 10px;">
                            <i class="fas fa-chart-pie" style="margin-right: 6px;"></i> Ver Reporte
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div style="padding: 5rem 2rem; text-align: center; background: white; border-radius: 20px; border: 1px dashed rgba(62,180,137,0.2);">
            <i class="fas fa-history" style="font-size: 4rem; color: #3eb489; margin-bottom: 1.5rem; opacity: 0.5;"></i>
            <h4 style="color: var(--text); font-size: 1.5rem; margin-bottom: 8px; font-weight: 800;">Historial vacío</h4>
            <p style="color: var(--text-light);">Aún no tienes proyectos finalizados o registrados en tu historial.</p>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/instructor/historial.blade.php ENDPATH**/ ?>