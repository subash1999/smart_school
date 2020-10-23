@extends('layouts.school-admin-layout')
@section('page-heading','Guardians / Edit ('.$guardian->name.')')
@section('school-admin-content')
    @php
        $school = \App\School::findOrFail(getCurrentSchoolId());
    @endphp
    <h2 class="h2 text-center">Edit Guardian</h2>
    <div class="d-block container">
        <a href="{{ route('school-admin-show-guardian',['id'=>$guardian->id]) }}"
           class="btn btn-primary bg-gradient-primary">View</a>
        <input type="button" class="btn btn-danger" value="Delete" name="delete" id="delete_guardian_btn_{{ $guardian->id }}">
        <form action="{{ route('school-admin-destroy-guardian',['id' => $guardian->id]) }}"
              name="delete_guardian_form" id="delete_guardian_form_{{ $guardian->id }}"
              method="POST">
            @method('delete')
            @csrf
            <input type="hidden" value="{{ route('super-admin-school-admin') }}" name="redirect_url">
            <input type="hidden" value="{{ $guardian->id }}" name="id" id="guardian_id_{{ $guardian->id }}">
        </form>
    </div>
    @push('js')
        @php
            $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the Guardian</h5>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$guardian->id." </h6>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Guardian Name : $guardian->name </h6>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User : ".$guardian->User->email." </h6>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> School Name : ".$guardian->School->name."</h6>";
            $res = passwordConfirmationBoxScript("#delete_guardian_btn_".$guardian->id,"#delete_guardian_form_".$guardian->id,"Password",$title);
            echo($res);
        @endphp
    @endpush
    @include('snippets.change-image',[
        'upload_btn_text' => 'Upload New Passport Photo',
        'current_image_url' => getPassportPhotoImageUrl($guardian->passport_photo),
        'image_upload_url' => route('school-admin-update-guardian-passport-photo',['id' => $guardian->id]),
        'redirect_url' => null,
    ])
    {{-- Edit Form for Guardian--}}
    <form action="{{ route("school-admin-update-guardian-text-data",['id'=>$guardian->id]) }}"
          method="POST"
          class="w-75 col-xxl-6 col-xl-6 col-lg-6 m-auto"
          id="save_guardian_form">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="user">User <span class="text-danger"> ( Required) </span></label>
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
                        @if(strcasecmp($user->id,$guardian->user_id)==0)
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
            <label for="school">School <span class="text-danger"> ( Required) </span></label>
            @php
                $full_address_array = array();
                if(isset($school->address)){
                    array_push($full_address_array,$school->address);
                }
                if(isset($school->district)){
                    array_push($full_address_array,$school->district);
                }
                if(isset($school->country)){
                    array_push($full_address_array,$school->country);
                }
                $full_address = implode(", ",$full_address_array);
            @endphp
            <div>
                <img src='{{ getLogoImageUrl($school->logo) }}'
                     loading='lazy'
                     style='height:24px;weight:24px;' class='mr-3'>{{ $school->name }}
                <br>
                <small>{{ $full_address }}</small>
            </div>
            <input type="hidden" name="school" value="{{ $school->id }}" class="form-control @error('school') is-invalid @enderror">
            @error('school')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Guardian Name <span class="text-danger"> ( Required) </span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   required min="2" max="255"
                   value="{{ old('name')?? $guardian->name }}">
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
                        @if(strcasecmp($gender_value,$guardian->gender)==0)
                            @php
                                $selected = 'selected = "selected"';
                            @endphp
                        @else
                            @php
                                unset($selected);
                            @endphp
                        @endif
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
                   value="{{ old('address') ?? $guardian->address }}">
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
                   value="{{ old('district') ?? $guardian->district }}">
            @error('district')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message ?? $guardian->district }}</strong>
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
                        @if(strcasecmp($country,$guardian->country)==0)
                            @php
                                $selected = 'selected = "selected"';
                            @endphp
                        @else
                            @php
                                unset($selected);
                            @endphp
                        @endif
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
                   value="{{ old('phone1') ?? $guardian->phone1 }}">
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
                   value="{{ old('phone2') ?? $guardian->phone2 }}">
            @error('phone2')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>

            <textarea name="description" id="description"
                      class="form-control">{{ old('description') ?? $guardian->description }}</textarea>
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
            @push('css')
                {{--                changing the height of ckeditor--}}
                <style>
                    .ck-editor__editable_inline {
                        min-height: 100px;
                    }
                </style>
            @endpush

        </div>
        <input type="button" value="Save Guardian" id="save_guardian_btn"
               class="btn btn-lg bg-gradient-primary float-right text-white">
    </form>
@endsection
@push('js')
    @php
        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Saving the Guardian</h5>";
        $title .= "<h6>ID: ".$guardian->id."</h6>"."<h6>Name: ".$guardian->name."</h6>";
        $title .= "<h6>School Name: ".$guardian->school->name."</h6>";
        $res = passwordConfirmationBoxScript("#save_guardian_btn","#save_guardian_form","Password",$title);
        echo($res);
    @endphp
@endpush
