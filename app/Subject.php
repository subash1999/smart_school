<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * A subject belongs to many grades
     * science subject may be taught in may grades
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function grades(){
        return $this->belongsToMany('App\Grade','grade_subject','subject_id','grade_id');
    }

    /**
     * A subject has many gradeSubject (grade_subject) pivot table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gradeSubjects(){
        return $this->hasMany('App\GradeSubject','subject_id','id');
    }
    /**
     * A subject belongs to a school session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolSession(){
        return $this->belongsTo('App\SchoolSession','school_session_id','íd');
    }
}
