<?php $__env->startSection('content'); ?>
<div class="error-page" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 40px; text-align: center;">
    <div style="font-size: 120px; color: var(--primary); margin-bottom: 20px;">404</div>
    <h1 style="font-size: 32px; color: var(--text); margin-bottom: 16px;">Página no encontrada</h1>
    <p style="font-size: 16px; color: var(--text-light); margin-bottom: 32px; max-width: 500px;">
        Lo sentimos, la página que estás buscando no existe o ha sido movida.
    </p>
    <a href="<?php echo e(route('home')); ?>" class="btn-premium" style="display: inline-block; padding: 14px 28px;">
        <i class="fas fa-home"></i> Volver al inicio
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/errors/404.blade.php ENDPATH**/ ?>