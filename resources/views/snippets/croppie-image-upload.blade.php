@php
    use Illuminate\Support\Str;
    $uuid = Str::uuid();
@endphp
<!--   Image Crop and Upload Modal -->
<div id="uploadimageModal_{{ $uuid }}" class="modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle_{{ $uuid }}">Upload & Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" name="image_{{ $uuid }}" id="image_{{ $uuid }}"
                       class="mx-auto d-none"
                       accept="image/*" max="1024">
                <form action="{{ $image_upload_url }}" class="d-none" method="POST"
                      name="image_upload_form_{{ $uuid }}" id="image_upload_form_{{ $uuid }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="image" value="" id="cropped_image_{{$uuid}}">
                    @isset($redirect_url)
                        <input type="hidden" name="redirect_url" value="{{ $redirect_url }}">
                    @endisset
                </form>
                <div class="row  ">
                    <div class="mx-auto d-block text-center">
                        <div id="image_demo_{{ $uuid }}" style="width:350px; margin-top:30px"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-theme" id="crop_image_{{ $uuid }}">Crop & Upload Image</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <!--Image crop and upload modal end -->
    <script >
        $(document).ready(function(){
            @error('image')
                bootbox.alert({
                    title: '<h5 class="font-weight-bold">Error On Uploading Cropped Image </h5>',
                    message: '<label class="text-danger">{{ $message }}</label>',
                    backdrop: true,
                });
            @enderror
            if('{{ $upload_btn_jquery ?? '' }}'!=''){
                $('{{ $upload_btn_jquery ?? '' }}').on('click',function(){
                    $("#image_{{ $uuid }}").click()
                });
            }
            var image_crop = $('#image_demo_{{ $uuid }}').croppie({
                enableExif: true,
                enableOrientation: true,
                viewport: {
                    width:{{ $viewport_width ?? 250 }},
                    height:{{ $viewport_height?? 250 }},
                    type:'square' //circle
                },
                boundary:{
                    width:{{ $boundary_width ?? 300 }},
                    height:{{ $boundary_height ?? 300 }}
                },
            });

            $('#uploadimageModal_{{ $uuid }}').on('shown.bs.modal',function(){
                $('#image_{{ $uuid }}').val('');
            });

            $('#image_{{ $uuid }}').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                    image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function(){
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal_{{ $uuid }}').modal('show');
            });



            $('#crop_image_{{ $uuid }}').click(function(event){
                image_crop.croppie('result', {
                    type: 'base64',
                    //for the original image size
                    size: 'original',
                    format: "jpeg",
                    //keep the hundred percent quality
                    quality: 1
                }).then(function(response){
                    $('#cropped_image_{{ $uuid }}').val(response);
                    $('#image_upload_form_{{ $uuid }}').submit();
                    $('#uploadimageModal_{{ $uuid }}').modal('hide');
                    $("#logo").attr('src',response);
                    $("#image_{{ $uuid }}").val('');
                })
            });

        });
    </script>
@endpush


