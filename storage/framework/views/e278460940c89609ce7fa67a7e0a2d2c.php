<?php $__env->startSection('title', 'Notificaciones'); ?>
<?php $__env->startSection('page-title', 'Mis Notificaciones'); ?>


<?php $__env->startSection('content'); ?>
<div class="animate-fade-in" style="max-width: 800px; margin: 0 auto;">

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: var(--text); letter-spacing: -0.5px;">
                Centro de <span style="color: var(--primary);">Notificaciones</span>
            </h2>
            <p style="font-size: 14px; color: var(--text-light); margin-top: 4px; font-weight: 500;">
                <?php echo e($notificaciones->where('read_at', null)->count()); ?> sin leer
            </p>
        </div>
        <?php if($notificaciones->where('read_at', null)->count() > 0): ?>
            <form action="<?php echo e(route('notificaciones.leer_todas')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-premium" style="background: #f1f5f9; color: var(--text); box-shadow: none; border: 1px solid var(--border); font-size: 13px; padding: 10px 20px;">
                    <i class="fas fa-check-double"></i> Marcar todas como leídas
                </button>
            </form>
        <?php endif; ?>
    </div>
    <?php
        $defaultDashboard = route('home');
        if (auth()->check()) {
            $defaultDashboard = match(auth()->user()->rol_id) {
                1 => route('aprendiz.dashboard'),
                2 => route('instructor.dashboard'),
                3 => route('empresa.dashboard'),
                4 => route('admin.dashboard'),
                default => route('home'),
            };
        }
        $returnUrl = session('notificaciones_return_url', $defaultDashboard);
    ?>
    <div style="text-align:right; margin-top: 20px;">
        <a href="<?php echo e($returnUrl); ?>" class="btn-premium" style="background:#e2e8f0; color: var(--text); box-shadow: none; border: 1px solid var(--border); font-size: 13px; padding: 10px 20px;">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>
<br>
    
    <?php if($notificaciones->isEmpty()): ?>
        <div class="glass-card" style="text-align: center; padding: 80px 20px;">
            <div style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px; color: #cbd5e1;">
                <i class="fas fa-bell-slash"></i>
            </div>
            <h4 style="font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 8px;">Todo al día</h4>
            <p style="color: var(--text-light); font-weight: 500;">No tienes notificaciones por el momento.</p>
        </div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <?php $__currentLoopData = $notificaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $leida = !is_null($notificacion->read_at);
                    $iconColor = $leida ? '#94a3b8' : 'var(--primary)';
                    $iconBg   = $leida ? '#f8fafc' : 'var(--primary-soft)';
                    $borderColor = $leida ? 'var(--border)' : 'var(--primary-soft)';
                    $icon = $notificacion->data['icono'] ?? 'fa-bell';
                ?>
                <div class="glass-card" style="padding: 20px 24px; border-color: <?php echo e($borderColor); ?>; <?php echo e($leida ? 'opacity: 0.75;' : ''); ?> display: flex; align-items: flex-start; gap: 16px; transition: all 0.2s;">
                    <div style="width: 44px; height: 44px; border-radius: 14px; background: <?php echo e($iconBg); ?>; display: flex; align-items: center; justify-content: center; color: <?php echo e($iconColor); ?>; font-size: 18px; flex-shrink: 0;">
                        <i class="fas <?php echo e($icon); ?>"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 4px;">
                            <p style="font-size: 15px; font-weight: <?php echo e($leida ? '600' : '700'); ?>; color: var(--text); margin: 0;">
                                <?php echo e($notificacion->data['titulo'] ?? 'Notificación del sistema'); ?>

                            </p>
                            <span style="font-size: 11px; color: var(--text-lighter); white-space: nowrap; font-weight: 600; flex-shrink: 0;">
                                <?php echo e($notificacion->created_at ? $notificacion->created_at->diffForHumans() : ''); ?>

                            </span>
                        </div>
                        <p style="font-size: 13px; color: var(--text-light); margin: 0 0 12px; line-height: 1.5;">
                            <?php echo e($notificacion->data['mensaje'] ?? 'Sin detalles.'); ?>

                        </p>
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <?php if(isset($notificacion->data['url']) && $notificacion->data['url']): ?>
                                <a href="<?php echo e($notificacion->data['url']); ?>" style="font-size: 12px; font-weight: 700; color: var(--primary); text-decoration: none; padding: 4px 10px; background: var(--primary-soft); border-radius: 6px;">Ver Detalles</a>
                            <?php endif; ?>
                            
                            <?php if(!$leida): ?>
                                <form action="<?php echo e(route('notificaciones.leer', $notificacion->id)); ?>" method="POST" style="margin:0;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" style="background: none; border: none; padding: 0; font-size: 12px; font-weight: 700; color: var(--primary); cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-check"></i> Marcar como leída
                                    </button>
                                </form>
                            <?php else: ?>
                                <span style="font-size: 11px; font-weight: 700; color: var(--text-lighter); display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-check-double"></i> Leída
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="margin-top: 32px;">
            <?php echo e($notificaciones->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/shared/notificaciones.blade.php ENDPATH**/ ?>