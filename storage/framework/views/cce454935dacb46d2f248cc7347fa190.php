<?php $__env->startSection('title', 'Iniciar Sesión'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-page-wrapper">
    <a href="<?php echo e(route('home')); ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Inicio
    </a>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-container" style="max-width: 1100px;">
        <div class="login-brand">
            <div class="brand-header">
                <img src="<?php echo e(asset('assets/logo.png')); ?>" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
            
            <div class="brand-quote">
                <h2>Impulsa <span style="color: var(--primary-light);"> Ideas</span>,<br>Cosecha <span style="color: var(--primary-light);">Éxitos</span>.</h2>
                <p>"La innovación es el camino que transforma el conocimiento en soluciones reales para el mundo."</p>
            </div>

            <div class="brand-features">
                <div class="brand-feature">
                    <i class="fas fa-rocket"></i>
                    <span>Proyectos Innovadores</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-handshake"></i>
                    <span>Red de Contactos</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-chart-line"></i>
                    <span>Seguimiento Profesional</span>
                </div>
            </div>

            <div class="brand-footer">
                Bolsa de Proyectos & Talentos v2.0
            </div>
        </div>

        <div class="login-content" style="padding: 64px;">
            <div class="content-header">
                <h3>Bienvenido de nuevo</h3>
                <p>Ingresa tus credenciales para continuar.</p>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"> <?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-error"> <?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if(session('info')): ?>
                <div class="alert alert-info" style="background: #eff6ff; border-color: #3b82f6; color: #1e40af;"> <?php echo e(session('info')); ?>

                    <form action="<?php echo e(route('verification.resend')); ?>" method="POST" style="margin-top: 8px;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="correo" value="<?php echo e(old('correo')); ?>">
                        <button type="submit" class="resend-link">
                            <i class="fas fa-paper-plane"></i> Reenviar enlace de verificación
                        </button>
                    </form>
                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-error">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <span><?php echo e($error); ?></span><br> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login.post')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>
                        Correo Electrónico
                        <i class="fas fa-question-circle hint-icon" data-hint="Correo con el que te registraste en la plataforma" style="margin-left: 4px;"></i>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="correo" value="<?php echo e(old('correo')); ?>" placeholder="tucorreo@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        Contraseña
                        <i class="fas fa-question-circle hint-icon" data-hint="Mínimo 6 caracteres" style="margin-left: 4px;"></i>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="form-hint">
                        <i class="fas fa-shield-alt" style="color: #64748b;"></i>
                        Tu información está protegida
                    </div>
                </div>

                <a href="<?php echo e(route('auth.olvide-contraseña')); ?>" class="forgot-link">¿Olvidaste tu contraseña?</a>

                <button type="submit" class="btn-submit">
                    Entrar al Portal <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </button>
            </form>

            <div class="divider">ó regístrate como</div>

            <div class="role-grid">
                <a href="<?php echo e(route('registro.aprendiz')); ?>" class="role-card">
                    <i class="fas fa-user-graduate"></i>
                    <span>Aprendiz</span>
                </a>
                <a href="<?php echo e(route('registro.instructor')); ?>" class="role-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Instructor</span>
                </a>
                <a href="<?php echo e(route('registro.empresa')); ?>" class="role-card">
                    <i class="fas fa-building"></i>
                    <span>Empresa</span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/login.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/auth/login.blade.php ENDPATH**/ ?>