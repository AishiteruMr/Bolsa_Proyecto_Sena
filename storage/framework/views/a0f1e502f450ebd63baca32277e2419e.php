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
    <span class="nav-label" style="margin-top: 24px; display: flex; align-items: center; gap: 8px; color: var(--primary);">
        <i class="fas fa-headset" style="font-size: 10px;"></i> Soporte
    </span>
    <a href="<?php echo e(route('admin.mensajes.soporte')); ?>" class="nav-item active">
        <i class="fas fa-envelope"></i> Mensajes Soporte
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="glass-card" style="padding: 28px; background: white;">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 24px;">Mensajes de Quejas y Sugerencias</h3>
        
        <div class="premium-table-container">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Remitente</th>
                        <th>Email</th>
                        <th>Motivo</th>
                        <th>Mensaje</th>
                        <th>Estado</th>
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
                            <td>
                                <span class="status-badge" style="padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; background: <?php echo e($m->estado == 'respondido' ? '#d1fae5' : '#fef3c7'); ?>; color: <?php echo e($m->estado == 'respondido' ? '#065f46' : '#92400e'); ?>;">
                                    <?php echo e(ucfirst($m->estado ?? 'Pendiente')); ?>

                                </span>
                            </td>
                            <td><?php echo e($m->created_at->format('d/m/Y H:i')); ?></td>
                            <td style="text-align: right;">
                                <!-- Modal trigger or inline form for manual response -->
                                <button type="button" class="btn-premium" style="padding: 6px 12px; font-size: 11px; background: var(--primary-soft); color: var(--primary); text-decoration: none; border-radius: 6px; border: none; cursor: pointer;" onclick="toggleResponseForm('<?php echo e($m->id); ?>')">
                                    <i class="fas fa-reply"></i> <?php echo e($m->estado == 'respondido' ? 'Ver Respuesta' : 'Responder'); ?>

                                </button>
                                
                                <div id="form-<?php echo e($m->id); ?>" style="display: none; margin-top: 10px; text-align: left;">
                                    <form action="<?php echo e(route('admin.mensajes.soporte.responder', $m->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <textarea name="respuesta" class="form-control" required placeholder="Escribe tu respuesta manual..." style="width: 100%; margin-bottom: 5px; height: 80px;"><?php echo e($m->respuesta); ?></textarea>
                                        <button type="submit" class="btn-premium" style="border: none; cursor: pointer; padding: 6px 12px; font-size: 11px; background: var(--primary); color: white; border-radius: 6px;">
                                            <i class="fas fa-paper-plane"></i> Enviar Respuesta
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7" style="text-align:center; padding: 40px;">No hay mensajes registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            <?php echo e($mensajes->links()); ?>

        </div>
    </div>

    <script>
        function toggleResponseForm(id) {
            const form = document.getElementById('form-' + id);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/admin/mensajes-soporte.blade.php ENDPATH**/ ?>