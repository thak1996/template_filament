<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'FDS Logística e Terceirização - Mudanças Residenciais e Comerciais')</title>
    <meta name="description" content="@yield('description', 'FDS Logística: especialista em mudanças residenciais e comerciais, transporte de equipamentos sensíveis, armazenagem e terceirização de mão de obra. Atendimento em todo território nacional.')">
    <meta name="keywords" content="mudanças, logística, transporte, mudanças residenciais, mudanças comerciais, armazenagem, terceirização, FDS, São Paulo, Guarulhos">
    <meta name="author" content="FDS Logística e Terceirização">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'FDS Logística e Terceirização')">
    <meta property="og:description" content="@yield('description', 'Especialista em mudanças residenciais e comerciais com qualidade e segurança')">
    <meta property="og:image" content="{{ asset('images/fds-logo.png') }}">
    <meta property="og:locale" content="pt_BR">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'FDS Logística e Terceirização')">
    <meta property="twitter:description" content="@yield('description', 'Especialista em mudanças residenciais e comerciais com qualidade e segurança')">
    <meta property="twitter:image" content="{{ asset('images/fds-logo.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">

    <!-- Contact Information (Schema.org) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "MovingCompany",
            "name": "FDS Logística e Terceirização",
            "description": "Empresa especializada em mudanças residenciais e comerciais, transporte de equipamentos sensíveis e terceirização de mão de obra",
            "url": "{!! json_encode(url('/')) !!}",
            "telephone": "+55-11-2358-9716",
            "email": "contato@fdslogistica.com.br",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Rua Palhoça, 398",
                "addressLocality": "Guarulhos",
                "addressRegion": "SP",
                "postalCode": "07241-010",
                "addressCountry": "BR"
            },
            "areaServed": "Brasil",
            "serviceType": ["Mudanças Residenciais", "Mudanças Comerciais", "Transporte de Equipamentos", "Armazenagem", "Terceirização"],
            "openingHours": "Mo-Fr 08:00-18:00, Sa 08:00-12:00"
        }
    </script>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @yield('styles')
</head>

<body>
    @yield('content')
    @vite('resources/js/app.js')
    @yield('scripts')
</body>

</html>