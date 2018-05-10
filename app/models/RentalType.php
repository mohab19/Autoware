<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RentalType extends Model
{
    protected $table = 'rental_types';
    protected $fillable = ['name'];
    public $timestamps = false;


    public function car()
    {
        return $this->hasMany('App\models\Car')->withTrashed();
    }
}


