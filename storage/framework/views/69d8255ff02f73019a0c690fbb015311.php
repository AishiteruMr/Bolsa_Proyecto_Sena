<header class="navbar">
    <a href="<?php echo e(route('home')); ?>" class="logo">
        <img src="<?php echo e(asset('assets/logo.webp')); ?>" alt="Logo SENA">
        <span>Inspírate SENA</span>
    </a>

    <nav class="menu" id="mainMenu">
        <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Inicio</a>
        <a href="<?php echo e(route('nosotros')); ?>" class="<?php echo e(request()->routeIs('nosotros') ? 'active' : ''); ?>">Nosotros</a>
        <a href="<?php echo e(route('soporte')); ?>" class="<?php echo e(request()->routeIs('soporte') ? 'active' : ''); ?>">Soporte</a>
        <a href="<?php echo e(route('login')); ?>" class="btn-login mobile-login">Ingresar</a>
    </nav>

    <div class="nav-right">
        <a href="<?php echo e(route('login')); ?>" class="btn-login desktop-login">Ingresar</a>
        <button class="hamburger" id="hamburgerBtn" onclick="toggleMenu()">
            <i class="fas fa-bars" id="hamburgerIcon"></i>
        </button>
    </div>
</header>

<script>
function toggleMenu() {
    const menu = document.getElementById('mainMenu');
    const icon = document.getElementById('hamburgerIcon');
    menu.classList.toggle('active');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
}

function closeMenu() {
    const menu = document.getElementById('mainMenu');
    const icon = document.getElementById('hamburgerIcon');
    menu.classList.remove('active');
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
}

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