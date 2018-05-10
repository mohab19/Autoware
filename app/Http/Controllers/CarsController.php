<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCar;
use App\models\Car;
use App\models\Expenses;
use App\models\OutCome;
use App\models\Partner;
use App\models\RentalType;
use App\models\Renting;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarsController extends Controller
{
    public $expenses;
    public $cars_fields =
        [
            'الصورة',
            'النوع',
            'الموديل',
            'اللون',
            'رقم اللوحة',
            'عداد الكيلومترات',
            'اسم المالك',
            'السعر في اليوم',
            'السعر في الشهر',
            'ملاحظات',
        ];

    public $cars_register_fields =
        [
            ['name' => 'name' , 'placeholder' => 'الأسم' , 'type' => 'text'],
            ['name' => 'model' , 'placeholder' => 'الموديل' , 'type' => 'text'],
            ['name' => 'color' , 'placeholder' => 'اللون' , 'type' => 'text'],
            ['name' => 'licence' , 'placeholder' => ' رقم الرخصة' , 'type' => 'text'],
            ['name' => 'licence_owner' , 'placeholder' => ' مالك الرخصة' , 'type' => 'text'],
            ['name' => 'licence_date' , 'placeholder' => ' تاريخ الرخصة' , 'type' => 'text'],
            ['name' => 'licence_from' , 'placeholder' => ' صادرة من' , 'type' => 'text'],
            ['name' => 'plate' , 'placeholder' => 'رقم اللوحة' , 'type' => 'text'],
            ['name' => 'motor' , 'placeholder' => 'رقم الموتور' , 'type' => 'text'],
            ['name' => 'chassis' , 'placeholder' => 'رقم الشاسيه' , 'type' => 'text'],
            ['name' => 'KM_Counter' , 'placeholder' => 'عداد الكيلومترات' , 'type' => 'text'],
            ['name' => 'day_price' , 'placeholder' => 'السعر في اليوم' , 'type' => 'text'],
            ['name' => 'month_price' , 'placeholder' => 'السعر في الشهر' , 'type' => 'text'],
            ['name' => 'car_price' , 'placeholder' => 'السعر الكلي للسيارة' , 'type' => 'text'],
            ['name' => 'partner_id' , 'placeholder' => 'المالك' , 'type' => 'select' , 'options' => [] ],
            ['name' => 'rental_type_id' , 'placeholder' => 'النوع ' ,'type' => 'select' , 'options' => [] ],
            ['name' => 'renter_value' , 'placeholder' => 'العمولة او الايجار للشريك : عمولة ="%"' , 'type' => 'text'],
        ];

    public $app_url;
    public $photo_directory;
    public function __construct()
    {
        $this->app_url = url()->to('/');
        $this->photo_directory = 'Cars';
        $this->fillRentalTypeOptions();
        $this->fillPartnerOptions();
        $this->expenses = new ExpensesController();
    }

    public function RegisterCar(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'model' => 'required',
            'color' => 'required',
            'KM_Counter' => 'required|numeric',
            'plate' => 'required',
            'motor' => 'required',
            'chassis' => 'required',
            'day_price' => 'required|numeric',
            'partner_id' => 'required',
            'rental_type_id' => 'required',
            'renter_value' => 'required',
            'picture' => 'max:10000'
        ]);

        $data = $request->except('_token');
        $car = Car::create($data);
        $id = $car->id;
        $data['picture']  = $this->AddCarImage($request,"main" , $id,0);
        $car->picture = $data['picture'];
        $car->save();
        if($car)
        {
            $type = $car->rental_type_id;
            if($type == 1)
            {
                $outcome = new OutCome();
                $outcome->outcomes_type_id = 1;
                $outcome->partner_id = $car->partner->id;
                $outcome->car_id = $car->id;
                $outcome->title = "ايجار";
                $outcome->value = $car->renter_value;
                $outcome->save();
            }
            return 1;
        }

        else
            return 0;
    }
    public function AddCarImage(Request $request , $file , $id , $attachment)
    {
        $flag = 0;
        $success = 0;
        $file_name = '';
        if($request->picture) {
            if(is_array($request->picture))
            {
                $pictures = array();
                $counter = 0;
                foreach ($request->file('picture') as $item) {
                    $counter++;
                    $logo = $item;
                    $upload_to = app_path() . '/../public/' . $this->photo_directory . "/" . $id . "/attachments/" . $attachment->id;
                    $extension = $logo->getClientOriginalExtension();
                    $file_name = $file."-".$counter. ".$extension";
                    $success = $logo->move($upload_to, $file_name);
                    if($success)
                    $pictures[] = $this->app_url."/".$this->photo_directory."/".$id. "/attachments/" . $attachment->id."/".$file_name;
                    else
                        return 0;
                }
                $pictures_str  = implode("||", $pictures);
                return $pictures_str;
            }
            else
            {
                $logo = $request->file('picture');

                $upload_to = app_path() . '/../public/' . $this->photo_directory . "/" . $id;
                $extension = $logo->getClientOriginalExtension();
                $file_name = $file . ".$extension";
                $success = $logo->move($upload_to, $file_name);
                if ($success)
                    return $this->app_url."/".$this->photo_directory."/".$id."/".$file_name;
                else
                    return 0;
            }
        }
    }

    public function GetCars()
    {
        $cars = Car::select(
            'cars.*',
            'users.first_name',
            'users.last_name')
            ->leftJoin('users','cars.partner_id','=','users.id')
            ->get();
        return $cars;
    }

    public function fillRentalTypeOptions()
    {
        $rentals = RentalType::select(
            'rental_types.id as value',
            'rental_types.name as display_name'
        )->where('id','>',0)
            ->get();
        for ($i = 0; $i < sizeof($this->cars_register_fields) ; $i++)
        {
            if($this->cars_register_fields[$i]['name'] == "rental_type_id")
            {
                $this->cars_register_fields[$i]['options'] = $rentals;
            }
        }
    }

    public function fillPartnerOptions()
    {
        $partners = Partner::select(
            'partners.user_id',
            'partners.id as value'
        )
            ->get();
        for ($i = 0; $i < sizeof($this->cars_register_fields) ; $i++)
        {
            if($this->cars_register_fields[$i]['name'] == "partner_id")
            {
                $this->cars_register_fields[$i]['options'] = $partners;
            }
        }
    }
    function RemoveFolder($dir)
    {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file"))
                $this->RemoveFolder("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }
    public function Delete(Request $request)
    {
        $data = $request;
        $car = Car::find($request->id);

        if(sizeof($car->rentings)>0)
        {
            foreach ($car->rentings as $renting)
            {
                if($renting->deleted_at == NULL)
                    return 2;
            }
        }
        if(sizeof($car->waitings)>0)
        {
            foreach ($car->waitings as $waiting)
            {
                if($waiting->deleted_at == NULL)
                    return 2;
            }
        }
        if($car->attachments)
        {
            foreach ($car->attachments as $attachment)
            {
                $attachment->forcedelete();
            }
        }
        $upload_to = app_path() . '/../public/'.$this->photo_directory."/".$car->id;
        if(is_dir($upload_to))
            $this->RemoveFolder($upload_to);
        if($car->delete())
            return 1;
    }
    public function Profile()
    {
        $id = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '-')+1);
        $car = Car::find($id);
        if($car)
        {
            $rentings = Renting::where("car_id",$id)->withTrashed()->get();
            return view('pages.CarProfile',
                [
                    'car' =>$car,
                    'rentings' =>$rentings,
                    'expenses_fields' => $this->expenses->GetExpensesFields(),
                    'car_expenses' => $this->expenses->GetCarExpenses($id),
                    'cars_register_fields' => $this->cars_register_fields,

                ]);
        }
        else
            return view('errors.404');

    }
    public function Update(Request $request)
    {
        $this->validate($request,[
                'name' => 'required',
                'model' => 'required',
                'color' => 'required',
                'KM_Counter' => 'required|numeric',
                'plate' => 'required',
                'motor' => 'required',
                'chassis' => 'required',
                'day_price' => 'required|numeric',
                'partner_id' => 'required',
        ]);
echo $request->partner_id;

        $car = Car::find($request->id);
        $data= $request->except('_token');
        $car->update($data);
$car->partner_id = $request->partner_id;
$car->save();
    }
    public function CheckAvailability(Request $request)
    {
        $this->validate($request,[
            'id' => 'required',
        ]);
        $car = Car::find($request->id);
        if($car->available)
        {
            return 1;
        }
        else if(!$car->available)
        {
            $rentings = Renting::where('car_id',$request->id)->get();
            if(sizeof($rentings))
            {
                foreach ($rentings as $renting)
                {
                    $date = date_format(new \DateTime($renting->end_duration), "d-m-Y");
                }
                return $date;

            }
            else
                return 0;
        }
    }
}