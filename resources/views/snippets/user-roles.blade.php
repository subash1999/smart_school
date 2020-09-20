
@push('css')
    <link rel="stylesheet" href="{{ asset("vendors/DataTables/datatables.css") }}">
@endpush
@push('js')
    <script src="{{ asset("vendors/DataTables/datatables.js") }}"></script>
    <script>
        jQuery(function ($) {
            $('#user_roles_table_{{ $user->id }}').DataTable({
                "scrollY": "240px",
                // "scrollX": true,
                // "autoWidth": true,
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
<h2 class="m-3">User Roles</h2>
<table id="user_roles_table_{{ $user->id }}"
    class="table table-bordered">
    <thead>
        <th>S.N</th>
        <th>Role</th>
        <th>School Name</th>
    </thead>
    <tbody>
        @php
            $sn = 1;
        @endphp
        @foreach($user->getAvailableRoles() as $role => $role_infos)
            @foreach ($role_infos as $role_info)
                <tr>
                    <td>{{ $sn++ }}</td>
                    <td>{{ $role }}</td>
                    <td>{{ $role_info['school_name'] ?? ''}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
