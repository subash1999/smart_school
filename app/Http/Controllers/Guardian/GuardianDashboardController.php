<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuardianDashboardController extends Controller
{
    public function index(){
        return view("guardian.guardian-dashboard");
    }
}
