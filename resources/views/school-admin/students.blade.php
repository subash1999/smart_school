@extends('layouts.school-admin-layout')
@section('page-heading','Students')
@section('school-admin-content')
    <h3 class="text-break">List of Students of {{ $school->name }}
        <u class="font-weight-bolder">{{ getCurrentSchoolSessionName() ?? 'All' }} Session</u></h3>
    @include('snippets.students-table',[
        'students' => $students,
        'redirect_url' => URL::current(),
        'view_route_name' => 'school-admin-show-student',
        'edit_route_name' => 'school-admin-edit-student',
        'remove_route_name' => 'school-admin-remove-student-from-school',
        'reassign_route_name' => 'school-admin-reassign-student-to-school',
        'delete_route_name' => 'school-admin-destroy-student',
    ])
@endsection
