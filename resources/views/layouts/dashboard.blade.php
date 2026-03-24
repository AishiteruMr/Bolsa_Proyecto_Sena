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
            --primary: #39a900;
            --primary-light: #4cc115;
            --primary-soft: rgba(57, 169, 0, 0.1);
            --secondary: #2c3e50;
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
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

        /* ── SIDEBAR (Modern Glassmorphism) ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--secondary);
            color: #fff;
            position: fixed; top: 0; left: 0; height: 100vh;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
        }

        .sidebar-logo {
            padding: 32px 24px;
            display: flex; align-items: center; gap: 14px;
        }
        .sidebar-logo img { 
            width: 44px; height: 44px; 
            background: #fff; padding: 6px; 
            border-radius: 12px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .sidebar-logo span { 
            font-size: 18px; font-weight: 700; 
            line-height: 1.1; letter-spacing: -0.5px;
        }

        .sidebar-nav { flex: 1; padding: 20px 16px; overflow-y: auto; }
        
        .nav-label { 
            display: block;
            font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.4); 
            text-transform: uppercase; letter-spacing: 1.5px; 
            margin: 24px 12px 12px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 16px; 
            color: rgba(255,255,255,0.6); 
            font-size: 15px; font-weight: 500;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 4px;
        }
        .nav-item i { font-size: 18px; width: 24px; text-align: center; }
        .nav-item:hover { 
            background: rgba(255,255,255,0.05); 
            color: #fff; 
            transform: translateX(4px);
        }
        .nav-item.active { 
            background: var(--primary); 
            color: #fff; 
            box-shadow: 0 8px 16px rgba(57, 169, 0, 0.3);
        }

        .sidebar-footer { 
            padding: 24px; 
            background: rgba(0,0,0,0.1);
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-avatar { 
            width: 40px; height: 40px; 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 10px; 
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 16px;
        }
        .user-name { font-size: 14px; font-weight: 600; color: #fff; }
        .user-role { font-size: 11px; color: rgba(255,255,255,0.5); }

        /* ── MAIN CONTENT ── */
        .main { 
            margin-left: var(--sidebar-w); 
            flex: 1; min-height: 100vh;
            display: flex; flex-direction: column;
            transition: all 0.4s ease;
        }

        .topbar {
            height: 80px; background: rgba(248, 250, 252, 0.8);
            backdrop-filter: blur(12px);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; position: sticky; top: 0; z-index: 10;
        }
        .topbar-title { font-size: 22px; font-weight: 700; letter-spacing: -0.5px; }

        .page-content { padding: 0 40px 40px; overflow-y: auto; }

        /* ── MODERN CARDS ── */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(0,0,0,0.06); }

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
        }
        .stat-card::after {
            content: ''; position: absolute; top:0; right:0;
            width: 80px; height: 80px;
            background: var(--primary-soft);
            border-radius: 0 0 0 100%;
            z-index: 0;
        }
        .stat-card h3 { font-size: 32px; font-weight: 800; color: var(--text); position: relative; z-index: 1; }
        .stat-card p { font-size: 14px; font-weight: 500; color: var(--text-light); margin-top: 4px; }

        /* ── TABLES ── */
        .table-container { 
            width: 100%; overflow-x: auto; 
            border-radius: 12px; border: 1px solid var(--border);
            background: #fff;
        }
        table { width: 100%; border-collapse: collapse; }
        th { 
            background: #f1f5f9; padding: 16px 20px;
            text-align: left; font-size: 12px; font-weight: 600;
            color: var(--text-light); text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--bg); }

        /* ── BUTTONS ── */
        .btn {
            padding: 10px 24px; border-radius: 12px;
            font-size: 14px; font-weight: 600;
            cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(57, 169, 0, 0.2); }
        .btn-primary:hover { background: var(--primary-light); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(57, 169, 0, 0.3); }
        
        .btn-outline { background: #fff; border: 2px solid var(--primary); color: var(--primary); }
        .btn-outline:hover { background: var(--primary); color: #fff; }

        /* ── BADGES ── */
        .badge {
            padding: 6px 14px; border-radius: 8px;
            font-size: 12px; font-weight: 600;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #e0f2fe; color: #075985; }

        /* ── ALERTS ── */
        .alert { 
            padding: 16px 24px; border-radius: 12px; margin-bottom: 24px;
            font-size: 15px; font-weight: 500;
            animation: slideIn 0.5s ease;
        }
        @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

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
                <span style="font-size:13px; color:#666;">{{ now()->format('d/m/Y') }}</span>
            </div>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
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
