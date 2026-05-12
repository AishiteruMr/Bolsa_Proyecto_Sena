<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Verificación OTP - Inspírate SENA. Bolsa de Proyectos.">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon.png') }}">
    <meta property="og:title" content="Verificación OTP - Inspírate SENA">
    <meta property="og:description" content="Verificación OTP para Inspírate SENA - Bolsa de Proyectos.">
    <meta property="og:image" content="{{ asset('assets/logo.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_CO">
    <meta name="twitter:card" content="summary_large_image">
    <title>@yield('title', 'Verificación OTP - Inspírate SENA')</title>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vitebuilt
        @vite(['resources/css/app.css', 'resources/css/login.css'])
    @endvitebuilt
</head>
<body>
    <div class="otp-page">
        @yield('content')
    </div>
</body>
</html>
