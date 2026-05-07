<header class="navbar">
    <a href="<?php echo e(route('home')); ?>" class="logo">
        <img src="<?php echo e(asset('assets/logo.webp')); ?>" alt="Logo SENA">
        <span>Inspírate SENA</span>
    </a>

    <nav class="menu" id="mainMenu">
        <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Inicio</a>
        <a href="<?php echo e(route('nosotros')); ?>" class="<?php echo e(request()->routeIs('nosotros') ? 'active' : ''); ?>">Nosotros</a>
        <a href="<?php echo e(route('soporte')); ?>" class="<?php echo e(request()->routeIs('soporte') ? 'active' : ''); ?>">Soporte</a>
    </nav>

    <div class="nav-right">
        <a href="<?php echo e(route('login')); ?>" class="btn-login">Ingresar</a>
        <button class="hamburger" id="hamburgerBtn" onclick="toggleMenu()">
            <i class="fas fa-bars" id="hamburgerIcon"></i>
        </button>
    </div>
</header>

<div id="menuOverlay" style="display: none;"></div>

<script>
function toggleMenu() {
    const menu = document.getElementById('mainMenu');
    const icon = document.getElementById('hamburgerIcon');
    const overlay = document.getElementById('menuOverlay');
    const isOpen = menu.classList.toggle('active');

    if (isOpen) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    } else {
        closeMenu();
    }
}

function closeMenu() {
    const menu = document.getElementById('mainMenu');
    const icon = document.getElementById('hamburgerIcon');
    const overlay = document.getElementById('menuOverlay');
    menu.classList.remove('active');
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
    overlay.style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('menuOverlay').addEventListener('click', closeMenu);

document.querySelectorAll('#mainMenu a').forEach(link => {
    link.addEventListener('click', closeMenu);
});

window.addEventListener('resize', function() {
    if (window.innerWidth > 640) {
        closeMenu();
    }
});
</script>

<style>
#menuOverlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    z-index: 998;
    opacity: 0;
    animation: fadeIn 0.3s forwards;
}

@keyframes fadeIn {
    to { opacity: 1; }
}
</style>
<?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/partials/navbar.blade.php ENDPATH**/ ?>