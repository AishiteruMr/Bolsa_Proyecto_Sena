<header class="navbar">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo SENA">
        <span>Inspírate SENA</span>
    </a>

    <nav class="menu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">Nosotros</a>
    </nav>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
    </div>
</header>
