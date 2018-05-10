<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renting extends Model
{
    use SoftDeletes;
    protected $table = 'rentings';
    protected $fillable = ['client_id','user_id', 'car_id','start_duration','end_duration','paid',
        'total','KM_Counter_Penalty_total','KM_Counter_Penalty_paid','discount',
        'payrate','userate','notes'];

    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo('App\models\Client')->withTrashed();
    }
public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function car()
    {
        return $this->belongsTo('App\models\Car')->withTrashed();
    }
    public function outcomes()
    {
        return $this->hasMany('App\models\OutCome');
    }
    public function incomes()
    {
        return $this->hasMany('App\models\InCome');
    }
    public function getDeptAttribute()
    {
        return $this->total - ($this->discount + $this->paid);
    }
    public function getKMDeptAttribute()
    {
        $dept = $this->KM_Counter_Penalty_total - $this->KM_Counter_Penalty_paid;
        return $dept;
    }
    public function getstartAttribute()
    {
        return date("Y-m-d",strtotime($this->created_at));
    }
    public function getendAttribute()
    {
        if($this->deleted_at != NULL)
        return date("Y-m-d",strtotime($this->deleted_at));
        else
            return "لم يتم بعد";
    }
}