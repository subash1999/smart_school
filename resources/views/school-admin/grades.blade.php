@extends('layouts.school-admin-layout')
@section('page-heading','Grades')
@section('school-admin-content')
    <h3 class="text-break">List of Grades of {{ $school->name }} <u
            class="font-weight-bolder">{{ getCurrentSchoolSessionName() ?? 'All' }} Session</u></h3>

    @include('snippets.grades-table',[
        'grades' => $grades,
        'redirect_url' => URL::current(),
        'view_route_name' => 'school-admin-show-grade',
        'edit_route_name' => 'school-admin-edit-grade',
        'delete_route_name' => 'school-admin-destroy-grade',
    ])
@endsection
