<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    /**
     * A super admin belongs to one user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
