<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $table = 'clients';
    protected $fillable = ['user_id','licence','licence_type','licence_from', 'licence_to'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function incomes()
    {
        return $this->hasMany('App\models\InCome');
    }public function rentings()
    {
        return $this->hasMany('App\models\Renting')->withTrashed();
    }
}