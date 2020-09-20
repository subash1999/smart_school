<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function index(){
        $super_admin = \App\SuperAdmin::findOrFail(auth()->user()->SuperAdmin->id);
        $user_count = \App\User::count();
        $school_count = \App\School::count();
        $school_admin_count = \App\SchoolAdmin::count();
        return view("super-admin.super-admin-dashboard")->with([
            'super_admin' => $super_admin,
            'user_count' => $user_count,
            'school_count' => $school_count,
            'school_admin_count' => $school_admin_count,
        ]);
    }
}
