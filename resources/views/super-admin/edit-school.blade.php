@extends("layouts.super-admin-layout")
@section('page-heading','School / '.$school->name.' ( Edit )')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
@endpush
@push('js')
    <script src="{{ asset("js/exif.js") }}"></script>
    <script src="{{ asset('js/croppie.js') }}"></script>
@endpush
@section('super-admin-content')
    <div class="d-block container">
        <a href="{{ route('super-admin-show-school',['id'=>$school->id]) }}"
           class="btn btn-primary bg-gradient-primary">View</a>
        <input type="button" class="btn btn-danger" value="Delete" name="delete" id="delete_school_btn_{{ $school->id }}">
        <form action="{{ route('super-admin-destroy-school',['id' => $school->id]) }}"
              name="delete_school_form" id="delete_school_form_{{ $school->id }}"
              method="POST">
            @method('delete')
            @csrf
            <input type="hidden" value="{{ route('super-admin-school') }}" name="redirect_url">
            <input type="hidden" value="{{ $school->id }}" name="id" id="school_id_{{ $school->id }}">
        </form>
    </div>
    @push('js')
        @php
            $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the School</h5>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$school->id." </h6>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> School Name : $school->name </h6>";
            $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
            $title .="All the Data Related to School will be Deleted (Students ,Teachers, Guardians, Grades, Exams, etc.)";
            $title .= "</small>";
            $res = passwordConfirmationBoxScript("#delete_school_btn_".$school->id,"#delete_school_form_".$school->id,"Password",$title);
            echo($res);
        @endphp
    @endpush
    @include('snippets.change-image',[
        'upload_btn_text' => 'Upload New Logo',
        'current_image_url' => getLogoImageUrl($school->logo),
        'image_upload_url' => route('super-admin-update-school-logo',['id' => $school->id]),
        'redirect_url' => null,
    ])
{{--    Edit form for the School --}}
    <form action="{{ route("super-admin-update-school-text-data",['id'=>$school->id]) }}"
          method="POST"
          class="w-75 col-xxl-6 col-xl-6 col-lg-6 m-auto"
          id="update_school_form">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $school->id }}">
        <div class="form-group">
            <label for="name">School Name <span class="text-danger"> ( Required) </span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   required min="2" max="255"
                   value="{{ old('name') ?? $school->name }}">
            @error('name')
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
                   value="{{ old('address') ?? $school->address }}">
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
                   value="{{ old('district') ?? $school->district }}">
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
                @foreach(config("utilities.countries") as $country)
                    @php
                        $selected_country = $school->country;
                        $old_country_isset = old("country");
                        if($old_country_isset){
                            $selected_country = old('country');
                        }
                    @endphp
                    @if(strcasecmp($selected_country,$country) == 0)
                        @php
                            $selected = 'selected = "selected"';
                            unset($selected_country);
                        @endphp
                    @else
                        @php
                            unset($selected);
                        @endphp
                    @endif
                    <option value="{{ $country }}" {{ $selected ?? '' }}>{{ $country }}</option>

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
                   value="{{ old('phone1') ?? $school->phone1 }}">
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
                   value="{{ old('phone2') ?? $school->phone2 }}">
            @error('phone2')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email1">Email 1</label>
            <input type="email" name="email1"
                   class="form-control @error('email1') is-invalid @enderror"
                   min="2" max="255"
                   value="{{ old('email1') ?? $school->email1 }}">
            @error('email1')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email2">Email 2</label>
            <input type="email" name="email2"
                   class="form-control @error('email2') is-invalid @enderror"
                   min="2" max="255"
                   value="{{ old('email2') ?? $school->email2 }}">
            @error('email2')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>

            <textarea name="description" id="description"
                      class="form-control">{{ old('description') ?? $school->description }}</textarea>
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
        <input type="button" value="Save" id="save_btn" class="btn btn-lg bg-gradient-info float-right">
    </form>
@endsection
@push('js')
    @php
        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Updating the School Data</h5>";
        $res = passwordConfirmationBoxScript("#save_btn","#update_school_form","Password",$title);
        echo($res);
    @endphp
@endpush
