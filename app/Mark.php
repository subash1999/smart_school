<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    /**
     * A mark belongs to a exam
     * A mark is for a exam taken
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam(){
        return $this->belongsTo('App\Exam','exam_id','id');
    }

    /**
     * A marks belongs to a student
     * A marks is for a student
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){
        return $this->belongsTo('App\Student','student_id','id');
    }

}
