@extends("layouts.super-admin-layout")
@section("super-admin-content")
    <img src="{{ route('logo-image',['filename'=>urlencode(Auth::user()->avatar)]) }}" alt="Avatar" style="height:200px;width:200px;">
@endsection
