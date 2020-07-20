<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * A school has many school admins
     * One or more school admin possible
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolAdmins(){
        return $this->hasMany('App\SchoolAdmin','school_id','id');
    }

    /**
     * A school has many school sessions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolSessions(){
        return $this->hasMany('App\SchoolSession','school_id','id');
    }
}
