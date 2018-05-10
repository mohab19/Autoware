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

class ReservationController extends Controller
{

    public $KM_Counter_Penalty_total = 0;
    public $rent_fields =
        [
            'رقم الحجز',
            'اسم العميل',
            'اسم السيارة',
            'من',
            'الى',
            'المبلغ المطلوب',
            'المبلغ المدفوع',
            'المبلغ المتبقى',
        ];
    public $utils;
    public $cars;
    public function __construct()
    {
        $this->utils = new Utils();
        $this->cars = new CarsController();
    }
    public function GetRentingsFields()
    {
        return $this->rent_fields;
    }

    public function GetCustomers()
    {
        $user = Client::orderBy('id','desc')->get();
        return $user;
    }

    public function GetRentings()
    {
        return $rentings = Renting::orderBy("id","desc")->withTrashed()->get();
    }

    public function GetCars()
    {
        return Car::where('available',1)->get();
    }

    public function CalculateReservation(Request $request)
    {
        $car_id = 0;
        $data = $request->except('_token');
        if($data['car_id'])
        $car_id = $data['car_id'];
        else
        {
            $renting = Renting::find($request->id);
            $car_id = $renting->car_id;
        }
        $car = Car::where('id',$car_id)->first();
        $days = $this->utils->DateDiff($data['start_duration'],$data['end_duration'],'DAY');
        $total_price = (int)$car->day_price * (int)$days;
        if($data['DiscountOption'])
            $total_price = $total_price - $data['discount'];
        return $total_price;
    }

    public function CalculateRenewReservation(Request $request)
    {
        $renting = Renting::find($request->id);
        $days = $this->utils->DateDiff($request->start_duration,$request->end_duration,'DAY');
        $total_price = (int)$renting->car->day_price * (int)$days;
        if($request->DiscountOption)
            $total_price = $total_price - $request->discount;
        return $total_price;
    }
    public function CreateReservation(RequestReservation $request)
    {
        $data = $request->except(['_token','DiscountOption']);
        /**
         * additional validations
         * difference between start and end durations
         */
        $request->session()->flash('data', $data);
        return url('/checkout');
    }
    public function RenewReservation(Request $request)
    {
        $this->validate($request,[
            'start_duration' => 'required',
            'end_duration' => 'required',
            'DiscountOption' => 'required',
            'discount' => 'required_if:DiscountOption,1|numeric',
            'paid' => 'required|numeric',
        ]);
        $renting = Renting::find($request->id);
        $data = $request->except(['_token','DiscountOption']);
        $data['car_id'] = $renting->car_id;
        $data['client_id'] = $renting->client_id;
        /**
         * additional validations
         * difference between start and end durations
         */
        $request->session()->flash('data', $data);
        return url('/checkout');
    }
    public function ReservationCheckOut(Request $request)
    {

        $data = $request->session()->get('data');
        if(isset($data)) {

            $today = $this->utils->GetDateToday();
            $client = Client::where('id', $data['client_id'])->first();
            $car_user_data = Car::select(
                'cars.*',
                'users.*'
            )
                ->leftJoin('users', 'cars.partner_id', '=', 'users.id')
                ->where('cars.id', '=', $data['car_id'])
                ->first();

            $days = $this->utils->DateDiff($data['start_duration'], $data['end_duration'], 'DAY');
            $request->session()->flash('dataP2', $data);
            $request->session()->flash('dataP3', $car_user_data);
            $request->session()->flash('dataP4',$days);
            $reservation = Renting::orderBy('id','desc')->withTrashed()->first();
            if($reservation)
                $sn = $reservation->id+1;
            else
                $sn =1;
            return view('pages.checkout',
                [
                    'data' => $data,
                    'today' => $today,
                    'car_user_data' => $car_user_data,
                    'client' => $client,
                    'day_name' => $this->utils->GetDayName(),
                    'number_of_days' => $days,
                    'sn'=>$sn
                ]);
        }else{
            return view('errors.403');
        }
    }

