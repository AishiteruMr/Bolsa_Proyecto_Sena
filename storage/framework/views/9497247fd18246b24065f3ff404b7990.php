<?php $__env->startSection('title', 'Mi Perfil - Inspírate SENA'); ?>
<?php $__env->startSection('page-title', 'Mi Perfil'); ?>

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
<?php
    $camposCompletos = 0;
    if(!empty($aprendiz->nombres))  $camposCompletos++;
    if(!empty($aprendiz->apellidos)) $camposCompletos++;
    if(!empty($aprendiz->programa_formacion)) $camposCompletos++;
    if(!empty($usuario->correo))    $camposCompletos++;
    $progresoPerfil = ($camposCompletos / 4) * 100;

    $totalPost     = $aprendiz->postulaciones()->count();
    $aprobadas     = $aprendiz->postulacionesAprobadas()->count();
    $evidencias    = $aprendiz->evidencias()->count();
?>

<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto; padding-bottom: 40px;">

    
    <div class="instructor-hero" style="padding: 48px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-user-circle"></i></div>
        <div style="display: flex; align-items: center; gap: 32px; position: relative; z-index: 1;">
            <div style="position: relative; flex-shrink: 0;">
                <div style="width: 96px; height: 96px; border-radius: 50%; background: rgba(255,255,255,0.18); border: 3px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 900; color: white;">
                    <?php echo e(strtoupper(substr($aprendiz->nombres ?? 'A', 0, 1))); ?>

                </div>
                <div style="position: absolute; bottom: -4px; right: -4px; width: 28px; height: 28px; border-radius: 50%; background: #fbbf24; border: 3px solid white; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #78350f;">
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <div style="flex: 1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <span class="instructor-tag">Mi Perfil</span>
                    <?php if($aprendiz->activo): ?>
                        <span style="background:rgba(251,191,36,0.2); border:1px solid rgba(251,191,36,0.35); color:#fde68a; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:800;">En Formación</span>
                    <?php endif; ?>
                </div>
                <h1 class="instructor-title">Hola, <span style="color: var(--primary);"><?php echo e($aprendiz->nombres); ?>!</span></h1>
                <p style="font-size:15px; color:rgba(255,255,255,0.7); font-weight:500;">
                    <i class="fas fa-graduation-cap" style="margin-right:8px;"></i><?php echo e($aprendiz->programa_formacion); ?>

                </p>

                <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:14px; padding:14px 18px; margin-top:16px; max-width:380px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <span style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px;">Integridad del Perfil</span>
                        <span style="font-size:13px; font-weight:900; color:#fde68a;"><?php echo e($progresoPerfil); ?>%</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.15); border-radius:3px; overflow:hidden;">
                        <div style="width:<?php echo e($progresoPerfil); ?>%; height:100%; background:linear-gradient(90deg,#fde68a,#fbbf24); border-radius:3px; transition:width 1.2s ease;"></div>
                    </div>
                </div>
            </div>

            
            <div style="display:grid; gap:12px; flex-shrink:0;">
                <div class="apr-stat-chip">
                    <div style="font-size:28px; font-weight:900; color:white;"><?php echo e($totalPost); ?></div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Postulaciones</div>
                </div>
                <div class="apr-stat-chip">
                    <div style="font-size:28px; font-weight:900; color:#86efac;"><?php echo e($aprobadas); ?></div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Aprobadas</div>
                </div>
                <div class="apr-stat-chip">
                    <div style="font-size:28px; font-weight:900; color:#fde68a;"><?php echo e($evidencias); ?></div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Evidencias</div>
                </div>
            </div>
        </div>
    </div>

    
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start;">

        
        <div class="glass-card" style="padding:32px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:24px; border-bottom:1.5px solid rgba(62,180,137,0.1);">
                <div style="width:48px; height:48px; border-radius:14px; background:rgba(62,180,137,0.1); color:#3eb489; display:flex; align-items:center; justify-content:center; font-size:20px;">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h3 style="font-size:20px; font-weight:800; color:var(--text);">Datos <span style="color:var(--primary);">Personales</span></h3>
                    <p style="font-size:13px; color:var(--text-light); font-weight:500; margin-top:2px;">Tu información visible en la plataforma.</p>
                </div>
            </div>

            <form action="<?php echo e(route('aprendiz.perfil.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:20px;">
                    <div class="aprendiz-form-group">
                        <label class="aprendiz-form-label">Nombres</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-user aprendiz-input-icon"></i>
                            <input type="text" name="nombre" value="<?php echo e(old('nombre', $aprendiz->nombres)); ?>" required class="aprendiz-input-control" placeholder="Tu nombre">
                        </div>
                    </div>
                    <div class="aprendiz-form-group">
                        <label class="aprendiz-form-label">Apellidos</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-user-tie aprendiz-input-icon"></i>
                            <input type="text" name="apellido" value="<?php echo e(old('apellido', $aprendiz->apellidos)); ?>" required class="aprendiz-input-control" placeholder="Tus apellidos">
                        </div>
                    </div>
                </div>

                <div class="aprendiz-form-group" style="margin-bottom:20px;">
                    <label class="aprendiz-form-label">Programa de Formación</label>
                    <div class="aprendiz-input-wrapper">
                        <i class="fas fa-graduation-cap aprendiz-input-icon"></i>
                        <input type="text" name="programa" value="<?php echo e(old('programa', $aprendiz->programa_formacion)); ?>" required class="aprendiz-input-control" placeholder="Tu programa SENA">
                    </div>
                </div>

                <div class="aprendiz-form-group" style="margin-bottom:28px;">
                    <label class="aprendiz-form-label" style="color:#94a3b8;">Correo Institucional (Solo Lectura)</label>
                    <div class="aprendiz-input-wrapper">
                        <i class="fas fa-envelope aprendiz-input-icon"></i>
                        <input type="email" value="<?php echo e($usuario->correo); ?>" disabled class="aprendiz-input-control aprendiz-input-disabled">
                    </div>
                </div>

                
                <div style="background:#f8fafc; border:2px dashed rgba(62,180,137,0.2); border-radius:20px; padding:24px; margin-bottom:28px;">
                    <h4 style="font-size:15px; font-weight:800; color:var(--text); display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                        <i class="fas fa-shield-alt" style="color:#3eb489;"></i> Seguridad
                    </h4>
                    <div class="aprendiz-form-group" style="margin-bottom:16px;">
                        <label class="aprendiz-form-label">Nueva Contraseña (Opcional)</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-lock aprendiz-input-icon"></i>
                            <input type="password" name="password" placeholder="Mínimo 6 caracteres (vacío = sin cambio)" class="aprendiz-input-control">
                        </div>
                    </div>
                    <div class="aprendiz-form-group" style="margin-bottom:0;">
                        <label class="aprendiz-form-label">Confirmar Contraseña</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-lock aprendiz-input-icon"></i>
                            <input type="password" name="password_confirmation" placeholder="Repite la contraseña" class="aprendiz-input-control">
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-aprendiz-action" style="padding:16px 40px; font-size:15px;">
                        <i class="fas fa-sync-alt"></i> Actualizar Mi Perfil
                    </button>
                </div>
            </form>
        </div>

        
        <div style="display:flex; flex-direction:column; gap:20px;">

            
            <div class="glass-card" style="padding:24px;">
                <h4 style="font-size:12px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">Tu Actividad</h4>
                <div style="display:grid; gap:12px;">
                    <?php $__currentLoopData = [
                        ['icon'=>'fa-paper-plane','bg'=>'rgba(62,180,137,0.1)','color'=>'#3eb489','label'=>'Postulaciones','value'=>$totalPost],
                        ['icon'=>'fa-check-circle','bg'=>'#eff6ff','color'=>'#3b82f6','label'=>'Proyectos OK','value'=>$aprobadas],
                        ['icon'=>'fa-file-alt','bg'=>'#fffbeb','color'=>'#f59e0b','label'=>'Evidencias','value'=>$evidencias],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:<?php echo e($s['bg']); ?>; border-radius:14px; border:1px solid rgba(0,0,0,0.05);">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.7); color:<?php echo e($s['color']); ?>; display:flex; align-items:center; justify-content:center; font-size:14px;">
                                <i class="fas <?php echo e($s['icon']); ?>"></i>
                            </div>
                            <span style="font-size:13px; font-weight:700; color:#475569;"><?php echo e($s['label']); ?></span>
                        </div>
                        <span style="font-size:20px; font-weight:900; color:#1e293b;"><?php echo e($s['value']); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="glass-card" style="padding:24px; background:linear-gradient(135deg, #3eb489, #2d9d74); color:white; border:none; position:relative; overflow:hidden;">
                <div style="position:absolute; top:-20px; right:-20px; font-size:100px; color:rgba(255,255,255,0.08);"><i class="fas fa-graduation-cap"></i></div>
                <h4 style="font-size:12px; font-weight:700; color:rgba(255,255,255,0.7); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; position:relative;">Programa Activo</h4>
                <p style="font-size:17px; font-weight:800; line-height:1.4; position:relative; margin-bottom:16px;"><?php echo e($aprendiz->programa_formacion); ?></p>
                <span style="background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.25); padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; position:relative;">En Formación</span>
            </div>

            
            <div class="glass-card" style="padding:24px;">
                <div style="display:flex; align-items:center; gap:14px; margin-bottom:12px;">
                    <div style="width:40px; height:40px; border-radius:12px; background:#fef2f2; color:#ef4444; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h4 style="font-size:15px; font-weight:800; color:var(--text);">¿Necesitas ayuda?</h4>
                </div>
                <p style="font-size:13px; color:var(--text-light); font-weight:500; line-height:1.5; margin-bottom:16px;">Si tienes problemas con tu información institucional, contacta a la coordinación.</p>
                <a href="mailto:soporte@sena.edu.co" class="btn-premium" style="width:100%; justify-content:center; padding:12px;">
                    <i class="fas fa-envelope"></i> Contactar Soporte
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/aprendiz/perfil.blade.php ENDPATH**/ ?>