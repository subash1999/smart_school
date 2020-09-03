<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailableDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("auth.available-dashboard");
    }

    public function goToDashboard(Request $request){
//        dd($request->post());
        $role = $request->post('role',null);
        $school_id = $request->post('school_id');
        $url = "#";
        if(strcasecmp($role,"Super Admin") == 0){
            session(["current_role" => "Super Admin"]);
            session(["current_school_id" => null]);
            $url = route("super-admin-dashboard");
        }
        else if(strcasecmp($role,"School Admin") == 0){
            session(["current_role" => "School Admin"]);
            session(["current_school_id" => $school_id]);
            $url= route("school-admin-dashboard",['school_id' => $school_id]);
        }
        else if(strcasecmp($role,"Teacher") == 0){
            session(["current_role" => "Teacher"]);
            session(["current_school_id" => $school_id]);
            $url= route("teacher-dashboard",['school_id' => $school_id]);
        }
        else if(strcasecmp($role,"Guardian") == 0){
            session(["current_role" => "Guardian"]);
            session(["current_school_id" => $school_id]);
            $url= route("guardian-dashboard",['school_id' => $school_id]);
        }
        else{
            abort(404,"Dashboard for give Role Not Found");
        }
        session(["current_dashboard_url" => $url]);
//        dd(session("current_dashboard_url"));
        return redirect($url);
    }


}
