<h4 class="h4 font-weight-bold">School Admins</h4>
<table class="w-100 table-bordered" id="school_admins_table">
    <thead>
    <th>S.N</th>
    <th>I.D</th>
    <th>Passport Photo</th>
    <th>Name</th>
    <th>Full Address</th>
    <th>User</th>
    <th>View</th>
    </thead>
    <tbody>
    @foreach($school->schoolAdmins as $school_admin)
        <tr>
            <td>{{ $loop->index +1 }}</td>
            <td>{{ $school_admin->id }}</td>
            <td class="justify-content-center">
                <img src="{{ getPassportPhotoImageUrl($school_admin->passport_photo) }}"
                     class="img-fluid rounded m-auto d-block"
                     alt="Passport Photo of {{ $school_admin->id }}"
                     style="height: 70px;">
            </td>
            <td>{{ $school_admin->name }}</td>
            <td>{{ joinNotEmptyArrayElements(', ',[$school_admin->address,$school_admin->district,$school_admin->country]) }}</td>
            <td>{{ $school_admin->load('User')->User->email }}</td>
            <td><a href="#" class="btn btn-primary btn-sm m-2">View</a></td>
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

