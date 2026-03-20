<header class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo SENA">
        </a>
        <span>Inspírate SENA</span>
    </div>

    <nav class="menu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">Nosotros</a>
    </nav>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-login">Ingresar</a>
    </div>
</header>
