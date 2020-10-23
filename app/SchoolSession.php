<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolSession extends Model
{
    protected $casts = [
        'from' => 'datetime:Y-m-d',
        'to' => 'datetime:Y-m-d',
    ];
    protected $dates = ['from','to'];
    /**
     * A school session has many grades
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grades(){
        return $this->hasMany('App\Grade','school_session_id','id');
    }


    /**
     * A school session belongs to a school
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){
        return $this->belongsTo('App\School','school_id','id');
    }

    /**
     * A school session has many subjects
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(){
        return $this->hasMany('App\Subject','school_session_id','id');
    }

    /**
     * one school session has many exam groups
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examGroups(){
        return $this->hasMany('App\ExamGroup','school_session_id','id');
    }

    /**
     * Exams of that school session
     * @return \Illuminate\Support\Collection
     */
    public function exams(){
        $exams = [];
        foreach($this->Grades as $grade){
            foreach($grade->GradeSubjects as $grade_subject){
                foreach($grade_subject->Exams as $exam){
                    array_push($exams,$exam);
                }
            }
        }
        return collect($exams);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function students(){
        $students = $this->School->load('students')->Students;
        $students_selected = [];
        if(isset($this->id)){
            foreach($students as $student){
                foreach($student->Grades as $grade){
                    if($grade->school_session_id == $this->id){
                        array_push($students_selected,$student);
                        break;
                    }
                }
            }
        }
        else{
            $students_selected = $students;
        }

        return collect($students_selected);
    }

    public function getSessionDurationText(){
        return $this->from->format('Y M d')." - ".$this->to->format('Y M d');
    }
}
