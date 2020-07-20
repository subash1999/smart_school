<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeSubjectTeacher extends Model
{
    protected $table = "grade_subject_teacher";

    /**
     * Get the grade subject pivot table that a teacher teaches
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gradeSubject(){
        return $this->belongsTo('App\GradeSubject','grade_subject_id','id');
    }

    /**
     * Get the teacher for a subject of a grade
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(){
        return $this->belongsTo('App\Teacher','teacher_id','id');
    }
}
