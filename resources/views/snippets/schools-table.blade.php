
@push('css')
    <link rel="stylesheet" href="{{ asset("vendors/DataTables/datatables.css") }}">
@endpush
@push('js')
    <script src="{{ asset("vendors/DataTables/datatables.js") }}"></script>
    <script>
        jQuery(function ($) {
            $('#schools_table').DataTable({
                "scrollY": "240px",
                "scrollX": true,
                "scrollCollapse": false,
                stateSave: true,
                // fixedColumns:   {
                //     leftColumns: 2,
                //     rightColumns: 1
                // },
            });
        });
    </script>
@endpush
@section("super-admin-content")
    <h2 class="h2 text-center">List of Registered Schools</h2>
    <table class="table-bordered w-100" id="schools_table">
        <thead>
        <th>SN</th>
        <th>ID</th>
        <th>Logo</th>
        <th>School's Name</th>
        <th>Address</th>
        @isset($view_school_route_name)
        <th>View</th>
        @endisset
        @isset($edit_school_route_name)
        <th>Edit</th>
        @endisset
        @isset($delete_school_route_name)
        <th>Delete</th>
        @endisset
        </thead>
        <tbody>
        @foreach($schools as $school)
            <tr>
                <td>{{ $loop->index +1  }}</td>
                <td>{{ $school->id }}</td>
                <td><img src="{{ getLogoImageUrl($school->logo) }}" alt="Logo of Not Found"
                         class="img-fluid rounded" style="max-height: 70px;" loading="lazy"></td>
                <td>{{ $school->name }}</td>
                <td>{{ joinNotEmptyArrayElements(', ',[$school->address,$school->district, $school->country]) }}</td>
                @isset($view_school_route_name)
                <td class="float-none"><a href="{{ route($view_school_route_name,['id'=>$school->id]) }}" class="btn btn-theme btn-sm m-1">View</a></td>
                @endisset
                @isset($edit_school_route_name)
                    <td class="float-none"><a href="{{ route($edit_school_route_name,['id' => $school->id]) }}" class="btn btn-primary btn-sm m-1">Edit</a></td>
                @endisset
                @isset($delete_school_route_name)
                <td class="float-none">
                    <form action="{{ route($delete_school_route_name,['id' => $school->id]) }}"
                          method="POST" name="delete_school_form" id="delete_form_{{ $school->id }}">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" id="id_{{ $school->id }}" value="{{ $school->id }}">
                        <input type="submit" value="Delete" class="btn btn-danger btn-sm m-1"
                               name="delete" id="delete_btn_{{ $school->id }}">
                    </form>
                    @push('js')
                        @php
                            $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the School</h5>";
                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$school->id." </h6>";
                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> School Name : $school->name </h6>";
                            $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                            $title .="All the Data Related to School will be Deleted (Students ,Teachers, Guardians, Grades, Exams, etc.)";
                            $title .= "</small>";
                            $res = passwordConfirmationBoxScript("#delete_btn_".$school->id,"#delete_form_".$school->id,"Password",$title);
                            echo($res);
                        @endphp
                    @endpush
                </td>
                @endisset
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
