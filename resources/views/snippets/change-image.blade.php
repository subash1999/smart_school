<div class="col">
    <img src="{{ $current_image_url }}" alt="Logo Not Found" class="img-fluid img-thumbnail rounded mx-auto d-block"
         style="max-height: 200px;"
         name="logo"
         id="logo">
    <br>

    <button type="button" class="btn btn-theme mx-auto d-block"
            id="upload_pp_btn"
    >{{ $upload_btn_text ?? "Upload New Image" }}</button>
    <br />
    <div id="uploaded_image"></div>
</div>

@php
    if(!isset($redirect_url)){
        $redirect_url = null;
    }
@endphp

@include('snippets.croppie-image-upload',[
            'upload_btn_jquery' => '#upload_pp_btn',
            'image_upload_url' => $image_upload_url,
            'redirect_url' => $redirect_url])
