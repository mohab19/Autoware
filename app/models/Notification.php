<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['title','url','read'];


    public function getDateAttribute()
    {
        return date("Y-m-d",strtotime($this->created_at));
    }
}
