<?php $__env->startSection('title', 'Admin - Mensajes de Soporte'); ?>
<?php $__env->startSection('page-title', 'Mensajes de Soporte'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Administración</span>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="<?php echo e(route('admin.usuarios')); ?>" class="nav-item">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href= "<?php echo e(route('admin.empresas')); ?>" class="nav-item">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="<?php echo e(route('admin.proyectos')); ?>" class="nav-item">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
    <span class="nav-label" style="margin-top: 16px;">Soporte</span>
    <a href="<?php echo e(route('admin.mensajes.soporte')); ?>" class="nav-item active">
        <i class="fas fa-envelope"></i> Mensajes Soporte
    </a>
    <span class="nav-label" style="margin-top: 16px;">Herramientas</span>
    <a href="<?php echo e(route('admin.backup')); ?>" class="nav-item">
        <i class="fas fa-database"></i> Backup
    </a>
    <a href="<?php echo e(route('admin.audit')); ?>" class="nav-item">
        <i class="fas fa-clipboard-list"></i> Auditoría
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="glass-card" style="padding: 28px; background: white;">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 24px;">Mensajes Recibidos</h3>
        
        <div class="premium-table-container">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Remitente</th>
                        <th>Email</th>
                        <th>Motivo</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $mensajes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="font-weight: 700;"><?php echo e($m->nombre); ?></td>
                            <td><?php echo e($m->email); ?></td>
                            <td>
                                <span class="status-badge" style="padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; background: #e0e7ff; color: #4338ca;">
                                    <?php echo e($m->motivo); ?>

                                </span>
                            </td>
                            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($m->mensaje); ?></td>
                            <td><?php echo e($m->created_at->format('d/m/Y H:i')); ?></td>
                            <td style="text-align: right;">
                                <a href="mailto:<?php echo e($m->email); ?>?subject=Respuesta a su mensaje de soporte: <?php echo e($m->motivo); ?>" class="btn-premium" style="padding: 6px 12px; font-size: 11px; background: var(--primary-soft); color: var(--primary); text-decoration: none; border-radius: 6px;">
                                    <i class="fas fa-reply"></i> Responder
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" style="text-align:center; padding: 40px;">No hay mensajes nuevos.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            <?php echo e($mensajes->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/admin/mensajes-soporte.blade.php ENDPATH**/ ?>