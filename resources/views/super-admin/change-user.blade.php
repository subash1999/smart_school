@extends("layouts.super-admin-layout")
@section('page-heading','Me / Change User')
@php
    $super_admin = auth()->user()->SuperAdmin;
@endphp
@section('super-admin-content')
    <div class="w-75 m-auto">
        <form action="{{ route("super-admin-change-super-admin-user",['id'=>$super_admin->id]) }}"
              method="POST"
              id="change_user_form" name="change_user_form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <h4 class="font-weight-bold text-center">Current User: {{ $super_admin->User->email }}</h4>
            </div>
            <label class="text-break bg-warning p-3 small">
                <h5><u>Note:</u></h5>
                <ul>
                    <li>Only one user can be super admin made at a time</li>
                    <li>Once the user is changed you will be logged out from the system</li>
                    <li>You will no longer be Super Admin of Website</li>
                    <li>The selected user will be made new Super Admin of the system</li>
                </ul>
            </label>
            <div class="form-group">
                <label for="user">New User <span class="text-danger"> ( Required) </span></label>
                <select name="user" id="user"
                        class="form-control @error('user') is-invalid @enderror"
                        required>
                    <option value="">-- Select User --</option>
                    @foreach(\App\User::orderBy('email')->get() as $user)
                        @if(strcasecmp(old('user'),$user->id) == 0)
                            @php
                                $selected = 'selected = "selected"';
                            @endphp
                        @else
                            @if(strcasecmp($user->id,$super_admin->user_id)==0)
                                @php
                                    $selected = 'selected = "selected"';
                                @endphp
                            @else
                                @php
                                    unset($selected);
                                @endphp
                            @endif
                        @endif
                        <option
                            value="{{ $user->id }}"
                            {{ $selected ?? '' }}
                            data-content="<div
                        >
                        <img src='{{ getAvatarImageUrl($user->avatar) }}'
                        loading='lazy'
                        style='height:24px;weight:24px;' class='mr-3'>{{ $user->email }}
                                </div>">
                            {{ $user->email }}
                        </option>
                    @endforeach
                </select>
                @error('user')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Super Admin Name <span class="text-danger"> ( Required) </span></label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       required min="2" max="255"
                       value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="gender">Gender <span class="text-danger"> ( Required) </span></label>
                <select name="gender" id="gender"
                        class="form-control @error('gender') is-invalid @enderror"
                        required>
                    <option value="">--- Select Gender ---</option>
                    @php
                        $gender_contents = [
                            'Male' => '<img src="'.asset('images/male-icon.jpg').'" style="height:24px;weight:24px;" class="mr-3">Male',
                            'Female' => '<img src="'.asset('images/female-icon.jpg').'" style="height:24px;weight:24px;" class="mr-3">Female',
                            'Other' => '<img src="'.asset('images/other-gender-icon.png').'" style="height:24px;weight:24px;" class="mr-3">Other',
                        ];
                    @endphp
                    @foreach($gender_contents as $gender_value => $gender_content)
                        @if(strcasecmp(old('gender'),$gender_value) == 0)
                            @php
                                $selected = 'selected = "selected"';
                            @endphp
                        @else
                            @php
                                unset($selected);
                            @endphp
                        @endif
                        <option value="{{ $gender_value }}" {{ $selected ?? '' }}
                        data-content="{{ $gender_content }}">{{ $gender_value }}</option>
                    @endforeach
                </select>
                @error('gender')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Address <span class="text-danger"> ( Required) </span></label>
                <input type="text" name="address"
                       class="form-control @error('address') is-invalid @enderror"
                       required min="2" max="255"
                       value="{{ old('address') }}">
                @error('address')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
            <div class="form-group">
                <label for="district">District</label>
                <input type="text" name="district"
                       class="form-control @error('district') is-invalid @enderror"
                       min="2" max="255"
                       value="{{ old('district') }}">
                @error('district')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="country">Country <span class="text-danger"> ( Required) </span></label>
                <select name="country" id="country"
                        class="form-control @error('country') is-invalid @enderror"
                        required>
                    <option value="">--- Select Country ---</option>
                    @foreach(config("utilities.countries") as $country_code => $country)
                        @if(strcasecmp(old('country'),$country) == 0)
                            @php
                                $selected = 'selected = "selected"';
                            @endphp
                        @else
                            @php
                                unset($selected);
                            @endphp
                        @endif
                        <option data-content="<img src='https://www.countryflags.io/{{ $country_code }}/shiny/24.png' class='mr-3'>{{ $country }}"
                                {{--                        data-thumbnail="https://www.countryflags.io/{{ $country_code }}/shiny/64.png"--}}
                                value="{{ $country }}" {{ $selected ?? '' }}>{{ $country }}</option>
                    @endforeach
                </select>
                @error('country')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone1">Phone 1 <span class="text-danger"> ( Required) </span></label>
                <input type="text" name="phone1"
                       class="form-control @error('phone1') is-invalid @enderror"
                       required min="2" max="255"
                       value="{{ old('phone1') }}">
                @error('phone1')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone2">Phone 2</label>
                <input type="text" name="phone2"
                       class="form-control @error('phone2') is-invalid @enderror"
                       min="2" max="255"
                       value="{{ old('phone2') }}">
                @error('phone2')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>

                <textarea name="description" id="description"
                          class="form-control">{{ old('description') }}</textarea>
                {{--            Script for using ckeditor in the description text area--}}

                @push("js")
                    <script src="{{ asset("js/ckeditor.js") }}"></script>
                    <script>
                        $(function(){
                            var editor = ClassicEditor
                                .create( document.querySelector( '#description' ),{
                                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                                    height : 300,
                                    heading: {
                                        options: [
                                            {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                                            {
                                                model: 'heading1',
                                                view: 'h1',
                                                title: 'Heading 1',
                                                class: 'ck-heading_heading1'
                                            },
                                            {
                                                model: 'heading2',
                                                view: 'h2',
                                                title: 'Heading 2',
                                                class: 'ck-heading_heading2'
                                            }
                                        ]
                                    }
                                } )
                                .catch( error => {
                                    console.error( error );
                                } );
                            // console.log(ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName ));
                        });
                    </script>
                @endpush

            </div>
        </form>
        <input type="button" value="Change User" class="btn btn-outline-theme float-right btn-lg" id="change_user_btn">
    </div>
@endsection
@push('js')
    @php
        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Changing the Super Admin User</h5>";
        $title .= "<br><br>";
        $title .= '<label class="text-break bg-warning p-3 small">';
        $title .= '<h5><u>Note:</u></h5>';
        $title .= '<ul>';
        $title .= '<li>Once the user is changed you will be logged out from the system</li>';
        $title .= '<li>You will no longer be Super Admin of Website</li>';
        $title .= '<li>The selected user will be made new Super Admin of the system</li>';
        $title .= '</ul>';
        $title .= '</label>';
        $res = passwordConfirmationBoxScript("#change_user_btn","#change_user_form","Password",$title);
        echo($res);
    @endphp
@endpush
