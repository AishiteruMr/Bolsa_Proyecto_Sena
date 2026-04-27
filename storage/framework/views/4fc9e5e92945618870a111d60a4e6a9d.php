<?php $__env->startSection('title', 'Banco de Proyectos - Admin'); ?>
<?php $__env->startSection('page-title', 'Banco de Proyectos'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopSection(); ?>
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
    <a href="<?php echo e(route('admin.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.proyectos') ? 'active' : ''); ?>">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <!-- Header tipo dashboard (icono + degradado suave) -->
        <div class="admin-header-master" style="margin-bottom:18px;">
            <div class="admin-header-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                    <span class="admin-badge-hub">Banco Proyectos</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;">Panel de administración</span>
                </div>
                <h1 class="admin-header-title">Control Central de <span style="color: var(--primary);">Proyectos</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 16px; max-width: 700px; font-weight: 500;">Monitoreo global y asignación estratégica de instructores.</p>
            </div>
        </div>

        <!-- FILTROS DE BÚSQUEDA -->
        <div class="glass-card" style="padding: 24px; margin-bottom: 24px; background: white;">
            <form method="GET" action="<?php echo e(route('admin.proyectos')); ?>">
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 16px; align-items: end;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Buscar</label>
                        <input type="text" name="buscar" value="<?php echo e(request('buscar')); ?>" placeholder="Título, descripción o empresa..." style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Estado</label>
                        <select name="estado" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                            <option value="">Todos</option>
                            <option value="pendiente" <?php echo e(request('estado') == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                            <option value="aprobado" <?php echo e(request('estado') == 'aprobado' ? 'selected' : ''); ?>>Aprobado</option>
                            <option value="rechazado" <?php echo e(request('estado') == 'rechazado' ? 'selected' : ''); ?>>Rechazado</option>
                            <option value="en_progreso" <?php echo e(request('estado') == 'en_progreso' ? 'selected' : ''); ?>>En Progreso</option>
                            <option value="cerrado" <?php echo e(request('estado') == 'cerrado' ? 'selected' : ''); ?>>Cerrado</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Categoría</label>
                        <select name="categoria" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none; background: white;">
                            <option value="">Todas</option>
                            <?php $__currentLoopData = $categorias ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat); ?>" <?php echo e(request('categoria') == $cat ? 'selected' : ''); ?>><?php echo e(ucfirst($cat)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="<?php echo e(request('fecha_inicio')); ?>" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="<?php echo e(request('fecha_fin')); ?>" style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                </div>
                <div style="display: flex; gap: 12px; margin-top: 16px; justify-content: flex-end;">
                    <?php if(request()->has('buscar') || request()->has('estado') || request()->has('categoria') || request()->has('fecha_inicio') || request()->has('fecha_fin')): ?>
                        <a href="<?php echo e(route('admin.proyectos')); ?>" class="btn-premium" style="padding: 12px 20px; background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; box-shadow: none; font-size: 13px;">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="btn-premium" style="padding: 12px 24px; font-size: 13px;">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>

        <?php if(request()->has('buscar') || request()->has('estado') || request()->has('categoria') || request()->has('fecha_inicio') || request()->has('fecha_fin')): ?>
        <div style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 13px; font-weight: 700; color: var(--primary);">
                <i class="fas fa-filter"></i> Mostrando <?php echo e($proyectos->count()); ?> resultado(s)
            </span>
        </div>
        <?php endif; ?>

        <div class="admin-project-grid">
            <?php $__empty_1 = true; $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="glass-card admin-project-card">
                
                <div class="admin-project-card-header">
                    <div style="position:relative; z-index:1;">
                        <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                            <?php
                                $statusStyles = match($p->estado) {
                                    'aprobado' => ['bg' => 'linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%)', 'color' => '#fff', 'icon' => 'fa-check-circle'],
                                    'pendiente' => ['bg' => '#fff7ed', 'color' => '#ea580c', 'icon' => 'fa-clock'],
                                    'rechazado' => ['bg' => '#fef2f2', 'color' => '#dc2626', 'icon' => 'fa-times-circle'],
                                    default => ['bg' => '#f8fafc', 'color' => '#64748b', 'icon' => 'fa-info-circle']
                                };
                            ?>
                            <span class="admin-project-badge" style="background: <?php echo e($statusStyles['bg']); ?>; color: <?php echo e($statusStyles['color']); ?>;">
                                <i class="fas <?php echo e($statusStyles['icon']); ?>"></i>
                                <?php echo e($p->estado); ?>

                            </span>
                        </div>
                    </div>
                    
                    <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; line-height: 1.4; letter-spacing: -0.3px;"><?php echo e(Str::limit($p->titulo, 55)); ?></h3>
                    <p style="font-size: 13px; color: #64748b; margin: 0; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #cbd5e1;"></span>
                        <?php echo e($p->empresa_nombre); ?>

                    </p>
                </div>

                <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                    
                    <?php $hasCalidad = !empty($p->calidad_aprobada); ?>
                    <div style="margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Mentor Asignado</label>
                            <?php if(!$hasCalidad): ?>
                                <span style="font-size: 10px; color: #dc2626; font-weight: 700; background: #fef2f2; padding: 2px 8px; border-radius: 10px;">Pendiente Validación</span>
                            <?php elseif($p->instructor_nombre): ?>
                                <span style="font-size: 10px; color: var(--primary); font-weight: 700; background: var(--primary-soft); padding: 2px 8px; border-radius: 10px;">Asignado</span>
                            <?php else: ?>
                                <span style="font-size: 10px; color: #f97316; font-weight: 700; background: #fff7ed; padding: 2px 8px; border-radius: 10px;">Sin Asignar</span>
                            <?php endif; ?>
                        </div>
                        
                        <form action="<?php echo e(route('admin.proyectos.asignar', $p->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div style="display: flex; gap: 8px;">
                                <select name="instructor_usuario_id" style="flex: 1; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; font-weight: 600; color: #334155; background: #f8fafc; outline: none; transition: border-color 0.2s; cursor: pointer;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e2e8f0'" required <?php echo e(!$hasCalidad ? 'disabled' : ''); ?>>
                                    <option value="" disabled selected><?php echo e($hasCalidad ? 'Seleccionar Instructor...' : 'Validar calidad primero'); ?></option>
                                    <?php if($hasCalidad): ?>
                                        <?php $__currentLoopData = $instructores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ins): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ins->usuario->id ?? ''); ?>" <?php echo e($p->instructor_usuario_id == ($ins->usuario->id ?? '') ? 'selected' : ''); ?>>
                                                <?php echo e($ins->nombres); ?> <?php echo e($ins->apellidos); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <button type="submit" style="width: 42px; border: 1px solid #e2e8f0; border-radius: 10px; background: white; color: var(--primary); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.02); <?php echo e(!$hasCalidad ? 'opacity: 0.5; cursor: not-allowed;' : ''); ?>" <?php echo e(!$hasCalidad ? 'disabled' : ''); ?> title="<?php echo e($hasCalidad ? 'Actualizar' : 'Valida la calidad del proyecto primero'); ?>">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div style="margin-top: auto; display: grid; grid-template-columns: <?php echo e($p->estado == 'aprobado' ? '1fr 1fr' : '1fr'); ?>; gap: 10px;">
                        <a href="<?php echo e(route('admin.proyectos.revisar', $p->id)); ?>" style="text-align: center; padding: 10px; background: white; color: #334155; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 12px; font-weight: 700; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" onmouseover="this.style.background='#f8fafc'; this.style.color='#0f172a';" onmouseout="this.style.background='white'; this.style.color='#334155';">
                            Ver Detalles <i class="fas fa-arrow-right" style="margin-left: 4px; font-size: 10px; opacity: 0.7;"></i>
                        </a>

                        <?php if($p->estado == 'aprobado'): ?>
                        <form action="<?php echo e(route('admin.proyectos.estado', $p->id)); ?>" method="POST" style="width: 100%; margin: 0;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="estado" value="cerrado">
                            <button type="submit" style="width: 100%; text-align: center; padding: 10px; background: white; color: #dc2626; border: 1px solid #fee2e2; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" onmouseover="this.style.background='#fef2f2';" onmouseout="this.style.background='white';">
                                Pausar Proyecto <i class="fas fa-ban" style="margin-left: 4px; font-size: 10px; opacity: 0.7;"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="glass-card admin-empty-state">
                <div style="width: 90px; height: 90px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #cbd5e1; border: 1px solid var(--border);">
                    <i class="fas fa-folder-open" style="font-size:36px;"></i>
                </div>
                <h3 style="font-size:22px; font-weight:800; color:var(--text); margin-bottom: 8px;">No hay registros</h3>
                <p style="color: var(--text-light); font-size:16px; font-weight: 500;">Aún no se han recibido propuestas de proyectos en la plataforma.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/admin/proyectos.blade.php ENDPATH**/ ?>