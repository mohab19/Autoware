<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Utils\Utils;
use App\models\Employee;
use App\models\Employees;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    protected $role;
    protected $role_id;
    protected $utils;
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function PostLogin(LoginRequest $request)
    {
        $auth = false;
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials,$request->has('remember')))
            $auth = true;

        if($request->ajax())
        {
            return response()->json([
                'auth' => $auth,
//                'intended' => URL::previous()
                'intended' => '/dashboard'
            ]);
        }else{
            return redirect()->intended(URL::route('/'));
        }
    }

    public function LogOut()
    {
        Auth::logout();
        return redirect('/');
    }

    public function RegisterUsers(Request $request,$role)
    {
        $this->Validator($request,$role);
        $data = $request->except(['password_confirmation','_token']);
        $data['role_id']  = $this->utils->GetRoleId($role);
        $data['birthdate'] = $data['birthdate']." 00:00:00";
        if(isset($data['password']) )
            $data['password'] = bcrypt($data['password']);

        if(isset($data['salary'])) {
            $salary = $data['salary'];
            unset($data['salary']);
        }

        $user = User::create($data);

        if ($role == "Employee")
            $employee = Employee::create(['user_id' => $user->id,'salary' => $salary , 'month' => date("F"),'year' => date("Y")]);
        if ($user)
            return 1; // user created successfully
        else
            return 0; // something went wrong
    }
    public function UpdateUser(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthdate' => 'required|max:255',
            'phone' => 'required|numeric',
            'password' => 'required|max:255|confirmed'
        ]);
        $user = User::find($request->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->birthdate = $request->birthdate;
        $user->phone = $request->phone;
        $user->national_id = $request->national_id;
        $user->nationality = $request->nationality;
        $user->address = $request->address;
$user->password = bcrypt($request->password);
        $user->update();

    }


    public function Validator($request,$role)
    {
        switch ($role)
        {
            case "Employee":
                $this->validate($request,[
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'birthdate' => 'required|max:255',
                    'phone' => 'required|numeric',
                    'national_id' => 'required|numeric',
                    'salary' => 'required|numeric',
                    'email' => 'required|max:255|email|unique:users',
                    'password' => 'required|max:255|confirmed']);
                break;
            case "Customer":
                $this->validate($request,[
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'birthdate' => 'required|max:255',
                    'phone' => 'required|numeric',
                    'national_id' => 'required|numeric',
                    'nationality' => 'required']);
                break;
            case "Partner":
                $this->validate($request,[
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'birthdate' => 'required|max:255',
                    'phone' => 'required|numeric',
                    'address' => 'required|max:255',
                    'national_id' => 'required|numeric',
                    'email' => 'max:255|email|unique:users']);
                break;
            default:
                break;
        }
    }
    public function Contact(Request $request)
    {
        $this->validate($request,[
            'fullname' => 'required|max:255',
            'message' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|numeric'
        ]);
       /* Mail::send('emailis.send', ['title' => "Contact Us", 'content' => $request->message], function ($message)
        {

            $message->from($request->email,$request->fullname);

            $message->to('karimkhamiss@outlook.com');

        });*/
        if(mail("karim.khamiss@gmail.com" , $request->fullname , $request->message , $request->email))
            return 1;
        else
            return 0;


    }
}
