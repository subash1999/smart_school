@extends('layouts.school-admin-layout')
@section('page-heading','Teachers')
@section('school-admin-content')
    <h3 class="text-break">List of Teachers of {{ $school->name }}</h3>

    @include('snippets.teachers-table',[
        'teachers' => $teachers,
        'redirect_url' => URL::current(),
        'view_route_name' => 'school-admin-show-teacher',
        'edit_route_name' => 'school-admin-edit-teacher',
        'remove_route_name' => 'school-admin-remove-teacher-from-school',
        'reassign_route_name' => 'school-admin-reassign-teacher-to-school',
        'delete_route_name' => 'school-admin-destroy-teacher',
    ])
@endsection
