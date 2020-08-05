@extends('layouts.layout')
@push('css')
    {{--    Custom style for login --}}
    <style>
        /*Height 100% will make the background image 100%*/
        body, html {
            height: 100%;
        }
        /*Make the box sizing as border box*/
        * {
            box-sizing: border-box;
        }

    </style>
@endpush
@push('js')

@endpush
@section('above-app-content')
    @php
        $bg_img = asset('images/login-background.jpg');
    @endphp
    <div class="full-cover-bg-image" style="background-image: url('{{ $bg_img }}');"></div>
@endsection
@section('app-content')
    <div class="row login-center-div " style="height: 70%;" >
        <div class="col-6 bg-gradient-theme align-items-center justify-content-center" style="display: flex;background-color: black;">
                  <h3 class="h3 text-uppercase">Available Dashboards</h3>
        </div>
        <div class="col-6 scrollbar-thin" style="height: 100%;overflow-y: scroll;">
        @foreach(Auth::user()->getAvailableRoles() as $role => $role_values)
            @foreach($role_values as $role_value)
                <div class="card-header">
                    <h4>{{ $role }}</h4>
                    @php
                    $keys = array_keys($role_value);
                    $school_id = null;
                    if(in_array("school_id",$keys)){
                        $school_id = $role_value["school_id"];
                    }
                    @endphp
                    <form action="{{ route("go-to-dashboard") }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="{{ $role }}">
                        <input type="hidden" name="school_id" value="{{ $school_id }}">
                        <input type="submit" value="Go To Dashboard" class="btn btn-theme bg-gradient-theme float-right" style="display: block;">
                    </form>
{{--                    <a href="{{  }}"--}}
{{--                       >Go To Dashboard</a>--}}
                </div>
                <div class="card-body">
                    <h6><b>Your Name :</b> {{ $role_value['name'] }}</h6>
                    @if(in_array("school_name",$keys))
                    <h6><b>School Name :</b> {{ $role_value['school_name'] }}</h6>
                    @endif
                </div>
                <hr style="border-width: 5px;">
            @endforeach
        @endforeach
        </div>
    </div>

@endsection
