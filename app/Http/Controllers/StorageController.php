<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Storage;
use Str;

class StorageController extends Controller
{
    /**
     * @param String $base64Image
     * @param String $path
     * @return string
     */
    public function uploadBase64Image(String $base64Image,String $path=""){
        $image = base64ToImage($base64Image);
        $filename = Str::random(10)."--".time()."--".session_id()."--".Str::uuid();
        $filename .= ".".base64ImageExtension($base64Image);
        Storage::put($path.$filename, $image);
        return $filename;
    }

    /**
     * @param String $base64Image
     * @return mixed
     */
    public function uploadBase64AvatarImage(String $base64Image){
        return $this->uploadBase64Image($base64Image,config('custom-settings.avatar-directory'));
    }

    /**
     * @param String $base64Image
     * @return mixed
     */
    public function uploadBase64PassportPhotoImage(String $base64Image){
        return $this->uploadBase64Image($base64Image,config('custom-settings.passport-photo-directory'));
    }

    /**
     * @param String $base64Image
     * @return mixed
     */
    public function uploadBase64LogoImage(String $base64Image){
        return $this->uploadBase64Image($base64Image,config('custom-settings.logo-directory'));
    }

    /**
     * @param $filename
     * @param string $path
     * @return bool
     */
    public function deleteFileFromStorage($filename,String $path=""){
        return Storage::delete($path.$filename);
    }

    /**
     * @param String $filename
     * @return bool
     */
    public function deleteAvatarImage(String $filename){
        return $this->deleteFileFromStorage($filename,config('custom-settings.avatar-directory'));
    }

    /**
     * @param String $filename
     * @return bool
     */
    public function deletePassportPhotoImage(String $filename){
        return $this->deleteFileFromStorage($filename,config('custom-settings.passport-photo-directory'));
    }

    /**
     * @param $filename
     * @return bool
     */
    public function deleteLogoImage($filename){
        return $this->deleteFileFromStorage($filename,config('custom-settings.logo-directory'));
    }

    /**
     * @param String $filename
     * @param string $path
     * @return string
     */
    public function getFileFromStorage(String $filename,String $path=""){
        return Storage::path($path.$filename);
    }

    /**
     * @param Request $request
     * @param String $filename
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getAvatarImage(Request $request){
        $filename = $request->filename;
        if (filter_var(urldecode($filename), FILTER_VALIDATE_URL)) {
            $filename = urldecode($filename);
            return redirect($filename);
        }
        $path = $this->getFileFromStorage($filename,config('custom-settings.avatar-directory'));
        return response()->file($path);
    }

    /**
     * @param Request $request
     * @param String $filename
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getPassportPhotoImage(Request $request){
        $filename = $request->filename;
        if (filter_var(urldecode($filename), FILTER_VALIDATE_URL)) {
            $filename = urldecode($filename);
            return redirect($filename);
        }
        if($this->checkPassportPhotoPermission($filename)){
            $path = $this->getFileFromStorage($filename,config('custom-settings.passport-photo-directory'));
            return response()->file($path);
        }
        else{
            abort(403,"You are not Authorized to Access File : $filename");
        }

    }

    /**
     * @param Request $request
     * @param String $filename
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getLogoImage(Request $request){
        $filename = $request->filename;
        if (filter_var(urldecode($filename), FILTER_VALIDATE_URL)) {
            $filename = urldecode($filename);
            return redirect($filename);
        }
        $path =  $this->getFileFromStorage($filename,config('custom-settings.logo-directory'));
        return response()->file($path);
    }

    /**
     * @param String $base64Image
     * @return \Illuminate\Http\UploadedFile
     */
    public function base64ToUploadedFile(String $base64Image){
        $image = base64ToImage($base64Image);
        $tmp_image_file = imageStringToTempFile($image,base64ImageExtension($base64Image));
        $image_uploaded_file = fileToUploadedFile($tmp_image_file);;
        return $image_uploaded_file;
    }

    /**
     * @param String $filename
     * @return bool
     */
    private function checkPassportPhotoPermission(String $filename){
        $current_role = session('current_role',null);
        $current_school_id = session('currrent_school_id',null);
        $user_id = auth()->id();
        if(strcasecmp("Super Admin",$current_role) == 0 &&
            $current_school_id==null){
            $super_admin =  \App\SuperAdmin::where('passport_photo',$filename)->count()>0;
            if($super_admin){
                return $super_admin;
            }
            $school_admin = \App\SchoolAdmin::where('passport_photo',$filename)->count()>0;
            return $super_admin || $school_admin;
        }
        else if(strcasecmp("School Admin",$current_role) == 0 &&
            $current_school_id!=null) {
            $school_admin_pp = \App\SchoolAdmin::where('user_id',$user_id)
                    ->where('passport_photo',$filename)->count()>0;
            if($school_admin_pp){
                return $school_admin_pp;
            }
            $student_pp = \App\Student::where('school_id',$current_school_id)
                    ->where('passport_photo',$filename)->count()>0;
            if($school_admin_pp || $student_pp){
                return $school_admin_pp || $student_pp;
            }
            $guardian_pp = \App\Guardian::where('school_id',$current_school_id)
                    ->where('passport_photo',$filename)->count()>0;
            if($school_admin_pp || $student_pp || $guardian_pp){
                return $school_admin_pp || $student_pp || $guardian_pp;
            }
            $teacher_pp = \App\Teacher::where('school_id',$current_school_id)
                    ->where('passport_photo',$filename)->count()>0;
            return $school_admin_pp || $student_pp || $guardian_pp || $teacher_pp;
        }
        else if(strcasecmp("Guardian",$current_role) == 0 &&
            $current_school_id!=null) {
            $student_pp = \App\Guardian::where('school_id',$current_school_id)
                    ->where('user_id',$user_id)
                    ->whereHas('students', function($q) use($filename){

                        $q->where('passport_photo', '=', $filename);

                    })
                    ->count()>0;
            if($student_pp){
                return $student_pp;
            }
            $guardian_pp = \App\Guardian::where('school_id',$current_school_id)
                    ->where('user_id',$user_id)
                    ->where('passport_photo',$filename)->count()>0;
            if($student_pp || $guardian_pp){
                return $student_pp || $guardian_pp;
            }
            $teacher_pp = \App\Teacher::where('school_id',$current_school_id)
                    ->where('filename',$filename)->count()>0;
            return $student_pp || $guardian_pp || $teacher_pp;
        }
        else if(strcasecmp("Teacher",$current_role) == 0 &&
            $current_school_id!=null) {
            $student_pp = \App\Student::where('school_id',$current_school_id)
                    ->where('passport_photo',$filename)
                    ->count()>0;
            if($student_pp){
                return $student_pp;
            }
            $teacher_pp = \App\Teacher::where('school_id',$current_school_id)->count()>0;
            if($student_pp || $teacher_pp){
                return $student_pp || $teacher_pp;
            }
            $guardian_pp = \App\Guardian::where('school_id',$current_school_id)->count()>0;
            return $student_pp || $teacher_pp || $guardian_pp;
        }
        else{
            return false;
        }
    }
}
