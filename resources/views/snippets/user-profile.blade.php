<div class="container">
    <div class="row">
        <div class="col-md-auto m-3">
            <img src="{{ getAvatarImageUrl($user->avatar) }}"
                 alt="Avatar of {{ $user->id }}"
                 class="mx-auto d-block img-thumbnail"
                 style="max-height: 200px;">
        </div>
        <div class="col-md-auto">
            <div>
                <h2 class="font-weight-bold">User Information
                    <div class="float-right ml-5">
                        @isset($edit_route_name)
                            <a href="{{ route($edit_route_name,['id'=>$user->id]) }}"
                               class="btn btn-primary bg-gradient-primary">Edit</a>
                        @endisset
                        @if($user->id != Auth::user()->id)
                            @isset($delete_route_name)
                                <td>
                                    <input type="button" class="btn btn-danger bg-gradient-danger" value="Delete" name="delete" id="delete_user_btn_{{ $user->id }}">
                                    <form action="{{ route($delete_route_name,['id' => $user->id]) }}"
                                          name="delete_user_form" id="delete_user_form_{{ $user->id }}"
                                          method="POST">
                                        @method('delete')
                                        @csrf
                                        @isset($redirect_url)
                                            <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                                        @endisset
                                        <input type="hidden" value="{{ $user->id }}" name="id" id="user_id_{{ $user->id }}">
                                    </form>
                                </td>
                                @push('js')
                                    @php
                                        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the User</h5>";
                                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$user->id." </h6>";
                                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Email : $user->email </h6>";
                                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Current Roles : ".implode(', ',array_keys($user->getAvailableRoles()))." </h6>";
                                        $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\"> All the user roles will be deleted";
                                        $title .= "</small>";
                                        $res = passwordConfirmationBoxScript("#delete_user_btn_".$user->id,"#delete_user_form_".$user->id,"Password",$title);
                                        echo($res);
                                    @endphp
                                @endpush
                            @endisset
                        @endif
                    </div>
                </h2>
            </div>
            <label>ID: {{ $user->id }}</label>
            <br>
            <label>Email: {{ $user->email }}</label>
            <br>
            <label>Created at: {{ $user->created_at }}</label>
            <br>
            <label>Last Data Updated at: {{ $user->updated_at }}</label>
        </div>
    </div>
    <div></div>
</div>
