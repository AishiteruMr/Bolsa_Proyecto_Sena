<?php $__env->startSection('title', 'Registro Exitoso - SENA'); ?>
<?php $__env->startSection('header_icon', '🎉'); ?>
<?php $__env->startSection('header_title', '¡Registro Exitoso!'); ?>
<?php $__env->startSection('header_subtitle', 'Bienvenido a la plataforma'); ?>

<?php $__env->startSection('content'); ?>
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #0f172a;"><?php echo e($nombre); ?> <?php echo e($apellido); ?></strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 16px 0;">
    Nos complace informarte que tu cuenta fue creada correctamente en la <strong>Bolsa de Proyecto SENA</strong>.
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 30px 0;">
    Para comenzar a explorar todas las funcionalidades disponibles para tu perfil, por favor verifica tu correo electrónico con el enlace que te hemos enviado en un mensaje separado y luego inicia sesión.
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="<?php echo e(url('/login')); ?>" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                🚀 Iniciar Sesión
            </a>
        </td>
    </tr>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/emails/registro-exitoso.blade.php ENDPATH**/ ?>