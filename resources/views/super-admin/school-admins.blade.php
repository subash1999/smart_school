@extends("layouts.super-admin-layout")
@section('page-heading','School Admins')
@section('super-admin-content')
    @include('snippets.school-admins-table',[
            'school_admins'=>$school_admins,
            'redirect_url' => URL::current(),
            'view_route_name' => 'super-admin-show-school-admin',
            'edit_route_name' => 'super-admin-edit-school-admin',
            'delete_route_name' => 'super-admin-destroy-school-admin'])
@endsection
