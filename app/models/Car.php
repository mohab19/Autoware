<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $table = 'cars';
    protected $fillable = ['name', 'picture','model','color','licence_date','licence_owner','licence_from','licence','motor','chassis','plate',
        'partner_id','day_price','month_price','KM_Counter','rental_type_id','renter_value','car_price','available','notes'];

    protected $dates = ['deleted_at'];

    public function partner()
    {
        return $this->belongsTo('App\models\Partner')->withTrashed();
    }
    public function rental_type()
    {
        return $this->belongsTo('App\models\RentalType');
    }
    public function attachments()
    {
        return $this->hasMany('App\models\Attachment');
    }
    public function rentings()
    {
        return $this->hasMany('App\models\Renting')->onlyTrashed();
    }
    public function renting()
    {
        return $this->hasOne('App\models\Renting');
    }
    public function waitings()
    {
        return $this->hasMany('App\models\Waiting')->withTrashed();
    }
    public function outcomes()
    {
        return $this->hasMany('App\models\OutCome')->withTrashed();
    }
    public function incomes()
    {
        return $this->hasMany('App\models\InCome')->withTrashed();
    }
    public function getDisplayNameAttribute()
    {
        return $this->name." ".$this->color." ".$this->plate;
    }
}
