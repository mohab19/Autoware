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

class ClientsController extends Controller
{
    public $app_url;
    public $photo_directory;
    public function __construct()
    {
        $this->app_url = url()->to('/');
        $this->photo_directory = 'Users';
    }
    public $clients_fields = [
        'الأسم',
        'تاريخ الميلاد',
        'رقم التليفون',
        'العنوان',
        'الرقم القومى',
        'ملاحظات'
    ];

    // continue later in order to make a dynamic registeration fields in all  user controllers
    public $client_register_fields =
        [
            ['name' => '']
        ];

    public function GetClients()
    {
        $clients = User::select(
            'users.*',
            'clients.*')
            ->leftJoin('clients','clients.user_id','=','users.id')
            ->where('users.role_id',4)
            ->get();
        return $clients;
    }

    public function GetClientsFields()
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
            'national_id' => 'required',
            'id_from' => 'required',
            'id_date' => 'required',
            'nationality' => 'required',
            'licence' => 'required',
            'licence_type' => 'required',
            'licence_from' => 'required',
            'licence_to' => 'required',
        ]);
        $data = $request->except('_token');
        $data['password'] = encrypt($request->phone);
        $data['role_id'] = 4;
        $data['active'] = 1;
        $user = User::create($data);
        if($user)
        {
            $data['user_id'] = $user->id;
            $client = Client::create($data);
        }
        if($client)
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
            'national_id' => 'required|numeric',
            'nationality' => 'required',
        ]);
        $user = User::find($request->user_id);
        $client = Client::find($request->id);
        $data = $request->except('_token');
        if($user->update($data)&&$client->update($data))
        {
            return 1;
        }
    }
   public function delete(Request $request)
   {
       $data = $request;
       $client = Client::find($request->id);
       if(sizeof($client->rentings)>0)
       {
           foreach ($client->rentings as $renting)
           {
               if($renting->deleted_at == NULL)
                   return 2;
           }
       }
       if($client->user->attachments)
       {
           foreach ($client->user->attachments as $attachment)
           {
               $attachment->user_id = NULL;
               $attachment->forcedelete();
           }
       }
       $upload_to = app_path() . '/../public/'.$this->photo_directory."/".$client->user->id;
       if(is_dir($upload_to))
           $this->RemoveFolder($upload_to);
       $client->delete();
       $client->user->delete();
   }
    function RemoveFolder($dir)
    {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    public function Profile()
    {
        $id = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '-')+1);
        $client = Client::find($id);
        if($client)
        {
            $rentings = Renting::where("client_id",$id)->withTrashed()->get();
            $dept = 0;
            $userate = 0;
            $payrate=0;
            $paycount = 0;
            $usecount=0;
            if($rentings->count())
            {

                foreach ($rentings as $renting)
                {
                    $dept += $renting->dept;
                    $dept += $renting->KM_Dept;
                    if($renting->userate!=NULL)
                    {
                        $userate+=$renting->userate;
                        $usecount++;

                    }
                    if($renting->payrate!=NULL)
                    {
                        $payrate+=$renting->payrate;
                        $paycount++;
                    }
                }
                if($userate)
                $userate = $userate/$usecount;
                if($payrate)
                $payrate = $payrate/$paycount;
            }
            return view('pages.ClientProfile',
                [
                    'client' =>$client,
                    'rentings' =>$rentings,
                    'dept'=>$dept,
                    'userate'=>$userate,
                    'payrate'=>$payrate
                ]);
        }
        else
            return view('errors.404');

    }

    /**
     * @return array
     */

    public function AddUserImage(Request $request , $file)
    {
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
                    $upload_to = app_path() . '/../public/images/'.$this->photo_directory."/".$request->user_id;
                    $extension = $logo->getClientOriginalExtension();
                    $file_name = $file."-".$counter. ".$extension";
                    $success = $logo->move($upload_to, $file_name);
                    if($success)
                        $pictures[] = $this->app_url."/images/".$this->photo_directory."/".$request->user_id."/".$file_name;
                    else
                        return 0;
                }
                $pictures_str  = implode("||", $pictures);
                return $pictures_str;




            }
            else
            {
                $logo = $request->file('picture');
                $upload_to = app_path() . '/../public/'.$this->photo_directory."/".$request->user_id;
                $extension = $logo->getClientOriginalExtension();
                $file_name = $file . ".$extension";
                $success = $logo->move($upload_to, $file_name);
                if ($success)
                    return $this->app_url."/images/".$this->photo_directory."/".$request->user_id."/".$file_name;
                else
                    return 0;
            }
        }
    }
    public function PayDept(Request $request)
    {
        $this->validate($request,[
            'dept' => 'required|numeric',
        ]);
        $renting = Renting::withTrashed()->find($request->id);
            if($request->dept<=$renting->dept &&$request->dept>0)
            {
                $renting->paid += $request->dept;
                $renting->update();
                $income = new InCome();
                $income->incomes_type_id = 2;
                $income->renting_id = $renting->id;
                $income->client_id = $renting->client_id;
                $income->partner_id = $renting->car->partner_id;
                $income->car_id = $renting->car->id;
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
                    $outcome->user_id = Auth::user()->id;
                    $outcome->title = "عمولة دين";
                    $commission = floatval($renting->car->renter_value);
                    $outcome->value = ($request->dept) * ($commission/100);
                    $outcome->save();
                }

            }
            else
                return 2;


    }

}
