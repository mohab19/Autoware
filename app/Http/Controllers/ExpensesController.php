<?php

namespace App\Http\Controllers;

use App\models\Expenses;

use App\models\OutCome;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{

    public $ExpensesFields = [
        'العنوان',
        'القيمة',
    ];
    public function GetExpensesFields()
    {
        return $this->ExpensesFields;
    }
    public function GetGeneralExpenses()
   {
        $general_expenses = OutCome::where("outcomes_type_id",6)->get();
        return $general_expenses;
   }
    public function GetCarExpenses($id)
    {
        $general_expenses = OutCome::where("outcomes_type_id",5)->get();
        return $general_expenses;
    }
    public function AddGeneral(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'value' => 'required|numeric',
        ]);
        $outcome = new OutCome();
        $outcome->title=$request->title;
        $outcome->value=$request->value;
        $outcome->outcomes_type_id=6;
        $outcome->user_id=Auth::user()->id;
        $outcome->save();

    }
    public function Delete(Request $request)
    {
        $data = $request;
        $expense = OutCome::where('id',$data['id'])->first();
        $expense->forcedelete();
    }
    public function Update(Request $request)
    {
        $expense = OutCome::find($request->id);
        $expense->title = $request->title;
        $expense->value = $request->value;
        $expense->update();
    }
    public function AddCar(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'value' => 'required|numeric',
        ]);
        $outcome = new OutCome();
        $outcome->title=$request->title;
        $outcome->value=$request->value;
        $outcome->outcomes_type_id=5;
        $outcome->user_id=Auth::user()->id;
        $outcome->car_id=$request->car_id;
        $outcome->save();
    }

}
