<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') - Inspírate SENA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/instructorDash.css') }}">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --verde: #298564;
            --verde-dark: #3eb489;
            --verde-light: #e8f5e0;
            --sidebar-w: 260px;
            --gris: #f4f6f9;
            --texto: #2c3e50;
            --blanco: #fff;
            --sombra: 0 4px 20px rgba(0,0,0,0.08);
            --radio: 12px;
        }
        body { font-family: 'Poppins', sans-serif; color: var(--texto); background: var(--gris); display: flex; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, #298564 0%, #298564 50%, #298564 100%);
            position: fixed; top: 0; left: 0; height: 100vh;
            display: flex; flex-direction: column;
            z-index: 100; transition: transform .3s;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        .sidebar-logo {
            padding: 24px 20px;
            display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }
        .sidebar-logo img { width: 40px; height: 40px; border-radius: 50%; background: #fff; padding: 4px; }
        .sidebar-logo span { color: #fff; font-weight: 700; font-size: 15px; line-height: 1.2; }
        .sidebar-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .nav-label { color: rgba(255,255,255,.5); font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; padding: 12px 20px 6px; }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 20px; color: rgba(255,255,255,.85); font-size: 14px;
            transition: all .2s; cursor: pointer;
            border-left: 3px solid transparent;
        }
        .nav-item:hover, .nav-item.active { background: rgba(255,255,255,.15); color: #fff; border-left-color: #fff; }
        .nav-item i { width: 20px; text-align: center; font-size: 16px; }
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,.15); }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,.3); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; }
        .user-name { color: #fff; font-size: 13px; font-weight: 500; }
        .user-role { color: rgba(255,255,255,.6); font-size: 11px; }

        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            background: var(--blanco); padding: 0 28px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,.06); position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 18px; font-weight: 600; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .page-content { flex: 1; padding: 28px; scroll-behavior: smooth; }
        .page-content h1, .page-content h2, .page-content h3, .page-content section { scroll-margin-top: 80px; }

        /* ── CARDS ── */
        .card { background: var(--blanco); border-radius: var(--radio); box-shadow: var(--sombra); padding: 24px; }
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: var(--blanco); border-radius: var(--radio); padding: 20px; box-shadow: var(--sombra); text-align: center; border-top: 4px solid var(--verde); transition: transform .2s; }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-card h3 { font-size: 32px; font-weight: 700; color: var(--verde); }
        .stat-card p { font-size: 13px; color: #666; margin-top: 4px; }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 16px; text-align: left; font-size: 14px; border-bottom: 1px solid #f0f0f0; }
        th { background: #f8f9fa; font-weight: 600; font-size: 13px; color: #666; }
        tr:hover td { background: #fafafa; }

        /* ── BUTTONS ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 30px; border: none; cursor: pointer; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; transition: all .2s; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn-primary { background: var(--verde-dark); color: #fff; }
        .btn-primary:hover { background: var(--verde-dark); transform: translateY(-1px); }
        .btn-outline { background: transparent; border: 2px solid var(--verde); color: var(--verde); }
        .btn-outline:hover { background: var(--verde); color: #fff; }
        .btn-danger { background: #e74c3c; color: #fff; }
        .btn-danger:hover { background: #c0392b; }
        .btn-warning { background: #f39c12; color: #fff; }

        /* ── ALERTS ── */
        .alert { padding: 14px 18px; border-radius: var(--radio); margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-error   { background: #f8d7da; color: #721c24; border-left: 4px solid #e74c3c; }
        .alert-warning { background: #fff3cd; color: #856404; border-left: 4px solid #ffc107; }

        /* ── BADGES ── */
        .badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger  { background: #f8d7da; color: #721c24; }
        .badge-info    { background: #cce5ff; color: #004085; }

        /* ── FORM ── */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--texto); }
        .form-control { width: 100%; padding: 10px 14px; border: 2px solid #e8edf0; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; outline: none; transition: border-color .2s; }
        .form-control:focus { border-color: var(--verde); box-shadow: 0 0 0 3px rgba(57,169,0,0.1); }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        
        /* ── PAGINATION ── */
        .pagination { display:flex; gap:6px; justify-content:center; margin-top:20px; }
        .pagination a, .pagination span { padding:8px 14px; border-radius:8px; font-size:13px; }
        .pagination a { background:#fff; color:#2c3e50; border:1px solid #e8edf0; }
        .pagination a:hover { background:#39a900; color:#fff; border-color:#39a900; }
        .pagination span { background:#39a900; color:#fff; }

        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
        }
    </style>
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
                <div>
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
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger" style="width:100%; justify-content: center;">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">@yield('page-title', 'Principal')</span>
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
