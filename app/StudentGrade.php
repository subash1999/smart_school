<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    protected $table = "student_grade";
    /**
     * A student's grade for a school session belongs to a student
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){
        return $this->belongsTo('App\Student','student_id','id');
    }

    /**
     * A student's grade for a school session belongs to a grade
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade(){
        return $this->belongsTo('App\Grade','grade_id','id');
    }

}
