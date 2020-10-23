<div class="container">
    <div class="row">
        <div class="col-md-auto">
            <div>
                <h2 class="font-weight-bold">Grade Information
                    <div class="float-right ml-5">
                        @isset($edit_route_name)
                            <a href="{{ route($edit_route_name,['id'=>$grade->id]) }}"
                               class="btn btn-primary bg-gradient-primary">Edit</a>
                        @endisset
                        @isset($delete_route_name)
                            <td>
                                <input type="button" class="btn btn-danger bg-gradient-danger" value="Delete"
                                       name="delete" id="delete_grade_btn_{{ $grade->id }}">
                                <form action="{{ route($delete_route_name,['id' => $grade->id]) }}"
                                      name="delete_grade_form" id="delete_grade_form_{{ $grade->id }}"
                                      method="POST">
                                    @method('delete')
                                    @csrf
                                    @isset($redirect_url)
                                        <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                                    @endisset
                                    <input type="hidden" value="{{ $grade->id }}" name="id"
                                           id="grade_id_{{ $grade->id }}">
                                </form>
                            </td>
                            @push('js')
                                @php
                                    $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the grade</h5>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$grade->id." </h6>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Grade Name : $grade->name </h6>";
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
                        @endisset
                    </div>
                </h2>
            </div>
            <label>ID: {{ $grade->id }}</label>
            <br>
            <label>Grade: {{ $grade->grade_name }}</label>
            <br>
            <label>Section: {{ $grade->section }}</label>
            <br>
            <label class="font-weight-bolder">Session: {{ $grade->SchoolSession->name }}
                <sub>{{ $grade->SchoolSession->getSessionDurationText() }}</sub>
            </label>
            <br>
            <label>Total Students: {{ $grade->students()->count() }}</label>
            <br>
            <label>Total Teachers: {{ $grade->teachers()->count() }}</label>
            <br>
            <label>Total Subjects: {{ $grade->subjects()->count() }}</label>
            <br>
            <label>Total Exams: {{ $grade->exams()->count() }}</label>
            <br>
            <label>School:
                @isset($school_url)
                    <a href="{{ $school_url }}">{{ $grade->school()->name }}</a>
                @else
                    {{ $grade->school()->name }}
                @endisset

            </label>
            <br>
            <label>
                <b>Description:</b>
                <br>
                <div class="border border-theme p-3">
                    {!! $grade->description !!}
                </div>
            </label>
            <br>
            <label>Created at: {{ $grade->created_at }}</label>
            <br>
            <label>Last Data Updated at: {{ $grade->updated_at }}</label>
        </div>
    </div>
    <div></div>
</div>
