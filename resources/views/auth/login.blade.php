@extends('layouts.layout')
@push('css')
{{--    Custom style for login --}}
    <style>
        /*Height 100% will make the background image 100%*/
        body, html {
            height: 100%;
        }
        /*Make the box sizing as border box*/
        * {
            box-sizing: border-box;
        }
    </style>
@endpush
@push('js')
@endpush
@section('above-app-content')
    @php
    $bg_img = asset('images/login-background.jpg');
    @endphp
    <div class="full-cover-bg-image" style="background-image: url('{{ $bg_img }}');"></div>
@endsection
@section('app-content')
    <div class="row login-center-div ">
        <div class="col-6 bg-gradient-theme align-items-center text-center" style="display: flex;background-color: black;">
            <div class="text-center">
                <h1 class="h1 text-center text-uppercase">{{ config('app.name','Smart School') }}</h1>
            </div>
        </div>
        <div class="col-6">
            <h1 class="h1 text-uppercase text-center">Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @method('post')
                @csrf
                <div class="form-group">
                    <label for="email" class="form-check-label" >Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-check-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                </div>

                <input type="submit" value="Login" class="btn btn-theme bg-gradient-theme float-right btn-lg">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" style="color: inherit;font-size: 105%;" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </form>
        </div>
    </div>

@endsection
