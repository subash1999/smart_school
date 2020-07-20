<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    /**
     * A guardian belongs to a session of a school
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolSession(){
        return $this->belongsTo('App\SchoolSession','school_session_id','id');
    }

    /**
     * A guardian belongs to many students
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(){
        return $this->belongsToMany('App\Student','guardian_student','guardian_id','student_id');
    }

    /**
     * A guardian has many data in guardian_student pivot table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guardianStudents(){
        return $this->hasMany('App\GuardianStudent','guardian_id','id');
    }

    /**
     * A guardian belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
