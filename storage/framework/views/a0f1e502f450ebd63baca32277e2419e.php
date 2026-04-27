<?php $__env->startSection('title', 'Soporte Técnico'); ?>
<?php $__env->startSection('page-title', 'Mensajes de Soporte'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
    <style>
        .soporte-wrapper { max-width: 1100px; margin: 0 auto; }
        .soporte-card { background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden; }
        .msg-item { border-bottom: 1px solid #f1f5f9; padding: 20px; transition: background 0.2s; margin-bottom: 15px; border-radius: 12px; border: 1px solid #e2e8f0; }
        .msg-item:hover { background: #f8fafc; }
        .msg-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px; }
        .msg-info { display: flex; gap: 15px; align-items: center; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-motivo { background: #e0e7ff; color: #4338ca; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-respondido { background: #d1fae5; color: #065f46; }
        .response-panel { margin-top: 15px; padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; display: none; }
        .btn-toggle { background: #f1f5f9; color: #475569; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; }
        .btn-toggle:hover { background: #e2e8f0; }
        .btn-submit { background: #0f172a; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; }
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
                <div class="msg-item">
                    <div class="msg-header">
                        <div class="msg-info">
                            <div>
                                <div style="font-weight: 800; color: #1e293b;"><?php echo e($m->nombre); ?></div>
                                <div style="font-size: 13px; color: #64748b;"><?php echo e($m->email); ?></div>
                            </div>
                            <span class="badge badge-motivo"><?php echo e($m->motivo); ?></span>
                        </div>
                        <span class="badge <?php echo e($m->estado == 'respondido' ? 'badge-respondido' : 'badge-pendiente'); ?>">
                            <?php echo e(ucfirst($m->estado)); ?>

                        </span>
                    </div>
                    <div style="color: #475569; margin-bottom: 15px;"><?php echo e($m->mensaje); ?></div>
                    <button class="btn-toggle" onclick="togglePanel('panel-<?php echo e($m->id); ?>')">
                        <i class="fas <?php echo e($m->estado == 'respondido' ? 'fa-eye' : 'fa-reply'); ?>"></i> 
                        <?php echo e($m->estado == 'respondido' ? 'Ver Respuesta' : 'Responder'); ?>

                    </button>
                    
                    <div id="panel-<?php echo e($m->id); ?>" class="response-panel">
                        <form action="<?php echo e(route('admin.mensajes.soporte.responder', $m->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <textarea name="respuesta" class="form-control" placeholder="Escribe tu respuesta aquí..." required style="width:100%; height:100px; padding:12px; border: 1px solid #cbd5e1; border-radius:8px; margin-bottom:10px;"><?php echo e($m->respuesta); ?></textarea>
                            <button type="submit" class="btn-submit">Enviar Respuesta</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="padding:40px; text-align:center; color:#94a3b8;">No hay mensajes registrados.</div>
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