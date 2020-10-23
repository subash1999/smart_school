@extends('layouts.school-admin-layout')
@php
    $section = null;
    if(isset($grade->section)){
        $section = "'$grade->section'";
    }
@endphp
@section('page-heading')
    Grades / Edit ({{ $grade->grade_name }} {{ $section }})
    <sub>
        {{ $grade->SchoolSession->name }}
        <small>
            <small>
                <b>
                    {{ $grade->SchoolSession->getSessionDurationText() }}
                </b>
            </small>
        </small>
    </sub>
@endsection
@section('school-admin-content')
    @php
        $school = \App\School::findOrFail(getCurrentSchoolId());
    @endphp
    <h2 class="h2 text-center">Edit Grade Info</h2>
    <div class="d-block clearfix float-right">
        <a href="{{ route('school-admin-show-grade',['id'=>$grade->id]) }}"
           class="btn btn-primary bg-gradient-primary">View</a>
        <input type="button" class="btn btn-danger" value="Delete" name="delete"
               id="delete_grade_btn_{{ $grade->id }}">
        <form action="{{ route('school-admin-destroy-grade',['id' => $grade->id]) }}"
              name="delete_grade_form" id="delete_grade_form_{{ $grade->id }}"
              method="POST">
            @method('delete')
            @csrf
            <input type="hidden" value="{{ route('super-admin-school-admin') }}" name="redirect_url">
            <input type="hidden" value="{{ $grade->id }}" name="id" id="grade_id_{{ $grade->id }}">
        </form>
    </div>
    @push('js')
        @php
            $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the grade</h5>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$grade->id." </h6>";
            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Grade Name : $grade->grade_name </h6>";
            if(isset($grade->section)){
                $section = "Section : ".$grade->section;
                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> $section </h6>";

            }
            $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
            $title .= "</small>";
            $res = passwordConfirmationBoxScript("#delete_grade_btn_".$grade->id,"#delete_grade_form_".$grade->id,"Password",$title);
            echo($res);
        @endphp
    @endpush
    <form action="{{ route("school-admin-update-grade",['id'=>$grade->id]) }}"
          method="POST"
          class="w-75 col-xxl-6 col-xl-6 col-lg-6 m-auto"
          id="save_grade_form">
        @method('PUT')
        @csrf
        <div class="form-group font-weight-bolder">
            @php
                $section = null;
                if(isset($grade->section)){
                    $section = "'$grade->section'";
                }
            @endphp
            <label> Current Grade :
                <i>
                    {{ $grade->grade_name }} {{ $section??'' }}
                    &nbsp;&nbsp;
                    <sub><b>
                            {{ $grade->SchoolSession->name }}
                            <small><b>
                                    {{ $grade->SchoolSession->getSessionDurationText() }}
                                </b></small>
                        </b></sub>
                </i>
            </label>
        </div>

        <div class="form-group">
            <label for="school_session">School Session <span class="text-danger"> ( Required) </span></label>
            <select name="school_session" id="school_session"
                    class="form-control @error('school_session') is-invalid @enderror"
                    required>
                <option value="">--- Select School Session ---</option>
                @foreach($school_sessions as $school_session)
                    @if(strcasecmp(old('school_session'),$school_session->id) == 0)
                        @php
                            $selected = 'selected = "selected"';
                        @endphp
                    @else
                        @if(strcasecmp($grade->SchoolSession->id,$school_session->id)==0)
                            @php
                                $selected = 'selected = "selected"';
                            @endphp
                        @else
                            @php
                                unset($selected);
                            @endphp
                        @endif
                    @endif
                    <option data-content="{{ $school_session->name }}
                        &nbsp;&nbsp;
                        <sub><b>
                        <small><b>
{{ $school_session->getSessionDurationText() }}
                        </b></small>
                    </b></sub>"
                            {{--                        data-thumbnail="https://www.gradeflags.io/{{ $grade_code }}/shiny/64.png"--}}
                            value="{{ $school_session->id }}" {{ $selected ?? '' }}>{{ $school_session->name }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback d-none" role="alert" id="school_session_error">
                <strong></strong>
            </span>
            @error('school_session')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="grade">Grade <span class="text-danger"> ( Required )</span></label>
            <input type="text" class="form-control @error('grade') is-invalid @enderror"
                   value="{{ old('grade') ?? $grade->grade_name }}" id="grade" name="grade">
            <span class="invalid-feedback d-none" role="alert" id="grade_error">
                <strong></strong>
            </span>
        </div>
        <div class="form-group">
            <label for="section">Section</label>
            <input type="text" class="form-control @error('section') is-invalid @enderror"
                   value="{{ old('section') ?? $grade->section }}" id="section" name="section">
            <span class="invalid-feedback d-none" role="alert" id="section_error">
                <strong></strong>
            </span>
        </div>
        <div class="alert alert-danger d-none" id="form_errors">

        </div>
        <div class="clearfix">
            <input type="button" class="btn btn-primary btn-lg float-right" value="Save" id="save_grade_btn" name="save_grade_btn">
        </div>
        @push('js')
            @php
                $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Saving the Grade</h5>";
                $title .= "<h6>ID: ".$grade->id."</h6>";
                $title .= "<h5 class=\"font-weight-bolder\">Old Grade Info</h5>";
                $title .= "<h6>Grade: ".$grade->grade_name."</h6>";
                $title .= "<h6>School Session: ".$grade->SchoolSession->getSessionDurationText()."</h6>";
                if(isset($grade->section)){
                    $title .= "<h6>Section: ".$grade->section."</h6>";
                }

                $res = passwordConfirmationBoxScript("#save_grade_btn","#save_grade_form","Password",$title);
                echo($res);
            @endphp
        @endpush
    </form>
    <hr class="border-theme">
    <h2 class="h2 text-center">Migrate Grade Related Information to Another Grade
        <br>
    </h2>
    <div class="text-center">
        <label> Current Grade :
            <i>
                {{ $grade->grade_name }} {{ $section??'' }}
                &nbsp;&nbsp;
                <sub><b>
                        {{ $grade->SchoolSession->name }}
                        <small><b>
                                {{ $grade->SchoolSession->getSessionDurationText() }}
                            </b></small>
                    </b></sub>
            </i>
        </label>
    </div>

@endsection
@push('js')
    <script>
        $('#school_session, #grade, #section').on('change', function () {
            var school_session = $("#school_session").val();
            var grade = $("#grade").val();
            var section = $("#section").val();
            //hide all the errors
            $("#school_session").removeClass('is-invalid');
            $("#school_session_error").addClass('d-none');
            $("#grade").removeClass('is-invalid');
            $("#grade_error").addClass('d-none');
            $("#form_errors").hide("slow");
            $("#save_btn").prop('disabled',false);
            $('select').selectpicker('refresh');
            // if school session is not selected
            if (school_session === "") {
                $("#school_session").addClass('is-invalid');
                $("#school_session_error").removeClass('d-none');
                $("#save_btn").prop('disabled',true);
                $('select').selectpicker('refresh');
                $("#school_session_error>strong").html('School Session must be selected');
            }
            // if grade is empty
            else if(grade === ""){
                $("#grade").addClass('is-invalid');
                $("#grade_error").removeClass('d-none');
                $("#save_btn").prop('disabled',true);
                $('select').selectpicker('refresh');
                $("#grade_error>strong").html('Grade is required');
            }
            else{

                $.ajax({
                    type: "POST",
                    url: "{{ route('school-admin-api-check-if-grade-exists-in-session-when-updating') }}",
                    data: { school_session: school_session, grade: grade,
                        section: section,id: {{ $grade->id }} },
                    success: function (data) {
                        $("#save_btn").prop('disabled',false);
                    },
                    error: function(data){
                        // console.log(data.responseJSON.errors);
                        console.log(data);
                        var errors = "";
                        for(const error of Object.values(data.responseJSON.errors)){
                            errors += "<li><b>"+error+"</b></li>";
                        }
                        $("#form_errors").html(errors);
                        $("#form_errors").removeClass("d-none");
                        $("#form_errors").slideDown("slow");
                        $("#save_btn").prop('disabled',true);
                    }

                });
                $("#save_btn").prop('disabled',false);
                $('select').selectpicker('refresh');
            }
        });
    </script>
@endpush
