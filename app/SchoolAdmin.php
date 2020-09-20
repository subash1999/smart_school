<?php

namespace App;

use App\Http\Controllers\StorageController;
use Illuminate\Database\Eloquent\Model;

class SchoolAdmin extends Model
{

    //    delete event handling
    public static function boot()
    {
        parent::boot();

        // Attach event handler, on deleting of the user
        SchoolAdmin::deleting(function($school_admin)
        {
            (new StorageController())->deletePassportPhotoImage($school_admin->passport_photo);
        });
    }

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
