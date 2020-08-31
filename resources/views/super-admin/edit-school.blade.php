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
    @include('snippets.change-image',[
        'upload_btn_text' => 'Upload New Logo',
        'current_image_url' => getLogoImageUrl($school->logo),
        'image_upload_url' => route('super-admin-update-school-logo',['id' => $school->id]),
        'redirect_url' => null,
    ])
{{--    Edit form for the School --}}
    <form action="{{ route("super-admin-store-school") }}"
          method="POST"
          class="w-75 col-xxl-6 col-xl-6 col-lg-6 m-auto"
          id="create_school_form">
        @csrf
        <input type="hidden" name="id" value="{{ $school->id }}">
        <div class="form-group">
            <label for="name">School Name <span class="text-danger"> ( Required) </span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   required min="2" max="255"
                   value="{{ $school->name }}">
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
                   value="{{ $school->address }}">
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
                   value="{{ $school->district }}">
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
                    @if(strcasecmp($school->country,$country) == 0)
                        @php
                            $selected = "selected = \"selected\""
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
                   value="{{ $school->phone1 }}">
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
                   value="{{ $school->phone2 }}">
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
                   value="{{ $school->email1 }}">
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
                   value="{{ $school->email2 }}">
            @error('email2')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>

            <textarea name="description" id="description"
                      class="form-control">{{ $school->description }}</textarea>
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
        <input type="button" value="SAVE" id="save_btn" class="btn btn-lg bg-gradient-info float-right">
    </form>
@endsection
