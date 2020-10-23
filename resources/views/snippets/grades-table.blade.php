<table class="w-100 table-bordered" id="grades_table">
    <thead>
    <th>S.N</th>
    <th>I.D</th>
    <th>Grade Name</th>
    <th>Section</th>
    <th>School Session</th>
    @isset($school_route_name)
        <th>School</th>
    @endisset
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
    @foreach($grades as $grade)
        <tr>
            <td>{{ $loop->index +1 }}</td>
            <td>{{ $grade->id }}</td>
            <td>{{ $grade->grade_name }}</td>
            <td>{{ $grade->section }}</td>
            <td>{{ $grade->SchoolSession->name }}
                <sub>{{ $grade->SchoolSession->from->format('Y M d') }} - {{ $grade->SchoolSession->to->format('Y M d') }}</sub></td>
            @isset($school_route_name)
                <td>
                    <a href="{{ route($school_route_name,['id' => $grade->school()->id]) }}">{{ $grade->school()->name }}</a>
                </td>
            @endisset
            @isset($view_route_name)
                <td><a href="{{ route($view_route_name,['id'=>$grade->id]) }}"
                       class="btn bg-gradient-theme text-white btn-sm m-2">View</a></td>
            @endisset
            @isset($edit_route_name)
                <td><a href="{{ route($edit_route_name,['id'=>$grade->id]) }}"
                       class="btn btn-primary bg-gradient-primary btn-sm m-2">Edit</a></td>
            @endisset
            @isset($delete_route_name)
                <td>
                    <input type="button" class="btn btn-danger btn-sm m-2" value="Delete" name="delete"
                           id="delete_grade_btn_{{ $grade->id }}">
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
                        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the Grade</h5>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$grade->id." </h6>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Grade : $grade->grade_name </h6>";
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
            $('#grades_table').DataTable({
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

