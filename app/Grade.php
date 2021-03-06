<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /**
     * A grade belongs to a school session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolSession(){
        return $this->belongsTo('App\SchoolSession','school_session_id','id');
    }

    public function school(){
        return \App\SchoolSession::find($this->SchoolSession->id)->School;
    }

    /**
     * get the subjects of a grade
     * A grade has many subjects
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects(){
        return $this->belongsToMany('App\Subject','grade_subject','grade_id','subject_id');
    }

    /**
     * A grade has many grade subjects
     * grade_subject is a pivot table
     * This gives the relation to the pivot table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gradeSubjects(){
        return $this->hasMany('App\GradeSubject','grade_id','id');
    }

    /**
     * A grade has many students
     * e.g. A grade 1 can have 20 students
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(){
        return $this->belongsToMany('App\Student','student_grade','grade_id','id');
    }

    /**
     * A grade has many student grade
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentGrades(){
        return $this->hasMany('App\StudentGrade','grade_id','id');
    }

    public function teachers(){
//        grade subject ids of the grade
        $grade_subject_ids = $this->gradeSubjects()->pluck('id')->toArray();
//        get the teachers of the gradeSubject ids
        return \App\GradeSubjectTeacher::whereIn('grade_subject_id',$grade_subject_ids)
            ->get();
    }

    public function exams(){
        //        grade subject ids of the grade
        $grade_subject_ids = $this->gradeSubjects()->pluck('id')->toArray();
//        get the exams of the gradeSubject ids
        return \App\Exam::whereIn('grade_subject_id',$grade_subject_ids)
            ->get();
    }


}
