<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StorageController;
use App\Rules\GenderValidation;
use App\School as School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('super-admin.school-admins',['school_admins'=>\App\SchoolAdmin::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super-admin.create-school-admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        validate the all fields
//        here we validate user and school foreign key so that given user or school exists
        $request->validate([
            'name' => 'required|min:2|max:255',
            'gender'=>['required',new GenderValidation()],
            'address' => 'required|min:2|max:255',
            'district' => 'nullable|min:2|max:255',
            'country' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'user' => 'required|exists:users,id',
            'school' => 'required|exists:schools,id',
            'description' => 'nullable',
        ]);

//        validate the combine uniqueness of user and school.
//        This validation validates the uniqueness of [user,school]
//        after it is validated that user and school exists in above validation
        $request->validate([
            'user' => 'unique:App\SchoolAdmin,user_id,NULL,id,school_id,'.$request->school,
            'school' => 'unique:App\SchoolAdmin,school_id,NULL,id,user_id,'.$request->user,
        ],
        [
            'user.unique' => 'The :attribute is already School Admin for School: '.\App\School::find($request->school)->name.".",
            'school.unique' => 'The :attribute already has a School Admin for User: '.\App\User::find($request->user)->email.".",
        ]);

        $school_admin = new \App\SchoolAdmin;
        $school_admin->name = $request->name;
        $school_admin->gender = $request->gender;
        $school_admin->address = $request->address;
        $school_admin->district = $request->district;
        $school_admin->country = $request->country;
        $school_admin->country = $request->country;
        $school_admin->phone1 = $request->phone1;
        $school_admin->phone2 = $request->phone2;
        $school_admin->description = $request->description;
        $school_admin->user_id = $request->user;
        $school_admin->school_id = $request->school;
        $school_admin->save();

        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-success\">School Admin Created/Added/Registered Successfully</h5>" =>
                    "<span class=\"text-capitalize\">ID: $school_admin->id <br> School Admin Name :  $school_admin->name <br></span>"
            ],
        ]);

        return redirect(route('super-admin-show-school-admin',['id'=>$school_admin->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('super-admin.show-school-admin',[
            'school_admin' => \App\SchoolAdmin::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('super-admin.edit-school-admin',['school_admin'=>\App\SchoolAdmin::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassportPhoto(Request $request, $id)
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
        $school_admin = \App\SchoolAdmin::findOrFail($id);
//        getting the old file name to delete
        $old_pp = $school_admin->passport_photo;
//        store the new base64 Logo
        $filename = (new StorageController())->uploadBase64PassportPhotoImage($base64Image);
//        change the logo file name
        $school_admin->passport_photo = $filename;
//        save the school object
        $school_admin->save();
//        after saving the new filename, delete the old logo image to save up space
        (new StorageController())->deletePassportPhotoImage($old_pp);
//        session message to show the successful change of logo
        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-success\">School Admin Passport Photo Changed Successfully</h5>" =>
                    "<span class=\"text-capitalize\">ID: $id <br> School Admin Name :  $school_admin->name <br></span>"
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateTextData(Request $request, $id)
    {
//        validate the all fields
//        here we validate user and school foreign key so that given user or school exists
        $request->validate([
            'name' => 'required|min:2|max:255',
            'gender'=>['required', new GenderValidation()],
            'address' => 'required|min:2|max:255',
            'district' => 'nullable|min:2|max:255',
            'country' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'user' => 'required|exists:users,id',
            'school' => 'required|exists:schools,id',
            'description' => 'nullable',
        ]);

//        validate the combine uniqueness of user and school.
//        This validation validates the uniqueness of [user,school]
//        after it is validated that user and school exists in above validation
        $request->validate([
            'user' => 'unique:App\SchoolAdmin,user_id,'.$id.',id,school_id,'.$request->school,
            'school' => 'unique:App\SchoolAdmin,school_id,'.$id.',id,user_id,'.$request->user,
        ],
        [
            'user.unique' => 'The :attribute is already School Admin for School: '.\App\School::find($request->school)->name.".",
            'school.unique' => 'The :attribute already has a School Admin for User: '.\App\User::find($request->user)->email.".",
        ]);

        $school_admin = \App\SchoolAdmin::find($id);
        $school_admin->name = $request->name;
        $school_admin->gender = $request->gender;
        $school_admin->address = $request->address;
        $school_admin->district = $request->district;
        $school_admin->country = $request->country;
        $school_admin->country = $request->country;
        $school_admin->phone1 = $request->phone1;
        $school_admin->phone2 = $request->phone2;
        $school_admin->description = $request->description;
        $school_admin->user_id = $request->user;
        $school_admin->school_id = $request->school;
        $school_admin->save();

        session([
        config('custom-settings.alert-messages') => [
            "<h5 class=\"text-success\">School Admin Updated Successfully</h5>" =>
                "<span class=\"text-capitalize\">ID: $school_admin->id <br> School Name :  $school_admin->name <br>
                School : $school_admin->School->name<br> User: $school_admin->User->email </span>"
            ],
        ]);

        if(isset($request->redirect_url)){
            return redirect($request->redirect_url);
        }
        return redirect(route('super-admin-show-school-admin',['id'=>$school_admin->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request,$id)
    {
        $school_admin = \App\SchoolAdmin::findOrFail($id);
        $school_admin_name = $school_admin->name;
        $email = $school_admin->user->email;
//        delete the image
        (new StorageController())->deletePassportPhotoImage($school_admin->passport_photo);
        $school_admin->delete();
        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-danger\">School Admin Deleted Successfully</h5>" =>
                    "<span class=\"text-capitalize\">ID: $id <br> School Admin Name :  $school_admin_name <br> Email :  $email </span>"
            ],
        ]);
        if(isset($request->redirect_url)){
            return redirect($request->redirect_url);
        }
        return redirect(route('super-admin-school-admin'));
    }
}
