<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-121208389-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-121208389-1');

    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css')) }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        window.App = @json([
            'signedIn' => auth()->check(),
            'user' => auth()->user()
        ]);
    </script>
</head>

<body>
    <div id="app">
    @include('partials.header')
        <div class="l-main">
            @yield('main')
        </div>
        <flash></flash>
    @include('partials.footer')
    </div>

    <script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    @stack('scripts-after')
</body>

</html>