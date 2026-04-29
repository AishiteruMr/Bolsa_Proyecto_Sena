<?php $__env->startSection('title', 'Inspírate SENA - Inicio'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/index.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="hero-section">
        <div class="hero-bg-blobs">
            <div class="hero-blob" style="top:-100px; right: -100px;"></div>
            <div class="hero-blob" style="bottom:-100px; left: -100px; background: rgba(59,130,246,0.1)"></div>
        </div>

        <div class="hero-layout">
            <div class="hero-content">
                <div class="hero-badge" style="font-size: 11px; padding: 6px 12px;">
                    <i class="fas fa-bolt" style="margin-right: 6px;"></i> Portal de Innovación
                </div>
                <h1 class="hero-title">
                    Conectamos <span>Talento</span> con<br><span>Empresa</span>
                </h1>
                <p class="hero-desc">
                    La plataforma definitiva donde aprendices e instructores colaboran en proyectos reales que transforman el ecosistema empresarial de Colombia.
                </p>
                <div class="hero-actions">
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                        Comenzar Ahora <i class="fas fa-rocket" style="margin-left: 10px;"></i>
                    </a>
                    <a href="<?php echo e(route('nosotros')); ?>" class="btn btn-outline" style="border-radius: 16px;">
                        Ver Nosotros <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-image-wrapper">
                    <img src="<?php echo e(asset('assets/sena1.png')); ?>" alt="SENA" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80'">
                </div>
               
              
            </div>
        </div>
    </section>

    <section class="bento-grid">
        <div class="bento-stats">
            <div class="bento-stats-item">
                <div class="bento-stats-number"><?php echo e($totalProyectos); ?></div>
                <div class="bento-stats-label">Proyectos</div>
            </div>
            <div class="bento-stats-item">
                <div class="bento-stats-number"><?php echo e($totalEmpresas); ?></div>
                <div class="bento-stats-label">Empresas</div>
            </div>
            <div class="bento-stats-item">
                <div class="bento-stats-number"><?php echo e($totalAprendices); ?></div>
                <div class="bento-stats-label">Aprendices</div>
            </div>
        </div>

        <div class="bento-item empresas">
            <div class="bento-icon"><i class="fas fa-building"></i></div>
            <h3>Empresas</h3>
            <p>Encuentra soluciones innovadoras para tus desafíos técnicos encargando proyectos a equipos de aprendices calificados.</p>
            <a href="<?php echo e(route('registro.empresa')); ?>" class="btn">
                Registrar empresa <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="bento-item instructores">
            <div class="bento-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <h3>Instructores</h3>
            <p>Lidera el desarrollo de competencias prácticas guiando a los aprendices en la ejecución de proyectos de alto valor.</p>
            <a href="<?php echo e(route('registro.instructor')); ?>" class="btn">
                Unirme como guía <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="bento-item aprendices">
            <div class="bento-icon"><i class="fas fa-user-graduate"></i></div>
            <h3>Aprendices</h3>
            <p>Participa en retos reales, adquiere experiencia certificable y conecta directamente con empresas aliadas.</p>
            <a href="<?php echo e(route('registro.aprendiz')); ?>" class="btn">
                Postular talento <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-content">
            <h2>¿Listo para transformar el futuro?</h2>
            <p>Únete hoy a la mayor comunidad de innovación técnica y comienza a generar valor real en la industria.</p>
            <a href="<?php echo e(route('login')); ?>" class="btn">
                Comenzar Ahora <i class="fas fa-rocket"></i>
            </a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/index.blade.php ENDPATH**/ ?>