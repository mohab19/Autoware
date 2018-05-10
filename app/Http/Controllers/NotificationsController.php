<?php

namespace App\Http\Controllers;

use App\models\Attachment;
use App\models\Client;
use App\models\Notification;
use App\models\Renting;
use App\models\Roles;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\models\Attachments;



class NotificationsController extends Controller
{


    public function GetNotifications()
    {
        return Notification::orderBy('id','desc')->get();
    }
    public function Count()
    {
        $notifications = Notification::where('read',0)->get();
        return $notifications->count();
    }
    public function Read()
    {
        $notifications = Notification::where('read',0)->get();
        foreach ($notifications as $notification)
        {
            $notification->read = 1;
            $notification->update();
        }

    }
    public function Delete(Request $request)
    {
        $notifications = Notification::find($request->id);
        if($notifications)
        {
            $notifications->forceDelete();
        }
    }
    public function DailyNotifications()
    {

        $rentings = Renting::get();
        foreach ($rentings as $renting)
        {
            $data = array();
            if(date('Y-m-d', strtotime($renting->end_duration)) == date('Y-m-d',strtotime("tomorrow")))
            {
                $data['title'] = "ستقوم باستلام السيارة " .$renting->car->name." غدا ";
                $data['url']="/recive";
                Notification::create($data);
            }
            else if(date('Y-m-d', strtotime($renting->end_duration)) == date('Y-m-d'))
            {
                $data['title'] = "ستقوم باستلام السيارة " .$renting->car->name." اليوم ";
                $data['url']="/recive";
                Notification::create($data);
            }
        }
        $clients = Client::get();
        foreach ($clients as $client) {
            foreach ($client->rentings as $renting) {
                $data = array();
                if ($renting->dept > 0 && date('Y-m-d') > date('Y-m-d', strtotime($renting->end_duration . "+1 month"))) {
                    $data['title'] = "العميل " . $renting->client->user->first_name .$renting->client->user->last_name. " عليه " . $renting->dept . " جنيه " .
                        "للحجز رقم " . $renting->id;
                    $data['url'] = "/client/-" . $renting->client_id;
                    Notification::create($data);
                }
            }
        }

    }

}
