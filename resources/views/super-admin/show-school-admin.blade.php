@extends("layouts.super-admin-layout")
@section('page-heading','School Admin / '.$school_admin->name)
@section('super-admin-content')
    @include('snippets.school-admin-profile',[
        'school_admin' => $school_admin,
        'school_url' => route('super-admin-show-school',['id'=>$school_admin->School->id]),
        'edit_route_name' => 'super-admin-edit-school-admin',
        'delete_route_name' => 'super-admin-destroy-school-admin',
    ])
@endsection
