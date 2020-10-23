@extends("layouts.school-admin-layout")
@section('page-heading','School Admins / '.$school_admin->name)
@section("school-admin-content")
    @include('snippets.school-admin-profile',[
        'school-admin' => $school_admin,
    ])
@endsection
