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
    <div class="full-cover-bg-image" style="background-image: url('{{ $bg_img }}');height:10% !important;"></div>
@endsection
@section('app-content')
    <div class="row m-5" style="height: 70%;" >
        <div class="col-6 border-right border-theme">
            <h5 class="text-uppercase text-center font-weight-bold">Change Password</h5>
            <hr>
            <form action="{{ route('update-password') }}" method="POST" id="change_password_form_{{ Auth::user()->id }}" name="change_password_form_{{ Auth::user()->id }}">
                @csrf
                @method('PUT')
                @isset($redirect_url)
                    <input type="hidden" value="{{ $redirect_url }}" id="redirect_url" name="redirect_url">
                @endisset
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" class="form-control  @error('old_password') is-invalid @enderror" id="old_password" name="old_password" required="required">
                    @error('old_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" class="form-control  @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required="required">
                    @error('new_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation"> Confirm New Password</label>
                    <input type="password" class="form-control  @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" required="required">
                    @error('new_password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary text-white" value="Update Password" id="change_password_btn_{{ Auth::user()->id }}">
            </form>
        </div>
        <div class="col-6 border-left border-theme">
            <h5 class="text-uppercase text-center font-weight-bold">Change Email</h5>
            <hr>
            <form action="{{ route('update-email') }}" method="POST" class="text-info">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="new_email">New Email</label>
                    <input type="email" class="form-control @error('new_email') is-invalid @enderror"
                           name="new_email" id="new_email" autocomplete="off" value="{{ old('new_email') ?? '' }}">
                    @error('new_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Current Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <input type="submit" value="Update Email" class="btn btn-warning" >
            </form>
        </div>
    </div>

@endsection
