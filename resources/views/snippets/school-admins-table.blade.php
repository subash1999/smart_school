<table class="w-100 table-bordered" id="school_admins_table">
    <thead>
    <th>S.N</th>
    <th>I.D</th>
    <th>Passport Photo</th>
    <th>Name</th>
    <th>Full Address</th>
    <th>Email (User)</th>
    <th>School</th>
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
    @foreach($school_admins as $school_admin)
        <tr>
            <td>{{ $loop->index +1 }}</td>
            <td>{{ $school_admin->id }}</td>
            <td class="justify-content-center">
                <img src="{{ getPassportPhotoImageUrl($school_admin->passport_photo) }}"
                     class="img-fluid rounded m-auto d-block"
                     alt="Passport Photo of {{ $school_admin->id }}"
                     style="height: 70px;" loading="lazy">
            </td>
            <td>{{ $school_admin->name }}</td>
            <td>{{ joinNotEmptyArrayElements(', ',[$school_admin->address,$school_admin->district,$school_admin->country]) }}</td>
            <td>{{ $school_admin->load('User')->User->email }}</td>
            <td><a href="{{ route('super-admin-show-school',['id' => $school_admin->School->id]) }}">{{$school_admin->School->name}}</a></td>
            @isset($view_route_name)
            <td><a href="{{ route($view_route_name,['id'=>$school_admin->id]) }}" class="btn bg-gradient-theme text-white btn-sm m-2">View</a></td>
            @endisset
            @isset($edit_route_name)
            <td><a href="{{ route($edit_route_name,['id'=>$school_admin->id]) }}" class="btn btn-primary bg-gradient-primary btn-sm m-2">Edit</a></td>
            @endisset
            @isset($delete_route_name)
            <td>
                <input type="button" class="btn btn-danger btn-sm m-2" value="Delete" name="delete" id="delete_school_admin_btn_{{ $school_admin->id }}">
                <form action="{{ route($delete_route_name,['id' => $school_admin->id]) }}"
                      name="delete_school_admin_form" id="delete_school_admin_form_{{ $school_admin->id }}"
                      method="POST">
                    @method('delete')
                    @csrf
                    @isset($redirect_url)
                        <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                    @endisset
                    <input type="hidden" value="{{ $school_admin->id }}" name="id" id="school_admin_id_{{ $school_admin->id }}">
                </form>
            </td>
            @push('js')
                @php
                    $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the School Admin</h5>";
                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$school_admin->id." </h6>";
                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> School Admin Name : $school_admin->name </h6>";
                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$school_admin->load('User')->User->email." </h6>";
                    $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                    $title .= "</small>";
                    $res = passwordConfirmationBoxScript("#delete_school_admin_btn_".$school_admin->id,"#delete_school_admin_form_".$school_admin->id,"Password",$title);
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

