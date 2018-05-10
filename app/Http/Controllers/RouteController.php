<?php

namespace App\Http\Controllers;


use App\models\Notification;
use App\models\Roles;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RouteController extends Controller
{

    public $user;
    public $role;
    public $notifications;
    public function __construct()
    {
        $this->user = Auth::user();
        $this->role = Roles::class;
    }

    public function index()
    {
        $user = Auth::user();
        if(isset($user))
            return view('pages.index',['user' => $user]);
        else
            return view('pages.index');
    }
    public function login()
    {
        $user = Auth::user();
        if(isset($user))
            return view('pages.index',['user' => $user]);
        else
            return view('pages.login');
    }

    public function Dashboard()
    {
        if(Gate::allows('admin',$this->role)) {
            return redirect('/overview');
        }
        else if(Gate::allows('partner',$this->role)) {
            return redirect('/PartnerPanel');
        }
        else if (Gate::allows('employee',$this->role)) {
            return redirect('/quickaccess');
        }
        else {
            return redirect('/login');
        }
    }
}
