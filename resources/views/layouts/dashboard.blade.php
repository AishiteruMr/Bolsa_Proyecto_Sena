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
    <style>
        :root {
            /* Palette SENA - Premium */
            --primary: #3EB489;
            --primary-dark: #298564;
            --primary-light: #6ee7b7;
            --primary-soft: rgba(62, 180, 137, 0.08);
            --primary-glow: rgba(62, 180, 137, 0.4);
            
            --secondary: #1e293b;
            --secondary-light: #334155;
            
            --bg: #f8fafc;
            --surface: rgba(255, 255, 255, 0.85);
            --surface-solid: #ffffff;
            
            --text: #0f172a;
            --text-light: #64748b;
            --text-lighter: #94a3b8;
            
            --border: rgba(226, 232, 240, 0.8);
            --border-glass: rgba(255, 255, 255, 0.4);
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            --shadow-premium: 0 25px 50px -12px rgba(62, 180, 137, 0.2);
            
            --radius-sm: 10px;
            --radius: 20px;
            --radius-lg: 32px;
            
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
            -webkit-font-smoothing: antialiased;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: #0f172a;
            color: #fff;
            position: fixed; top: 0; left: 0; height: 100vh;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-logo {
            padding: 32px;
            display: flex; align-items: center; gap: 14px;
            min-height: 120px;
        }
        .sidebar-logo img { 
            width: 44px; height: 44px; 
            background: #fff; padding: 8px; 
            border-radius: 14px; 
            box-shadow: 0 8px 16px rgba(62,180,137,0.3);
            flex-shrink: 0;
        }
        .sidebar-logo span { 
            font-size: 22px; font-weight: 800; 
            line-height: 1; letter-spacing: -1.5px;
            color: #fff;
            white-space: nowrap;
        }

        .sidebar-nav { flex: 1; padding: 10px 20px; overflow-y: auto; }
        
        .nav-label { 
            display: block;
            font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.3); 
            text-transform: uppercase; letter-spacing: 1.5px; 
            margin: 32px 14px 12px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px; 
            color: rgba(255,255,255,0.5); 
            font-size: 14px; font-weight: 600;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 6px;
            text-decoration: none;
        }
        .nav-item i { font-size: 18px; width: 24px; text-align: center; }
        .nav-item:hover { 
            background: rgba(255,255,255,0.05); 
            color: #fff; 
            transform: translateX(4px);
        }
        .nav-item.active { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff; 
            box-shadow: 0 10px 20px -5px rgba(62,180,137,0.4);
        }

        .sidebar-footer { 
            padding: 24px; 
            background: rgba(255,255,255,0.02);
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .user-info { display: flex; align-items: center; gap: 14px; }
        .user-avatar { 
            width: 44px; height: 44px; 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 14px; 
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 18px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(62,180,137,0.3);
        }
        .user-name { font-size: 14px; font-weight: 700; color: #fff; }
        .user-role { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 2px; }

        /* ── MAIN CONTENT ── */
        .main { 
            margin-left: var(--sidebar-w); 
            flex: 1; min-height: 100vh;
            display: flex; flex-direction: column;
            transition: all 0.4s ease;
        }

        .topbar {
            height: 80px; 
            background: rgba(248, 250, 252, 0.8);
            backdrop-filter: blur(20px);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px; position: sticky; top: 0; z-index: 10;
        }
        .topbar-title { 
            font-size: 22px; font-weight: 800; letter-spacing: -0.5px;
            color: var(--text);
        }

        .page-content { padding: 40px 48px 64px; }

        /* ── PREMIUM COMPONENTS ── */
        .glass-card {
            background: var(--surface);
            backdrop-filter: blur(12px);
            border-radius: var(--radius);
            padding: 24px;
            border: 1px solid var(--border-glass);
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .glass-card:hover { 
            transform: translateY(-6px); 
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-glow);
        }

        .stat-card-premium {
            background: var(--surface-solid);
            padding: 32px; border-radius: var(--radius);
            border: 1px solid var(--border);
            position: relative; overflow: hidden;
            transition: all 0.3s ease;
        }
        .stat-card-premium:hover { transform: scale(1.02); box-shadow: var(--shadow-lg); }

        .btn-premium {
            padding: 12px 28px; border-radius: 14px;
            font-size: 15px; font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff; text-decoration: none;
            display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 10px 20px -5px rgba(62,180,137,0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none; cursor: pointer;
        }
        .btn-premium:hover { 
            transform: translateY(-3px) scale(1.02); 
            box-shadow: 0 15px 30px -5px rgba(62,180,137,0.5);
            filter: brightness(1.1);
        }

        /* ── TABLES ── */
        .premium-table-container {
            width: 100%; overflow: hidden;
            background: #fff; border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .premium-table { width: 100%; border-collapse: collapse; }
        .premium-table th { 
            background: #f8fafc; padding: 20px 24px;
            text-align: left; font-size: 11px; font-weight: 800;
            color: var(--text-light); text-transform: uppercase;
            letter-spacing: 1px; border-bottom: 1px solid #f1f5f9;
        }
        .premium-table td { padding: 20px 24px; font-size: 14.5px; border-bottom: 1px solid #f8fafc; }
        .premium-table tr:hover td { background: var(--primary-soft); }

        /* ── ALERTS ── */
        .alert { 
            padding: 16px 24px; border-radius: 16px; margin-bottom: 32px;
            font-size: 15px; font-weight: 600;
            animation: slideIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex; align-items: center; gap: 12px;
            border: 1px solid transparent;
        }
        .alert-success { background: #ecfdf5; color: #065f46; border-color: #d1fae5; }
        .alert-error { background: #fef2f2; color: #991b1b; border-color: #fee2e2; }

        @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        @media (max-width: 1200px) {
            :root { --sidebar-w: 80px; }
            .sidebar-logo span, .nav-label, .user-name, .user-role { display: none; }
            .sidebar-logo { padding: 32px 0; justify-content: center; min-height: 100px; }
            .sidebar-logo img { width: 36px; height: 36px; padding: 6px; }
            .nav-item { justify-content: center; padding: 14px; }
            .nav-item i { margin: 0; }
        }

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
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
            <div class="topbar-right">
                <span style="font-size:13px; color: var(--text-light); font-weight: 600;">{{ now()->translatedFormat('d M, Y') }}</span>
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
