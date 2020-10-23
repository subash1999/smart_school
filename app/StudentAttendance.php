<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $table = "student_attendance";

    protected $casts = [
        'is_present' => 'boolean',
    ];
    /**
     * A student attendance belongs to a school calendar (day of school)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolCalendar(){
        return $this->belongsTo('App\SchoolCalendar','school_calendar_id','id');
    }

    /**
     * A student attendance belongs to a student
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){
        return $this->belongsTo('App\Student','student_id','id');
    }

    /**
     * A student attendance belongs to a grade's subject
     * for e.g. A student attendance of grade 1 for subject "science"
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gradeSubject(){
        return $this->belongsTo('App\GradeSubject','grade_subject_id','id');
    }

}
