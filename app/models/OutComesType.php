<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class OutComesType extends Model
{
    protected $table = 'outcomes_types';
    protected $fillable = ['name'];
    public $timestamps = false;
}
