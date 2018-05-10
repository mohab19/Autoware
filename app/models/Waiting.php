<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waiting extends Model
{
    use SoftDeletes;
    protected $table = 'waitings';
    protected $fillable = ['client_id','car_id','user_id','start_duration','end_duration',
        'total','notes'];

    protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo('App\models\Client')->withTrashed();
    }
    public function car()
    {
        return $this->belongsTo('App\models\Car')->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}