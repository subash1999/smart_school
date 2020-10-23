<?php

namespace App;

use App\Http\Controllers\StorageController;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //    delete event handling
    public static function boot()
    {
        parent::boot();

        // Attach event handler, on deleting of the user
        School::deleting(function($school)
        {
            (new StorageController())->deleteLogoImage($school->logo);
        });
    }
    /**
     * A school has many school admins
     * One or more school admin possible
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolAdmins(){
        return $this->hasMany('App\SchoolAdmin','school_id','id');
    }

    /**
     * A school has many school sessions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolSessions(){
        return $this->hasMany('App\SchoolSession','school_id','id');
    }

    /**
     * A school has many teachers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teachers(){
        return $this->hasMany('App\Teacher','school_id','id');
    }

    /**
     * One school has many students
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(){
        return $this->hasMany('App\Student','school_id','id');
    }

    /**
     * A school has many guardians
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guardians(){
        return $this->hasMany('App\Guardian','school_id','id');
    }

    public function subjects(){
        $subjects = [];
        foreach ($this->SchoolSessions as $school_session){
            foreach($school_session->Subjects as $subject){
                array_push($subjects,$subject);
            }
        }
        return collect($subjects);
    }

    public function examGroups(){
        $exam_groups = [];
        foreach ($this->SchoolSessions as $school_session){
            foreach($school_session->ExamGroups as $exam_group){
                array_push($exam_groups,$exam_group);
            }
        }
        return collect($exam_groups);
    }

    public function exams(){
        $exams = [];
        foreach ($this->SchoolSessions as $school_session){
            foreach($school_session->exams() as $exam){
                array_push($exams,$exam);
            }
        }
        return collect($exams);
    }

    public function grades(){
        $grades = [];
        foreach ($this->SchoolSessions as $school_session){
            foreach($school_session->grades()->orderBy('grade_name')->orderBy('section')->get()
                    as $grade){
                array_push($grades,$grade);
            }
        }
        return collect($grades);
    }

}
