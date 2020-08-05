<?php

use App\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});
Auth::routes();
Route::get('/available-dashboard', "AvailableDashboardController@index")->name('available-dashboard');
Route::post('/go-to-dashboard',"AvailableDashboardController@goToDashboard")->name("go-to-dashboard");


Route::group(['prefix'=>'super-admin',"namespace"=>'SuperAdmin', 'middleware'=>'super-admin'],function(){
    Route::get('','SuperAdminDashboardController@index')->name("super-admin-dashboard");
    Route::get('/school','SchoolController@index')->name("super-admin-school");
    Route::get('/school/create','SchoolController@create')->name("super-admin-add-school");
    Route::post('/school','SchoolController@store')->name("super-admin-store-school");
});
Route::group(['prefix'=>'school-admin',"namespace"=>'SchoolAdmin', 'middleware'=>'school-admin'],function(){
    Route::get('','SchoolAdminDashboardController@index')->name("school-admin-dashboard");
});
Route::group(['prefix'=>'teacher',"namespace"=>'Teacher', 'middleware'=>'teacher'],function(){
    Route::get('','TeacherDashboardController@index')->name("teacher-dashboard");
});
Route::group(['prefix'=>'guardian',"namespace"=>'Guardian', 'middleware'=>'guardian'],function(){
    Route::get('','GuardianDashboardController@index')->name("guardian-dashboard");
});



//dd(App\User::find(1)->getAvailableRoles());
//Route::get('/home', 'HomeController@index')->name('home');
