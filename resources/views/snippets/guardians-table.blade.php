<table class="w-100 table-bordered" id="guardians_table">
    <thead>
    <th>S.N</th>
    <th>I.D</th>
    <th>Passport Photo</th>
    <th>Name</th>
    <th>Full Address</th>
    <th>Email (User)</th>
    @isset($student)
        <th>Relation to Student</th>
    @endisset
    @isset($school_route_name)
        <th>School</th>
    @endisset
    @if(isset($delete_guardian_of_student_route_name) &&
                    isset($student))
        <th>Remove Guardian Student Relation</th>
    @endif
    @isset($view_route_name)
        <th>View</th>
    @endisset
    @isset($edit_route_name)
        <th>Edit</th>
    @endisset
    @isset($delete_route_name)
        <th>Delete</th>
    @endisset
    </thead>
    <tbody>
    @foreach($guardians->sortBy('id') as $guardian)
        <tr>
            <td>{{ $loop->index +1 }}</td>
            <td>{{ $guardian->id }}</td>
            <td class="justify-content-center">
                <img src="{{ getPassportPhotoImageUrl($guardian->passport_photo) }}"
                     class="img-fluid rounded m-auto d-block"
                     alt="Passport Photo of {{ $guardian->id }}"
                     style="height: 70px;" loading="lazy">
            </td>
            <td>{{ $guardian->name }}</td>
            <td>{{ joinNotEmptyArrayElements(', ',[$guardian->address,$guardian->district,$guardian->country]) }}</td>
            <td>{{ $guardian->load('User')->User->email }}</td>
            @isset($student)
                @php
                    $relation_to_student = $guardian->guardianStudents()
                            ->where('guardian_id',$guardian->id)
                            ->where('student_id',$student->id)
                            ->first()
                            ->relation_to_student;
                @endphp
                <td>{{ $relation_to_student }}</td>
            @endisset
            @isset($school_route_name)
                <td>
                    <a href="{{ route($school_route_name,['id' => $guardian->School->id]) }}">{{$guardian->School->name}}</a>
                </td>
            @endisset
            @if(isset($delete_guardian_of_student_route_name) &&
                    isset($student))
                <td>
                    <button type="button"
                            class="btn bg-gradient-warning btn-sm m-2"
                            id="delete_student_{{ $student->id }}_guardian_{{ $guardian->id }}_btn">
                        Delete Relation
                    </button>
                    <form action="{{ route($delete_guardian_of_student_route_name,[
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
                <td><a href="{{ route($view_route_name,['id'=>$guardian->id]) }}"
                       class="btn bg-gradient-theme text-white btn-sm m-2">View</a></td>
            @endisset
            @isset($edit_route_name)
                <td><a href="{{ route($edit_route_name,['id'=>$guardian->id]) }}"
                       class="btn btn-primary bg-gradient-primary btn-sm m-2">Edit</a></td>
            @endisset
            @isset($delete_route_name)
                <td>
                    <input type="button" class="btn btn-danger btn-sm m-2" value="Delete" name="delete"
                           id="delete_guardian_btn_{{ $guardian->id }}">
                    <form action="{{ route($delete_route_name,['id' => $guardian->id]) }}"
                          name="delete_guardian_form" id="delete_guardian_form_{{ $guardian->id }}"
                          method="POST">
                        @method('delete')
                        @csrf
                        @isset($redirect_url)
                            <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                        @endisset
                        <input type="hidden" value="{{ $guardian->id }}" name="id"
                               id="guardian_id_{{ $guardian->id }}">
                    </form>
                </td>
                @push('js')
                    @php
                        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the Guardian</h5>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$guardian->id." </h6>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Guardian Name : $guardian->name </h6>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$guardian->load('User')->User->email." </h6>";
                        $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                        $title .= "</small>";
                        $res = passwordConfirmationBoxScript("#delete_guardian_btn_".$guardian->id,"#delete_guardian_form_".$guardian->id,"Password",$title);
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
            $('#guardians_table').DataTable({
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

