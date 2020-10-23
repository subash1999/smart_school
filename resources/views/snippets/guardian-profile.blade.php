<div class="container">
    <div class="row">
        <div class="col-md-auto m-3">
            <img src="{{ getPassportPhotoImageUrl($guardian->passport_photo) }}"
                 alt="PP of {{ $guardian->id }}"
                 class="mx-auto d-block img-thumbnail"
                 style="max-height: 200px;">
        </div>
        <div class="col-md-auto">
            <div>
                <h2 class="font-weight-bold">General Information
                    <div class="float-right ml-5">
                        @isset($edit_route_name)
                            <a href="{{ route($edit_route_name,['id'=>$guardian->id]) }}"
                               class="btn btn-primary bg-gradient-primary">Edit</a>
                        @endisset
                        @isset($delete_route_name)
                            <td>
                                <input type="button" class="btn btn-danger bg-gradient-danger" value="Delete" name="delete" id="delete_guardian_btn_{{ $guardian->id }}">
                                <form action="{{ route($delete_route_name,['id' => $guardian->id]) }}"
                                      name="delete_guardian_form" id="delete_guardian_form_{{ $guardian->id }}"
                                      method="POST">
                                    @method('delete')
                                    @csrf
                                    @isset($redirect_url)
                                        <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                                    @endisset
                                    <input type="hidden" value="{{ $guardian->id }}" name="id" id="guardian_id_{{ $guardian->id }}">
                                </form>
                            </td>
                            @push('js')
                                @php
                                    $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the Guardian</h5>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$guardian->id." </h6>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Guardian Name : $guardian->name </h6>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$guardian->load('User')->User->email." </h6>";
                                    $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                    $title .= "</small>";
                                    $res = passwordConfirmationBoxScript("#delete_guardian_btn_".$guardian->id,"#delete_guardian_form_".$guardian->id,"Password",$title);
                                    echo($res);
                                @endphp
                            @endpush
                        @endisset
                    </div>
                </h2>
            </div>
            <label>ID: {{ $guardian->id }}</label>
            <br>
            <label>Name: {{ $guardian->name }}</label>
            <br>
            <label>Gender: {{ $guardian->gender }}</label>
            <br>
            <label>Address: {{ $guardian->address }}</label>
            <br>
            <label>District: {{ $guardian->district }}</label>
            <br>
            <label>Country: {{ $guardian->country }}
                <img src="https://www.countryflags.io/{{ countryToCountryCode($guardian->country) }}/shiny/24.png">
            </label>
            <br>
            <label>Phone 1: {{ $guardian->phone1 }}</label>
            <br>
            <label>Phone 2: {{ $guardian->phone2 }}</label>
            <br>
            <label>User: {{ $guardian->User->email }}</label>
            <br>
            <label>School:
                @isset($school_url)
                    <a href="{{ $school_url }}">{{ $guardian->School->name }}</a>
                @else
                    {{ $guardian->School->name }}
                @endisset

            </label>
            <br>
            <label>
                <b>Description:</b>
                <br>
                <div class="border border-theme p-3">
                    {!! $guardian->description !!}
                </div>
            </label>
            <br>
            <label>Created at: {{ $guardian->created_at }}</label>
            <br>
            <label>Last Data Updated at: {{ $guardian->updated_at }}</label>
        </div>
    </div>
    <div></div>
</div>
