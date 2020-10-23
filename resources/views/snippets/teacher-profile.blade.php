<div class="container">
    <div class="row">
        <div class="col-md-auto m-3">
            <img src="{{ getPassportPhotoImageUrl($teacher->passport_photo) }}"
                 alt="PP of {{ $teacher->id }}"
                 class="mx-auto d-block img-thumbnail"
                 style="max-height: 200px;">
        </div>
        <div class="col-md-auto">
            <div>
                <h2 class="font-weight-bold">General Information
                    <div class="float-right ml-5">
                        @isset($edit_route_name)
                            <a href="{{ route($edit_route_name,['id'=>$teacher->id]) }}"
                               class="btn btn-primary bg-gradient-primary">Edit</a>
                        @endisset
                        @if(isset($remove_route_name) || isset($reassign_route_name))
                            <td>
                                @if($teacher->has_left && isset($reassign_route_name))
                                    <input type="button" class="btn btn-outline-success m-2" value="Reassign"
                                           name="delete"
                                           id="reassign_teacher_btn_{{ $teacher->id }}">
                                    <form action="{{ route($reassign_route_name,['id' => $teacher->id]) }}"
                                          name="reassign_teacher_form" id="reassign_teacher_form_{{ $teacher->id }}"
                                          method="POST">
                                        @method('put')
                                        @csrf
                                        @isset($redirect_url)
                                            <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                                        @endisset
                                        <input type="hidden" value="{{ $teacher->id }}" name="id"
                                               id="teacher_id_{{ $teacher->id }}">
                                    </form>

                                    @push('js')
                                        @php
                                            $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Reassigning Teacher To School</h5>";
                                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$teacher->id." </h6>";
                                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Teacher Name : $teacher->name </h6>";
                                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$teacher->load('User')->User->email." </h6>";
                                            $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                            $title .= "</small>";
                                            $res = passwordConfirmationBoxScript("#reassign_teacher_btn_".$teacher->id,"#reassign_teacher_form_".$teacher->id,"Password",$title);
                                            echo($res);
                                        @endphp
                                    @endpush
                                @elseif(!$teacher->has_left && isset($remove_route_name))
                                    <input type="button" class="btn btn-outline-secondary m-2" value="Remove" name="delete"
                                           id="remove_teacher_btn_{{ $teacher->id }}">
                                    <form action="{{ route($remove_route_name,['id' => $teacher->id]) }}"
                                          name="remove_teacher_form" id="remove_teacher_form_{{ $teacher->id }}"
                                          method="POST">
                                        @method('put')
                                        @csrf
                                        @isset($redirect_url)
                                            <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                                        @endisset
                                        <input type="hidden" value="{{ $teacher->id }}" name="id"
                                               id="teacher_id_{{ $teacher->id }}">
                                    </form>

                                    @push('js')
                                        @php
                                            $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Removing Teacher From School</h5>";
                                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$teacher->id." </h6>";
                                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Teacher Name : $teacher->name </h6>";
                                            $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$teacher->load('User')->User->email." </h6>";
                                            $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                            $title .= "All the Classes of teacher will be deleted";
                                            $title .= "</small>";
                                            $res = passwordConfirmationBoxScript("#remove_teacher_btn_".$teacher->id,"#remove_teacher_form_".$teacher->id,"Password",$title);
                                            echo($res);
                                        @endphp
                                    @endpush
                                @endif
                            </td>
                        @endif
                        @isset($delete_route_name)
                            <td>
                                <input type="button" class="btn btn-danger bg-gradient-danger" value="Delete"
                                       name="delete" id="delete_teacher_btn_{{ $teacher->id }}">
                                <form action="{{ route($delete_route_name,['id' => $teacher->id]) }}"
                                      name="delete_teacher_form" id="delete_teacher_form_{{ $teacher->id }}"
                                      method="POST">
                                    @method('delete')
                                    @csrf
                                    @isset($redirect_url)
                                        <input type="hidden" value="{{ $redirect_url }}" name="redirect_url">
                                    @endisset
                                    <input type="hidden" value="{{ $teacher->id }}" name="id"
                                           id="teacher_id_{{ $teacher->id }}">
                                </form>
                            </td>
                            @push('js')
                                @php
                                    $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the Teacher</h5>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$teacher->id." </h6>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> Teacher Name : $teacher->name </h6>";
                                    $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> User Email : ".$teacher->load('User')->User->email." </h6>";
                                    $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                                    $title .= "</small>";
                                    $res = passwordConfirmationBoxScript("#delete_teacher_btn_".$teacher->id,"#delete_teacher_form_".$teacher->id,"Password",$title);
                                    echo($res);
                                @endphp
                            @endpush
                        @endisset
                    </div>
                </h2>
            </div>
            <h4 class="{{ $teacher->has_left?'text-danger':'text-success' }}">{{ $teacher->has_left?'This Teacher is currently not in School':'' }} </h4>

            <br>
            <label>ID: {{ $teacher->id }}</label>
            <br>
            <label>Name: {{ $teacher->name }}</label>
            <br>
            <label>Gender: {{ $teacher->gender }}</label>
            <br>
            <label>Address: {{ $teacher->address }}</label>
            <br>
            <label>District: {{ $teacher->district }}</label>
            <br>
            <label>Country: {{ $teacher->country }}
                <img src="https://www.countryflags.io/{{ countryToCountryCode($teacher->country) }}/shiny/24.png">
            </label>
            <br>
            <label>Phone 1: {{ $teacher->phone1 }}</label>
            <br>
            <label>Phone 2: {{ $teacher->phone2 }}</label>
            <br>
            <label>User: {{ $teacher->User->email }}</label>
            <br>
            <label>School:
                @isset($school_url)
                    <a href="{{ $school_url }}">{{ $teacher->School->name }}</a>
                @else
                    {{ $teacher->School->name }}
                @endisset

            </label>
            <br>
            <label>
                <b>Description:</b>
                <br>
                <div class="border border-theme p-3">
                    {!! $teacher->description !!}
                </div>
            </label>
            <br>
            <label>Created at: {{ $teacher->created_at }}</label>
            <br>
            <label>Last Data Updated at: {{ $teacher->updated_at }}</label>
        </div>
    </div>
    <div></div>
</div>
