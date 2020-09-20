@extends("layouts.super-admin-layout")
@section('page-heading','Users / '.$user->email)
@section('super-admin-content')
    @include('snippets.user-profile',[
        'school_admin' => $user,
        'delete_route_name' => 'super-admin-destroy-user',
        'redirect_url' => route('super-admin-user'),
    ])
    <hr style="border-width: 5px;height: 5px;" class="border-theme">
    @include('snippets.user-roles',[
    'user' => $user
    ])
@endsection
