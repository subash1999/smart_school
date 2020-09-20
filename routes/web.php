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
Route::get('/test', function () {
    return view('test');
});
Route::get('/home', function () {
    return view('home');
});
Auth::routes(['verify' => true]);
Route::get('/password-verification', function (Request $request) {
    return view("snippets.password-verification", ['url' => url('/password-verification')]);
});


Route::group(['prefix' => 'storage'], function () {
    Route::get('/avatar', 'StorageController@getAvatarImage')->name('avatar-image');
    Route::get('/passport_photo', 'StorageController@getPassportPhotoImage')->name('passport-photo-image')->middleware('auth');
    Route::get('/logo/', 'StorageController@getLogoImage')->name('logo-image');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/edit_user_info', 'Auth\UserController@edit')->name('edit-user-info');
    Route::put('/update_password', 'Auth\UserController@updatePassword')->name('update-password');
    Route::put('/update_email', 'Auth\UserController@updateEmail')->name('update-email');
});

Route::group(['middleware' => ['verified', 'auth']], function () {

    Route::get('/available-dashboard', "AvailableDashboardController@index")->name('available-dashboard');
    Route::post('/go-to-dashboard', "AvailableDashboardController@goToDashboard")->name("go-to-dashboard");

    Route::group(['prefix' => 'super-admin', "namespace" => 'SuperAdmin', 'middleware' => 'super-admin'], function () {
        Route::get('', 'SuperAdminDashboardController@index')->name("super-admin-dashboard");

        Route::group(['prefix' => 'school'], function () {
            Route::get('/', 'SchoolController@index')->name("super-admin-school");
            Route::get('/create', 'SchoolController@create')->name("super-admin-create-school");
            Route::post('/', 'SchoolController@store')->name("super-admin-store-school");
            Route::delete('/{id}', 'SchoolController@destroy')->name("super-admin-destroy-school");
            Route::get('/{id}', 'SchoolController@show')->name('super-admin-show-school');
            Route::get('/{id}/edit', 'SchoolController@edit')->name('super-admin-edit-school');
            Route::put('/{id}/update-school-logo', 'SchoolController@updateSchoolLogo')->name('super-admin-update-school-logo');
            Route::put('/{id}', 'SchoolController@updateTextData')->name('super-admin-update-school-text-data');
        });

        Route::group(['prefix' => 'school_admin'], function () {
            Route::get('/', 'SchoolAdminController@index')->name("super-admin-school-admin");
            Route::get('/create', 'SchoolAdminController@create')->name("super-admin-create-school-admin");
            Route::post('/', 'SchoolAdminController@store')->name("super-admin-store-school-admin");
            Route::delete('/{id}', 'SchoolAdminController@destroy')->name("super-admin-destroy-school-admin");
            Route::get('/{id}', 'SchoolAdminController@show')->name('super-admin-show-school-admin');
            Route::get('/{id}/edit', 'SchoolAdminController@edit')->name('super-admin-edit-school-admin');
            Route::put('/{id}/update-school-admin-passport-photo', 'SchoolAdminController@updatePassportPhoto')->name('super-admin-update-school-admin-passport-photo');
            Route::put('/{id}', 'SchoolAdminController@updateTextData')->name('super-admin-update-school-admin-text-data');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@index')->name("super-admin-user");
            Route::delete('/{id}', 'UserController@destroy')->name("super-admin-destroy-user");
            Route::get('/{id}', 'UserController@show')->name('super-admin-show-user');
        });

        Route::get('edit-profile','SuperAdminController@edit')->name('super-admin-edit-profile');
        Route::put('update-profile-passport-photo', 'SuperAdminController@updatePassportPhoto')->name('super-admin-update-profile-passport-photo');
        Route::put('edit-profile-text-data', 'SuperAdminController@updateTextData')->name('super-admin-update-profile-text-data');
        Route::get('change-super-admin-user','SuperAdminController@changeUser')->name('super-admin-change-super-admin-user');
        Route::put('change-super-admin-user','SuperAdminController@updateUser')->name('super-admin-update-super-admin-user');
    });
    Route::group(['prefix' => 'school-admin', "namespace" => 'SchoolAdmin', 'middleware' => 'school-admin'], function () {
        Route::get('', 'SchoolAdminDashboardController@index')->name("school-admin-dashboard");
    });
    Route::group(['prefix' => 'teacher', "namespace" => 'Teacher', 'middleware' => 'teacher'], function () {
        Route::get('', 'TeacherDashboardController@index')->name("teacher-dashboard");
    });
    Route::group(['prefix' => 'guardian', "namespace" => 'Guardian', 'middleware' => 'guardian'], function () {
        Route::get('', 'GuardianDashboardController@index')->name("guardian-dashboard");
    });

    Route::get('/home', 'HomeController@index')->name('home');

});
Route::post('/password-verification', function (Request $request) {
    $check = Hash::check($request->post('password'), auth()->user()->password);
});
