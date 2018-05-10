<?php

namespace App\Http\Controllers;

use App\models\Client;
use App\models\InCome;
use App\models\OutCome;
use App\models\Paying;
use App\models\Renting;
use App\models\Rentings;
use App\models\Settings;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{


    public function GetSetting($title)
    {
        $setting = Settings::where('title',$title)->first();
        return $setting;
    }
    public function update(Request $request,$title)
    {
        $setting = $this->GetSetting($title);
        $data = $request->except('_token');
        if($setting->update($data))
        {
            return 1;
        }
    }
}
