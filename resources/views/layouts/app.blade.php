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
    </style>

    @yield('styles')
</head>
<body>
    @yield('content')

    <script>
        // Auto-hide alerts
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => { el.style.opacity = '0'; el.style.transition = 'opacity .5s'; setTimeout(() => el.remove(), 500); }, 4000);
        });
    </script>
    @yield('scripts')
</body>
</html>
