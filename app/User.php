<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id','first_name','last_name', 'birthdate', 'address','office','password',
        'email','phone','national_id','notes','role_id','id_from','id_date','nationality','active'];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\models\Roles');
    }

    public function cars()
    {
        return $this->hasMany('App\models\Car')->withTrashed();
    }

    public function employee()
    {
        return $this->hasOne('App\models\Employee')->withTrashed();
    }
    public function client()
    {
        return $this->hasOne('App\models\Client')->withTrashed();
    }
    public function partner()
    {
        return $this->hasOne('App\models\Partner')->withTrashed();
    }

    public function renting()
    {
        return $this->hasMany('App\models\Renting')->withTrashed();
    }
    public function attachments()
    {
        return $this->hasMany('App\models\Attachment');
    }
//    public function paying()
//{
//    return $this->hasMany('App\models\Paying');
//}
    public function getDisplayNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getBirthAttribute()
    {
        $birthdate = explode(" ",$this->birthdate);
        return $birth = $birthdate[0];
    }

}
