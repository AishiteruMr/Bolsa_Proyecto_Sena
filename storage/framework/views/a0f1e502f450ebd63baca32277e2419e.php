<?php $__env->startSection('title', 'Soporte Técnico'); ?>
<?php $__env->startSection('page-title', 'Mensajes de Soporte'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
    <style>
        .soporte-wrapper { max-width: 1000px; margin: 0 auto; }
        .response-panel { display: none; }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Administración</span>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item"><i class="fas fa-th-large"></i> Principal</a>
    <a href="<?php echo e(route('admin.usuarios')); ?>" class="nav-item"><i class="fas fa-users"></i> Gestión Usuarios</a>
    <a href= "<?php echo e(route('admin.empresas')); ?>" class="nav-item"><i class="fas fa-building"></i> Empresas Aliadas</a>
    <a href="<?php echo e(route('admin.proyectos')); ?>" class="nav-item"><i class="fas fa-project-diagram"></i> Banco Proyectos</a>
    <span class="nav-label" style="margin-top: 24px; color: var(--primary);"><i class="fas fa-headset"></i> Soporte</span>
    <a href="<?php echo e(route('admin.mensajes.soporte')); ?>" class="nav-item active"><i class="fas fa-envelope"></i> Mensajes Soporte</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="soporte-wrapper">
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php $__empty_1 = true; $__currentLoopData = $mensajes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card-base" style="padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div>
                                <div style="font-weight: 800; color: var(--text);"><?php echo e($m->nombre); ?></div>
                                <div style="font-size: 13px; color: var(--text-light);"><?php echo e($m->email); ?></div>
                            </div>
                            <span class="inline-pill inline-pill--muted"><?php echo e($m->motivo); ?></span>
                        </div>
                        <span class="status-badge-support <?php echo e($m->estado == 'respondido' ? 'respondido' : 'pendiente'); ?>">
                            <?php echo e(ucfirst($m->estado)); ?>

                        </span>
                    </div>
                    <div style="color: var(--text-light); margin-bottom: 20px; line-height: 1.6;"><?php echo e($m->mensaje); ?></div>
                    
                    <button class="btn-premium" onclick="togglePanel('panel-<?php echo e($m->id); ?>')">
                        <i class="fas <?php echo e($m->estado == 'respondido' ? 'fa-eye' : 'fa-reply'); ?>"></i> 
                        <?php echo e($m->estado == 'respondido' ? 'Ver Respuesta' : 'Responder'); ?>

                    </button>
                    
                    <div id="panel-<?php echo e($m->id); ?>" class="response-panel" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border);">
                        <form action="<?php echo e(route('admin.mensajes.soporte.responder', $m->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <textarea name="respuesta" class="form-control" placeholder="Escribe tu respuesta aquí..." required style="width:100%; height:120px; padding:16px; border: 1px solid var(--border); border-radius:12px; margin-bottom:16px; font-family:inherit;"><?php echo e($m->respuesta); ?></textarea>
                            <button type="submit" class="btn-premium">Enviar Respuesta</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="card-base" style="padding:40px; text-align:center; color:var(--text-light);">No hay mensajes registrados.</div>
            <?php endif; ?>
        </div>
        <div style="margin-top:20px;"><?php echo e($mensajes->links()); ?></div>
    </div>

    <script>
        function togglePanel(id) {
            const panel = document.getElementById(id);
            panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/admin/mensajes-soporte.blade.php ENDPATH**/ ?>