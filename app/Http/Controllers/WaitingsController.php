<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestReservation;
use App\Http\Utils\Utils;
use App\models\Attachment;
use App\models\Attachments;
use App\models\Car;
use App\models\Cars;
use App\models\Client;
use App\models\InCome;
use App\models\OutCome;
use App\models\Partner;
use App\models\Partners;
use App\models\Paying;
use App\models\Renting;
use App\models\Rentings;
use App\models\Waiting;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WaitingsController extends Controller
{

    public $KM_Counter_Penalty_total = 0;
    public $waitings_fields =
        [
            ' العميل',
            ' السيارة',
            'من',
            'الى',
            'المبلغ المطلوب',
            'ملاحظات',
            'تاريخ الاضافة',
            'الموظف',

        ];
    public $utils;
    public $cars;
    public function __construct()
    {
        $this->utils = new Utils();
        $this->cars = new CarsController();
    }
    public function GetWaitingsFields()
    {
        return $this->waitings_fields;
    }

    public function GetCustomers()
    {
        $user = Client::get();
        return $user;
    }

    public function GetWaitings()
    {
        return $Waitings = Waiting::orderBy("id","desc")->withTrashed()->get();
    }

    public function GetCars()
    {
        return Car::get();
    }

    public function CalculateWaiting(Request $request)
    {
        $data = $request->except('_token');
        $car = Car::where('id',$data['car_id'])->first();
        $days = $this->utils->DateDiff($data['start_duration'],$data['end_duration'],'DAY');
        $total_price = (int)$car->day_price * (int)$days;

        return $total_price;

    }
    public function GetCarDate(Request $request)
    {
        $car = Car::find($request->car_id);
        $date = 0;
        if(sizeof($car->rentings)) {
            foreach ($car->rentings as $renting) {
                $date = date('Y-m-d', strtotime($renting->end_duration));

            }
        }
        if(sizeof($car->waitings))
        {
            foreach ($car->waitings as $waiting)
            {
                $date = date('Y-m-d',strtotime($waiting->end_duration));
            }
        }
        return $date;
    }
    public function Add(Request $request)
    {
        $this->validate($request,[
            'client_id' => 'required',
            'car_id' => 'required',
            'start_duration' => 'required',
            'end_duration' => 'required',
        ]);
        $data = $request->except('_token');
        $data['user_id'] = Auth::user()->id;
        $data['total'] = $this->CalculateWaiting($request);
        $waiting = Waiting::create($data);
        if($waiting)
        {
            return 1;
        }
        else
            return 0;
    }
    public function Delete(Request $request)
    {
        $waiting = Waiting::find($request->id);
        if($waiting->forcedelete())
        {
            return 1;
        }
        else
            return 0;
    }
    public function Update(Request $request)
    {
        $this->validate($request,[
            'car_id' => 'required',
            'start_duration' => 'required',
            'end_duration' => 'required',
    ]);

        $waiting = Waiting::find($request->id);

        if($waiting)
        {
            $data = $request->except('_token','id');
            $data['total']=$this->CalculateWaiting($request);
            if($waiting->update($data))
                return 1;
        }
    }


}
