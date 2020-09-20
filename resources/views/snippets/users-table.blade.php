
@push('css')
    <link rel="stylesheet" href="{{ asset("vendors/DataTables/datatables.css") }}">
@endpush
@push('js')
    <script src="{{ asset("vendors/DataTables/datatables.js") }}"></script>
    <script>
        jQuery(function ($) {
            $('#users_table').DataTable({
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
    <h2 class="h2 text-center">List of Registered Users</h2>
    <table class="table-bordered w-100" id="users_table">
        <thead>
        <th>SN</th>
        <th>ID</th>
        <th>Avatar</th>
        <th>Email</th>
        <th>Created At</th>
        @isset($view_user_route_name)
            <th>View</th>
        @endisset
        @isset($edit_user_route_name)
            <th>Edit</th>
        @endisset
        @isset($delete_user_route_name)
            <th>Delete</th>
        @endisset
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $loop->index +1  }}</td>
                <td>{{ $user->id }}</td>
                <td><img src="{{ getAvatarImageUrl($user->avatar) }}" alt="Logo of Not Found"
                         class="img-fluid rounded" style="max-height: 70px;" loading="lazy"
                    ></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                @isset($view_user_route_name)
                    <td class="float-none"><a href="{{ route($view_user_route_name,['id'=>$user->id]) }}" class="btn btn-theme btn-sm m-1">View</a></td>
                @endisset
                @isset($edit_user_route_name)
                    <td class="float-none"><a href="{{ route($edit_user_route_name,['id' => $user->id]) }}" class="btn btn-primary btn-sm m-1">Edit</a></td>
                @endisset
                @isset($delete_user_route_name)
                    <td class="float-none">
                    @if($user->id != Auth::user()->id)
                            <input type="submit" value="Delete" class="btn btn-danger btn-sm m-1"
                                   name="delete" id="delete_btn_{{ $user->id }}">
                            <form action="{{ route($delete_user_route_name,['id' => $user->id]) }}"
                                  method="POST" name="delete_user_form" id="delete_form_{{ $user->id }}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" id="id_{{ $user->id }}" value="{{ $user->id }}">
                            </form>
                            @push('js')
                                @php
                                    $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the User</h5>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$user->id." </h6>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Email : $user->email </h6>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Current Roles : ".implode(', ',array_keys($user->getAvailableRoles()))." </h6>";
                                    $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\"> All the user roles will be deleted";
                                    $title .= "</small>";
                                    $res = passwordConfirmationBoxScript("#delete_btn_".$user->id,"#delete_form_".$user->id,"Password",$title);
                                    echo($res);
                                @endphp
                            @endpush
                    @endif
                    </td>
                @endisset
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
