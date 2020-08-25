<?php
use Illuminate\Support\Str;

function getShortFormOfSentence($sentence){
    $words = preg_split("/[\s,_-]+/", $sentence);
    $acronym = "";
    foreach ($words as $w) {
        $acronym .= $w[0];
    }
    return $acronym;
}

// Function for basic field validation (present and neither empty nor only white space
function isNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '');
}

/**
 * This function only joins the not null or not empty members of array
 * example: joinNotEmptyArrayElements(',',['a',' ',null,'d']) it will return "a,d"
 * @param $join_by // join the string by this i.e ','(comma), ' '(space), etc.
 * @param $arr // array to join
 * @return string
 */
function joinNotEmptyArrayElements($join_by,$arr){
    $new_arr = array();
    foreach ($arr as $a){
        if(!isNullOrEmptyString($a)){
            array_push($new_arr,$a);
        }
    }
    return join($join_by,$new_arr);
}

function passwordConfirmationBoxScript($submit_btn_jquery_string,$form_jquery_string,$confirmation_msg,$title='') {
    $password_confirmation_route = route('password.confirm');
    $a = <<<EOT
        <script defer>
        $(function(){
            $('$submit_btn_jquery_string').on('click', function (e) {
                e.preventDefault();
                bootbox.prompt({
                    title : '$title',
                    inputType: 'password',
                    message: '$confirmation_msg',
                    required: true,
                    callback: function (result) {
                        if (result) {
                            $.ajax({
                                url: '${password_confirmation_route}',
                                type:'POST',
                                data: {password: result},
                                success: function(data) {
                                    if(data.success){
                                        $('$form_jquery_string').submit();
                                    }else{
                                         bootbox.alert({
                                            title:'Password Confirmation Error',
                                            message: data.error,
                                         });
                                    }
                                },
                                error: function(error){
                                    var errors = Object.entries(error.responseJSON.errors);
                                    var error_msg = "";
                                    errors.forEach(function(error_group, index_of_error_group){
                                        error_msg += "<span class=\"font-weight-bolder text-uppercase\">" + error_group[0] + "</span>";
                                        error_group[1].forEach(function(error_of_input,input_name){
                                                error_msg += "<li class=\"ml-4\" >" + error_of_input+ "</li><br>";                                        });
                                    });
                                    bootbox.alert({
                                        title:'<span class="text-danger">Password Confirmation Error</span>',
                                        message: error_msg,
                                    });
                                }
                            });
                        }
                    }
                });
            });
        });
        </script>
        EOT;
    return($a);
}

function croppieFileUpload($photo_upload_url,
                           $upload_btn_jquery=NULL,
                           $viewport_width=200,$viewport_height=200,
                           $boundary_width=265,$boundary_height=265){

    $uuid = Str::uuid();

    $croppie_html = <<<EOT
    <!--   Image Crop and Upload Modal -->
    <div id="uploadimageModal_$uuid" class="modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle_$uuid">Upload & Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" name="photo_$uuid" id="photo_$uuid"
                           class="mx-auto d-none"
                           accept="image/*">
                    <div class="row  ">
                        <div class="mx-auto d-block text-center">
                            <div id="image_demo_$uuid" style="width:350px; margin-top:30px"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-theme crop_image_$uuid">Crop & Upload Image</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    EOT;
    $croppie_js = <<<EOT
    <!--Image crop and upload modal end -->
    <script >
        $(document).ready(function(){
            if('{$upload_btn_jquery}'!=''){
                $('{$upload_btn_jquery}').on('click',function(){
                    $("#photo_{$uuid}").click()
                });
            }
            var image_crop = $('#image_demo_{$uuid}').croppie({
                enableExif: true,
                enableOrientation: true,
                viewport: {
                    width:{$viewport_width},
                    height:{$viewport_height},
                    type:'square' //circle
                },
                boundary:{
                    width:{$boundary_width},
                    height:{$boundary_height}
                },
            });

            $('#photo_{$uuid}').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                    image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function(){
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal_{$uuid}').modal('show');
            });

            $('.crop_image_{$uuid}').click(function(event){
                image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response){
                    // console.log(response);
                    $("#logo").attr('src',response);
                    $("#photo_{$uuid}").val(null);
                    $('#uploadimageModal_{$uuid}').modal('hide');
                    $.ajax({
                        url:"{$photo_upload_url}",
                        type: "POST",
                        data:{"image": response},
                        success:function(data)
                        {
                            $('#uploadimageModal').modal('hide');
                            $('#uploaded_image').html(data);
                        }
                    });
                })
            });

        });
    </script>
    EOT;
    return ['html'=>$croppie_html,'js'=>$croppie_js];

}


