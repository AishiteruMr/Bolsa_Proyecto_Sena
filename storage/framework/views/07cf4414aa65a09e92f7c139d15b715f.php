<?php $__env->startSection('title', 'Aprendices'); ?>
<?php $__env->startSection('page-title', 'Mis Aprendices'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Principal</span>
    <a href="<?php echo e(route('instructor.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="<?php echo e(route('instructor.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.proyectos') ? 'active' : ''); ?>">
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
    <div class="instructor-hero-bg-icon"><i class="fas fa-users"></i></div>
    <div style="position: relative; z-index: 1;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 10px;">
            <span class="instructor-tag">Aprendices</span>
        </div>
        <h1 style="font-size: 36px; font-weight: 800; color: white; margin-bottom: 8px;">Comunidad de Aprendices</h1>
        <p style="color: rgba(255,255,255,0.7); font-size: 15px;">Supervisa el desempeño y progreso de los aprendices en tus proyectos.</p>
    </div>
</div>

<div class="instructor-community-grid animate-fade-in">
    <?php $__empty_1 = true; $__currentLoopData = $aprendices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="background: rgba(255,255,255,0.9); border-radius: 20px; overflow: hidden; border: 1px solid rgba(62,180,137,0.1); transition: all 0.3s; padding: 32px; display: flex; flex-direction: column; align-items: center; text-align: center;">
            <div style="width: 80px; height: 80px; border-radius: 24px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800; margin-bottom: 16px; box-shadow: 0 10px 20px rgba(62,180,137,0.3);">
                <?php echo e(strtoupper(substr($a->nombres ?? 'A', 0, 1))); ?>

            </div>
            
            <h4 style="font-size:1.1rem; font-weight:700; margin-bottom:0.5rem; color: var(--text);"><?php echo e($a->nombres ?? ''); ?> <?php echo e($a->apellidos ?? ''); ?></h4>
            
            <div style="font-size:0.85rem; color: var(--text-light); margin-bottom: 1rem;">
                <div style="margin-bottom: 4px;"><i class="fas fa-graduation-cap" style="color:#3eb489; margin-right:6px;"></i><?php echo e($a->programa_formacion ?? 'Sin programa'); ?></div>
                <div><i class="fas fa-envelope" style="color:#3eb489; margin-right:6px;"></i><?php echo e($a->usuario->correo ?? 'Sin correo'); ?></div>
            </div>

            <div style="margin-top: auto; width: 100%; border-top: 1px solid rgba(62,180,137,0.1); padding-top: 1rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <span style="background: #dcfce7; border: 1px solid #bbf7d0; color: #15803d; width: fit-content; margin: 0 auto; padding: 6px 14px; border-radius: 20px; font-size: 10px; font-weight: 700;">
                        <i class="fas fa-check-circle"></i> Postulación Aprobada
                    </span>
                    <div style="font-size:12px; color:#3eb489; font-weight: 700;">
                        <i class="fas fa-briefcase" style="margin-right:4px;"></i><?php echo e($a->postulaciones->first()?->proyecto?->titulo ?? 'Sin proyecto'); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 20px; border: 1px dashed rgba(62,180,137,0.2);">
            <i class="fas fa-users" style="font-size: 48px; color: #3eb489; margin-bottom: 16px; opacity: 0.5;"></i>
            <h4 style="color:var(--text); font-size:1.5rem; margin-bottom:8px; font-weight: 800;">No hay aprendices activos</h4>
            <p style="color:var(--text-light); font-weight: 500;">Aún no tienes aprendices vinculados a tus proyectos.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/instructor/aprendices.blade.php ENDPATH**/ ?>