<header class="navbar">
    <a href="<?php echo e(route('home')); ?>" class="logo">
        <img src="<?php echo e(asset('assets/logo.png')); ?>" alt="Logo SENA">
        <span>Inspírate SENA</span>
    </a>

    <nav class="menu" id="mainMenu">
        <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Inicio</a>
        <a href="<?php echo e(route('nosotros')); ?>" class="<?php echo e(request()->routeIs('nosotros') ? 'active' : ''); ?>">Nosotros</a>
        <a href="<?php echo e(route('soporte')); ?>" class="<?php echo e(request()->routeIs('soporte') ? 'active' : ''); ?>">Soporte</a>
    </nav>

    <div class="nav-right">
        <a href="<?php echo e(route('login')); ?>" class="btn-login">Ingresar</a>
        <button class="hamburger" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<script>
function toggleMenu() {
    const menu = document.getElementById('mainMenu');
    menu.classList.toggle('active');
}
</script>
<?php /**PATH C:\laragon\www\Bolsa_Proyecto_Sena\resources\views/partials/navbar.blade.php ENDPATH**/ ?>