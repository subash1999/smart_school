<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolSession extends Model
{
    /**
     * A school session has many grades
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grades(){
        return $this->hasMany('App\Grade','school_session_id','id');
    }

    /**
     * A single school session has many guardians
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guardians(){
        return $this->hasMany('App\Guardian','school_session_id','id');
    }

    /**
     * A school session belongs to a school
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){
        return $this->belongsTo('App\School','school_id','id');
    }

    /**
     * A school session has many students
     * for e.g. A school session of year 2020 can have 500 students
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(){
        return $this->hasMany('App\Student','school_session_id','id');
    }

    /**
     * A school session has many subjects
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(){
        return $this->hasMany('App\Subject','school_session_id','id');
    }

    /**
     * A school session has many teachers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teachers(){
        return $this->hasMany('App\Teacher','school_session_id','id');
    }
}
