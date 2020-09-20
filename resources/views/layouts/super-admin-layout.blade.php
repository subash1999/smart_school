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
                <h3>Super Admin</h3>
                <strong>
                    {{ getShortFormOfSentence("Super Admin") }}
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
                    $home_url = route('super-admin-dashboard');
                @endphp
                <li class="{{ activeClass($home_url) }}">
                    <a href="{{ $home_url }}">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                @php
                    $school_urls = [
                        'schools' => route("super-admin-school"),
                        'create_school' => route("super-admin-create-school"),
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
                            <a href="{{ $school_urls['create_school'] }}">Create School</a>
                        </li>
                    </ul>
                </li>
                @php
                    $school_admin_urls = [
                        'school_admins' => route('super-admin-school-admin'),
                        'create_school_admin' => route('super-admin-create-school-admin'),
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
                            <a href="{{ $school_admin_urls['create_school_admin'] }}">Create School Admin</a>
                        </li>
                    </ul>
                </li>
                @php
                    $users_url = route('super-admin-user')
                @endphp
                <li class="{{ activeClass($users_url) }}">
                    <a href="{{ $users_url }}">
                        <i class="fas fa-user-secret"></i>
                        Users
                    </a>
                </li>
                @php
                    $edit_profile_url = route('super-admin-edit-profile')
                @endphp
                <li class="{{ activeClass($edit_profile_url) }}">
                    <a href="{{ $edit_profile_url }}">
                        <i class="fas fa-edit"></i>
                        Edit Profile
                    </a>
                </li>
                @php
                    $change_super_admin_user_url = route('super-admin-change-super-admin-user')
                @endphp
                <li class="{{ activeClass($change_super_admin_user_url) }}">
                    <a href="{{ $change_super_admin_user_url }}">
                        <i class="fas fa-exchange-alt"></i>
                        Change Super Admin User
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Page Content  -->
        {{-- Content For the Current Link in sidebar        --}}
        <div class="content-of-sidebar" id="content-of-sidebar">
            {{--        check if the page-heading section is set in child views--}}
            {{--    if the page-heading is set then show it the heading navigation--}}
            @if (trim($__env->yieldContent('page-heading')))
                <nav class="navbar navbar-light bg-gradient-theme ">
                    <span class="navbar-brand text-white col-10 text-truncate">@yield('page-heading')</span>
                </nav>
                <br>
            @endif

            @yield('super-admin-content')
        </div>
    </div>
@endsection
@push('js')
    {{-- Script for the     --}}
    <script src="{{ asset('js/jquery.mCustomScrollbar.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
@endpush
