<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body>
        <div id="app">
            @include('partials.header')
            <div class="l-main">
                @yield('main')
            </div>
            @include('partials.footer')
        </div>

        <script src="{{ url(mix('js/manifest.js')) }}"></script>
        <script src="{{ url(mix('js/vendor.js')) }}"></script>
        <script src="{{ url(mix('js/app.js')) }}"></script>
        @stack('scripts-after')
    </body>
</html>
