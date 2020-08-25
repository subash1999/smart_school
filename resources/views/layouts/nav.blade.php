<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Smart School') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" v-pre>
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item" id="loginedUser">
                        <a href="#" class="nav-link">
                            <img src="{{ Auth::user()->avatar }}" alt="User" class="rounded-circle" style="height: 25px;" >
                        </a>
                        <div id="loginedUserInfo" class="d-none">
                            <div id="userInfoWithImage">
                                <img src="{{ Auth::user()->avatar }}" alt="User"
                                     class="img-fluid rounded-circle" style="height: 35px;" >
                                <br>
                                <h6 class="text-center mt-3">{{ Auth::user()->email }}</h6>
                            </div>
                            <div id="userActions" style="height: 20px; overflow-y: scroll;">
{{--                                Check if the current_dashboard_url varibale exists in the session--}}
                                @if (session()->has('current_dashboard_url'))
                                    @if (session("current_dashboard_url") != null)
                                        <a href="{{ url(session('current_dashboard_url')) }}" class="text-white btn border m-1 w-100"><i class="fas fa-tachometer-alt"></i> Go To Current Dashboard</a>
                                    @endif
                                @endif
                                <a href="{{ route('available-dashboard') }}" class="text-white btn border m-1 w-100"> <i class="fas fa-redo"></i> Switch Dashboard</a>
                                <a class="text-danger btn border m-1 w-100 logout-btn" href="#" >
                                    {{ __('Logout') }} <i class="fas fa-sign-out-alt"></i>
                                </a>
{{--                                Since logout is a post routing operation we use form with POST method--}}
                                <form class="logout-form" action="{{ route('logout') }}" method="POST" >
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                    @push('css')
                        <style>
                            .popover-body {
                                overflow-y : scroll;
                                height: 20px;
                            }
                        </style>
                    @endpush
                    @push('js')
                        <script defer>

                            $(function () {
                                //
                                // Script for the popover of the logined user
                                $('#loginedUser').popover({
                                    container: 'body',
                                    delay: 150,
                                    title: $("#userInfoWithImage").html(),
                                    content:$("#userActions").html(),
                                    html: true,
                                    placement: 'bottom',
                                    trigger: 'focus|click',
                                    // boundary: 'viewport',
                                    template: '<div class="popover bg-gradient-theme text-white" style="height: 20px;overflow-y: scroll;" role="tooltip">' +
                                        '<div class="arrow bg-gradient-theme text-theme"></div>' +
                                        '<h3 class="popover-header bg-gradient-theme text-white"></h3>' +
                                        '<div class="text-white popover-body bg-gradient-theme "></div>' +
                                        '</div>'
                                });
                                // Submit the logout-form on logout btn clicked
                                $(document).on('click','.logout-btn',function(){
                                    $(".logout-form").submit();
                                });
                                // disable autoscroll to top while clicking on popover of loginedUser icon
                                $('#loginedUser').on('click', function(e) {e.preventDefault(); return true;});
                            });

                        </script>
                    @endpush
                @endguest
            </ul>
        </div>
    </div>
</nav>

