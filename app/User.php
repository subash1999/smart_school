<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;  // Import Hash facade
use Storage;

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
     * Hash the password before saving it using the mutator
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function getAvailableRoles(){
        $roles = [];
        if($this->isSuperAdmin()){
            $roles["Super Admin"] = [['id' => $this->superAdmin->id,
            'name'=> $this->superAdmin->name]];
        }
        if($this->isSchoolAdmin()){
            $role = [];
            foreach ($this->schoolAdmins as $school_admin){
                $role[] = ['name' => $school_admin->name,
                    'school_name' => $school_admin->load('school')->school->name,
                    'id' => $school_admin->id,
                    'school_id' => $school_admin->load('school')->school->id];
            }
            $roles["School Admin"] = $role;
        }
        if($this->isTeacher()){
            $role = [];
            foreach ($this->teachers as $teacher){
                $role[] = ['name' => $teacher->name,
                    'school_name' => $teacher->load('school')->school->name,
                    'id' => $teacher->id,
                    'school_id' => $teacher->load('school')->school->id];
            }
            $roles["Teacher"] = $role;
        }
        if($this->isGuardian()){
            $role = [];
            foreach ($this->guardians as $guardian){
                $role[] = ['name' => $guardian->name,
                    'school_name' => $guardian->load('school')->school->name,
                    'id' => $guardian->id,
                    'school_id' => $guardian->load('school')->school->id];
            }
            $roles["Guardian"] = $role;
        }
        return $roles;
    }
    public function isSuperAdmin(){
        return $this->SuperAdmin()->count()>0;
    }
    public function isSchoolAdmin(){
        return $this->SchoolAdmins()->count()>0;
    }
    public function isTeacher(){
        return $this->Teachers()->count()>0;
    }
    public function isGuardian(){
        return $this->Guardians()->count()>0;
    }
    /**
     * A user has one school admin
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolAdmins(){
        return $this->hasMany('App\SchoolAdmin','user_id','id');
    }
    /**
     * A user has one guardian
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guardians(){
        return $this->hasMany('App\Guardian','user_id','id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function  teachers(){
        return $this->hasMany('App\Teacher','user_id','id');
    }

}
