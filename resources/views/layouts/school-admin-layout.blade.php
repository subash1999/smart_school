@extends('layouts.layout')
@push('css')
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.css') }}">
@endpush
@section('app-content')
    <div class="wrapper-of-sidebar">
        <!-- Sidebar  -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <span  class="sidebarCollapse float-right" id="sidebarCollapse" style="cursor: pointer">
                    <i class="fas fa-angle-double-left fa-3x m-1" id="sidebarCollapseIcon" class="sidebarCollapseIcon"></i>
                </span>
                <h3>School Admin</h3>
                <strong>
                    {{ getShortFormOfSentence("School Admin") }}
                </strong>
            </div>
            @php
                function activeClass($url_arrays){
                    if(!is_array($url_arrays)){
                        $url_arrays = [$url_arrays];
                    }
                    $flag = false;
                    foreach ($url_arrays as $url){
                        if(strcmp($url,url()->current())==0){
                            $flag = true;
                            break;
                        }
                    }
                    return $flag?"active": "";
                }
                function collapseClass($url_arrays){
                    if(!is_array($url_arrays)){
                        $url_arrays = [$url_arrays];
                    }
                    $flag = false;
                    foreach ($url_arrays as $url){
                        if(strcmp($url,url()->current())==0){
                            $flag = true;
                            break;
                        }
                    }
                    return $flag?"": "collapse";
                }
            @endphp
            <ul class="list-unstyled components">
                @php
                    $home_url = "#"
                @endphp
                <li class="{{ activeClass($home_url) }}">
                    <a href="{{ $home_url }}">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                @php
                    $school_urls = [
                        'schools' => '#',
                        'add_school' => '#',
                        ];
                @endphp
                <li class="{{ activeClass($school_urls) }}">
                    <a href="#schoolsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-school"></i>
                        Schools
                    </a>
                    <ul class="{{ collapseClass($school_urls) }} list-unstyled" id="schoolsSubmenu">
                        <li>
                            <a href="{{ $school_urls['schools'] }}">Schools</a>
                        </li>
                        <li>
                            <a href="{{ $school_urls['add_school'] }}">Add School</a>
                        </li>
                    </ul>
                </li>
                @php
                    $school_admin_urls = [
                        'school_admins' => '#',
                        'add_school_admin' => '#',
                        ];
                @endphp
                <li class="{{ activeClass($school_admin_urls) }}">
                    <a href="#schoolAdminsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-users"></i>
                        School Admins
                    </a>
                    <ul class="{{ collapseClass($school_admin_urls) }} list-unstyled" id="schoolAdminsSubmenu">
                        <li>
                            <a href="{{ $school_admin_urls['school_admins'] }}">School Admins</a>
                        </li>
                        <li>
                            <a href="{{ $school_admin_urls['add_school_admin'] }}">Add School Admin</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-user-edit"></i>
                        User Profile
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-key"></i>
                        Change Password
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Page Content  -->
        {{-- Content For the Current Link in sidebar        --}}
        <div class="content-of-sidebar" id="content-of-sidebar">
            @yield('school-admin-content')
        </div>
    </div>
@endsection
@push('js')
    {{-- Script for the     --}}
    <script src="{{ asset('js/jquery.mCustomScrollbar.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
@endpush
