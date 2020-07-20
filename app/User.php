<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * A user has one school admin
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function schoolAdmin(){
        return $this->hasOne('App\SchoolAdmin','user_id','id');
    }
    /**
     * A user has one guardian
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function guardian(){
        return $this->hasOne('App\Guardian','user_id','id');
    }
    /**
     * A user has one super admin
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function superAdmin(){
        return $this->hasOne('App\SuperAdmin','user_id','id');
    }

    /**
     * A user has one teacher
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function  teacher(){
        return $this->hasOne('App\Teacher','user_id','id');
    }

}
