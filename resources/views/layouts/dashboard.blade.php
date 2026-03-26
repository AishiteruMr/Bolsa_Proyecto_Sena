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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --primary: #3EB489;
            --primary-light: #52c89a;
            --primary-dark: #298564;
            --primary-soft: rgba(62, 180, 137, 0.12);
            --secondary: #264653;
            --bg: #E0F2F1;
            --surface: #ffffff;
            --text: #000000;
            --text-light: #4a6572;
            --border: #b2dfdb;
            --shadow-sm: 0 1px 3px rgba(38,70,83,0.08);
            --shadow: 0 10px 15px -3px rgba(38,70,83,0.12), 0 4px 6px -2px rgba(38,70,83,0.06);
            --radius-sm: 8px;
            --radius: 16px;
            --sidebar-w: 280px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            font-family: 'Outfit', sans-serif; 
            background: var(--bg); 
            color: var(--text); 
            display: flex; 
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, #264653 0%, #1a323d 100%);
            color: #fff;
            position: fixed; top: 0; left: 0; height: 100vh;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 10px 0 40px rgba(38,70,83,0.25);
        }

        .sidebar-logo {
            padding: 32px 24px;
            display: flex; align-items: center; gap: 14px;
            border-bottom: 1px solid rgba(62,180,137,0.2);
        }
        .sidebar-logo img { 
            width: 44px; height: 44px; 
            background: #fff; padding: 6px; 
            border-radius: 12px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .sidebar-logo span { 
            font-size: 18px; font-weight: 700; 
            line-height: 1.1; letter-spacing: -0.5px;
            color: #fff;
        }

        .sidebar-nav { flex: 1; padding: 20px 16px; overflow-y: auto; }
        
        .nav-label { 
            display: block;
            font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.35); 
            text-transform: uppercase; letter-spacing: 2px; 
            margin: 24px 12px 10px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 14px;
            padding: 13px 16px; 
            color: rgba(255,255,255,0.65); 
            font-size: 14.5px; font-weight: 500;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 4px;
            text-decoration: none;
        }
        .nav-item i { font-size: 17px; width: 22px; text-align: center; }
        .nav-item:hover { 
            background: rgba(62,180,137,0.15); 
            color: #3EB489; 
            transform: translateX(4px);
        }
        .nav-item.active { 
            background: linear-gradient(135deg, #3EB489 0%, #298564 100%);
            color: #fff; 
            box-shadow: 0 6px 20px rgba(62,180,137,0.35);
        }

        .sidebar-footer { 
            padding: 20px 24px; 
            background: rgba(0,0,0,0.15);
            border-top: 1px solid rgba(62,180,137,0.15);
        }
        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-avatar { 
            width: 40px; height: 40px; 
            background: linear-gradient(135deg, #3EB489 0%, #298564 100%);
            border-radius: 10px; 
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(62,180,137,0.3);
        }
        .user-name { font-size: 14px; font-weight: 600; color: #fff; }
        .user-role { font-size: 11px; color: rgba(255,255,255,0.45); margin-top: 2px; }

        /* ── MAIN CONTENT ── */
        .main { 
            margin-left: var(--sidebar-w); 
            flex: 1; min-height: 100vh;
            display: flex; flex-direction: column;
            transition: all 0.4s ease;
        }

        .topbar {
            height: 76px; 
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(38,70,83,0.08);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; position: sticky; top: 0; z-index: 10;
            box-shadow: 0 2px 12px rgba(38,70,83,0.06);
        }
        .topbar-title { 
            font-size: 20px; font-weight: 700; letter-spacing: -0.5px;
            color: #000;
        }

        .page-content { padding: 32px 40px 48px; overflow-y: auto; }

        /* ── MODERN CARDS ── */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(38,70,83,0.1); }

        /* ── FORM CONTROLS ── */
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px; font-size: 14px;
            font-family: 'Outfit', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: var(--text);
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(62,180,137,0.15);
        }

        /* ── STATS BENTO ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: var(--surface);
            padding: 24px; border-radius: var(--radius);
            border: 1px solid var(--border);
            text-align: left;
            position: relative; overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card::after {
            content: ''; position: absolute; top:0; right:0;
            width: 80px; height: 80px;
            background: var(--primary-soft);
            border-radius: 0 var(--radius) 0 100%;
            z-index: 0;
        }
        .stat-card h3 { font-size: 34px; font-weight: 800; color: var(--primary-dark); position: relative; z-index: 1; }
        .stat-card p { font-size: 13px; font-weight: 500; color: var(--text-light); margin-top: 6px; }

        /* ── TABLES ── */
        .table-container { 
            width: 100%; overflow-x: auto; 
            border-radius: 14px; border: 1px solid var(--border);
            background: #fff;
        }
        table { width: 100%; border-collapse: collapse; }
        th { 
            background: #E0F2F1; padding: 14px 20px;
            text-align: left; font-size: 11px; font-weight: 700;
            color: #264653; text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        td { padding: 15px 20px; font-size: 14px; border-bottom: 1px solid var(--border); color: var(--text); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(62,180,137,0.04); }

        /* ── BUTTONS ── */
        .btn {
            padding: 10px 24px; border-radius: 12px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none; display: inline-flex; align-items: center; gap: 8px;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
        }
        .btn-primary { 
            background: linear-gradient(135deg, #3EB489 0%, #298564 100%); 
            color: #fff; 
            box-shadow: 0 4px 14px rgba(62,180,137,0.3); 
        }
        .btn-primary:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 24px rgba(62,180,137,0.45); 
            filter: brightness(1.05);
        }
        
        .btn-outline { 
            background: #fff; 
            border: 2px solid #3EB489; 
            color: #298564; 
        }
        .btn-outline:hover { 
            background: #3EB489; 
            color: #fff; 
            border-color: #3EB489;
        }

        .btn-sm { padding: 7px 16px; font-size: 13px; border-radius: 8px; }

        /* ── BADGES ── */
        .badge {
            padding: 5px 12px; border-radius: 20px;
            font-size: 11.5px; font-weight: 700;
            display: inline-block; letter-spacing: 0.3px;
        }
        .badge-success { background: rgba(62,180,137,0.15); color: #298564; border: 1px solid rgba(62,180,137,0.3); }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #E0F2F1; color: #264653; border: 1px solid #b2dfdb; }

        /* ── ALERTS ── */
        .alert { 
            padding: 14px 20px; border-radius: 12px; margin-bottom: 20px;
            font-size: 14px; font-weight: 500;
            animation: slideIn 0.4s ease;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: rgba(62,180,137,0.12); color: #298564; border: 1px solid rgba(62,180,137,0.25); }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        @keyframes slideIn { from { transform: translateY(-16px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .notification-bell:hover { color: var(--primary) !important; transform: scale(1.1); }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .sidebar.open { transform: translateX(0); }
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
            <span class="topbar-title">@yield('page-title', 'Principal')</span>
            <div class="topbar-right">
                <span style="font-size:13px; color:#666;">{{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

            <x-toast-container />

            @if(session('success'))
                <div x-init="$nextTick(() => { $dispatch('notify', { message: '{{ session('success') }}', type: 'success' }) })"></div>
            @endif
            @if(session('error'))
                <div x-init="$nextTick(() => { $dispatch('notify', { message: '{{ session('error') }}', type: 'error' }) })"></div>
            @endif
            @if(session('warning'))
                <div x-init="$nextTick(() => { $dispatch('notify', { message: '{{ session('warning') }}', type: 'warning' }) })"></div>
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div x-init="$nextTick(() => { $dispatch('notify', { message: '{{ $error }}', type: 'error' }) })"></div>
                @endforeach
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
