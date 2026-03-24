<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') - Inspírate SENA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Layts.dashboard.css') }}">
    @yield('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="SENA">
            <span>Inspírate<br>SENA</span>
        </div>
        <nav class="sidebar-nav">
            @yield('sidebar-nav')
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(session('nombre', 'U'), 0, 1)) }}</div>
                <div style="flex:1">
                    <div class="user-name">{{ session('nombre') }} {{ session('apellido') }}</div>
                    <div class="user-role">
                        @switch(session('rol'))
                            @case(1) Aprendiz @break
                            @case(2) Instructor @break
                            @case(3) Empresa @break
                            @case(4) Administrador @break
                        @endswitch
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0; margin-left: auto;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Cerrar Sesión" style="background: rgba(231, 76, 60, 0.1); border:none; color:#e74c3c; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor:pointer; transition: all 0.3s ease;">
                        <i class="fas fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
            <div class="topbar-right">
                <span style="font-size:13px; color:#666;">{{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">⚠️ {{ session('warning') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => { el.style.opacity='0'; el.style.transition='opacity .5s'; setTimeout(()=>el.remove(),500); }, 4000);
        });
    </script>
    @yield('scripts')
</body>
</html>
