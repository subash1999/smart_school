@extends("layouts.super-admin-layout")
@section('page-heading','Schools')
@include('snippets.schools-table',[
    'schools'=>$schools,
    'view_school_route_name'=>'super-admin-show-school',
    'edit_school_route_name'=>'super-admin-edit-school',
    'delete_school_route_name'=>'super-admin-destroy-school',
    ])
