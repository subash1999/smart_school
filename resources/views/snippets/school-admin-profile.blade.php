<div class="container">
    <div class="row">
        <div class="col-md-auto m-3">
            <img src="{{ getPassportPhotoImageUrl($school_admin->passport_photo) }}"
                 alt="PP of {{ $school_admin->id }}"
                 class="mx-auto d-block img-thumbnail"
                 style="max-height: 200px;">
        </div>
        <div class="col-md-auto">
            <div>
                <h2 class="font-weight-bold">General Information
                <div class="float-right ml-5">
                    @isset($edit_route_name)
                        <a href="{{ route($edit_route_name,['id'=>$school_admin->id]) }}"
                           class="btn btn-primary bg-gradient-primary">Edit</a>
                    @endisset
                    @isset($delete_route_name)
                        <td>
                            <input type="button" class="btn btn-danger bg-gradient-danger" value="Delete" name="delete" id="delete_school_admin_btn_{{ $school_admin->id }}">
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
                </div>
                </h2>
            </div>
            <label>Name: {{ $school_admin->name }}</label>
            <br>
            <label>Gender: {{ $school_admin->gender }}</label>
            <br>
            <label>Address: {{ $school_admin->address }}</label>
            <br>
            <label>District: {{ $school_admin->district }}</label>
            <br>
            <label>Country: {{ $school_admin->country }}
                <img src="https://www.countryflags.io/{{ countryToCountryCode($school_admin->country) }}/shiny/24.png">
            </label>
            <br>
            <label>Phone 1: {{ $school_admin->phone1 }}</label>
            <br>
            <label>Phone 2: {{ $school_admin->phone2 }}</label>
            <br>
            <label>User: {{ $school_admin->User->email }}</label>
            <br>
            <label>School: <a href="{{ $school_url }}">{{ $school_admin->School->name }}</a></label>
            <br>
            <label>Created at: {{ $school_admin->created_at }}</label>
            <br>
            <label>Last Data Updated at: {{ $school_admin->updated_at }}</label>
        </div>
    </div>
    <div></div>
</div>
