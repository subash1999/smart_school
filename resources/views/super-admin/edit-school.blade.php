@extends("layouts.super-admin-layout")
@section('page-heading','School / '.$school->name.' ( Edit )')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
@endpush
@push('js')
    <script src="{{ asset("js/exif.js") }}"></script>
    <script src="{{ asset('js/croppie.js') }}"></script>
@endpush
@section('super-admin-content')
    <div class="col">
            <img src="{{ $school->logo }}" alt="Logo Not Found" class="img-fluid img-thumbnail rounded mx-auto d-block"
                 style="max-height: 200px;"
                 name="logo"
                 id="logo">
        <br>

        <button type="button" class="btn btn-theme mx-auto d-block"
                id="upload_pp_btn"
        >Upload New Image</button>
        <br />
        <div id="uploaded_image"></div>
    </div>
    @php
    $croppie_upload = croppieFileUpload("","#upload_pp_btn");
    @endphp
    {!! $croppie_upload['html'] !!}
    @push('js')
        {!! $croppie_upload['js'] !!}
    @endpush
@endsection
