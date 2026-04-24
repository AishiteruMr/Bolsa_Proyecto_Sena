<?php $__env->startSection('title', 'Mis Proyectos'); ?>
<?php $__env->startSection('page-title', 'Mis Proyectos'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <span class="nav-label">Portal Empresa</span>
    <a href="<?php echo e(route('empresa.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('empresa.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="<?php echo e(route('empresa.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('empresa.proyectos') ? 'active' : ''); ?>">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="<?php echo e(route('empresa.proyectos.crear')); ?>" class="nav-item <?php echo e(request()->routeIs('empresa.proyectos.crear') ? 'active' : ''); ?>">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="<?php echo e(route('empresa.perfil')); ?>" class="nav-item <?php echo e(request()->routeIs('empresa.perfil') ? 'active' : ''); ?>">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/empresa.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="animate-fade-in" style="padding-bottom: 40px;">
        
        <!-- Hero Header -->
        <div class="instructor-hero">
            <div class="instructor-hero-bg-icon"><i class="fas fa-project-diagram"></i></div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <span class="instructor-tag">Convocatorias</span>
                </div>
                <h1 class="instructor-title">Portafolio de <span style="color: var(--primary);">Proyectos</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 16px; font-weight: 500;">Evolución y seguimiento de tus proyectos estratégicos.</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="instructor-stat-grid">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; background: linear-gradient(135deg, #0a1a15, #1a2e28); border: none; color: white;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(255,255,255,0.1); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; line-height: 1;"><?php echo e($proyectos->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; opacity: 0.8;">Total Publicados</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #16a34a; line-height: 1;"><?php echo e($proyectos->where('estado', 'aprobado')->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Activas</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #d97706; line-height: 1;"><?php echo e($proyectos->where('estado', 'pendiente')->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">En Revisión</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div style="font-size: 32px; font-weight: 800; color: #ef4444; line-height: 1;"><?php echo e($proyectos->where('estado', 'rechazado')->count()); ?></div>
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Rechazados</div>
                </div>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="glass-card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px 32px; background: linear-gradient(135deg, rgba(62,180,137,0.05), rgba(62,180,137,0.02)); border-bottom: 1px solid rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: space-between;">
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 14px;">
                    <span style="width: 42px; height: 42px; border-radius: 12px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-list-check"></i>
                    </span>
                    Directorio de Proyectos
                </h3>
                <a href="<?php echo e(route('empresa.proyectos.crear')); ?>" class="btn-premium" style="padding: 12px 24px;">
                    <i class="fas fa-plus-circle"></i> Nuevo Proyecto
                </a>
            </div>
            
            <?php if($proyectos->isNotEmpty()): ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Proyecto</th>
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Categoría</th>
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Estado</th>
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Duración</th>
                            <th style="padding: 16px 24px; text-align: left; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Publicado</th>
                            <th style="padding: 16px 24px; text-align: right; font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 20px 24px;">
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <div style="width: 52px; height: 52px; border-radius: 14px; background: #f8fafc; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            <?php if($proyecto->pro_evidencia_foto): ?>
                                                <img src="<?php echo e(asset('storage/' . $proyecto->pro_evidencia_foto)); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <i class="fas fa-rocket" style="color: var(--text-lighter); font-size: 20px;"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: var(--text); font-size: 14px;"><?php echo e(Str::limit($proyecto->titulo, 40)); ?></div>
                                            <div style="font-size: 11px; color: var(--text-lighter); font-weight: 600;">ID: PROJ-<?php echo e(str_pad($proyecto->id, 4, '0', STR_PAD_LEFT)); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 20px 24px;">
                                    <span style="background: #f1f5f9; color: var(--text-light); padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                        <?php echo e($proyecto->categoria); ?>

                                    </span>
                                </td>
                                <td style="padding: 20px 24px;">
                                    <?php
                                        $statusClass = match($proyecto->estado) {
                                            'aprobado' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#16a34a'],
                                            'pendiente' => ['bg' => '#fffbeb', 'border' => '#fde68a', 'text' => '#d97706'],
                                            'rechazado' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#ef4444'],
                                            default => ['bg' => '#f1f5f9', 'border' => '#e2e8f0', 'text' => '#64748b'],
                                        };
                                    ?>
                                    <span style="background: <?php echo e($statusClass['bg']); ?>; border: 1px solid <?php echo e($statusClass['border']); ?>; color: <?php echo e($statusClass['text']); ?>; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">
                                        <?php echo e($proyecto->estado); ?>

                                    </span>
                                </td>
                                <td style="padding: 20px 24px; font-weight: 700; color: var(--text-light); font-size: 14px;">
                                    <i class="fas fa-hourglass" style="margin-right: 6px; color: #3eb489;"></i>
                                    <?php echo e($proyecto->duracion_estimada_dias); ?> días
                                </td>
                                <td style="padding: 20px 24px; color: var(--text-lighter); font-size: 13px; font-weight: 600;">
                                    <i class="far fa-calendar-alt" style="margin-right: 6px;"></i>
                                    <?php echo e(\Carbon\Carbon::parse($proyecto->fecha_publicacion)->translatedFormat('d M, Y')); ?>

                                </td>
                                <td style="padding: 20px 24px;">
                                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                        <?php if($proyecto->estado == 'aprobado'): ?>
                                        <a href="<?php echo e(route('empresa.proyectos.postulantes', $proyecto->id)); ?>" style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" title="Ver Postulantes" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                                            <i class="fas fa-users-viewfinder"></i>
                                        </a>
                                        <a href="<?php echo e(route('empresa.proyectos.reporte', $proyecto->id)); ?>" target="_blank" style="width: 36px; height: 36px; border-radius: 10px; background: #f0fdf4; color: #16a34a; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" title="Exportar PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('empresa.proyectos.edit', $proyecto->id)); ?>" style="width: 36px; height: 36px; border-radius: 10px; background: #f8fafc; color: var(--text-light); display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" title="Editar" onmouseover="this.style.background='#3eb489'; this.style.color='white'" onmouseout="this.style.background='#f8fafc'; this.style.color='var(--text-light)'">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="<?php echo e(route('empresa.proyectos.destroy', $proyecto->id)); ?>" method="POST" id="cerrar-form-<?php echo e($proyecto->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>
                                        <button type="button" onclick="openConfirm('¿Cerrar proyecto?', 'El proyecto &quot;<?php echo e(Str::limit($proyecto->titulo, 30)); ?>&quot; ya no será visible para nuevos aprendices.', () => document.getElementById('cerrar-form-<?php echo e($proyecto->id); ?>').submit())" style="width: 36px; height: 36px; border-radius: 10px; background: #fef2f2; color: #ef4444; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s;" title="Cerrar" onmouseover="this.style.background='#ef4444'; this.style.color='white'" onmouseout="this.style.background='#fef2f2'; this.style.color='#ef4444'">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div style="text-align: center; padding: 80px 40px;">
                <div style="width: 100px; height: 100px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3eb489; margin: 0 auto 24px; font-size: 40px;">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 8px;">Aún no tienes convocatorias</h3>
                <p style="color: var(--text-light); font-size: 16px; margin-bottom: 32px;">Inicia hoy mismo publicando tu primer proyecto para atraer el talento que necesitas.</p>
                <a href="<?php echo e(route('empresa.proyectos.crear')); ?>" class="btn-premium" style="padding: 14px 28px;">
                    <i class="fas fa-rocket"></i> Empezar Ahora
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/empresa/proyectos.blade.php ENDPATH**/ ?>