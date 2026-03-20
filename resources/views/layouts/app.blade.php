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
            --verde: #39a900;
            --verde-dark: #2d8500;
            --verde-light: #e8f5e0;
            --gris: #f4f6f9;
            --texto: #2c3e50;
            --texto-suave: #6c757d;
            --blanco: #ffffff;
            --sombra: 0 4px 20px rgba(0,0,0,0.08);
            --radio: 12px;
        }
        body { font-family: 'Poppins', sans-serif; color: var(--texto); background: var(--gris); }
        a { text-decoration: none; color: inherit; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px; border-radius: 30px; border: none; cursor: pointer; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; transition: all .2s; }
        .btn-primary { background: var(--verde); color: #fff; }
        .btn-primary:hover { background: var(--verde-dark); transform: translateY(-1px); }
        .btn-outline { background: transparent; border: 2px solid var(--verde); color: var(--verde); }
        .btn-outline:hover { background: var(--verde); color: #fff; }
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
        .navbar { background: var(--blanco); padding: 0 48px; height: 68px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 12px rgba(0, 0, 0, .07); position: sticky; top: 0; z-index: 100; }
        .logo { display: flex; align-items: center; gap: 10px; }
        .logo img { width: 40px; }
        .logo span { font-weight: 700; font-size: 18px; color: var(--verde-dark); }
        .menu a { margin-left: 28px; font-size: 14px; font-weight: 600; color: var(--texto-suave); transition: color .2s; }
        .menu a:hover, .menu a.active { color: var(--verde); }
        .btn-login { background: var(--verde); color: var(--blanco); padding: 9px 22px; border-radius: 30px; font-size: 14px; font-weight: 600; transition: background .2s; }
        .btn-login:hover { background: var(--verde-dark); color: var(--blanco); }

        /* --- GLOBAL FOOTER --- */
        .footer { background: #1a1a1a; color: #ccc; padding: 48px 80px 24px; }
        .footer-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 32px; margin-bottom: 32px; }
        .footer-col h3 { color: var(--blanco); font-size: 15px; font-weight: 600; margin-bottom: 12px; }
        .footer-col p, .footer-col a { font-size: 13px; color: #888; display: block; margin-bottom: 6px; }
        .footer-col a:hover { color: var(--verde); }
        .footer-col ul { list-style: none; padding: 0; margin: 0; }
        .footer-col ul li { margin-bottom: 6px; }
        .footer-bottom { border-top: 1px solid #333; padding-top: 16px; text-align: center; font-size: 13px; color: #555; }

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
