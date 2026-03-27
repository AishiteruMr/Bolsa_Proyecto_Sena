<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inspírate SENA')</title>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #3EB489;
            --primary-dark: #298564;
            --primary-light: #6ee7b7;
            --primary-soft: rgba(62, 180, 137, 0.08);
            --primary-glow: rgba(62, 180, 137, 0.4);
            
            --secondary: #0f172a;
            --secondary-light: #1e293b;
            
            --bg: #f8fafc;
            --surface: rgba(255, 255, 255, 0.95);
            --text: #0f172a;
            --text-light: #64748b;
            --radius: 24px;
            --shadow-premium: 0 20px 40px rgba(62, 180, 137, 0.12);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text);
            background: var(--bg);
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            transition: all .3s ease;
        }

        .btn-primary {
            background: var(--verde-marino);
            color: #fff;
            box-shadow: 0 4px 15px rgba(27, 107, 95, 0.3);
        }

        .btn-primary:hover {
            background: var(--verde-marino-dark);
            transform: translateY(-2px);
            box-shadow: var(--sombra-hover);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--verde-marino);
            color: var(--verde-marino);
        }

        .btn-outline:hover {
            background: var(--verde-marino);
            color: #fff;
        }

        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .alert {
            padding: 14px 18px;
            border-radius: var(--radio);
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .card {
            background: var(--blanco);
            border-radius: var(--radio);
            box-shadow: var(--sombra);
            padding: 24px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #cce5ff;
            color: #004085;
        }

        /* --- GLOBAL NAVBAR --- */
        .navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            padding: 0 8%;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .logo img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .logo span {
            font-weight: 900;
            font-size: 24px;
            letter-spacing: -1px;
            background: linear-gradient(135deg, var(--verde-marino) 0%, var(--verde-marino-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .menu a {
            font-size: 15px;
            font-weight: 700;
            color: var(--texto-suave);
            transition: all 0.3s ease;
            position: relative;
        }

        .menu a:hover {
            color: var(--verde-marino);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--verde-marino) 0%, var(--verde-marino-dark) 100%);
            color: white;
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 10px 20px rgba(62, 180, 137, 0.2);
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(62, 180, 137, 0.3);
        }

        /* --- GLOBAL FOOTER --- */
        .footer {
            background: #0f172a;
            color: rgba(255,255,255,0.6);
            padding: 100px 8% 40px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: 2fr repeat(3, 1fr);
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-col h3 {
            color: white;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 24px;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col a {
            color: rgba(255,255,255,0.5);
            transition: all 0.3s;
        }

        .footer-col a:hover {
            color: var(--verde-marino-light);
            padding-left: 4px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 30px;
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }

            .footer {
                padding: 40px 24px 20px;
            }
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