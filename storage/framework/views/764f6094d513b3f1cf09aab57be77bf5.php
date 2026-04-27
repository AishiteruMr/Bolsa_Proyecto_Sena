<?php $__env->startSection('title', 'Verifica tu correo con código - SENA'); ?>
<?php $__env->startSection('header_icon', '🔑'); ?>
<?php $__env->startSection('header_title', 'Verifica tu correo'); ?>
<?php $__env->startSection('header_subtitle', 'Paso final para activar tu cuenta'); ?>

<?php $__env->startSection('content'); ?>
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #0f172a;"><?php echo e($nombre); ?></strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 16px 0;">
    Gracias por registrarte en la <strong>Bolsa de Proyecto SENA</strong>. Para proteger tu seguridad, necesitamos que verifiques tu correo electrónico utilizando el siguiente código:
</p>

<div style="text-align: center; margin: 30px 0;">
    <div style="display: inline-block; background-color: #f1f5f9; padding: 15px 30px; border-radius: 10px; font-size: 32px; font-weight: 700; color: #047857; letter-spacing: 5px;">
        <?php echo e($otp); ?>

    </div>
</div>

<div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
    <p style="margin: 0; font-size: 14px; color: #b45309; line-height: 1.5;">
        <strong>Importante:</strong> Este código de verificación expirará en <strong>10 minutos</strong>. Si no solicitaste este registro, ignora este correo.
    </p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/emails/verificar-correo-otp.blade.php ENDPATH**/ ?>