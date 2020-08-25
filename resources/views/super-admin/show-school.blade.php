@extends("layouts.super-admin-layout")
@section('page-heading','School / '.$school->name)
@section('super-admin-content')
    @include('snippets.school-profile', [
            'school' => $school,
            'edit_school_route_name' => 'super-admin-edit-school',
            'delete_school_route_name' => 'super-admin-destroy-school'])
    @include('snippets.school-admins-table',[
            'school'=>$school,
            'edit_school_admin_route_name' => '#',
            'delete_school_admin_route_name' => '#'])
@endsection

