@extends("layouts.layout")
@section("app-content")
    <div class="flex-center position-ref full-height bg-gradient-theme text-white">
        <div class="code">
            @yield('code')
        </div>

        <div class="message" style="padding: 10px;">
            @yield('message')
        </div>
    </div>
@endsection
@push("js")
    <script>
{{--        check if the error-title is set--}}
{{--    if the error title is set then make it the title of document--}}
        @if (trim($__env->yieldContent('title')))
            document.title = "@yield("title")";
        @endif

    </script>
@endpush
@push("css")
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 85vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .code {
            border-right: 3px solid;
            font-size: 36px;
            padding: 0 25px 0 25px;
            text-align: center;
        }

        .message {
            font-size: 28px;
            text-align: center;
        }
    </style>
@endpush
