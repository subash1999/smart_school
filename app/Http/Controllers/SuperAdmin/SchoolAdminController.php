<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|min:2|max:255',
            'address' => 'required|min:2|max:255',
            'district' => 'nullable|min:2|max:255',
            'country' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',

            'description' => 'nullable',
        ]);
        $school_admin = new \App\SchoolAdmin;
        $school_admin->name = $request->name;
        $school_admin->address = $request->address;
        $school_admin->district = $request->district;
        $school_admin->country = $request->country;
        $school_admin->country = $request->country;
        $school_admin->phone1 = $request->phone1;
        $school_admin->phone2 = $request->phone2;
        $school_admin->email1 = $request->email1;
        $school_admin->email2 = $request->email2;
        $school_admin->description = $request->description;
        $school_admin->save();

        session([
            config('custom-settings.alert-messages') => [
                "<h5 class=\"text-success\">School Admin Created/Added/Registered Successfully</h5>" =>
                    "<span class=\"text-capitalize\">ID: $school_admin->id <br> School Admin Name :  $school_admin->name <br></span>"
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
