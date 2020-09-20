<?php

namespace App;

use App\Http\Controllers\StorageController;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //    delete event handling
    public static function boot()
    {
        parent::boot();

        // Attach event handler, on deleting of the user
        School::deleting(function($school)
        {
            (new StorageController())->deleteLogoImage($school->logo);
        });
    }
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

    /**
     * A school has many teachers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teachers(){
        return $this->hasMany('App\Teacher','school_id','id');
    }

    /**
     * One school has many students
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(){
        return $this->hasMany('App\Student','school_id','id');
    }

    /**
     * A school has many guardians
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guardians(){
        return $this->hasMany('App\Guardian','guardian_id','id');
    }
}
