<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Inspírate SENA - Bolsa de Proyectos. Conectamos talento con empresa. Plataforma donde aprendices e instructores colaboran en proyectos reales que transforman el ecosistema empresarial de Colombia.')">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon.png') }}">
    <meta property="og:title" content="@yield('og_title', 'Inspírate SENA - Inicio')">
    <meta property="og:description" content="@yield('og_description', 'Conectamos talento con empresa. Plataforma donde aprendices e instructores colaboran en proyectos reales que transforman el ecosistema empresarial de Colombia.')">
    <meta property="og:image" content="{{ asset('assets/logo.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_CO">
    <meta name="twitter:card" content="summary_large_image">
    <title>@yield('title', 'Inspírate SENA')</title>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vitebuilt
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endvitebuilt

    @yield('styles')
</head>

<body>
    @include('partials.loader')
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @vitebuilt
        @vite(['resources/js/dashboard.js'])
    @endvitebuilt
    @yield('scripts')
</body>

</html>
