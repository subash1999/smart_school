<?php

namespace App;

use App\Http\Controllers\StorageController;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{

    //    delete event handling
    public static function boot()
    {
        parent::boot();

        // Attach event handler, on deleting of the user
        Guardian::deleting(function($guardian)
        {
            (new StorageController())->deletePassportPhotoImage($guardian->passport_photo);
        });
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

    public function school(){
        return $this->belongsTo('App\School','school_id','id');
    }
}
