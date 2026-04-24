<?php $__env->startSection('title', 'Gestión de Proyecto | ' . $proyecto->titulo); ?>
<?php $__env->startSection('page-title', 'Gestión Técnica'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
    <a href="<?php echo e(route('instructor.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="<?php echo e(route('instructor.proyectos')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.proyectos*') ? 'active' : ''); ?>">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="<?php echo e(route('instructor.historial')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.historial') ? 'active' : ''); ?>">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="<?php echo e(route('instructor.aprendices')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.aprendices') ? 'active' : ''); ?>">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="<?php echo e(route('instructor.perfil')); ?>" class="nav-item <?php echo e(request()->routeIs('instructor.perfil') ? 'active' : ''); ?>">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/instructor.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div style="margin-bottom: 24px;">
    <a href="<?php echo e(route('instructor.proyectos')); ?>" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-light); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; padding: 8px 16px; background: white; border-radius: 12px; border: 1px solid rgba(62,180,137,0.1); box-shadow: 0 2px 4px rgba(0,0,0,0.02);" onmouseover="this.style.color='#3eb489'; this.style.borderColor='rgba(62,180,137,0.3)'; this.style.transform='translateX(-4px)'" onmouseout="this.style.color='var(--text-light)'; this.style.borderColor='rgba(62,180,137,0.1)'; this.style.transform='translateX(0)'">
        <i class="fas fa-arrow-left"></i> Regresar a Mis Proyectos
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
    
    <!-- Main Management Pillar -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Project Hero Card -->
        <div style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid rgba(62,180,137,0.1);">
            <div class="instructor-project-hero">
                <img src="<?php echo e($proyecto->imagen_url); ?>?t=<?php echo e(time()); ?>" alt="" style="width:100%; height:100%; object-fit:cover;">
                <div class="instructor-hero-overlay"></div>
                
                <div class="instructor-hero-content">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                        <div>
                            <span style="background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-bottom: 8px; display: inline-block;"><?php echo e($proyecto->categoria); ?></span>
                            <h2 style="color: white; font-size: 2rem; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.3); margin: 0;"><?php echo e($proyecto->titulo); ?></h2>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.95rem; margin-top: 8px; font-weight: 500;"><i class="fas fa-building" style="margin-right: 8px;"></i><?php echo e($proyecto->nombre); ?></p>
                        </div>
                        <button type="button" onclick="document.getElementById('uploadForm').classList.toggle('active')" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white; padding: 10px 18px; border: 1px solid rgba(255,255,255,0.25); border-radius: 12px; font-weight: 700; cursor: pointer;">
                            <i class="fas fa-camera" style="margin-right: 8px;"></i> Editar Visual
                        </button>
                    </div>
                </div>
            </div>

            <div id="uploadForm" class="instructor-collapsible" style="display: none;">
                <form action="<?php echo e(route('instructor.proyectos.imagen', $proyecto->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <input type="file" name="imagen" accept="image/*" required class="aprendiz-input-control" style="flex: 1; padding: 10px;">
                        <button type="submit" class="btn-premium" style="width: auto; padding: 10px 24px;">Actualizar Portada</button>
                    </div>
                </form>
            </div>

            <div style="padding: 2rem;">
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: rgba(62,180,137,0.05); padding: 1.25rem; border-radius: 14px; border: 1px solid rgba(62,180,137,0.1); display:flex; align-items:center; gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:rgba(62,180,137,0.1);color:#3eb489;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-rocket" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <p style="font-size:0.65rem;color:var(--text-light);text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;font-weight:700;">Publicación</p>
                            <p style="font-weight:800;color:var(--text);font-size:0.9rem;"><?php echo e($proyecto->fecha_publicacion ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d M, Y') : 'No definida'); ?></p>
                        </div>
                    </div>
                    <div style="background:rgba(62,180,137,0.05);padding:1.25rem;border-radius:14px;border:1px solid rgba(62,180,137,0.1);display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:rgba(62,180,137,0.1);color:#3eb489;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-hourglass-half" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <p style="font-size:0.65rem;color:var(--text-light);text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;font-weight:700;">Duración</p>
                            <p style="font-weight:800;color:var(--text);font-size:0.9rem;"><?php echo e($proyecto->duracion_estimada_dias); ?> días</p>
                        </div>
                    </div>
                    <div style="background:#fef2f2;padding:1.25rem;border-radius:14px;border:1px solid #fecaca;display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:#fee2e2;color:#ef4444;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-flag-checkered" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <p style="font-size:0.65rem;color:#ef4444;text-transform:uppercase;letter-spacing:1px;margin-bottom:2px;font-weight:700;">Cierre estimado</p>
                            <p style="font-weight:800;color:#ef4444;font-size:0.9rem;"><?php echo e($proyecto->fecha_publicacion ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias ?? 0)->format('d M, Y') : 'No estimado'); ?></p>
                        </div>
                    </div>
                </div>

                
                <?php if($proyecto->latitud && $proyecto->longitud): ?>
                <div style="margin-bottom:1.5rem;border-radius:16px;overflow:hidden;border:1px solid rgba(62,180,137,0.2);">
                    <div style="background:rgba(62,180,137,0.05);padding:10px 16px;display:flex;align-items:center;gap:8px;border-bottom:1px solid rgba(62,180,137,0.1);">
                        <i class="fas fa-map-marker-alt" style="color:#ef4444;font-size:13px;"></i>
                        <span style="font-size:0.7rem;font-weight:800;color:var(--text);text-transform:uppercase;letter-spacing:0.5px;">Ubicación de la empresa</span>
                    </div>
                    <div id="instructor-map" style="width:100%;height:220px;"></div>
                </div>
                <?php else: ?>
                <div style="margin-bottom:1.5rem;display:flex;align-items:center;gap:10px;background:#f8fafc;border:1px dashed #e2e8f0;border-radius:12px;padding:12px 16px;">
                    <i class="fas fa-map-marker-alt" style="color:#94a3b8;"></i>
                    <span style="font-size:0.85rem;color:var(--text-light);font-weight:500;">Ubicación geográfica no registrada para este proyecto.</span>
                </div>
                <?php endif; ?>

                <div style="color: var(--text-light); line-height: 1.7; font-size: 0.95rem;">
                    <h4 style="color: var(--text); font-weight: 800; margin-bottom: 0.75rem;">Descripción Técnica</h4>
                    <?php echo nl2br(e($proyecto->pro_description ?? $proyecto->descripcion)); ?>

                </div>
            </div>
        </div>

        <!-- Working Plan (Stages) -->
        <div style="background: white; padding: 2rem; border-radius: 20px; border: 1px solid rgba(62,180,137,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--text);">Mapa de Ruta Académica</h3>
                    <p style="color: var(--text-light); font-size: 0.9rem; font-weight: 500;">Define las etapas y hitos del proyecto.</p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="button" onclick="document.getElementById('estructuraForm').classList.toggle('active')" class="btn-premium" style="width: auto; padding: 10px 20px; background: rgba(62,180,137,0.1); color: #3eb489;">
                        <i class="fas fa-file-alt" style="margin-right: 8px;"></i> Subir Estructura
                    </button>
                    <button type="button" onclick="document.getElementById('stageForm').classList.toggle('active')" class="btn-premium" style="width: auto; padding: 10px 24px;">
                        <i class="fas fa-plus" style="margin-right: 8px;"></i> Nueva Etapa
                    </button>
                </div>
            </div>

            
            <div id="estructuraForm" class="instructor-collapsible" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: rgba(62,180,137,0.03); border-radius: 14px; border: 1px dashed rgba(62,180,137,0.2);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <div>
                        <h4 style="font-weight: 800; color: var(--text); font-size: 1rem; margin-bottom: 4px;">
                            <i class="fas fa-folder-open" style="color: #3eb489; margin-right: 8px;"></i>
                            Archivo de Estructura del Proyecto
                        </h4>
                        <p style="font-size: 0.8rem; color: var(--text-light); font-weight: 500;">Sube un documento con la estructura, rubricas o planificacion general.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('estructuraForm').classList.toggle('active')" style="background: transparent; border: none; color: var(--text-light); cursor: pointer; font-size: 1.2rem;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <?php if($proyecto->url_estructura): ?>
                <div style="margin-bottom: 1rem; padding: 12px 16px; background: rgba(62,180,137,0.08); border-radius: 10px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 1.2rem;"></i>
                        <div>
                            <p style="font-weight: 700; color: var(--text); font-size: 0.85rem;">Archivo actual</p>
                            <a href="<?php echo e(asset('storage/' . $proyecto->url_estructura)); ?>" target="_blank" style="color: #3eb489; font-size: 0.8rem; font-weight: 600; text-decoration: none;">Ver archivo</a>
                        </div>
                    </div>
                    <form action="<?php echo e(route('instructor.proyectos.estructura.eliminar', $proyecto->id)); ?>" method="POST" id="eliminar-estructura-form" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" onclick="openConfirm('Eliminar archivo', 'Este archivo sera eliminado permanentemente.', () => document.getElementById('eliminar-estructura-form').submit())" style="width: 32px; height: 32px; border-radius: 8px; background: rgba(239,68,68,0.1); color: #ef4444; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
                <?php endif; ?>
                <form action="<?php echo e(route('instructor.proyectos.estructura', $proyecto->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: end;">
                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text); margin-bottom: 6px;">
                                <i class="fas fa-upload" style="margin-right: 6px; color: #3eb489;"></i>
                                Seleccionar archivo
                            </label>
                            <input type="file" name="estructura" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar" class="aprendiz-input-control" style="padding: 10px;">
                            <p style="font-size: 0.75rem; color: var(--text-light); margin-top: 4px;">Formatos: PDF, Word, Excel, PowerPoint, ZIP, RAR | Max: 20MB</p>
                        </div>
                        <button type="submit" class="btn-premium" style="width: auto; padding: 10px 24px;">
                            <i class="fas fa-cloud-upload-alt" style="margin-right: 6px;"></i>Subir
                        </button>
                    </div>
                </form>
            </div>

            
            <div style="margin-bottom: 2rem; padding: 14px 18px; background: linear-gradient(135deg, rgba(62,180,137,0.08), rgba(62,180,137,0.04)); border-radius: 12px; border: 1px solid rgba(62,180,137,0.15); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-alt" style="font-size: 1rem;"></i>
                    </div>
                    <div>
                        <p style="font-weight: 800; color: var(--text); font-size: 0.9rem;">
                            <?php echo e($proyecto->url_estructura ? 'Estructura Personalizada' : 'Estructura Predeterminada'); ?>

                        </p>
                        <p style="font-size: 0.75rem; color: var(--text-light); font-weight: 500;">
                            <?php echo e($proyecto->url_estructura ? 'Archivo personalizado cargado' : 'Documento de planificación estándar'); ?>

                        </p>
                    </div>
                </div>
            </div>
            
            
            <div style="margin-bottom: 2rem; text-align: center;">
                <p style="font-size: 0.8rem; color: var(--text-light);">
                    ¿Deseas comparar con la estructura estándar?
                    <a href="<?php echo e(asset('assets/default-estructura.pdf')); ?>" target="_blank" style="color: #3eb489; font-weight: 700; text-decoration: underline;">Ver estructura predeterminada aquí</a>
                </p>
            </div>

            <div id="stageForm" class="instructor-collapsible" style="display: none; margin-bottom: 2rem;">
                <form action="<?php echo e(route('instructor.etapas.crear', $proyecto->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div style="display: grid; grid-template-columns: 80px 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <input type="number" name="orden" placeholder="N°" required class="aprendiz-input-control">
                        <input type="text" name="nombre" placeholder="Título de la etapa..." required class="aprendiz-input-control">
                    </div>
                    <textarea name="descripcion" placeholder="¿Qué deben entregar los aprendices en esta fase?" required class="aprendiz-input-control" style="min-height: 100px; margin-bottom: 1.5rem;"></textarea>
                    <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                        <button type="button" onclick="document.getElementById('stageForm').classList.toggle('active')" style="background: transparent; border: none; font-weight: 700; color: var(--text-light); cursor: pointer;">Cancelar</button>
                        <button type="submit" class="btn-premium" style="width: auto; padding: 10px 32px;">Lanzar Etapa</button>
                    </div>
                </form>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?php $__empty_1 = true; $__currentLoopData = $etapas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $etapa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="instructor-stage-card" id="stage-card-<?php echo e($etapa->id); ?>" style="background: white; border: 1px solid rgba(62,180,137,0.15); border-radius: 16px; padding: 1.5rem; transition: all 0.2s ease;">
                        
                        <div class="instructor-stage-view" id="stage-view-<?php echo e($etapa->id); ?>" style="display: flex; gap: 1.5rem; align-items: start;">
                            <div class="instructor-stage-number" style="width: 45px; height: 45px; border-radius: 14px; background: <?php echo e($index == 0 ? 'linear-gradient(135deg, #3eb489, #2d9d74)' : 'rgba(62,180,137,0.1)'); ?>; color: <?php echo e($index == 0 ? 'white' : '#3eb489'); ?>; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; flex-shrink: 0;">
                                <?php echo e($etapa->orden); ?>

                            </div>
                            
                            <div style="flex: 1;">
                                <h4 style="font-weight: 800; color: var(--text); margin-bottom: 8px; font-size: 1.15rem;"><?php echo e($etapa->nombre); ?></h4>
                                <p style="font-size: 0.95rem; color: var(--text-light); line-height: 1.7; font-weight: 500; margin-bottom: 12px;"><?php echo e($etapa->descripcion); ?></p>
                                
                                <?php if($etapa->url_documento): ?>
                                <div style="padding: 10px 14px; background: rgba(62,180,137,0.05); border-radius: 10px; display: inline-flex; align-items: center; gap: 12px; border: 1px solid rgba(62,180,137,0.1);">
                                    <i class="fas fa-file-alt" style="color: #3eb489; font-size: 1rem;"></i>
                                    <span style="font-size: 0.85rem; font-weight: 700; color: var(--text);">Documento adjunto</span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div style="display: flex; gap: 10px; flex-shrink: 0;">
                                <button type="button" onclick="document.getElementById('docForm-<?php echo e($etapa->id); ?>').classList.toggle('active')" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(62,180,137,0.1); color: #3eb489; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" title="Subir documento">
                                    <i class="fas fa-upload"></i>
                                </button>
                                <button type="button" onclick="toggleEditStage(<?php echo e($etapa->id); ?>)" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(62,180,137,0.1); color: #3eb489; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" title="Editar etapa">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="<?php echo e(route('instructor.etapas.eliminar', $etapa->id)); ?>" method="POST" id="eliminar-etapa-<?php echo e($etapa->id); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" onclick="openConfirm('¿Eliminar etapa?', 'La etapa &quot;<?php echo e(Str::limit($etapa->nombre, 25)); ?>&quot; será eliminada permanentemente.', () => document.getElementById('eliminar-etapa-<?php echo e($etapa->id); ?>').submit())" style="width: 40px; height: 40px; border-radius: 12px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Eliminar etapa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        
                        <div id="stage-edit-<?php echo e($etapa->id); ?>" style="display: none; width: 100%;">
                            <form action="<?php echo e(route('instructor.etapas.editar', $etapa->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <input type="number" name="orden" value="<?php echo e($etapa->orden); ?>" placeholder="N°" required class="aprendiz-input-control" style="border-radius: 10px;">
                                    <input type="text" name="nombre" value="<?php echo e($etapa->nombre); ?>" placeholder="Título de la etapa..." required class="aprendiz-input-control" style="border-radius: 10px;">
                                </div>
                                <textarea name="descripcion" placeholder="Descripción de la etapa..." required class="aprendiz-input-control" style="min-height: 100px; margin-bottom: 1rem; border-radius: 10px;"><?php echo e($etapa->descripcion); ?></textarea>
                                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                                    <button type="button" onclick="toggleEditStage(<?php echo e($etapa->id); ?>)" style="background: transparent; border: none; font-weight: 700; color: var(--text-light); cursor: pointer; padding: 10px 20px;">Cancelar</button>
                                    <button type="submit" class="btn-premium" style="width: auto; padding: 10px 24px; border-radius: 10px;">
                                        <i class="fas fa-save" style="margin-right: 8px;"></i>Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>

                        
                        <div id="docForm-<?php echo e($etapa->id); ?>" class="instructor-collapsible" style="display: none; margin-top: 1.5rem; padding: 1.5rem; background: #f8fafc; border-radius: 14px; border: 1px dashed #e2e8f0;">
                            <form action="<?php echo e(route('instructor.etapas.documento', $etapa->id)); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div style="margin-bottom: 1.25rem;">
                                    <label style="display: block; font-size: 0.9rem; font-weight: 700; color: var(--text); margin-bottom: 8px;">
                                        <i class="fas fa-file-upload" style="margin-right: 8px; color: #3eb489;"></i>
                                        Cargar Documento/Guía (PDF, Word, Excel, PPT)
                                    </label>
                                    <input type="file" name="documento" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" class="aprendiz-input-control" style="padding: 12px; border-radius: 10px; background: white;">
                                    <p style="font-size: 0.8rem; color: var(--text-light); margin-top: 6px;">Formato máximo: 10MB</p>
                                </div>
                                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                                    <button type="button" onclick="document.getElementById('docForm-<?php echo e($etapa->id); ?>').classList.toggle('active')" style="background: transparent; border: none; font-weight: 700; color: var(--text-light); cursor: pointer;">Cancelar</button>
                                    <button type="submit" class="btn-premium" style="width: auto; padding: 10px 24px; border-radius: 10px;">
                                        <i class="fas fa-upload" style="margin-right: 8px;"></i>Subir Documento
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="instructor-empty-state" style="text-align: center; padding: 3rem; background: #f8fafc; border-radius: 20px; border: 2px dashed #e2e8f0;">
                        <i class="fas fa-project-diagram" style="font-size: 48px; color: #cbd5e1; margin-bottom: 1rem;"></i>
                        <h4 style="color: var(--text-light); font-weight: 600;">Aún no hay etapas definidas.</h4>
                        <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 8px;">Define el plan de trabajo para que los aprendices comiencen sus entregas.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Management Pillar -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 2rem;">
        
        <!-- Quick Stats -->
        <div class="instructor-sidebar-card" style="text-align: center;">
            <p style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: var(--text-light); margin-bottom: 1rem;">Estado del Proyecto</p>
            <span style="background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; padding: 10px 20px; border-radius: 20px; font-size: 0.9rem; font-weight: 700; display: inline-block;">
                 <i class="fas fa-check-circle" style="margin-right: 8px;"></i> <?php echo e($proyecto->estado); ?>

            </span>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 1.5rem; border-top: 1px solid rgba(62,180,137,0.1); padding-top: 1.5rem;">
                <div>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #3eb489;"><?php echo e($integrantes->count()); ?></p>
                    <p style="font-size: 0.7rem; color: var(--text-light); font-weight: 700; text-transform: uppercase;">Equipo</p>
                </div>
                <div>
                    <p style="font-size: 1.5rem; font-weight: 800; color: #3eb489;"><?php echo e($etapas->count()); ?></p>
                    <p style="font-size: 0.7rem; color: var(--text-light); font-weight: 700; text-transform: uppercase;">Etapas</p>
                </div>
            </div>
        </div>

        <!-- Suite de Seguimiento -->
        <div class="instructor-sidebar-card">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text); margin-bottom: 1.25rem;">Suite de Seguimiento</h4>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="<?php echo e(route('instructor.reporte', $proyecto->id)); ?>" class="btn-premium" style="justify-content: center;">
                    <i class="fas fa-chart-bar"></i> Dashboard de Métricas
                </a>
                <a href="<?php echo e(route('instructor.evidencias.ver', $proyecto->id)); ?>" class="btn-premium" style="justify-content: center;">
                    <i class="fas fa-tasks"></i> Calificar Entregas
                </a>
            </div>
        </div>

        <!-- Postulations Pool -->
        <div class="instructor-sidebar-card">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text); margin-bottom: 1rem;">Solicitudes Pendientes (<?php echo e($postulaciones->where('estado', 'pendiente')->count()); ?>)</h4>
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <?php $__empty_1 = true; $__currentLoopData = $postulaciones->where('estado', 'pendiente'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="instructor-postulant-item">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; box-shadow: 0 4px 8px rgba(62,180,137,0.3);">
                                <?php echo e(substr($p->aprendiz->nombres ?? 'A', 0, 1)); ?>

                            </div>
                            <div style="overflow: hidden;">
                                <p style="font-size: 0.85rem; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($p->aprendiz->nombres); ?></p>
                                <p style="font-size: 0.7rem; color: var(--text-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600;"><?php echo e($p->aprendiz->programa_formacion); ?></p>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <form action="<?php echo e(route('instructor.postulaciones.estado', $p->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="estado" value="aceptada">
                                <button type="submit" style="width: 100%; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; border: none; padding: 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">Aceptar</button>
                            </form>
                            <form action="<?php echo e(route('instructor.postulaciones.estado', $p->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="estado" value="rechazada">
                                <button type="submit" style="width: 100%; background: rgba(62,180,137,0.08); color: #3eb489; border: 1px solid rgba(62,180,137,0.2); padding: 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">Omitir</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="text-align: center; color: var(--text-light); font-size: 0.85rem; padding: 1rem; font-weight: 500;">Sin solicitudes pendientes.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Current Team -->
        <div class="instructor-sidebar-card">
            <h4 style="font-size: 0.9rem; font-weight: 800; color: var(--text); margin-bottom: 1rem;">Equipo de Trabajo (<?php echo e($integrantes->count()); ?>)</h4>
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <?php $__empty_1 = true; $__currentLoopData = $integrantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="instructor-team-member">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem; border: 1px solid rgba(62,180,137,0.2);">
                            <?php echo e(substr($i->aprendiz->nombres, 0, 1)); ?>

                        </div>
                        <div style="overflow: hidden;">
                            <p style="font-size: 0.8rem; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($i->aprendiz->nombres); ?> <?php echo e($i->aprendiz->apellidos); ?></p>
                            <p style="font-size: 0.65rem; color: var(--text-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600;"><?php echo e($i->aprendiz->usuario->correo); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="text-align: center; color: var(--text-light); font-size: 0.85rem; font-weight: 500;">Equipo vacío.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEditStage(id) {
    const viewEl = document.getElementById('stage-view-' + id);
    const editEl = document.getElementById('stage-edit-' + id);
    if (editEl.style.display === 'none') {
        viewEl.style.display = 'none';
        editEl.style.display = 'block';
    } else {
        viewEl.style.display = 'flex';
        editEl.style.display = 'none';
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php if($proyecto->latitud && $proyecto->longitud): ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="<?php echo e(asset('js/maps.js')); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initViewMap('instructor-map', <?php echo e($proyecto->latitud); ?>, <?php echo e($proyecto->longitud); ?>, '<?php echo e($proyecto->nombre); ?>');
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/instructor/detalle_proyecto.blade.php ENDPATH**/ ?>