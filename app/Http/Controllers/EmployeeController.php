<?php

namespace App\Http\Controllers;

use App\models\Employee;
use App\models\Employees;
use App\models\OutCome;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class EmployeeController extends Controller
{

    public $employee_fields = [
        'الأسم',
        'تاريخ الميلاد',
        'رقم التليفون',
        'العنوان',
        'الرقم القومى',
        'المرتب',
    ];
    public function NewEmployees()
    {

        $employees = Employee::get();
        foreach ($employees as $employee)
        {
            $outcome = new OutCome();
            $outcome->outcomes_type_id = 3;
            $outcome->employee_id = $employee->id;
            $outcome->value = $employee->salary;
            $outcome->save();

        }
    }
    public function GetEmployees()
    {

        $employees = User::select(
            'users.*',
            'employees.*')
            ->leftJoin('employees','employees.user_id','=','users.id')
            ->where('users.role_id',3)
            ->get();
        return $employees;
    }

    public function GetEmployeeFields()
    {
        return $this->employee_fields;
    }
    public function add(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthdate' => 'required|max:255',
            'phone' => 'required|numeric',
            'salary' => 'required|numeric',
            'national_id' => 'required',
            'email' => 'required|unique:users',
            'address' => 'required'
        ]);
        $data = $request->except('_token');
        $data['password'] = bcrypt($request->phone);
        $data['role_id'] = 3;
        $data['active'] = 1;
        $user = User::create($data);
        if($user)
        {
            $data['user_id'] = $user->id;
            $employee = Employee::create($data);
        }
        if($employee)
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
            'salary' => 'required|numeric',
            'national_id' => 'required',
            'email' => 'required|email',
            'address' => 'required'

        ]);
        $data = $request->except('_token');
        $employee = Employee::find($request->id);
        if($employee)
        {
            $employee->update($data);
            $employee->user->update($data);
            $employee->save();
            $employee->user->save();
        }
//        if($employee->salary != $request->salary) {
//            if (date('m', strtotime($employee->month)) != date('m') || $employee->year != date('Y')) {
//                $NewEmployee = $employee->replicate();
//                $employee->delete();
//                $NewEmployee->salary = $request->salary;
//                $NewEmployee->month = date("F");
//                $NewEmployee->year = date("Y");
//                $NewEmployee->save();
//            }
//            else {
//                $employee->salary = $request->salary;
//                $employee->save();
//
//            }
//        }
//        else
//            $employee->save();


    }
    public function delete(Request $request)
    {
         $employee = Employee::find($request->id);
         if($employee)
         {
             if($employee->delete())
             if($employee->user->delete())
                 return 1;
         }
    }
    public function AddPenalty(Request $request)
    {
        $this->validate($request,[
            'value' => 'required|numeric',
        ]);
        $data = $request->except('_token');
        $data['outcomes_type_id'] = 4;
        $employee = OutCome::create($data);
        if($employee)
            return 1;
        else
            return 0;
    }
    public function Profile()
    {

        $id = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '-')+1);
        $employee = Employee::find($id);
        if($employee)
        {
            $penalties = OutCome::where('employee_id',$id)->where('outcomes_type_id',4)->withTrashed()->get();
            $salaries = OutCome::where('employee_id',$id)->where('outcomes_type_id',3)->withTrashed()->get();
            return view('pages.EmployeeProfile',
                [
                    'employee'=>$employee,
                    'penalties'=>$penalties,
                    'salaries'=>$salaries,
                    'TotalPenalty'=>0,
                ]);
        }
        else
            return view('errors.404');

    }
}
