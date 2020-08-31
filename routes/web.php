<?php

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Auth::routes(['register' => false]);
Route::get('/available-dashboard', "AvailableDashboardController@index")->name('available-dashboard');
Route::post('/go-to-dashboard',"AvailableDashboardController@goToDashboard")->name("go-to-dashboard");
Route::get('/password-verification',function(Request $request){
    return view("snippets.password-verification",['url'=> url('/password-verification')]);
});
Route::get('image',function(){
    //        return $this->avatar;
    $path = Storage::path("onezgrmazT--1598541462----7eadf745-1f4a-410e-9824-add95d56405c.png");
//    return Storage::disk('local')->download(, Auth::user()->avatar);
    return response()->file($path);
});

Route::group(['prefix'=>'storage','middleware'=>'auth'],function(){
    Route::get('/avatar','StorageController@getAvatarImage')->name('avatar-image');
    Route::get('/passport_photo','StorageController@getPassportPhotoImage')->name('passport-photo-image');
    Route::get('/logo/','StorageController@getLogoImage')->name('logo-image');
//    Route::put('/avatar','StorageController@getAvatarImage')->name('upload-avatar-image');
//    Route::put('/passport_photo','StorageController@getPassportPhotoImage')->name('upload-passport-photo-image');
//    Route::put('/logo','StorageController@getLogoImage')->name('upload-logo-image');
});

Route::get('image2/{filename}','StorageController@getLogoImage');
Auth::loginUsingId(0);
//dd(Auth::user()->getAvatarImage());
//dd(Storage::path("onezgrmazT--1598541462----7eadf745-1f4a-410e-9824-add95d56405c.png"));
Route::post('/password-verification',function(Request $request){
    $check = Hash::check($request->post('password'), auth()->user()->password);
});

Route::group(['prefix'=>'super-admin',"namespace"=>'SuperAdmin', 'middleware'=>'super-admin'],function(){
    Route::get('','SuperAdminDashboardController@index')->name("super-admin-dashboard");
    Route::group(['middleware' => 'password.confirm'],function(){
        Route::get('/school','SchoolController@index')->name("super-admin-school");
        Route::get('/school/create','SchoolController@create')->name("super-admin-create-school");
        Route::post('/school','SchoolController@store')->name("super-admin-store-school");
        Route::delete('/school/{id}','SchoolController@destroy')->name("super-admin-destroy-school");
        Route::get('/school/{id}','SchoolController@show')->name('super-admin-show-school');
        Route::get('/school/{id}/edit','SchoolController@edit')->name('super-admin-edit-school');
        Route::put('/school/{id}/update-school-logo','SchoolController@updateSchoolLogo')->name('super-admin-update-school-logo');
    });

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
