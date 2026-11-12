<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @if (app()->isProduction())
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WK61JGEQ65"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-WK61JGEQ65');
    </script>
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#006b3f">
    <title>@yield('title', 'Chapecoense Futsal')</title>
    <meta name="description" content="@yield('description', 'Site oficial da Chapecoense Futsal. Notícias, jogos, competições e história do Verdão das Quadras.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Chapecoense Futsal">
    <meta property="og:title" content="@yield('title', 'Chapecoense Futsal')">
    <meta property="og:description" content="@yield('description', 'Site oficial da Chapecoense Futsal. Notícias, jogos, competições e história do Verdão das Quadras.')">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:image" content="{{ url(trim($__env->yieldContent('og_image', '/images/logomarca.webp'))) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    <link rel="icon" href="{{ asset('images/logomarca.webp') }}" type="image/webp">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#conteudo">Ir para o conteúdo</a>
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
    @stack('scripts')
</body>
</html>
