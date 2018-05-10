<?php
/**
 * Created by PhpStorm.
 * User: karim
 * Date: 29/07/16
 * Time: 07:00 م
 */

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenses extends Model
{
    use SoftDeletes;
    protected $table = 'expenses';
    protected $fillable = ['title', 'value','month','year'];
    protected $dates = ['deleted_at'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function car()
    {
        return $this->belongsTo('App\models\Cars');
    }
}