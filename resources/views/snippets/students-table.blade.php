@php
    $uuid = Str::uuid();
    $current_school_session_id = getCurrentSchoolSessionId();
@endphp
<table class="w-100 table-bordered" id="school_admins_table_{{ $uuid }}">
    <thead>
    <th>S.N</th>
    <th>I.D</th>
    <th>Passport Photo</th>
    <th>Name</th>
    @isset($current_school_session_id)
        <th>Grade ({{ \App\SchoolSession::find($current_school_session_id)->name }})</th>
    @endisset
    <th>Full Address</th>
    <th>Has Left School</th>
    @isset($guardian)
        <th>Relation to Student</th>
    @endisset
    @isset($school_route_name)
        <th>School</th>
    @endisset
    @isset($delete_student_of_guardian_route_name)
        <th>Remove Guardian Student Relation</th>
    @endisset
    @isset($view_route_name)
        <th>View</th>
    @endisset
    @isset($edit_route_name)
        <th>Edit</th>
    @endisset
    @if(isset($remove_route_name) || isset($reassign_route_name))
        <th>Remove/ Reassign Student</th>
    @endif
    @isset($delete_route_name)
        <th>Delete</th>
    @endisset
    </thead>
    <tbody>
    @foreach($students as $student)
        <tr>
            <td>{{ $loop->index +1 }}</td>
            <td>{{ $student->id }}</td>
            <td class="justify-content-center">
                <img src="{{ getPassportPhotoImageUrl($student->passport_photo) }}"
                     class="img-fluid rounded m-auto d-block"
                     alt="Passport Photo of {{ $student->id }}"
                     style="height: 70px;" loading="lazy">
            </td>
            <td>{{ $student->name }}</td>
            @isset($current_school_session_id)
                @php
                $grade = "";
                    foreach($student->Grades as $grade){
                        if($grade->school_session_id == getCurrentSchoolSessionId()){
                            $grade = $grade->grade_name;
                            if(isset($grade->section)){
                                $grade .= "<br>Section: ".$grade->section;
                            }
                            break;
                        }
                    }
                @endphp
                <td>{!! $grade !!}</td>
            @endisset
            <td>{{ joinNotEmptyArrayElements(', ',[$student->address,$student->district,$student->country]) }}</td>
            <td>{!! $student->has_left?'<span class="text-danger">Yes</span>':'<span class="text-success">No</span>' !!}</td>
            @isset($guardian)
                @php
                    $relation_to_student = $student->guardianStudents()
                            ->where('guardian_id',$guardian->id)
                            ->where('student_id',$student->id)
                            ->first()
                            ->relation_to_student;
                @endphp
                <td>{{ $relation_to_student }}</td>
            @endisset
            @isset($school_route_name)
                <td>
                    <a href="{{ route($school_route_name,['id' => $student->School->id]) }}">{{$student->School->name}}</a>
                </td>
            @endisset
            @if(isset($delete_student_of_guardian_route_name) &&
                    isset($guardian))
                <td>
                    <button type="button"
                       class="btn bg-gradient-warning btn-sm m-2"
                       id="delete_student_{{ $student->id }}_guardian_{{ $guardian->id }}_btn">
                        Delete Relation</button>
                    <form action="{{ route($delete_student_of_guardian_route_name,[
                        'guardian_id'=>$guardian->id,
                        'student_id'=>$student->id]) }}" method="post"
                          id="delete_student_{{ $student->id }}_guardian_{{ $guardian->id }}_form">
                        @csrf
                        @method('delete')

                        <input type="hidden" name="guardian_id" value="{{ $guardian->id }}">
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                    </form>
                    @push('js')
                        <script>
                            $("#delete_student_{{ $student->id }}_guardian_{{ $guardian->id }}_btn")
                                .on('click', function (e) {
                                    e.preventDefault();
                                    bootbox.confirm({
                                        message: ` Are you sure you want to delete the guardian relation with student?<br>
                                            <label class="text-break">Guardian : {{ $guardian->name }} (ID: {{ $guardian->id }})</label><br>
                                            <label class="text-break">Student : {{ $student->name }} (ID: {{ $student->id }})</label><br>
                                            <label class="text-break">Relation : {{ $relation_to_student }}</label><br>`
                                        ,
                                        callback: function (result) {
                                            //if ok pressed result is true
                                            if (result) {
                                                $("#delete_student_{{ $student->id }}_guardian_{{ $guardian->id }}_form").submit();
                                            }
                                        },
                                        html: true,
                                        container: '#app',
                                    });
                                });

                        </script>
                    @endpush
                </td>
            @endif
            @isset($view_route_name)
                <td><a href="{{ route($view_route_name,['id'=>$student->id]) }}"
                       class="btn bg-gradient-theme text-white btn-sm m-2">View</a></td>
            @endisset
            @isset($edit_route_name)
                <td><a href="{{ route($edit_route_name,['id'=>$student->id]) }}"
                       class="btn btn-primary bg-gradient-primary btn-sm m-2">Edit</a></td>
            @endisset
            @if(isset($remove_route_name) || isset($reassign_route_name))
                <td>
                    @if($student->has_left && isset($reassign_route_name))
                        <input type="button" class="btn btn-outline-success btn-sm m-2" value="Reassign" name="delete"
                               id="reassign_student_btn_{{ $student->id }}">
                        <form action="{{ route($reassign_route_name,['id' => $student->id]) }}"
                              name="reassign_student_form" id="reassign_student_form_{{ $student->id }}"
                              method="POST">
                            @method('put')
                            @csrf
                            @isset($redirect_url)
                                <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                            @endisset
                            <input type="hidden" value="{{ $student->id }}" name="id"
                                   id="student_id_{{ $student->id }}">
                        </form>

                        @push('js')
                            @php
                                $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Reassigning Student To School</h5>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$student->id." </h6>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Student Name : $student->name </h6>";
                                $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                $title .= "</small>";
                                $res = passwordConfirmationBoxScript("#reassign_student_btn_".$student->id,"#reassign_student_form_".$student->id,"Password",$title);
                                echo($res);
                            @endphp
                        @endpush
                    @elseif(!$student->has_left && isset($remove_route_name))
                        <input type="button" class="btn btn-outline-secondary btn-sm m-2" value="Remove" name="delete"
                               id="remove_student_btn_{{ $student->id }}">
                        <form action="{{ route($remove_route_name,['id' => $student->id]) }}"
                              name="remove_student_form" id="remove_student_form_{{ $student->id }}"
                              method="POST">
                            @method('put')
                            @csrf
                            @isset($redirect_url)
                                <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                            @endisset
                            <input type="hidden" value="{{ $student->id }}" name="id"
                                   id="student_id_{{ $student->id }}">
                        </form>

                        @push('js')
                            @php
                                $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Removing Student From School</h5>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$student->id." </h6>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> student Name : $student->name </h6>";
                                $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                $title .= "All the Classes of student will be deleted";
                                $title .= "</small>";
                                $res = passwordConfirmationBoxScript("#remove_student_btn_".$student->id,"#remove_student_form_".$student->id,"Password",$title);
                                echo($res);
                            @endphp
                        @endpush
                    @endif
                </td>
            @endif
            @isset($delete_route_name)
                <td>
                    <input type="button" class="btn btn-danger btn-sm m-2" value="Delete" name="delete"
                           id="delete_student_btn_{{ $student->id }}">
                    <form action="{{ route($delete_route_name,['id' => $student->id]) }}"
                          name="delete_student_form" id="delete_student_form_{{ $student->id }}"
                          method="POST">
                        @method('delete')
                        @csrf
                        @isset($redirect_url)
                            <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                        @endisset
                        <input type="hidden" value="{{ $student->id }}" name="id"
                               id="student_id_{{ $student->id }}">
                    </form>
                </td>
                @push('js')
                    @php
                        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the Student</h5>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$student->id." </h6>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Student Name : $student->name </h6>";
                        $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                        $title .= "</small>";
                        $res = passwordConfirmationBoxScript("#delete_student_btn_".$student->id,"#delete_student_form_".$student->id,"Password",$title);
                        echo($res);
                    @endphp
                @endpush
            @endisset
        </tr>
    @endforeach
    </tbody>
</table>
@push('css')
    <link rel="stylesheet" href="{{ asset("vendors/DataTables/datatables.css") }}">
@endpush
@push('js')
    <script src="{{ asset("vendors/DataTables/datatables.js") }}"></script>
    <script>
        jQuery(function ($) {
            $('#school_admins_table_{{ $uuid }}').DataTable({
                "scrollY": "300px",
                "scrollX": true,
                "scrollCollapse": false,
                stateSave: true,
                // fixedColumns:   {
                //     leftColumns: 2,
                //     rightColumns: 1
                // },
            }).columns.adjust();
        });
    </script>
@endpush

