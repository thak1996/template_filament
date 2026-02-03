<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', config('site.description'))">
    <meta name="keywords" content="{{ config('site.keywords') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', config('site.description'))">
    <meta property="og:image" content="{{ asset('images/logo-share.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "{{ config('app.name') }}",
            "description": "{{ config('site.description') }}",
            "url": "{{ url('/') }}",
            "telephone": "{{ config('site.phone') }}",
            "email": "{{ config('site.email') }}",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{ config('site.address.street') }}",
                "addressLocality": "{{ config('site.address.city') }}",
                "addressRegion": "{{ config('site.address.state') }}",
                "postalCode": "{{ config('site.address.zip') }}"
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>

<body class="antialiased">
    @yield('content')
    @yield('scripts')
</body>

</html>