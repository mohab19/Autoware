<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutCome extends Model
{
    use SoftDeletes;
    protected $table = 'outcomes';
    protected $fillable = ['outcomes_type_id','employee_id','client_id','partner_id','user_id','car_id','renting_id','title','value'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function client()
    {
        return $this->belongsTo('App\models\Client')->withTrashed();
    }
    public function employee()
    {
        return $this->belongsTo('App\models\Employee')->withTrashed();
    }
    public function partner()
    {
        return $this->belongsTo('App\models\Partner')->withTrashed();
    }
    public function outcomes_type()
    {
        return $this->belongsTo('App\models\OutComesType');
    }
    public function car()
    {
        return $this->belongsTo('App\models\Car')->withTrashed();
    }
    public function renting()
    {
        return $this->belongsTo('App\models\Renting')->withTrashed();
    }

    public function getDateAttribute()
    {
        return date("Y-m-d",strtotime($this->created_at));
    }

}