    public function FinalReservationStep(Request $request)
    {
        $data = $request->session()->get('dataP2');
        $carUserData = $request->session()->get('dataP3');
        $days = $request->session()->get('dataP4');
        $title = "حجز";
        if($data['waiting_id']!=0)
        {
                $waiting = Waiting::find($data['waiting_id']);
                if($waiting)
                    $waiting->forcedelete();
        }
        if($data['renew_id']!=0)
        {
            $title = "تجديد حجز";
            $renting = Renting::find($data['id']);
                if($renting)
                    $renting->delete();
        }
        if(isset($data) && isset($carUserData) && isset($days) ) {
            $data['total'] = $carUserData->day_price * $days;
            $data['user_id'] = Auth::user()->id;

            $rental = Renting::create($data);
            $rental->car->available = 0;
            $rental->car->update();
            if ($rental)
            {
                    $income = new InCome();
                    $income->incomes_type_id = 1;
                    $income->renting_id = $rental->id;
                    $income->car_id = $rental->car_id;
                    $income->client_id = $rental->client_id;
                    $income->car_id = $rental->car_id;
                    $income->user_id = Auth::user()->id;
                    $income->title = $title;
                    $income->value = $rental->paid;
                    $income->save();
                if($rental->car->rental_type_id == 2)
                {
                    $outcome = new OutCome();
                    $outcome->outcomes_type_id = 2;
                    $outcome->user_id = Auth::user()->id;
                    $outcome->partner_id =$rental->car->partner->id;
                    $outcome->renting_id = $rental->id;
                    $outcome->car_id = $rental->car_id;
                    $outcome->title = "عمولة";
                    $commission = floatval($rental->car->renter_value);
                    $outcome->value = ($rental->paid) * ($commission/100);
                    $outcome->save();

                }
                return 1;
            }

            else
                return 0;
        }else{
            return -1;
        }
    }
    public function Delete(Request $request)
    {
        $renting = Renting::find($request->id);
        $renting->car->available = 1;
        $renting->car->update();
//        $incomes = InCome::where('renting_id',$renting->id)->first();
        foreach ($renting->incomes as $income)
        {
            $income->forcedelete();
        }
        foreach ($renting->outcomes as $outcome)
        {
            $outcome->forcedelete();
        }
        $renting->forcedelete();
    }
    public function PenaltyPay(Request $request)
    {
        $renting = Renting::withTrashed()->find($request->id);
        if ($renting) {

        if ($request->KM_Counter_Penalty_paid <= $renting->KM_Counter_Penalty_total &&($renting->KM_Counter_Penalty_paid+$request->KM_Counter_Penalty_paid) <= $renting->KM_Counter_Penalty_total  ) {
            $renting->KM_Counter_Penalty_paid += $request->KM_Counter_Penalty_paid;
            if ($renting->update()) {
                $income = new InCome();
                $income->incomes_type_id = 3;
                $income->renting_id = $renting->id;
                $income->client_id = $renting->client_id;
                $income->car_id = $renting->car->id;
                $income->user_id = Auth::user()->id;
                $income->title = "دفع كيلومترات ";
                $income->value = $request->KM_Counter_Penalty_paid;
                $income->save();
                if ($renting->car->rental_type_id == 2) {
                    $outcome = new OutCome();
                    $outcome->outcomes_type_id = 2;
                    $outcome->renting_id = $renting->id;
                    $outcome->client_id = $renting->client_id;
                    $outcome->car_id = $renting->car_id;
                    $outcome->partner_id = $renting->car->partner_id;
                    $outcome->user_id = Auth::user()->id;
                    $outcome->title = "عمولة كيلومترات";
                    $commission = floatval($renting->car->renter_value);
                    $outcome->value = ($request->KM_Counter_Penalty_paid) * ($commission / 100);
                    $outcome->save();
                }
                return 1;
            }

        } else
            return 2;
    }
    }
    public function PenaltyCheck(Request $request)
    {
        $renting = Renting::find($request->id);
        $KM_Used = $request->KM_Counter - $renting->car->KM_Counter;
        $days = $this->utils->DateDiff($renting->start_duration, $renting->end_duration, 'DAY');
        $KM_Expected = $days*130;
        if($KM_Used>$KM_Expected) {
            $KM_Diff = $KM_Used - $KM_Expected;
            $this->KM_Counter_Penalty_total = $KM_Diff * .5;
            return $this->KM_Counter_Penalty_total;
        }
        else
            return 0;

    }
    public function Recive(Request $request)
    {
        $renting = Renting::find($request->id);
        $this->validate($request,[
        'KM_Counter' => 'required|numeric|min:'.$renting->car->KM_Counter,
        'userate' => 'required|numeric|max:10',
        'payrate' => 'required|numeric|max:10',
    ]);


        if($renting->deleted_at==NULL)
        {
            $this->PenaltyCheck($request);
            if($request->picture[0] != "" && $request->picture[0] != " " && $request->picture[0] != "0")
            {
                $date = date_format(new \DateTime($renting->end_duration), "d-m-Y");
                $attachment = new Attachment();
                $attachment->save();
                $request->picture = $this->cars->AddCarImage($request,$date,$renting->car->id,$attachment);
                $attachment->car_id = $renting->car->id;
                $attachment->title="استلام - ".$date;
                $attachment->value=$request->picture;
                $attachment->save();
            }
            $renting->car->KM_Counter=$request->KM_Counter;
            $renting->notes = $request->notes;
            $renting->userate = $request->userate;
            $renting->payrate = $request->payrate;
            $renting->KM_Counter_Penalty_total = $this->KM_Counter_Penalty_total;
            if($request->dept>0)
            {
                if($request->dept>$renting->dept)
                    return "dept";
                $renting->paid += $request->dept;
                $income = new InCome();
                $income->incomes_type_id = 2;
                $income->renting_id = $renting->id;
                $income->client_id = $renting->client_id;
                $income->car_id = $renting->car_id;
                $income->user_id = Auth::user()->id;
                $income->title = "دفع دين";
                $income->value = $request->dept;
                $income->save();
                if($renting->car->rental_type_id == 2)
                {
                    $outcome = new OutCome();
                    $outcome->outcomes_type_id = 2;
                    $outcome->renting_id = $renting->id;
                    $outcome->client_id = $renting->client_id;
                    $outcome->car_id = $renting->car_id;
                    $outcome->partner_id = $renting->car->partner_id;
                    $outcome->user_id = Auth::user()->id;
                    $outcome->title = "عمولة دين";
                    $commission = floatval($renting->car->renter_value);
                    $outcome->value = ($request->dept) * ($commission/100);
                    $outcome->save();
                }
            }
            $renting->update();
            $renting->car->update();
            if($this->KM_Counter_Penalty_total>0)
                $this->PenaltyPay($request);
            $renting->delete();
            $renting->car->available = 1;
            $renting->car->update();
        }
    }
    public function Update(Request $request)
    {
        $this->validate($request,[
            'start_duration' => 'required',
            'end_duration' => 'required',
            'paid' => 'required',
    ]);

        $renting = Renting::find($request->id);
        $data = $request->except('_token','id');
        $renting->update($data);
                $paying = new Paying();
                $paying->user_id = $renting->user->id;
                $paying->title = "دفع عند تسليم السيارة : ".$renting->car->type;
                $paying->value = $request->dept;
                $paying->month = date("F");
                $paying->year = date("Y");
                $paying->save();
            }


}
