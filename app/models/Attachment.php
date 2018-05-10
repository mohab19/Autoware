<?php
/**
 * Created by PhpStorm.
 * User: karim
 * Date: 31/07/16
 * Time: 08:07 م
 */


namespace App\models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Attachment extends Model
{
    use SoftDeletes;
    protected $table = 'attachments';
    protected $fillable = ['user_id', 'car_id','title','value'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function car()
    {
        return $this->belongsTo('App\models\Car');
    }
}