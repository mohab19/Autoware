<?php

namespace App\Http\Controllers;

use App\models\Attachment;
use App\models\Roles;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\models\Attachments;



class AttachmentsController extends Controller
{

    public $user;
    public $clients;
    public $cars;
    public $reservation;
    public $app_url;
    public $photo_directory;
    public function __construct()
    {
        $this->app_url = url()->to('/');
        $this->photo_directory = 'Cars';
        $this->user = Auth::user();
        $this->clients = new ClientsController();
        $this->cars = new CarsController();
        $this->reservation = new ReservationController();
    }
    public function Car(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
        ]);
        $attachment = new Attachment();
        $attachment->save();
        $attachment->car_id = $request->id;
        $attachment->title=$request->title;
        $request->picture = $this->cars->AddCarImage($request,$request->title."-".$attachment->id , $attachment->car_id , $attachment);
        $attachment->value=$request->picture;
        $attachment->update();
    }
    public function Client(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
        ]);
        $attachment = new Attachment();
        $attachment->save();
        $attachment->user_id = $request->user_id;
        $attachment->title=$request->title;
        $request->picture = $this->clients->AddUserImage($request,$request->title."-".$attachment->id, $attachment->user_id);
        $attachment->value=$request->picture;
        $attachment->update();
    }
    public function Delete(Request $request)
    {
        $attachment = Attachment::find($request->id);
        $upload_to = app_path() . '/../public/'.$this->photo_directory."/".$request->car_id ."/attachments/".$request->id;
        if(is_dir($upload_to))
            $this->cars->RemoveFolder($upload_to);
        $attachment->forcedelete();
    }

}
