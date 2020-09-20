<?php

namespace App;

use App\Http\Controllers\StorageController;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    //    delete event handling
    public static function boot()
    {
        parent::boot();

        // Attach event handler, on deleting of the user
        SuperAdmin::deleting(function($super_admin)
        {
            (new StorageController())->deletePassportPhotoImage($super_admin->passport_photo);
        });
    }
    /**
     * A super admin belongs to one user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
