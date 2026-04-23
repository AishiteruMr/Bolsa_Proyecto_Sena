<header class="navbar">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo SENA">
        <span>Inspírate SENA</span>
    </a>

    <nav class="menu" id="mainMenu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">Nosotros</a>
    </nav>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
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
