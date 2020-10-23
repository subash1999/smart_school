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
    Route::get('/passport-photo', 'StorageController@getPassportPhotoImage')->name('passport-photo-image')->middleware('auth', \App\Http\Middleware\PassportPhotoPermission::Class);
    Route::get('/logo/', 'StorageController@getLogoImage')->name('logo-image');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/edit-user-info', 'Auth\UserController@edit')->name('edit-user-info');
    Route::put('/update-password', 'Auth\UserController@updatePassword')->name('update-password');
    Route::put('/update-email', 'Auth\UserController@updateEmail')->name('update-email');
    Route::put('/update-avatar', 'Auth\UserController@updateAvatar')->name('update-avatar');
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

        Route::get('edit-profile', 'SuperAdminController@edit')->name('super-admin-edit-profile');
        Route::put('update-profile-passport-photo', 'SuperAdminController@updatePassportPhoto')->name('super-admin-update-profile-passport-photo');
        Route::put('edit-profile-text-data', 'SuperAdminController@updateTextData')->name('super-admin-update-profile-text-data');
        Route::get('change-super-admin-user', 'SuperAdminController@changeUser')->name('super-admin-change-super-admin-user');
        Route::put('change-super-admin-user', 'SuperAdminController@updateUser')->name('super-admin-update-super-admin-user');
    });
    Route::group(['prefix' => 'school-admin', "namespace" => 'SchoolAdmin', 'middleware' => 'school-admin'], function () {
        Route::get('', 'SchoolAdminDashboardController@index')->name("school-admin-dashboard");

        Route::group(['prefix' => 'school-admins'], function () {
            Route::get('/', 'SchoolAdminController@index')->name('school-admin-school-admins');
            Route::get('/{id}', 'SchoolAdminController@show')->name('school-admin-show-school-admin');
        });

        Route::group(['prefix' => 'teacher', 'middleware' => \App\Http\Middleware\SchoolAdminTeacher::Class], function () {
            Route::get('/', 'TeacherController@index')->name("school-admin-teachers");
            Route::get('/create', 'TeacherController@create')->name("school-admin-create-teacher");
            Route::post('/', 'TeacherController@store')->name("school-admin-store-teacher");
            Route::delete('/{id}', 'TeacherController@destroy')->name("school-admin-destroy-teacher");
            Route::get('/{id}', 'TeacherController@show')->name('school-admin-show-teacher');
            Route::get('/{id}/edit', 'TeacherController@edit')->name('school-admin-edit-teacher');
            Route::put('/{id}/update-teacher-passport-photo', 'TeacherController@updatePassportPhoto')->name('school-admin-update-teacher-passport-photo');
            Route::put('/{id}', 'TeacherController@updateTextData')->name('school-admin-update-teacher-text-data');
            Route::put('/remove_teacher_from_school/{id}', 'TeacherController@removeTeacherFromSchool')->name('school-admin-remove-teacher-from-school');
            Route::put('/reassign_teacher_to_school/{id}', 'TeacherController@reassignTeacherToSchool')->name('school-admin-reassign-teacher-to-school');
            Route::post('/add_subject_of_teacher/{teacher_id}', 'TeacherController@storeSubjectOfTeacher')->name('school-admin-store-subject-of-teacher');
            Route::delete('/delete_subject_of_teacher/{teacher_id}/{grade_subject_id}', 'TeacherController@destroySubjectOfTeacher')->name('school-admin-destroy-subject-of-teacher');
        });
        Route::group(['prefix' => 'guardian', 'middleware' => \App\Http\Middleware\SchoolAdminGuardian::Class], function () {
            Route::get('/', 'GuardianController@index')->name("school-admin-guardians");
            Route::get('/create', 'GuardianController@create')->name("school-admin-create-guardian");
            Route::post('/', 'GuardianController@store')->name("school-admin-store-guardian");
            Route::delete('/{id}', 'GuardianController@destroy')->name("school-admin-destroy-guardian");
            Route::get('/{id}', 'GuardianController@show')->name('school-admin-show-guardian');
            Route::get('/{id}/edit', 'GuardianController@edit')->name('school-admin-edit-guardian');
            Route::put('/{id}/update-guardian-passport-photo', 'GuardianController@updatePassportPhoto')->name('school-admin-update-guardian-passport-photo');
            Route::put('/{id}', 'GuardianController@updateTextData')->name('school-admin-update-guardian-text-data');
            Route::post('/add_student_of_guardian/{guardian_id}', 'GuardianController@storeStudentOfGuardian')->name('school-admin-store-student-of-guardian');
            Route::delete('/delete_student_of_guardian/{guardian_id}/{student_id}', 'GuardianController@destroyStudentOfGuardian')->name('school-admin-destroy-student-of-guardian');
        });
        Route::group(['prefix' => 'student', 'middleware' => \App\Http\Middleware\SchoolAdminStudent::Class], function () {
            Route::get('/', 'StudentController@index')->name("school-admin-students");
            Route::get('/create', 'StudentController@create')->name("school-admin-create-student");
            Route::post('/', 'StudentController@store')->name("school-admin-store-student");
            Route::delete('/{id}', 'StudentController@destroy')->name("school-admin-destroy-student");
            Route::get('/{id}', 'StudentController@show')->name('school-admin-show-student');
            Route::get('/{id}/edit', 'StudentController@edit')->name('school-admin-edit-student');
            Route::put('/{id}/update-student-passport-photo', 'StudentController@updatePassportPhoto')->name('school-admin-update-student-passport-photo');
            Route::put('/{id}', 'StudentController@updateTextData')->name('school-admin-update-student-text-data');
            Route::post('/add_guardian_of_student/{student_id}', 'StudentController@storeGuardianOfStudent')->name('school-admin-store-guardian-of-student');
            Route::delete('/delete_guardian_of_student/{student_id}/{guardian_id}', 'StudentController@destroyGuardianOfStudent')->name('school-admin-destroy-guardian-of-student');

            Route::put('/remove_student_from_school/{id}', 'StudentController@removeStudentFromSchool')->name('school-admin-remove-student-from-school');
            Route::put('/reassign_student_to_school/{id}', 'StudentController@reassignStudentToSchool')->name('school-admin-reassign-student-to-school');
        });

        Route::group(['prefix' => 'grade', 'middleware' => \App\Http\Middleware\SchoolAdminGrade::Class], function () {
            Route::get('/', 'GradeController@index')->name("school-admin-grades");
            Route::get('/create', 'GradeController@create')->name("school-admin-create-grade");
            Route::post('/', 'GradeController@store')->name("school-admin-store-grade");
            Route::delete('/{id}', 'GradeController@destroy')->name("school-admin-destroy-grade");
            Route::get('/{id}', 'GradeController@show')->name('school-admin-show-grade');
            Route::get('/{id}/edit', 'GradeController@edit')->name('school-admin-edit-grade');
            Route::put('/{id}', 'GradeController@update')->name('school-admin-update-grade');

        });

//        school admin api
        Route::group(['prefix' => 'api'], function () {
            Route::post('/subjects_of_grade', function (Request $request) {
                $request->validate([
                    'grade_id' => 'required|exists:\App\Grade,id',
                ]);
                return \App\Grade::findOrFail($request->grade_id)->Subjects;
            })->name('school-admin-api-subjects-of-grade');

            Route::post('/new_roll_no_of_grade', function (Request $request) {
                $request->validate([
                    'grade_id' => 'required|exists:\App\Grade,id',
                ]);
                $max_roll_no = \App\StudentGrade::where('grade_id', $request->grade_id)->max('roll_no');
                if (isset($max_roll_no)) {
                    ++$max_roll_no;
                } else {
                    $max_roll_no = 1;
                }
                return $max_roll_no;
            })->name('school-admin-api-new-roll-no-of-grade');

            Route::post('/check_if_roll_no_exists_in_grade', function (Request $request) {
                $request->validate([
                    'grade_id' => 'required|exists:\App\Grade,id',
                    'roll_no' => 'required',
                ]);
                return (\App\StudentGrade::where('grade_id', $request->grade_id)->where('roll_no', $request->roll_no)->count() > 0);
            })->name('school-admin-api-check-if-roll-no-exists-in-grade');

            Route::post('/check_if_grade_exists_in_session_when_updating', function (Request $request) {
                $rules = [
                   'school_session' => 'required|exists:school_sessions,id',
                   'grade' => 'required',
                   'section' => 'nullable',
                    'id' => 'required|exists:grades,id',
                ];
                $validator = Validator::make($request->all(), $rules);
                $error_msgs = $validator->getMessageBag()->toArray();
                $grade_exists = \App\Grade::where('grade_name',$request->grade)
                        ->where('section',$request->section)
                        ->where('school_session_id',$request->school_session)
                        ->where('id','!=',$request->id)->count()>0;
                if($grade_exists){
                    array_push($error_msgs,"Grade and Section already exists in selected School Session");
                }
                // Validate the input and return correct response
                if (count($error_msgs)>0)
                {
                    return Response::json(array(
                        'success' => false,
                        'errors' => $error_msgs,

                    ), 400); // 400 being the HTTP code for an invalid request.
                }

                return Response::json(array('success' => true), 200);


            })->name('school-admin-api-check-if-grade-exists-in-session-when-updating');
        });
    });
    Route::group(['prefix' => 'teacher', "namespace" => 'Teacher', 'middleware' => 'teacher'], function () {
        Route::get('', 'TeacherDashboardController@index')->name("teacher-dashboard");
    });
    Route::group(['prefix' => 'guardian', "namespace" => 'Guardian', 'middleware' => 'guardian'], function () {
        Route::get('', 'GuardianDashboardController@index')->name("guardian-dashboard");
    });

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/change-current-school-session-id', function (Request $request) {
        $request->validate([
            'school_session_id' => 'nullable|exists:school_sessions,id',
        ]);
        setCurrentSchoolSessionId($request->school_session_id);
//        return to back after setting current school session
        return redirect()->back();
    })->name('change-current-school-session-id');

});
Route::post('/password-verification', function (Request $request) {
    $check = Hash::check($request->post('password'), auth()->user()->password);
});
