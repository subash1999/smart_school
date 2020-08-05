<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * A student has many guardians
     * i.e. one student may have a father and mother registered
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guardians(){
        return $this->belongsToMany('App\Guardian','guardian_student','student_id','guardian_id');
    }

    /**
     * A student has many guardianStudent, guardian_student is a pivot table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guardianStudents(){
        return $this->hasMany('App\GuardianStudent','student_id','id');
    }

    /**
     * A student has many marks for different exams
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marks(){
        return $this->hasMany('App\Mark','student_id','id');
    }

    /**
     * A student belongs to a school session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolSession(){
        return $this->belongsTo('App\SchoolSession','school_session_id','id');
    }

    /**
     * A student belongs to a school
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){
        return $this->belongsTo('App\School','school_id','id');
    }

    /**
     * A student belongs to a grade
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade(){
        return $this->belongsTo('App\Grade','grade_id','id');
    }

    /**
     * A student has many student attendances
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentAttendances(){
        return $this->hasMany('App\StudentAttendance','student_id','id');
    }

    /**
     * A student has many studentGradeSchoolSessions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentGradeSchoolSessions(){
        return $this->hasMany('App\StudentGradeSchoolSession','student_id','id');
    }

    /**
     * A student can study in different grades in different school sessions
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function grades(){
        return $this->belongsToMany('App\Grade','student_grade','student_id','grade_id');
    }

    /**
     * A student has many student grade
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentGrade(){
        return $this->hasMany('App\StudentGrade','student_id','id');
    }

    /**
     * A student has many attendance days (School Calendars)
     * use unique value to the date of SchoolCalendar so that we can get the dates when student was present
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attendedSchoolCalendars(){
        return $this->belongsToMany('App\SchoolCalendar','student_attendance','student_id','school_calendar_id');
    }

    /**
     * List of the attended grade subject
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attendedGradeSubjects(){
        return $this->belongsToMany('App\GradeSubject','student_attendance','student_id','grade_subject_id');
    }

}
