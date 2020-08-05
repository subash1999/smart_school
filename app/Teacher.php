<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /**
     * A teacher has many gradeTeacher
     * (grade_teacher) is a pivot table which shows relation between teacher and grade
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gradeSubjectTeachers(){
        return $this->hasMany('App\GradeSubjectTeacher','teacher_id','id');
    }

    /**
     * A teacher belongs to gradeSubjects
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function gradeSubjects(){
        return $this->belongsToMany('App\GradeSubject','grade_teacher','teacher_id','grade_subject_id');
    }

    /**
     * A teacher belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     * One teacher can have many attendances
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teacherAttendance(){
        return $this->hasMany('App\TeacherAttendance','teacher_id','id');
    }

    /**
     * Get all the School Calendars(days) of a teacher where he/she was absent or present
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schoolCalendars(){
        return $this->belongsToMany('App\SchoolCalendar','teacher_attendance','teacher_id','school_calendar_id');
    }

    /**
     * A teacher belongs to a school
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){
        return $this->belongsTo('App\School','school_id','id');
    }
}
