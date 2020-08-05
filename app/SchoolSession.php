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
     * A school session has many subjects
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects(){
        return $this->hasMany('App\Subject','school_session_id','id');
    }

    /**
     * one school session has many exam groups
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examGroup(){
        return $this->hasMany('App\ExamGroup','school_session_id','id');
    }


}
