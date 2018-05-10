<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;
    protected $table = 'partners';
    protected $fillable = ['id','user_id'];

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
    public function cars()
    {
        return $this->hasMany('App\models\Car')->withTrashed();
    }
    public function incomes()
    {
        return $this->hasMany('App\models\InCome')->withTrashed();
    }
    public function outcomes()
    {
        return $this->hasMany('App\models\OutCome');
    }
    public function getDisplayNameAttribute()
    {
        return $this->user->first_name . " " . $this->user->last_name;
    }
}