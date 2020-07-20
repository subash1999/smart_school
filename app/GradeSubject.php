<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeSubject extends Model
{
    protected $table = "grade_subject";

    /**
     * A GradeSubject (grade_subject) is a pivot table which has many exams
     * GradeSubject contains the relationship between the grade and subject
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exams(){
        return $this->hasMany('App\Exam','grade_subject_id','id');
    }

    /**
     * A GradeSubject in the Pivot table belongs to a grade
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade(){
        return $this->belongsTo('App\Grade','grade_id','id');
    }

    /**
     *  GradeSubject in the Pivot table belongs to a subject
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject(){
        return $this->belongsTo('App\Subject','subject_id','id');
    }

    /**
     * A subject of a grade (GradeSubject) has many teachers.
     * Sometimes a subject of a class can be taught by one or many teachers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gradeSubjectTeachers(){
        return $this->hasMany('App\GradeSubjectTeacher','grade_subject_id','id');
    }

    /**
     * A subject of a grade (GradeSubject) has many teachers.
     * Sometimes a subject of a class can be taught by one or many teachers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(){
        return $this->belongsToMany('App\Teacher','grade_subject_teacher','grade_subject_id','teacher_id');
    }

    /**
     * A grade subject (subject of a grade) has many student attendances
     * for eg: for a science subject of grade 1 , there can be 20 students
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentAttendances(){
        return $this->hasMany('App\StudentAttendance','grade_subject_id','id');
    }

}
