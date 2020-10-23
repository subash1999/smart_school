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
        <link href="{{ asset('css/fontawesome-5-all.css') }}" rel="stylesheet" >
        <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">

{{--        ck editor min and max height--}}
        <style>
            .ck-editor__editable_inline {
                min-height: 100px;
                max-height: 200px;
            }
        </style>

        <!-- CSS for file -->
        @stack('css')


        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    </head>
    <body style="padding-top: 70px;" class="scrollbar-thin">
        @include('layouts.nav')
        @yield('above-app-content')
        <div id="app" class="scrollbar-thin">
            <div class="bg-image"></div>
            @yield('app-content')
        </div>
    @yield('below-app-content')
    </body>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('js/popper-2.4.4.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/fontawesome-5-all.js') }}" defer></script>
    <script src="{{ asset('js/bootbox.all.js') }}" ></script>
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
{{--    thoo clock for the analog clock--}}
    <script src="{{ asset('vendors/Customizable-Analog-Alarm-Clock-with-jQuery-Canvas-thooClock/js/jquery.thooClock.js') }}"></script>

    <script>
        $(function () {
            $('select').selectpicker({
                'liveSearch': true,
                // 'mobile': true,
                'style': 'border',
                'styleBase': 'form-control',
                'dropupAuto': false,
                'size': 7,
                'container': '#app',
            });
        });
    </script>

    <script defer>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
{{--    Show the alert-msg if the session contains the alert messages--}}
    <script async>
{{--        Check if the session exists for the alert-messages variable in config--}}
{{--        The config is used because sometimes the session names may collide while programming
            and we may need to change the whole occurance of the varibale name for alert-messages,
            hence we need to use the config to easily change the variable name in future through config file --}}
        @if(session()->has(config('custom-settings.alert-messages')))
            @php
                // Get the messages stored in the variable to show alert-messages
                $msgs = session(config('custom-settings.alert-messages'));
                // If the session contains string change it to array
                if(is_string($msgs)){
                    $msgs = [$msgs];
                }
                // check if the variable is array
                if(is_array($msgs)){
                    // loop each msg and show the messages
                    foreach ($msgs as $title => $msg){
                        if(!is_numeric($title)){
                            $title = $title;
                        }
                        else{
                            $title = null;
                        }
                        // script to display the bootbox alert
                        echo("bootbox.alert({title:'$title',message:'$msg'});");
                    }
                }
                // if the msg is not array then print the msg as it is
                else{
                    echo("bootbox.alert({message:'$msgs'});");
                }
                session()->forget(config('custom-settings.alert-messages'));
            @endphp
        @endif
    </script>
    <!-- JS for file -->
    @stack('js')
</html>
