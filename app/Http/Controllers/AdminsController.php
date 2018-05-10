<?php

namespace App\Http\Controllers;

use App\models\Client;
use App\models\InCome;
use App\models\OutCome;
use App\models\Paying;
use App\models\Renting;
use App\models\Rentings;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminsController extends Controller
{


    public $clients_fields = [
        'الأسم',
        'تاريخ الميلاد',
        'رقم التليفون',
        'العنوان',
        'الرقم القومى',
    ];


    public function GetAdmins()
    {
        $admins = User::where('role_id',1)->get();
        return $admins;
    }

    public function GetAdminsFields()
    {
        return $this->clients_fields;
    }
    public function add(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'email' => 'required|unique:users',
            'national_id' => 'required',
        ]);
        $data = $request->except('_token');
        $data['password'] = bcrypt($request->phone);
        $data['role_id'] = 1;
        $data['active'] = 1;
        $user = User::create($data);
        if($user)
        {
            return 1;
        }


    }
    public function update(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthdate' => 'required|max:255',
            'phone' => 'required|numeric',
            'address' => 'required',
            'national_id' => 'required|numeric',
        ]);
        $user = User::find($request->user_id);
        $data = $request->except('_token');
        if($user->update($data))
        {
            return 1;
        }
    }
    public function delete(Request $request)
    {
        $admin = User::find($request->id);
        if($admin)
        {
$admin->email = $admin->id;

            if($admin->delete())
                return 1;
        }
    }

}
