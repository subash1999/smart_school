<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SchoolAdminDashboardController extends Controller
{
    public function index(){
        $school_id = getCurrentSchoolId();
        $school_admin = \App\SchoolAdmin::where('school_id',$school_id)
            ->where('user_id',auth()->user()->id)
            ->first();
        $school = \App\School::find($school_id);
        $guardian_count = \App\Guardian::where('school_id',$school_id)->count();
        $student_count = \App\Student::where('school_id',$school_id)->count();
        $teacher_count = \App\Teacher::where('school_id',$school_id)->count();
        $school_admin_count = \App\SchoolAdmin::where('school_id',$school_id)->count();

//        school_session_dependent data
        $school_session_id = getCurrentSchoolSessionId();
        if(isset($school_session_id)){
            try{
                $school_session = \App\SchoolSession::findOrFail($school_session_id);
            }
            catch (ModelNotFoundException $e){

            }
        }
        if(isset($school_session)){
            $grade_count = $school_session->Grades->count();
            $subject_count = $school_session->Subjects->count();
            $exam_group_count = $school_session->ExamGroups->count();
            $exam_count = $school_session->exams()->count();
            $student_count = $school_session->students()->count();
        }
        else{
            $grade_count = \App\School::find($school_id)->grades()->count();
            $subject_count = \App\School::find($school_id)->subjects()->count();
            $exam_group_count = \App\School::find($school_id)->examGroups()->count();
            $exam_count = \App\School::find($school_id)->exams()->count();
            $student_count = \App\School::find($school_id)->students()->count();

        }

        return view("school-admin.school-admin-dashboard",[
            'school_admin_count' => $school_admin_count,
            'teacher_count' => $teacher_count,
            'student_count' => $student_count,
            'guardian_count' => $guardian_count,
            'exam_count' => $exam_count,
            'grade_count' => $grade_count,
            'subject_count' => $subject_count,
            'exam_group_count' => $exam_group_count,
            'school_admin' => $school_admin,
            'school' => $school,
        ]);
    }
}
