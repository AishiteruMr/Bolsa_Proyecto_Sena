<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inspírate SENA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --verde-marino: #1b6b5f;
            --verde-marino-dark: #0f4a41;
            --verde-marino-light: #4a9b8d;
            --verde-claro: #d4f1ed;
            --verde-bg: #f0f9f7;
            --texto: #1a1a1a;
            --texto-suave: #666666;
            --blanco: #ffffff;
            --gris-light: #f8f9fa;
            --sombra: 0 8px 24px rgba(27, 107, 95, 0.12);
            --sombra-hover: 0 12px 32px rgba(27, 107, 95, 0.18);
            --radio: 12px;
        }
        body { font-family: 'Poppins', sans-serif; color: var(--texto); background: var(--gris-light); }
        a { text-decoration: none; color: inherit; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 8px; border: none; cursor: pointer; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600; transition: all .3s ease; }
        .btn-primary { background: var(--verde-marino); color: #fff; box-shadow: 0 4px 15px rgba(27, 107, 95, 0.3); }
        .btn-primary:hover { background: var(--verde-marino-dark); transform: translateY(-2px); box-shadow: var(--sombra-hover); }
        .btn-outline { background: transparent; border: 2px solid var(--verde-marino); color: var(--verde-marino); }
        .btn-outline:hover { background: var(--verde-marino); color: #fff; }
        .btn-danger { background: #e74c3c; color: #fff; }
        .btn-danger:hover { background: #c0392b; }
        .alert { padding: 14px 18px; border-radius: var(--radio); margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .card { background: var(--blanco); border-radius: var(--radio); box-shadow: var(--sombra); padding: 24px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger  { background: #f8d7da; color: #721c24; }
        .badge-info    { background: #cce5ff; color: #004085; }

        /* --- GLOBAL NAVBAR --- */
        .navbar { 
            background: var(--blanco); 
            padding: 0 48px; 
            height: 70px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05); 
            position: sticky; 
            top: 0; 
            z-index: 100;
            border-bottom: 1px solid #f0f0f0;
        }
        .logo { 
            display: flex; 
            align-items: center; 
            gap: 12px;
            cursor: pointer;
            transition: opacity .2s;
        }
        .logo:hover { opacity: 0.8; }
        .logo img { width: 42px; height: 42px; object-fit: contain; }
        .logo span { 
            font-weight: 800; 
            font-size: 19px; 
            background: linear-gradient(135deg, var(--verde-marino) 0%, var(--verde-marino-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .menu { 
            display: flex; 
            align-items: center; 
            gap: 4px;
            flex: 1;
            margin-left: 40px;
        }
        .menu a { 
            margin: 0 8px;
            padding: 8px 16px;
            font-size: 14px; 
            font-weight: 600; 
            color: var(--texto-suave); 
            transition: all .2s;
            border-radius: 6px;
            position: relative;
        }
        .menu a:hover, .menu a.active { 
            color: var(--verde-marino);
            background: var(--verde-bg);
        }
        .menu a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 16px;
            right: 16px;
            height: 3px;
            background: var(--verde-marino);
            border-radius: 2px 2px 0 0;
        }
        .nav-right {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .btn-login { 
            background: var(--verde-marino);
            color: var(--blanco); 
            padding: 10px 24px; 
            border-radius: 8px; 
            font-size: 14px; 
            font-weight: 600; 
            transition: all .3s;
            box-shadow: 0 4px 12px rgba(27, 107, 95, 0.25);
            cursor: pointer;
            border: none;
            display: inline-block;
        }
        .btn-login:hover { 
            background: var(--verde-marino-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(27, 107, 95, 0.35);
        }

        /* --- GLOBAL FOOTER --- */
        .footer { 
            background: #0f2419; 
            color: #b0b0b0; 
            padding: 60px 80px 30px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer-container { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
            gap: 40px; 
            margin-bottom: 40px; 
        }
        .footer-col h3 { 
            color: var(--blanco); 
            font-size: 15px; 
            font-weight: 700; 
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }
        .footer-col p, .footer-col a { 
            font-size: 13px; 
            color: #999; 
            display: block; 
            margin-bottom: 10px;
            line-height: 1.6;
            transition: color .2s;
        }
        .footer-col a:hover { 
            color: var(--verde-marino-light);
        }
        .footer-col ul { 
            list-style: none; 
            padding: 0; 
            margin: 0; 
        }
        .footer-col ul li { 
            margin-bottom: 8px; 
        }
        .footer-bottom { 
            border-top: 1px solid rgba(255,255,255,0.1); 
            padding-top: 20px; 
            text-align: center; 
            font-size: 12px; 
            color: #666;
        }

        @media (max-width: 768px) {
            .navbar { padding: 0 20px; }
            .footer { padding: 40px 24px 20px; }
        }
    </style>

    @yield('styles')
</head>
<body>
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        // Auto-hide alerts
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => { el.style.opacity = '0'; el.style.transition = 'opacity .5s'; setTimeout(() => el.remove(), 500); }, 4000);
        });
    </script>
    @yield('scripts')
</body>
</html>
