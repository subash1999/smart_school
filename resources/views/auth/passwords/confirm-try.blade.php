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
                <h3 class="h3 text-center text-uppercase">{{ __('Confirm Password') }}</h3>
            </div>
        </div>
        <div class="col-6">
            <h6 class="h6 text-center">{{ __('Please confirm your password before continuing.') }}</h6>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Confirm Password') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link text-white" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
