<?php $__env->startSection('title', 'Mis Entregas y Evidencias'); ?>
<?php $__env->startSection('page-title', 'Mis Entregas'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Principal</span>
    <a href="<?php echo e(route('aprendiz.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="<?php echo e(route('aprendiz.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.proyectos') ? 'active' : ''); ?>">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="<?php echo e(route('aprendiz.postulaciones')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.postulaciones') ? 'active' : ''); ?>">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <a href="<?php echo e(route('aprendiz.historial')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.historial') ? 'active' : ''); ?>">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="<?php echo e(route('aprendiz.entregas')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.entregas') ? 'active' : ''); ?>">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="<?php echo e(route('aprendiz.perfil')); ?>" class="nav-item <?php echo e(request()->routeIs('aprendiz.perfil') ? 'active' : ''); ?>">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/aprendiz.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="animate-fade-in" style="padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-tasks"></i></div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span class="instructor-tag">Entregas</span>
            </div>
            <h1 class="instructor-title">Mis <span style="color: var(--primary);">Entregas</span> y Evidencias</h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 16px; font-weight: 500;">Seguimiento de tus entregables en proyectos aprobados.</p>
        </div>
    </div>

    <?php if($proyectos->count() > 0): ?>
        <div class="instructor-stat-grid" style="margin-bottom: 32px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: var(--text); line-height: 1;"><?php echo e($evidencias->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Evidencias Totales</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #bbf7d0;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #16a34a; line-height: 1;"><?php echo e($evidencias->where('estado', 'aceptada')->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Aprobadas</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fde68a;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #d97706; line-height: 1;"><?php echo e($evidencias->where('estado', 'pendiente')->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Pendientes</div>
                </div>
            </div>
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-color: #fecaca;">
                <div style="width: 52px; height: 52px; border-radius: 16px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #ef4444; line-height: 1;"><?php echo e($evidencias->where('estado', 'rechazada')->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Rechazadas</div>
                </div>
            </div>
        </div>

        <div style="display: grid; gap: 32px;">
            <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $evidencias_proyecto = $evidencias->where('proyecto_id', $proyecto->id);
                ?>
                <div class="glass-card" style="padding: 0; overflow: hidden;">
                    <div style="padding: 24px 32px; background: linear-gradient(135deg, rgba(62,180,137,0.05), rgba(62,180,137,0.02)); border-bottom: 1px solid rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 4px;"><?php echo e($proyecto->titulo); ?></h4>
                                <p style="font-size: 13px; color: var(--text-light); margin: 0; font-weight: 600;">
                                    <i class="fas fa-building" style="margin-right: 6px; color: #3eb489;"></i><?php echo e($proyecto->nombre); ?>

                                    &nbsp;&middot;&nbsp;
                                    <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>Cierre: <?php echo e(\Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d/m/Y')); ?>

                                </p>
                            </div>
                        </div>
                        <span style="background: rgba(62,180,137,0.1); border: 1px solid rgba(62,180,137,0.2); padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 800; color: #3eb489;">
                            <?php echo e($evidencias_proyecto->count()); ?> Evidencias
                        </span>
                    </div>

                    <div style="padding: 24px 32px; display: grid; gap: 16px;">
                        <?php if($evidencias_proyecto->count() > 0): ?>
                            <?php $__currentLoopData = $evidencias_proyecto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evidencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $stateColor = match($evidencia->estado) {
                                        'aceptada'  => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a', 'icon' => 'fa-check-circle'],
                                        'rechazada' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#dc2626', 'icon' => 'fa-times-circle'],
                                        default     => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706', 'icon' => 'fa-hourglass-half'],
                                    };
                                ?>
                                <div style="background: <?php echo e($stateColor['bg']); ?>; border: 1.5px solid <?php echo e($stateColor['border']); ?>; border-radius: 16px; padding: 20px 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateX(8px)'" onmouseout="this.style.transform='translateX(0)'">
                                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                                        <div style="flex: 1; min-width: 280px;">
                                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                                <span style="width: 32px; height: 32px; border-radius: 10px; background: <?php echo e($stateColor['text']); ?>; color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; flex-shrink: 0;">
                                                    <?php echo e($evidencia->etapa->orden ?? '?'); ?>

                                                </span>
                                                <h5 style="font-size: 16px; font-weight: 800; color: var(--text); margin: 0;">
                                                    <?php echo e($evidencia->etapa->nombre ?? 'Etapa sin nombre'); ?>

                                                </h5>
                                            </div>
                                            <div style="font-size: 13px; color: var(--text-light); font-weight: 600; margin-bottom: 10px;">
                                                <i class="far fa-clock" style="margin-right: 8px;"></i>
                                                Entregado: <?php echo e(\Carbon\Carbon::parse($evidencia->fecha_envio)->translatedFormat('d M Y, H:i')); ?>

                                            </div>
                                            <?php if($evidencia->comentario_instructor): ?>
                                                <div style="background: rgba(255,255,255,0.8); border-radius: 10px; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.05);">
                                                    <p style="font-size: 13px; color: var(--text); font-weight: 600; margin: 0;">
                                                        <i class="fas fa-comment-dots" style="color: #3eb489; margin-right: 8px;"></i><?php echo e($evidencia->comentario_instructor); ?>

                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px; flex-shrink: 0;">
                                            <span style="background: white; color: <?php echo e($stateColor['text']); ?>; border: 1.5px solid <?php echo e($stateColor['border']); ?>; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; white-space: nowrap; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas <?php echo e($stateColor['icon']); ?>"></i> <?php echo e($evidencia->estado); ?>

                                            </span>
                                            <?php if($evidencia->ruta_archivo): ?>
                                                <a href="<?php echo e(asset('storage/' . $evidencia->ruta_archivo)); ?>" target="_blank"
                                                   class="btn-premium" style="padding: 8px 16px; font-size: 12px;">
                                                    <i class="fas fa-file-download"></i> Ver Archivo
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div style="text-align: center; padding: 48px; background: rgba(62,180,137,0.02); border-radius: 16px; border: 2px dashed rgba(62,180,137,0.1);">
                                <i class="fas fa-inbox" style="font-size: 36px; color: var(--text-lighter); margin-bottom: 12px; display: block;"></i>
                                <p style="font-weight: 700; color: var(--text-light); margin: 0;">Sin evidencias registradas aún</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="glass-card" style="padding: 80px 40px; text-align: center;">
            <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px; color: #3eb489;">
                <i class="fas fa-inbox"></i>
            </div>
            <h4 style="color: var(--text); font-size: 22px; font-weight: 800; margin-bottom: 8px;">Sin proyectos aprobados</h4>
            <p style="color: var(--text-light); max-width: 450px; margin: 0 auto 32px;">
                Cuando tengas un proyecto aprobado, podrás gestionar y enviar tus evidencias desde aquí.
            </p>
            <a href="<?php echo e(route('aprendiz.proyectos')); ?>" class="btn-premium" style="display: inline-flex;">
                <i class="fas fa-search"></i> Explorar Proyectos
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/aprendiz/mis-entregas.blade.php ENDPATH**/ ?>