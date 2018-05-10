<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
    use SoftDeletes;
    protected $table = 'settings';
    protected $fillable = ['title', 'value'];
    protected $dates = ['deleted_at'];
}
