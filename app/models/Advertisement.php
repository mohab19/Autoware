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

class Advertisement extends Model
{
    use SoftDeletes;
    protected $table = 'advertisements';
    protected $fillable = ['title', 'description','picture','attachments','price','notes'];
    protected $dates = ['deleted_at'];
}