@extends('layouts.school-admin-layout')
@section('page-heading','Guardians')
@section('school-admin-content')
    <h3 class="text-break">List of Guardians of {{ $school->name }}</h3>

    @include('snippets.guardians-table',[
        'guardians' => $guardians,
        'redirect_url' => URL::current(),
        'view_route_name' => 'school-admin-show-guardian',
        'edit_route_name' => 'school-admin-edit-guardian',
        'delete_route_name' => 'school-admin-destroy-guardian',
    ])
@endsection
