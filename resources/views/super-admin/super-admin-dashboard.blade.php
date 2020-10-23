@extends("layouts.super-admin-layout")
@section("super-admin-content")
    <div class="container-fluid p-3">
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
            {{--                Schools Tile--}}
            <div class="card bg-gradient-white border-success rounded col-md-auto m-4">
                <div class="card-header bg-gradient-success text-center">
                    <h1 class="font-italic text-white font-weight-bold  text-center text-w">{{ $school_count ?? 0 }}</h1>
                    <a href="{{ route('super-admin-school') }}">
                        <i class=" text-white-50 fas fa-school fa-5x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-school') }}" class="btn btn-outline-success">
                        <h4 class="font-weight-lighter">Schools</h4>
                    </a>
                </div>
            </div>
            {{--            School Admin Tile--}}
            <div class="card bg-gradient-white border-primary rounded col-md-auto m-4">
                <div class="card-header bg-gradient-primary text-center">
                    <h1 class="font-italic text-white font-weight-bold text-center">{{ $school_admin_count ?? 0 }}</h1>
                    <a href="{{ route('super-admin-school-admin') }}">
                        <i class=" text-white-50 fa fa-users fa-5x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-school-admin') }}" class="btn btn-outline-primary">
                        <h4 class="font-weight-lighter">School Admins</h4>
                    </a>
                </div>
            </div>
            {{--            Users Tile--}}
            <div class="card bg-gradient-white border-indigo rounded col-md-auto m-4">
                <div class="card-header bg-gradient-indigo text-center">
                    <h1 class="font-italic text-white font-weight-bold text-center">{{ $user_count ?? 0 }}</h1>
                    <a href="{{ route('super-admin-user') }}">
                        <i class=" text-white-50 fa fa-user-secret fa-5x"></i>
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('super-admin-user') }}" class="btn btn-outline-indigo">
                        <h4 class="font-weight-lighter">Users</h4>
                    </a>
                </div>
            </div>
        </div>
        <div class="row border-top border-theme p-3">
            <div class="alert alert-purple">
                <div class="alert-heading">
                    <h3 class="text-center font-weight-lighter">Your Profile</h3>
                    <hr>
                    <img src="{{ getPassportPhotoImageUrl($super_admin->passport_photo) }}"
                         alt="PP of {{ $super_admin->id }}"
                         height="180px" class="d-block m-auto">
                    <br>
                    <a href="{{ route('super-admin-edit-profile') }}"
                       class="btn btn-outline-primary d-block m-auto">Edit Profile</a>
                </div>
                <hr>
                <span class="text-break">Name: {{ $super_admin->name }}</span>
                <br>
                <span class="text-break">User:
                        <a href="{{ route('super-admin-show-user',['id'=>$super_admin->User->id]) }}"
                           title="Click to View User Details">
                            {{ $super_admin->User->email }}</a>
                    </span>
                <br>
                <span class="text-break">Gender: {{ $super_admin->gender }}</span>
                <br>
                <span class="text-break">Address: {{ $super_admin->address }}</span>
                <br>
                <span class="text-break">District: {{ $super_admin->district }}</span>
                <br>
                <span class="text-break">Country:
                        {{ $super_admin->country }}
                        <img
                            src="https://www.countryflags.io/{{ countryToCountryCode($super_admin->country) }}/shiny/24.png">
                        </span>
                <br>
                <span class="text-break">Phone1: {{ $super_admin->phone1 }}</span>
                <br>
                <span class="text-break">Phone2: {{ $super_admin->phone2 }}</span>
                <br>
                <span class="text-break">Description: <br>{!! $super_admin->description !!}</span>
            </div>
        </div>
    </div>
    </div>
@endsection
