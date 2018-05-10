<?php

namespace App\Http\Utils;

use App\models\Roles;
use Illuminate\Support\Facades\DB;

class Utils
{
    public  $weekDays=
    [
        'Sun' => 'الأحد',
        'Mon' => 'الأثنين',
        'Tue' => 'الثلاثاء',
        'Wed' => 'الأربعاء',
        'Thu' => 'الخميس',
        'Fri' => 'الجمعة',
        'Sat' => 'السبت'
    ];
    public function __construct()
    {
    }

    public function GetRoleId($role_name)
    {
        $role = Roles::where('name',$role_name)->first();
        return $role->id;
    }

    /**
     * @param $big_date // older is bigger
     * @param $small_date // newer is smaller
     * @param $diff_type  // date diff output (DAY,HOUR,MONTH)
     */
    public function DateDiff($big_date, $small_date, $diff_type)
    {
        $date = DB::select("SELECT TIMESTAMPDIFF($diff_type,'$big_date','$small_date') as date");
        return $date[0]->date;
    }

    /**
     * get date today
     * @return bool|string
     */
    public function GetDateToday()
    {
        date_default_timezone_set('Africa/Cairo');
        $today = date('Y-m-d H:i:s');
        $today = explode(' ',$today);
        return array('date' => $today[0] , 'time' => $today[1]);
    }

    public function GetDayName()
    {
        $day_abbrev = date("D");
        return $this->weekDays[$day_abbrev];
    }
}