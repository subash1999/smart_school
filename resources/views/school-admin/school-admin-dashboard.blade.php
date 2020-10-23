@extends("layouts.school-admin-layout")
@section("school-admin-content")
    @include('snippets.school-profile',[
        'school' => $school,
        'only_school_banner' => True,
    ])
    <hr class="border-theme">
    <div class="container-fluid pl-4 pr-3 pb-3">
        <h3 class="text-center">Tile Data Shown for : <u
                class="font-weight-bolder">{{ getCurrentSchoolSessionName() ?? 'All' }} Session</u></h3>
        <br>
        <div class="row">
{{--            Clock Tile--}}
            <div class="col-md-auto m-4" id="clock_tile">
                @push('js')
                    <script>
                        $(function(){
                            $('#clock_tile').thooClock({
                                size: 170,
                            });
                        });
                    </script>
                @endpush
            </div>
            {{--                School Admin Tile--}}
            <div class="card bg-gradient-white border-success rounded col-md-auto m-4">
                <div class="card-header bg-gradient-success text-center">
                    <h2 class="font-italic text-white font-weight-bold  text-center text-w">{{ $school_admin_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-school') }}">
                        <i class=" text-white-50 fas fa-users fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-school') }}" class="btn btn-outline-success">
                        <h5 class="font-weight-lighter">School Admins</h5>
                    </a>
                </div>
            </div>
            {{--            Teacher Tile--}}
            <div class="card bg-gradient-white border-primary rounded col-md-auto m-4">
                <div class="card-header bg-gradient-primary text-center">
                    <h2 class="font-italic text-white font-weight-bold text-center">{{ $teacher_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-school-admin') }}">
                        <i class=" text-white-50 fa fa-chalkboard-teacher fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-school-admin') }}" class="btn btn-outline-primary">
                        <h5 class="font-weight-lighter">Teachers</h5>
                    </a>
                </div>
            </div>
            {{--            Guardian Tile--}}
            <div class="card bg-gradient-white border-indigo rounded col-md-auto m-4">
                <div class="card-header bg-gradient-indigo text-center">
                    <h2 class="font-italic text-white font-weight-bold text-center">{{ $guardian_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fa fa-male fa-4x"></i><i class=" text-white-50 fa fa-female fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-indigo">
                        <h5 class="font-weight-lighter">Guardians</h5>
                    </a>
                </div>
            </div>
            {{--            Student Tile--}}
            <div class="card bg-gradient-white border-secondary rounded col-md-auto m-4">
                <div class="card-header bg-gradient-secondary text-center">
                    <h2 class="font-italic text-white font-weight-bold text-center">{{ $student_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fas fa-user-graduate fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-secondary">
                        <h5 class="font-weight-lighter">Students</h5>
                    </a>
                </div>
            </div>
            {{--            Grade Tile--}}
            <div class="card bg-gradient-white border-info rounded col-md-auto m-4">
                <div class="card-header bg-gradient-info text-center">
                    <h2 class="font-italic text-white font-weight-bold text-center">{{ $grade_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fa fa-chalkboard fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-info">
                        <h5 class="font-weight-lighter">Grades</h5>
                    </a>
                </div>
            </div>
            {{--            Subjects Tile--}}
            <div class="card bg-gradient-white border-purple rounded col-md-auto m-4">
                <div class="card-header bg-gradient-purple text-center">
                    <h2 class="font-italic text-white font-weight-bold text-center">{{ $subject_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fa fa-book fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-purple">
                        <h5 class="font-weight-lighter">Subjects</h5>
                    </a>
                </div>
            </div>
            {{--            Attendances Tile--}}
            <div class="card bg-gradient-white border-danger rounded col-md-auto m-4">
                <div class="card-header bg-gradient-danger text-center">
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fa fa-flag-checkered fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-danger">
                        <h5 class="font-weight-lighter">Attendances</h5>
                    </a>
                </div>
            </div>

            {{--            Exam Groups Tile--}}
            <div class="card bg-gradient-white border-success rounded col-md-auto m-4">
                <div class="card-header bg-gradient-success text-center">
                    <h2 class="font-italic text-white font-weight-bold text-center">{{ $exam_group_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fa fa-layer-group fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-success">
                        <h5 class="font-weight-lighter">Exam Groups</h5>
                    </a>
                </div>
            </div>
            {{--            Exams Tile--}}
            <div class="card bg-gradient-white border-theme rounded col-md-auto m-4">
                <div class="card-header bg-gradient-theme text-center">
                    <h2 class="font-italic text-white font-weight-bold text-center">{{ $exam_count ?? 0 }}</h2>
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fa fa-scroll fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-theme">
                        <h5 class="font-weight-lighter">Exams</h5>
                    </a>
                </div>
            </div>
            {{--            School Calendars Tile--}}
            <div class="card bg-gradient-dark border-light rounded col-md-auto m-4">
                <div class="card-header bg-gradient-light text-center">
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-dark-50 fa fa-calendar-alt fa-4x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-light">
                        <h5 class="font-weight-bolder">School <br> Calendars</h5>
                    </a>
                </div>
            </div>
        </div>
        <div class="row border-top border-theme p-3">
            <div class="alert alert-purple">
                <div class="alert-heading">
                    <h3 class="text-center font-weight-lighter">Your Profile</h3>
                    <hr>
                    <img src="{{ getPassportPhotoImageUrl($school_admin->passport_photo) }}"
                         alt="PP of {{ $school_admin->id }}"
                         height="180px" class="d-block m-auto">
                    <br>
                    <a href="{{ route('super-admin-edit-profile') }}"
                       class="btn btn-outline-primary d-block m-auto">Edit Profile</a>
                </div>
                <hr>
                <span class="text-break">Name: {{ $school_admin->name }}</span>
                <br>
                <span class="text-break">User:
                        <a href="{{ route('super-admin-show-user',['id'=>$school_admin->User->id]) }}"
                           title="Click to View User Details">
                            {{ $school_admin->User->email }}</a>
                    </span>
                <br>
                <span class="text-break">Gender: {{ $school_admin->gender }}</span>
                <br>
                <span class="text-break">Address: {{ $school_admin->address }}</span>
                <br>
                <span class="text-break">District: {{ $school_admin->district }}</span>
                <br>
                <span class="text-break">Country:
                        {{ $school_admin->country }}
                        <img
                            src="https://www.countryflags.io/{{ countryToCountryCode($school_admin->country) }}/shiny/24.png">
                        </span>
                <br>
                <span class="text-break">Phone1: {{ $school_admin->phone1 }}</span>
                <br>
                <span class="text-break">Phone2: {{ $school_admin->phone2 }}</span>
                <br>
                <span class="text-break">Description: <br>{!! $school_admin->description !!}</span>
            </div>
        </div>
    </div>
    </div>
@endsection
