@extends("layouts.school-admin-layout")
@section('page-heading','School Admins')
@section("school-admin-content")
    <h3 class="text-break">List of School Admins of {{ $school->name }}</h3>
    @include('snippets.school-admins-table',[
        'school_admins'=>$school_admins,
        'view_route_name' => 'school-admin-show-school-admin'
    ])
@endsection
