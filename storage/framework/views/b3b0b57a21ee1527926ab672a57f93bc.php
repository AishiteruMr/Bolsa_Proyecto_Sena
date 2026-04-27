<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Inspírate SENA'); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
    <div class="login-page-wrapper">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        
        <a href="<?php echo e(route('home')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>

        <div class="login-container" style="max-width: 480px; border-radius: 20px;">
            <div class="login-brand" style="display: none;">
            </div>
            
            <div class="login-content" style="padding: 36px 32px;">
                <div class="brand-header" style="display: flex; align-items: center; gap: 14px; margin-bottom: 28px;">
                    <img src="<?php echo e(asset('assets/logo.png')); ?>" alt="SENA" style="width: 44px; height: 44px; background: #fff; padding: 8px; border-radius: 12px; box-shadow: 0 4px 15px rgba(62,180,137,0.2);">
                    <span style="font-size: 24px; font-weight: 900; color: var(--secondary); letter-spacing: -1px;"><?php echo $__env->yieldContent('title', 'Inspírate'); ?></span>
                </div>
                
                <div class="content-header" style="margin-bottom: 24px;">
                    <h3 style="font-size: 22px; font-weight: 800; color: var(--secondary); margin-bottom: 6px; letter-spacing: -0.5px;"><?php echo $__env->yieldContent('form-title', 'Crear Cuenta'); ?></h3>
                    <p style="font-size: 13px; color: var(--text-light); font-weight: 500;"><?php echo $__env->yieldContent('form-subtitle', 'Completa tus datos'); ?></p>
                </div>
                
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/layouts/auth.blade.php ENDPATH**/ ?>