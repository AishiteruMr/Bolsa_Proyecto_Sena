<?php $__env->startSection('title', 'Empresas Aliadas - Admin'); ?>
<?php $__env->startSection('page-title', 'Directorio de Empresas'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Administración</span>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="<?php echo e(route('admin.usuarios')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.usuarios') ? 'active' : ''); ?>">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href="<?php echo e(route('admin.empresas')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.empresas') ? 'active' : ''); ?>">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="<?php echo e(route('admin.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.proyectos*') ? 'active' : ''); ?>">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
    <span class="nav-label" style="margin-top: 16px;">Soporte</span>
    <a href="<?php echo e(route('admin.mensajes.soporte')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.mensajes.soporte') ? 'active' : ''); ?>">
        <i class="fas fa-envelope"></i> Mensajes Soporte
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-header-master">
            <div class="admin-header-icon"><i class="fas fa-building"></i></div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="admin-badge-hub">Admin Control Hub</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i><?php echo e(now()->translatedFormat('l, d F Y')); ?></span>
                </div>
                <h1 class="admin-header-title">Ecosistema de <span style="color: var(--primary);">Empresas</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 720px; font-weight: 500;">Gestión y supervisión de organizaciones aliadas al SENA desde una vista centralizada.</p>
            </div>
        </div>

        <!-- BENTO STATS -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid var(--primary);">
                <div class="admin-stat-icon" style="background: var(--primary-soft); color: var(--primary);">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Total Aliados</div>
                    <div class="admin-stat-value"><?php echo e($empresas->count()); ?></div>
                </div>
            </div>
            
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid var(--primary-hover);">
                <div class="admin-stat-icon" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%); color: #fff;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="admin-stat-label">Empresas Activas</div>
                    <div class="admin-stat-value" style="color: var(--primary-hover);"><?php echo e($empresas->where('activo', 1)->count()); ?></div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid #f97316;">
                <div class="admin-stat-icon" style="background: #fff7ed; color: #f97316;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="admin-stat-label">En Espera</div>
                    <div class="admin-stat-value" style="color: #f97316;"><?php echo e($empresas->where('activo', 0)->count()); ?></div>
                </div>
            </div>
        </div>

        <div class="glass-card admin-table-card">
            <div class="admin-table-header">
                <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <span class="admin-stat-icon" style="width: 36px; height: 36px; background: var(--primary-soft); color: var(--primary); font-size: 16px;">
                        <i class="fas fa-list-check"></i>
                    </span>
                    Directorio Corporativo
                </h3>
            </div>
            
            <div class="premium-table-container">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Identificación (NIT)</th>
                            <th>Razón Social</th>
                            <th>Representante Legal</th>
                            <th>Contacto</th>
                            <th>Estado</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td style="font-weight: 800; color: var(--primary);"><?php echo e($e->nit); ?></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-building" style="color: var(--text-light); font-size: 14px;"></i>
                                        </div>
                                        <div class="admin-company-name"><?php echo e($e->nombre); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-company-rep"><i class="far fa-user-circle" style="margin-right: 6px; opacity: 0.5;"></i><?php echo e($e->representante); ?></div>
                                </td>
                                <td class="admin-contact">
                                    <i class="far fa-envelope" style="margin-right: 6px; opacity: 0.5;"></i>
                                    <?php echo e($e->correo_contacto); ?>

                                </td>
                                <td>
                                    <span class="status-badge <?php echo e($e->activo == 1 ? 'active' : 'inactive'); ?>" style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800;">
                                        <?php echo e($e->activo == 1 ? 'Activa' : 'Inactiva'); ?>

                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="<?php echo e(route('admin.empresas.estado', $e->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="estado" value="<?php echo e($e->activo == 1 ? 0 : 1); ?>">
                                        <button type="submit" class="btn-premium" style="padding: 10px 16px; font-size: 11px; background: <?php echo e($e->activo == 1 ? '#f8fafc' : 'var(--primary)'); ?>; color: <?php echo e($e->activo == 1 ? '#64748b' : 'white'); ?>; border: <?php echo e($e->activo == 1 ? '1px solid #e2e8f0' : 'none'); ?>; box-shadow: none;">
                                            <i class="fas <?php echo e($e->activo == 1 ? 'fa-ban' : 'fa-check-circle'); ?>"></i>
                                            <?php echo e($e->activo == 1 ? 'Inhabilitar' : 'Habilitar'); ?>

                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 80px;">
                                    <div style="color: var(--text-light);">
                                        <i class="fas fa-building-circle-exclamation" style="font-size: 48px; margin-bottom: 16px; opacity: 0.2;"></i>
                                        <div style="font-size: 16px; font-weight: 800; color: var(--text);">Sin empresas registradas</div>
                                        <div style="font-size: 14px; margin-top: 8px; font-weight: 500;">Las nuevas inscripciones aparecerán en esta tabla automáticamente.</div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/admin/empresas.blade.php ENDPATH**/ ?>