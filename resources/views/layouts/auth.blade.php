<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}" />
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}" />
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('css/mobile-fix-aggressive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ mix('css/app.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ultra-modern.css') }}?v={{ config('rb.version') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-ultra.css') }}?v={{ config('rb.version') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-responsive.css') }}?v={{ time() }}">

    @stack('head')
</head>

<body>
    <div class="page">
        <div class="page-single">
            @yield('content')
        </div>
    </div>
    <script src="{{ mix('js/app.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/mobile-optimization.js') }}?v={{ config('rb.version') }}" defer></script>
    @stack('scripts')
</body>

</html>