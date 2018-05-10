<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Paying extends Model
{
    protected $table = 'paying';
    protected $fillable = ['user_id','month','year', 'title', 'value'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}