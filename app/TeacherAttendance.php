<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    protected $table = "teacher_attendance";

    /**
     * A teacher's attendance belongs to a teacher
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(){
        return $this->belongsTo('App\Teacher','teacher_id','id');
    }

    /**
     * A teacher's attendance belongs to a school calendar ( day)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolCalendar(){
        return $this->belongsTo('App\SchoolCalendar','school_calendar_id','id');
    }
}
