@extends('layouts.school-admin-layout')
@section('page-heading','Grades / '.$grade->grade_name)
@section('school-admin-content')
    @include('snippets.grade-profile',[
        'grade' => $grade,
        'edit_route_name' => 'school-admin-edit-grade',
        'delete_route_name' => 'school-admin-destroy-grade',
    ])
@endsection
