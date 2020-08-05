@extends("layouts.super-admin-layout")
@push('css')
    <link rel="stylesheet" href="{{ asset("vendors/DataTables/datatables.css") }}">
@endpush
@push('js')
    <script src="{{ asset("vendors/DataTables/datatables.js") }}"></script>
    <script>
        jQuery(function ($) {
            $('#schools_table').DataTable({
                "scrollY": "260px",
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
    <table width="100%" class="table-bordered" id="schools_table">
        <thead>
            <th>SN</th>
            <th>ID</th>
            <th>School's Name</th>
            <th>Address</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
        @foreach($schools as $school)
            <tr>
                <td>{{ $loop->index +1  }}</td>
                <td>{{ $school->id }}</td>
                <td>{{ $school->name }}</td>
                <td>{{ $school->address }}, {{ $school->district }}, {{ $school->country }}</td>
                <td class="float-none"><a href="#" class="btn btn-theme btn-sm m-1">View</a></td>
                <td class="float-none"><a href="#" class="btn btn-primary btn-sm m-1">Edit</a></td>
                <td class="float-none"><a href="#" class="btn btn-danger btn-sm m-1">Delete</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
