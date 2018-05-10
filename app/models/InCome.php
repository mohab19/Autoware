<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InCome extends Model
{
    use SoftDeletes;
    protected $table = 'incomes';
    protected $fillable = ['incomes_type_id','user_id','client_id','renting_id','car_id','title','value'];
    protected $dates = ['deleted_at'];

    public function incomes_type()
    {
        return $this->belongsTo('App\models\InComesType');
    }
    public function renting()
    {
        return $this->belongsTo('App\models\Renting')->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function car()
    {
        return $this->belongsTo('App\models\Car')->withTrashed();
    }
    public function client()
    {
        return $this->belongsTo('App\models\Client')->withTrashed();
    }
    public function getPaidDateAttribute()
    {
        return date("Y-m-d",strtotime($this->created_at));
    }
    public function getDateAttribute()
    {
        return date("Y-m-d",strtotime($this->created_at));
    }

}
