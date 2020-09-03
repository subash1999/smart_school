@extends("layouts.super-admin-layout")
@section('page-heading','School Admin / Create')
@section('super-admin-content')
    <h2 class="h2 text-center">Add/Create/Register School Admin</h2>
    <form action="{{ route("super-admin-store-school") }}"
          method="POST"
          class="w-75 col-xxl-6 col-xl-6 col-lg-6 m-auto"
          id="create_school_form">
        @csrf
        <div class="form-group">
            <label for="school_id">School ID <span class="text-danger"> ( Required) </span></label>
            <select name="school_id" id="school_id"
                    class="form-control @error('school_id') is-invalid @enderror"
                    required>
                <option value="">-- Select School --</option>
                @foreach(\App\School::orderBy('name')->get() as $school)
                    <option data-icon="glyphicon glyphicon-eye-open" data-subtext="petrification"
                        value="{{ $school->id }}">

                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
            @error('school_id')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">School Admin Name <span class="text-danger"> ( Required) </span></label>
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
                @foreach(['Male','Female'] as $gender)
                    @if(strcasecmp(old('gender'),$gender) == 0)
                        @php
                            $selected = 'selected = "selected"';
                        @endphp
                    @else
                        @php
                            unset($selected);
                        @endphp
                    @endif
                    <option value="{{ $gender }}" {{ $selected ?? '' }}>{{ $gender }}</option>
                @endforeach
            </select>
            @error('country')
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
                @foreach(config("utilities.countries") as $country)
                    @if(strcasecmp(old('country'),$country) == 0)
                        @php
                            $selected = 'selected = "selected"';
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
            @push('css')
                {{--                changing the height of ckeditor--}}
                <style>
                    .ck-editor__editable_inline {
                        min-height: 100px;
                    }
                </style>
            @endpush

        </div>
        <input type="button" value="Add School Admin" id="add_school_admin_btn" class="btn btn-lg bg-gradient-primary float-right text-white">
    </form>
@endsection
