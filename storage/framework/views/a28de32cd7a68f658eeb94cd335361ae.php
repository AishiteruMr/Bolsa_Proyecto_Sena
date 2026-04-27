<?php $__env->startSection('title', 'Verificación OTP - Bolsa de Proyecto SENA'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-5">
        <h3 class="text-center mb-4 text-primary fw-bold">Verificación de Correo</h3>
        
        <p class="text-center text-muted mb-4">
            Hemos enviado un código de 6 dígitos a <strong><?php echo e($email); ?></strong>. Por favor, ingrésalo a continuación para activar tu cuenta.
        </p>

        <form action="<?php echo e(route('auth.verificar-otp')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="email" value="<?php echo e($email); ?>">
            
            <div class="mb-4">
                <label for="otp" class="form-label fw-semibold">Código OTP</label>
                <input type="text" class="form-control form-control-lg text-center fs-3 tracking-widest" id="otp" name="otp" required maxlength="6" placeholder="000000">
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2 fs-5 fw-semibold shadow-sm">Verificar Código</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="<?php echo e(route('login')); ?>" class="text-decoration-none">Volver al inicio</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/auth/verificar-otp.blade.php ENDPATH**/ ?>