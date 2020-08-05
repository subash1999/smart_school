<!doctype html>
<html lang="en">
    <head>
        <title>@yield('page-title',config('app.name','Smart School'))</title>

        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon/favicon-32x32.png') }}" type="image/gif" sizes="32x32">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- CSS for file -->
        @stack('css')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    </head>
    <body style="padding-top: 70px;" >
        @include('layouts.nav')
        @yield('above-app-content')
        <div id="app">
            <div class="bg-image"></div>
            @yield('app-content')
        </div>
    @yield('below-app-content')
    </body>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('js/popper-2.4.4.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/fontawesome-5-all.js') }}" defer></script>

    <script defer>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- JS for file -->
    @stack('js')
</html>
