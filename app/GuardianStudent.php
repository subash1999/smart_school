<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GuardianStudent extends Pivot
{
    protected $table = "guardian_student";

    /**
     * One GuardianStudent row in pivot table belongs to a guardian
     * One guardian_student belongs to one guardian
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guardian(){
        return $this->belongsTo('App\Guardian','guardian_id','id');
    }

    /**
     * One GuardianStudent row in pivot table belongs to a student
     * One guardian_student belongs to one guardian
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){
        return $this->belongsTo('App\Student','student_id','id');
    }
}
