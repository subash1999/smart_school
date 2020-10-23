<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @param $filename
 * @return string
 */
function getAvatarImageUrl($filename){
    $filename = urlencode($filename);
    return route('avatar-image')."?filename=$filename";
}

/**
 * @param $filename
 * @return string
 */
function getPassportPhotoImageUrl($filename){
    $filename = urlencode($filename);
    return route('passport-photo-image')."?filename=$filename";
}

/**
 * @param $filename
 * @return string
 */
function getLogoImageUrl($filename){
    $filename = urlencode($filename);
    return route('logo-image')."?filename=$filename";
}

/**
 * @param $sentence
 * @return string
 * if "United States" is given it will return "US"
 */
function getShortFormOfSentence($sentence){
    $words = preg_split("/[\s,_-]+/", $sentence);
    $acronym = "";
    foreach ($words as $w) {
        $acronym .= $w[0];
    }
    return $acronym;
}

/**
 * @param $str
 * @return bool
 * Function for basic field validation (present and neither empty nor only white space
 */
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

function countryToCountryCode($country_name){
    $country_array = config('utilities.countries');
    $country_code = array_search ($country_name, $country_array);
    return $country_code;
}

/**
 * @param $submit_btn_jquery_string
 * @param $form_jquery_string
 * @param $confirmation_msg
 * @param string $title
 * @return string
 */
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

/**
 * @param String $image_64
 * @return bool|string
 */
function base64ToImage(String $image_64){
    $replace = substr($image_64, 0, strpos($image_64, ',')+1);
//      find substring fro replace here eg: data:image/png;base64,
    $image = str_replace($replace, '', $image_64);
    $image = str_replace(' ', '+', $image);
    return base64_decode($image);
}

/**
 * @param String $image_64
 * @return mixed
 */
function base64ImageExtension(String $image_64){
    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
    return $extension;
}

/**
 * @param String $string
 * @return File
 */
function stringToTempFile(String $string,String $extension=Null){
    // save it to temporary dir first.
    $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
    if(isset($extension)){
        $tmpFilePath .= ".".$extension;
    }
    file_put_contents($tmpFilePath, $string);

    // this just to help us get file info.
    return new File($tmpFilePath);
}

/**
 * @param String $image
 * @return File
 */
function imageStringToTempFile(String $image,String $extension=Null){
    return stringToTempFile($image,$extension);
}

/**
 * @param File $file
 * @return UploadedFile
 */
function fileToUploadedFile(File $file){
    $file = new UploadedFile(
        $file->getPathname(),
        $file->getFilename(),
        $file->getMimeType(),
        0,
        true // Mark it as test, since the file isn't from real HTTP POST.
    );
    return $file;
}

/**
 * @param String $base64Image
 * @return UploadedFile
 */
function base64ToUploadedFile(String $base64Image){
    $image = base64ToImage($base64Image);
    $tmp_image_file = imageStringToTempFile($image,base64ImageExtension($base64Image));
    $image_uploaded_file = fileToUploadedFile($tmp_image_file);;
    return $image_uploaded_file;
}

function getCurrentUserRole(){
    return session('current_role');
}

function getCurrentSchoolId(){
    return session('current_school_id');
}

function getCurrentDashboardUrl(){
    return session('current_dashboard_url');
}

function getCurrentSchoolSession(){
    $school_session_id = getCurrentSchoolSessionId();
    $school_session = null;
    if(isset($school_session_id)){
        try{
            $school_session = \App\SchoolSession::findOrFail($school_session_id);
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e){
            $school_session = null;
        }
    }
    return $school_session;
}

function getCurrentSchoolSessionName(){
    $school_session = getCurrentSchoolSession();
    if(isset($school_session)){
        return $school_session->name;
    }
//    return null if school session is not set
    return null;
}

function getCurrentSchoolSessionId(){
    $school_session_id = session('current_school_session_id');
    if(isset($school_session_id)) {
        try {
            //    if school session id is set check if it exists in database
            $school_session = \App\SchoolSession::findOrFail($school_session_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {
//            if school session id does not exists then set it to null
            $school_session_id = null;
        }
    }
    else{
//        if variable value is not set then make it null
        $school_session_id = null;
    }
    return $school_session_id;
}

function setCurrentSchoolSessionId($school_session_id){
    if(isset($school_session_id)) {
        try {
            //    if school session id is set check if it exists in database
            $school_session = \App\SchoolSession::findOrFail($school_session_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {
//            if school session id does not exists then set it to null
            $school_session_id = null;
        }
    }
    else{
//        if variable value is not set then make it null
        $school_session_id = null;
    }

    session([
        'current_school_session_id' => $school_session_id
    ]);
    return True;
}
