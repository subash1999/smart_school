<table class="w-100 table-bordered" id="school_admins_table">
    <thead>
    <th>S.N</th>
    <th>I.D</th>
    <th>Passport Photo</th>
    <th>Name</th>
    <th>Full Address</th>
    <th>Email (User)</th>
    <th>Has Left School</th>
    @isset($school_route_name)
        <th>School</th>
    @endisset
    @isset($view_route_name)
        <th>View</th>
    @endisset
    @isset($edit_route_name)
        <th>Edit</th>
    @endisset
    @if(isset($remove_route_name) || isset($reassign_route_name))
        <th>Remove/ Reassign Teacher</th>
    @endif
    @isset($delete_route_name)
        <th>Delete</th>
    @endisset
    </thead>
    <tbody>
    @foreach($teachers as $teacher)
        <tr>
            <td>{{ $loop->index +1 }}</td>
            <td>{{ $teacher->id }}</td>
            <td class="justify-content-center">
                <img src="{{ getPassportPhotoImageUrl($teacher->passport_photo) }}"
                     class="img-fluid rounded m-auto d-block"
                     alt="Passport Photo of {{ $teacher->id }}"
                     style="height: 70px;" loading="lazy">
            </td>
            <td>{{ $teacher->name }}</td>
            <td>{{ joinNotEmptyArrayElements(', ',[$teacher->address,$teacher->district,$teacher->country]) }}</td>
            <td>{{ $teacher->load('User')->User->email }}</td>
            <td>{!! $teacher->has_left?'<span class="text-danger">Yes</span>':'<span class="text-success">No</span>' !!}</td>
            @isset($school_route_name)
                <td>
                    <a href="{{ route($school_route_name,['id' => $teacher->School->id]) }}">{{$teacher->School->name}}</a>
                </td>
            @endisset
            @isset($view_route_name)
                <td><a href="{{ route($view_route_name,['id'=>$teacher->id]) }}"
                       class="btn bg-gradient-theme text-white btn-sm m-2">View</a></td>
            @endisset
            @isset($edit_route_name)
                <td><a href="{{ route($edit_route_name,['id'=>$teacher->id]) }}"
                       class="btn btn-primary bg-gradient-primary btn-sm m-2">Edit</a></td>
            @endisset
            @if(isset($remove_route_name) || isset($reassign_route_name))
                <td>
                    @if($teacher->has_left && isset($reassign_route_name))
                        <input type="button" class="btn btn-outline-success btn-sm m-2" value="Reassign" name="delete"
                               id="reassign_teacher_btn_{{ $teacher->id }}">
                        <form action="{{ route($reassign_route_name,['id' => $teacher->id]) }}"
                              name="reassign_teacher_form" id="reassign_teacher_form_{{ $teacher->id }}"
                              method="POST">
                            @method('put')
                            @csrf
                            @isset($redirect_url)
                                <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                            @endisset
                            <input type="hidden" value="{{ $teacher->id }}" name="id"
                                   id="teacher_id_{{ $teacher->id }}">
                        </form>

                        @push('js')
                            @php
                                $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Reassigning Teacher To School</h5>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$teacher->id." </h6>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Teacher Name : $teacher->name </h6>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$teacher->load('User')->User->email." </h6>";
                                $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                $title .= "</small>";
                                $res = passwordConfirmationBoxScript("#reassign_teacher_btn_".$teacher->id,"#reassign_teacher_form_".$teacher->id,"Password",$title);
                                echo($res);
                            @endphp
                        @endpush
                    @elseif(!$teacher->has_left && isset($remove_route_name))
                        <input type="button" class="btn btn-outline-secondary btn-sm m-2" value="Remove" name="delete"
                               id="remove_teacher_btn_{{ $teacher->id }}">
                        <form action="{{ route($remove_route_name,['id' => $teacher->id]) }}"
                              name="remove_teacher_form" id="remove_teacher_form_{{ $teacher->id }}"
                              method="POST">
                            @method('put')
                            @csrf
                            @isset($redirect_url)
                                <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                            @endisset
                            <input type="hidden" value="{{ $teacher->id }}" name="id"
                                   id="teacher_id_{{ $teacher->id }}">
                        </form>

                        @push('js')
                            @php
                                $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Removing Teacher From School</h5>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$teacher->id." </h6>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Teacher Name : $teacher->name </h6>";
                                $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$teacher->load('User')->User->email." </h6>";
                                $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                $title .= "All the Classes of teacher will be deleted";
                                $title .= "</small>";
                                $res = passwordConfirmationBoxScript("#remove_teacher_btn_".$teacher->id,"#remove_teacher_form_".$teacher->id,"Password",$title);
                                echo($res);
                            @endphp
                        @endpush
                    @endif
                </td>
            @endif
            @isset($delete_route_name)
                <td>
                    <input type="button" class="btn btn-danger btn-sm m-2" value="Delete" name="delete"
                           id="delete_teacher_btn_{{ $teacher->id }}">
                    <form action="{{ route($delete_route_name,['id' => $teacher->id]) }}"
                          name="delete_teacher_form" id="delete_teacher_form_{{ $teacher->id }}"
                          method="POST">
                        @method('delete')
                        @csrf
                        @isset($redirect_url)
                            <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                        @endisset
                        <input type="hidden" value="{{ $teacher->id }}" name="id"
                               id="teacher_id_{{ $teacher->id }}">
                    </form>
                </td>
                @push('js')
                    @php
                        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the Teacher</h5>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$teacher->id." </h6>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Teacher Name : $teacher->name </h6>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$teacher->load('User')->User->email." </h6>";
                        $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                        $title .= "</small>";
                        $res = passwordConfirmationBoxScript("#delete_teacher_btn_".$teacher->id,"#delete_teacher_form_".$teacher->id,"Password",$title);
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
            $('#school_admins_table').DataTable({
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

