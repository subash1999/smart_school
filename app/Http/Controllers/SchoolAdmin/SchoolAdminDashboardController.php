<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolAdminDashboardController extends Controller
{
    public function index(){
        return view("school-admin.school-admin-dashboard");
    }
}
