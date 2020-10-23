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
                <h3 class="font-weight-bolder text-break">School Admin</h3>
                <h3 class="h5 font-weight-lighter text-break"><i>{{ \App\School::findOrFail(getCurrentSchoolId())->name }}</i></h3>
                <strong>
                    {{ getShortFormOfSentence("School Admin") }}
                    <br>
                    {{ getShortFormOfSentence(\App\School::findOrFail(getCurrentSchoolId())->name) }}
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
                <li>
                    <form action="{{ route('change-current-school-session-id') }}"
                          method="POST" name="school_session_form" id="school_session_form"
                        class="ml-2 mr-2">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="school_session">School Session : </label>
                            <br>
                            <select name="school_session_id" id="school_session_id"
                                    class="form-control form-control-sm @error('school_session_id') is-invalid @enderror">
                                <option value="" selected="selected">All Sessions</option>
                                @php
                                    $current_school_session_id = getCurrentSchoolSessionId();
                                    $school_sessions = \App\School::findOrFail(getCurrentSchoolId())
                                                        ->schoolSessions()
                                                        ->orderBy('name')->get();
                                @endphp
                                @foreach($school_sessions as $school_session)
                                    @php
                                        $selected = null;
                                    @endphp
                                    @isset($current_school_session_id)
                                        @if($current_school_session_id == $school_session->id)
                                            @php
                                                $selected = "selected=\"selected\"";
                                            @endphp
                                        @endif
                                    @endisset
                                    <option value="{{ $school_session->id }}" {{ $selected ?? '' }}
                                    data-content="{{ $school_session->name }}<sub><small>
                                        {{ $school_session->from->format('Y M d') }} - {{ $school_session->to->format('Y M d') }}
                                        </small></sub>">{{ $school_session->name }}</option>
                                @endforeach
                            </select>
                            @error('school_session_id')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        @push('js')
                            <script>
                                $("#school_session_id").on('change', function () {
                                    $('#school_session_form').submit();
                                });
                            </script>
                        @endpush
                    </form>
                </li>
                @php
                    $home_url = getCurrentDashboardUrl();
                @endphp
                <li class="{{ activeClass($home_url) }}">
                    <a href="{{ $home_url }}">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                @php
                    $school_admin_url = route('school-admin-school-admins')
                @endphp
                <li class="{{ activeClass($school_admin_url) }}">
                    <a href="{{ $school_admin_url }}">
                        <i class="fas fa-users"></i>
                        School Admins
                    </a>
                </li>
                @php
                    $teacher_urls = [
                        'teachers' => route('school-admin-teachers'),
                        'create_teacher' => route('school-admin-create-teacher'),
                        ];
                @endphp
                <li class="{{ activeClass($teacher_urls) }}">
                    <a href="#teachersSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Teachers
                    </a>
                    <ul class="{{ collapseClass($teacher_urls) }} list-unstyled" id="teachersSubmenu">
                        <li>
                            <a href="{{ $teacher_urls['teachers'] }}">Teachers</a>
                        </li>
                        <li>
                            <a href="{{ $teacher_urls['create_teacher'] }}">Create Teacher</a>
                        </li>
                    </ul>
                </li>
                @php
                    $guardian_urls = [
                        'guardians' => route("school-admin-guardians"),
                        'create_guardian' => route('school-admin-create-guardian'),
                        ];
                @endphp
                <li class="{{ activeClass($guardian_urls) }}">
                    <a href="#guardiansSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-male"></i><i class="fas fa-female"></i>
                        Guardians
                    </a>
                    <ul class="{{ collapseClass($guardian_urls) }} list-unstyled" id="guardiansSubmenu">
                        <li>
                            <a href="{{ $guardian_urls['guardians'] }}">Guardians</a>
                        </li>
                        <li>
                            <a href="{{ $guardian_urls['create_guardian'] }}">Create Guardian</a>
                        </li>
                    </ul>
                </li>
                @php
                    $student_urls = [
                        'students' => route('school-admin-students'),
                        'create_student' => route('school-admin-create-student'),
                        ];
                @endphp
                <li class="{{ activeClass($student_urls) }}">
                    <a href="#studentsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-user-graduate"></i>
                        Students
                    </a>
                    <ul class="{{ collapseClass($student_urls) }} list-unstyled" id="studentsSubmenu">
                        <li>
                            <a href="{{ $student_urls['students'] }}">Students</a>
                        </li>
                        <li>
                            <a href="{{ $student_urls['create_student'] }}">Create Student</a>
                        </li>
                    </ul>
                </li>
                @php
                    $grade_urls = [
                        'grades' => route('school-admin-grades'),
                        'create_grade' => route('school-admin-create-grade'),
                        ];
                @endphp
                <li class="{{ activeClass($grade_urls) }}">
                    <a href="#gradesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-chalkboard"></i>
                        Grades
                    </a>
                    <ul class="{{ collapseClass($grade_urls) }} list-unstyled" id="gradesSubmenu">
                        <li>
                            <a href="{{ $grade_urls['grades'] }}">Grades</a>
                        </li>
                        <li>
                            <a href="{{ $grade_urls['create_grade'] }}">Create Grade</a>
                        </li>
                    </ul>
                </li>
                @php
                    $subject_urls = [
                        'subjects' => '#',
                        'create_subject' => '#',
                        ];
                @endphp
                <li class="{{ activeClass($subject_urls) }}">
                    <a href="#subjectsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-book"></i>
                        Subjects
                    </a>
                    <ul class="{{ collapseClass($subject_urls) }} list-unstyled" id="subjectsSubmenu">
                        <li>
                            <a href="{{ $subject_urls['subjects'] }}">Subjects</a>
                        </li>
                        <li>
                            <a href="{{ $subject_urls['create_subject'] }}">Create Subject</a>
                        </li>
                    </ul>
                </li>
                @php
                    $attendance_urls = [
                        'attendances' => '#',
                        'create_attendance' => '#',
                        ];
                @endphp
                <li class="{{ activeClass($attendance_urls) }}">
                    <a href="#attendancesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-flag-checkered"></i>
                        Attendances
                    </a>
                    <ul class="{{ collapseClass($attendance_urls) }} list-unstyled" id="attendancesSubmenu">
                        <li>
                            <a href="{{ $attendance_urls['attendances'] }}">Attendances</a>
                        </li>
                        <li>
                            <a href="{{ $attendance_urls['create_attendance'] }}">Create Attendance</a>
                        </li>
                    </ul>
                </li>
                @php
                    $exam_group_urls = [
                        'exam_groups' => '#',
                        'create_exam_group' => '#',
                        ];
                @endphp
                <li class="{{ activeClass($exam_group_urls) }}">
                    <a href="#exam_groupsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-layer-group"></i>
                        Exam Groups
                    </a>
                    <ul class="{{ collapseClass($exam_group_urls) }} list-unstyled" id="exam_groupsSubmenu">
                        <li>
                            <a href="{{ $exam_group_urls['exam_groups'] }}">Exam Groups</a>
                        </li>
                        <li>
                            <a href="{{ $exam_group_urls['create_exam_group'] }}">Create Exam Group</a>
                        </li>
                    </ul>
                </li>
                @php
                    $school_calendar_urls = [
                        'school_calendars' => '#',
                        'create_school_calendar' => '#',
                        ];
                @endphp
                <li class="{{ activeClass($school_calendar_urls) }}">
                    <a href="#school_calendarsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-calendar-alt"></i>
                        School Calendars
                    </a>
                    <ul class="{{ collapseClass($school_calendar_urls) }} list-unstyled" id="school_calendarsSubmenu">
                        <li>
                            <a href="{{ $school_calendar_urls['school_calendars'] }}">School Calendars</a>
                        </li>
                        <li>
                            <a href="{{ $school_calendar_urls['create_school_calendar'] }}">Create School Calendar</a>
                        </li>
                    </ul>
                </li>
                @php
                    $edit_profile_url = "#"
                @endphp
                <li class="{{ activeClass($edit_profile_url) }}">
                    <a href="{{ $edit_profile_url }}">
                        <i class="fas fa-edit"></i>
                        Edit My Profile
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
                <nav class="navbar navbar-light bg-gradient-theme " id="page_heading">
                    <span class="navbar-brand text-white col-10 text-truncate">@yield('page-heading')</span>
                </nav>
                <br>
            @endif

            @yield('school-admin-content')
        </div>
    </div>
@endsection
@push('js')
    {{-- Script for the     --}}
    <script src="{{ asset('js/jquery.mCustomScrollbar.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
@endpush
