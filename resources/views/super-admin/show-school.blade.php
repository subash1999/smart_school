@extends("layouts.super-admin-layout")
@section('page-heading','School / '.$school->name)
@section('super-admin-content')
    @include('snippets.school-profile', [
            'school' => $school,
            'edit_school_route_name' => 'super-admin-edit-school',
            'delete_school_route_name' => 'super-admin-destroy-school'])
    <h4 class="h4 font-weight-bold">School Admins</h4>
    <a href="{{ route('super-admin-create-school-admin') }}" class="btn btn-info bg-gradient-info m-3">Add School Admin</a>

    @include('snippets.school-admins-table',[
            'school_admins'=>$school->schoolAdmins,
            'redirect_url' => URL::current(),
            'view_route_name' => 'super-admin-show-school-admin',
            'edit_route_name' => 'super-admin-edit-school-admin',
            'delete_route_name' => 'super-admin-destroy-school-admin'])
@endsection

