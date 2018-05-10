<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class InComesType extends Model
{
    protected $table = 'incomes_types';
    protected $fillable = ['name'];
    public $timestamps = false;
}
