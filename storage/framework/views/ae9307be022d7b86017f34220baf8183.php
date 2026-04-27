<?php $__env->startSection('title', 'Soporte | Inspírate SENA'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Diseño Minimalista y Moderno */
    .support-wrapper { padding: 80px 10%; color: #333; }
    
    .support-hero { text-align: center; margin-bottom: 60px; }
    .support-hero h1 { font-size: 3rem; font-weight: 800; letter-spacing: -1px; color: #00324d; }
    .support-hero p { font-size: 1.2rem; color: #666; max-width: 600px; margin: 20px auto 0; }
    
    .support-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-bottom: 60px; }
    
    .card-minimal { 
        background: #fff; 
        padding: 40px; 
        border-radius: 24px; 
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    .card-minimal:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
    .card-minimal h3 { font-size: 1.5rem; margin-bottom: 20px; color: #00324d; }
    .card-minimal ul { list-style: none; padding: 0; }
    .card-minimal ul li { margin-bottom: 15px; display: flex; align-items: flex-start; }
    .card-minimal ul li i { color: var(--primary); margin-right: 10px; margin-top: 5px; }
    
    .contact-form { 
        background: #fff; 
        padding: 60px; 
        border-radius: 30px; 
        border: 1px solid #f0f0f0;
        max-width: 800px; 
        margin: 0 auto; 
    }
    .form-input { width: 100%; padding: 15px; border: 1px solid #eee; border-radius: 12px; margin-bottom: 20px; font-family: inherit; }
    .btn-action { 
        background: #00324d; 
        color: white; 
        padding: 16px 32px; 
        border-radius: 12px; 
        font-weight: 600; 
        border: none; 
        cursor: pointer; 
        width: 100%; 
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="support-wrapper">
    <?php if(session('success')): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 12px; margin-bottom: 30px; text-align: center; border: 1px solid #c3e6cb;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <section class="support-hero">
        <h1>¿Cómo podemos ayudarte hoy?</h1>
        <p>Tu experiencia es nuestra prioridad. Encuentra soluciones rápidas o conecta con nuestro equipo de soporte.</p>
    </section>

    <div class="support-grid">
        <div class="card-minimal">
            <h3>Centro de Ayuda</h3>
            <ul>
                <li><i class="fas fa-check"></i> Guía rápida de inicio para nuevos usuarios.</li>
                <li><i class="fas fa-check"></i> Tutoriales sobre cómo gestionar proyectos.</li>
                <li><i class="fas fa-check"></i> Resolución de dudas sobre certificaciones.</li>
            </ul>
        </div>
        <div class="card-minimal">
            <h3>Solución de Problemas</h3>
            <ul>
                <li><i class="fas fa-exclamation-circle"></i> Restablecimiento de acceso a cuenta.</li>
                <li><i class="fas fa-exclamation-circle"></i> Optimización de carga en el dashboard.</li>
                <li><i class="fas fa-exclamation-circle"></i> Configuración de notificaciones.</li>
            </ul>
        </div>
    </div>

    <section class="contact-form">
        <h2 style="margin-bottom: 30px; text-align: center;">Envía tu consulta</h2>
        <form action="<?php echo e(route('soporte.enviar')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="text" name="nombre" placeholder="Tu nombre" class="form-input" required>
            <input type="email" name="email" placeholder="Tu correo electrónico" class="form-input" required>
            <select name="motivo" class="form-input">
                <option value="Duda">Duda General</option>
                <option value="Queja">Queja / Incidente</option>
                <option value="Sugerencia">Sugerencia de Mejora</option>
            </select>
            <textarea name="mensaje" placeholder="Describe detalladamente tu situación..." class="form-input" rows="6" required></textarea>
            <button type="submit" class="btn-action">Enviar solicitud</button>
        </form>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/soporte.blade.php ENDPATH**/ ?>