<div class="d-block container justify-content-center">
    <div class="row">
        <img src="{{ getLogoImageUrl($school->logo) }}" alt="Logo Not Found" class="rounded float-left d-inline-block img-fluid m-auto img-thumbnail" style="max-height: 130px;">
        <div class="text-center m-auto">
            <h1 class="h1 font-weight-bold">{{ $school->name }}</h1>
            <h5 class="h5">{{ $school->address }}</h5>
            @if (isNullOrEmptyString($school->district))
                <h5 class="h5">{{ $school->country }}</h5>
            @else
                <h5 class="h5">{{ $school->district }}, {{ $school->country }}
                    <img src="https://www.countryflags.io/{{ countryToCountryCode($school->country) }}/shiny/24.png">
                </h5>
            @endif
        </div>
        <div class="justify-content-center m-auto">
            @isset($edit_school_route_name)
                <a href="{{ route($edit_school_route_name,['id' => $school->id]) }}" class="btn btn-primary">Edit</a>
            @endisset
            @isset($delete_school_route_name)
                <input type="button" class="btn btn-danger" value="Delete" name="delete" id="delete_school_btn_{{ $school->id }}">
                <form action="{{ route($delete_school_route_name,['id' => $school->id]) }}"
                      name="delete_school_form" id="delete_school_form_{{ $school->id }}"
                      method="POST">
                    @method('delete')
                    @csrf
                    <input type="hidden" value="{{ route('super-admin-school') }}" name="redirect_url">
                    <input type="hidden" value="{{ $school->id }}" name="id" id="school_id_{{ $school->id }}">
                </form>
                @push('js')
                    @php
                        $title = "<h5 class=\"h5 font-weight-bolder\">Please Confirm your Password Before Deleting the School</h5>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> ID : ".$school->id." </h6>";
                        $title .= "<h6 class=\"small d-inline-block text-truncate w-75\"> School Name : $school->name </h6>";
                        $title .= "<br><small class=\"small bg-theme text-white font-weight-lighter text-justify font-italic\">";
                        $title .="All the Data Related to School will be Deleted (Students ,Teachers, Guardians, Grades, Exams, etc.)";
                        $title .= "</small>";
                        $res = passwordConfirmationBoxScript("#delete_school_btn_".$school->id,"#delete_school_form_".$school->id,"Password",$title);
                        echo($res);
                    @endphp
                @endpush
            @endisset
        </div>
    </div>
    @if(isset($only_school_banner))
        @if($only_school_banner == True)

        @endif
    @else
        <hr style="border-width: 2px;" class="border-theme">
        <h4 class="h4 font-weight-bold">General Information</h4>
        <label class="text-justify text-break">ID: {{ $school->id }}</label>
        <br>
        <label class="text-justify text-break">Phone : {{ joinNotEmptyArrayElements(', ',[$school->phone1,$school->phone2]) }}</label>
        <br>
        <label class="text-justify text-break">Email : {{ joinNotEmptyArrayElements(', ',[$school->email1,$school->email2]) }}</label>
        <br>
        <label class="text-justify text-break">Description: </label>
        <br>
        <label class="border border-theme p-3 text-break">{!! $school->description !!}</label>
        <hr style="border-width: 2px;" class="border-theme">
    @endif
</div>
