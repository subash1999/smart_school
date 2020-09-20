<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StorageController;
use App\School as School;
use App\SchoolAdmin;
use File;
use Illuminate\Http\Request;
//use Intervention\Image\Facades\Image;
use Image;
use Response;
use Str;
use Storage;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::all();
        return view("super-admin.schools",['schools'=>$schools]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("super-admin.create-school");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'address' => 'required|min:2|max:255',
            'district' => 'nullable|min:2|max:255',
            'country' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'email1' => 'nullable|email',
            'email2' => 'nullable|email',
            'description' => 'nullable',
        ]);
        $school = new School;
        $school->name = $request->name;
        $school->address = $request->address;
        $school->district = $request->district;
        $school->country = $request->country;
        $school->country = $request->country;
        $school->phone1 = $request->phone1;
        $school->phone2 = $request->phone2;
        $school->email1 = $request->email1;
        $school->email2 = $request->email2;
        $school->description = $request->description;
        $school->save();

        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-success\">School Created/Added/Registered Successfully</h5>" =>
                    "<span class=\"text-capitalize\">ID: $school->id <br> School Name :  $school->name <br></span>"
            ],
        ]);

        return redirect(route('super-admin-show-school',['id'=>$school->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vars = [
            'school' => School::findOrFail($id)
        ];
        return view('super-admin.show-school',$vars);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('super-admin.edit-school',['school' => $school]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTextData(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'address' => 'required|min:2|max:255',
            'district' => 'nullable|min:2|max:255',
            'country' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'email1' => 'nullable|email',
            'email2' => 'nullable|email',
            'description' => 'nullable',
        ]);
        $school = School::find($id);
        $school->name = $request->name;
        $school->address = $request->address;
        $school->district = $request->district;
        $school->country = $request->country;
        $school->country = $request->country;
        $school->phone1 = $request->phone1;
        $school->phone2 = $request->phone2;
        $school->email1 = $request->email1;
        $school->email2 = $request->email2;
        $school->description = $request->description;
        $school->save();

        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-success\">School Updated Successfully</h5>" =>
                    "<span class=\"text-capitalize\">ID: $school->id <br> School Name :  $school->name <br></span>"
            ],
        ]);

        if(isset($request->redirect_url)){
            return redirect($request->redirect_url);
        }
        return redirect(route('super-admin-show-school',['id'=>$school->id]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function updateSchoolLogo(Request $request, $id)
    {
        $base64Image = $request->image;
//        change the base64 data image to uploadedFile object using helper function
        $image = (new StorageController())->base64ToUploadedFile($base64Image);
//        remove the existing image
        $request->request->remove('image');
//        add new image to the request object
        $request->request->add(['image' => $image]);
//        validate the form
        $request->validate([
            'image'=>'image|max:'.config('custom-settings.max-image-size'),
            'redirect_url'=>'nullable',
        ]);
//        school model
        $school = School::findOrFail($id);
//        getting the old file name to delete
        $old_school_logo = $school->logo;
//        store the new base64 Logo
        $filename = (new StorageController())->uploadBase64LogoImage($base64Image);
//        change the logo file name
        $school->logo = $filename;
//        save the school object
        $school->save();
//        after saving the new filename, delete the old logo image to save up space
        (new StorageController())->deleteLogoImage($old_school_logo);
//        session message to show the successful change of logo
        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-success\">School Logo Changed Successfully</h5>" =>
                    "<span class=\"text-capitalize\">ID: $id <br> School Name :  $school->name <br></span>"
            ],
        ]);
//        if the redirect url is mentioned in the request then redirect it to the given url
        if ($request->has('redirect_url')){
            return redirect($request->post('redirect_url'));
        }
//        if redirect url not given redirect it back
        return redirect()->back();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $school = School::findOrFail($id);
        $school_name = $school->name;
        (new StorageController())->deleteLogoImage($school->logo);
        School::findOrFail($id)->delete();
//        return redirect(route('super-admin-school'));
        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-danger\">School Deleted Successfully</h5>" =>
                "<span class=\"text-capitalize\">ID: $id <br> School Name :  $school_name <br></span>"
            ],
        ]);
        if ($request->has('redirect_url')){
            return redirect($request->post('redirect_url'));
        }
        return redirect(route('super-admin-school'));
    }

}
