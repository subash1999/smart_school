<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCalendar extends Model
{
    /**
     * A school calendar belongs to the school session
     * A school calendar includes the different dates for a particular session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolSession(){
        return $this->belongsTo('App\SchoolSession','school_session_id','id');
    }

    /**
     * A school calendar has many school event
     * a single day in a calendar has can have many events
     * School calendar contains the data for each and every day
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolEvents(){
        return $this->hasMany('App\SchoolEvent','school_session_id','id');
    }

    /**
     * A school calendar (day) has many student attendances
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentAttendances(){
        return $this->hasMany('App\StudentAttendance','student_attendance','id');
    }

    /**
     * A school calendar (day) has many students
     * In a particular day many students may be attended on the school
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(){
        return $this->belongsToMany('App\Student','student_attendances','school_calendar_id','student_id');
    }

    /**
     * A school calendar (day) has many attendance of subjects of grades.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function gradeSubjects(){
        return $this->belongsToMany('App\GradeSubject','school_attendance','school_calendar_id','grade_subject_id');
    }

    /**
     * A school calendar(day) has many teacher attendance
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teacherAttendance(){
        return $this->hasMany('App\TeacherAttendance','school_calendar_id','id');
    }

    /**
     * Get the teachers for the school calendar(day)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(){
        return $this->belongsToMany('App\Teacher','teacher_attendance','school_calendar_id','teacher_id');
    }

}
