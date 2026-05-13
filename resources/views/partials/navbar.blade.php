<header class="navbar">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('assets/logo.webp') }}" alt="Logo SENA">
        <span>Inspírate SENA</span>
    </a>

    <nav class="menu" id="mainMenu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">Nosotros</a>
        <a href="{{ route('soporte') }}" class="{{ request()->routeIs('soporte') ? 'active' : '' }}">Soporte</a>
        <a href="{{ route('login') }}" class="btn-login mobile-login">Ingresar</a>
    </nav>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-login desktop-login">Ingresar</a>
        <button class="hamburger" id="hamburgerBtn" onclick="toggleMenu()">
            <i class="fas fa-bars" id="hamburgerIcon"></i>
        </button>
    </div>
    <div id="menuOverlay" onclick="closeMenu()"></div>
</header>

<script>
function toggleMenu() {
    const menu = document.getElementById('mainMenu');
    const icon = document.getElementById('hamburgerIcon');
    const overlay = document.getElementById('menuOverlay');
    menu.classList.toggle('active');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
    if (overlay) overlay.classList.toggle('active');
}

function closeMenu() {
    const menu = document.getElementById('mainMenu');
    const icon = document.getElementById('hamburgerIcon');
    const overlay = document.getElementById('menuOverlay');
    menu.classList.remove('active');
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
    if (overlay) overlay.classList.remove('active');
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
    pointer-events: none;
    transition: opacity 0.3s ease;
}
#menuOverlay.active {
    opacity: 1;
    pointer-events: auto;
}
</style>
