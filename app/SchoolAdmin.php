<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolAdmin extends Model
{
    /**
     * A school admin belongs to a school
     * It belongs to a school rather than schoolSession
     * because schoolAdmin is responsible for creating school session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(){
        return $this->belongsTo('App\School','school_id','id');
    }

    /**
     * A school admin belongs to a user
     * A schoolAdmin is also a user of the system (software)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User', 'user_id','id');
    }
}
