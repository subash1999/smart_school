<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    /**
     * A school event belongs to a date which is in school calendar table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolCalendar(){
        return $this->belongsTo('App\SchoolCalendar','school_calendar_id','id');
    }
}
