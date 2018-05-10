<?php

namespace App\Http\Controllers;

use App\models\Car;
use App\models\Cars;
use App\models\InCome;
use App\models\OutCome;
use App\models\Partner;
use App\models\Partners;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PartnersController extends Controller
{
    public $partners_fields = [
        'الأسم',
        'تاريخ الميلاد',
        'رقم التليفون',
        'العنوان',
        'الرقم القومى',
        'ملاحظات'
    ];

    public function NewPartners()
    {

        $cars = Car::where('rental_type_id',1)->get();

        foreach ($cars as $car)
        {
            if(date('d') == date('d',strtotime($car->created_at)))
            {
                $outcome = new OutCome();
                $outcome->outcomes_type_id = 1;
                $outcome->partner_id = $car->partner_id;
                $outcome->car_id = $car->id;
                $outcome->title = "ايجار";
                $outcome->value = $car->renter_value;
                $outcome->save();
            }
        }
    }

    public function GetPartners()
    {

        $employees = User::select(
            'users.*',
            'partners.*')
            ->leftJoin('partners', 'partners.user_id', '=', 'users.id')
            ->where('users.role_id', 2)
            ->get();
        return $employees;
    }

    public function GetPartnersFields()
    {
        return $this->partners_fields;
    }

    public function delete(Request $request)
    {
        $partner = Partner::find($request->id);
        if($partner->cars)
        {
            foreach ($partner->cars as $car)
            {
                foreach ($car->rentings as $renting)
                {
                    if($renting->deleted_at == NULL)
                        return 0;
                }
                foreach ($car->waitings as $waiting)
                {
                    if($waiting->deleted_at == NULL)
                        return 0;
                }
                $car->delete();
            }
        }
        if($partner->delete()) {
            $partner->user->delete();
            return 1;
        }


    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|unique:users',
            'address' => 'required',
            'national_id' => 'required',
        ]);
        $data = $request->except('_token');
        $data['password'] = bcrypt($request->phone);
        $data['role_id'] = 2;
        $data['active'] = 1;
        $user = User::create($data);
        if ($user) {
            $data['user_id'] = $user->id;
            $partner = Partner::create($data);
        }
        if ($partner) {
            return 1;
        }


    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birthdate' => 'required|max:255',
            'phone' => 'required',
            'national_id' => 'required',
            'address' => 'required',
        ]);
        $partner = Partner::find($request->id);
        if($partner->user->email != $request->email)
        {
            $this->validate($request, [
                'email' => 'email|unique:users',
            ]);
        }
        $data = $request->except('_token','id');
        if($partner->user->update($data))
        {
            return 1;
        }
    }

    public function Profile()
    {
        $id = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '-') + 1);
        $partner = Partner::find($id);
        if ($partner) {
            return view('pages.Partner',
                [
                    'partner' => $partner,
                ]);
        } else
            return view('errors.404');

    }

    public function GetCars(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);
        $partner = Partner::find($request->id);
        switch ($request->type) {
            case '1':
                if ($partner->cars)
                    foreach ($partner->cars as $car) {
                        if ($car->rental_type_id == 2) {
                            if (sizeof($car->rentings) == 0) {
                                continue;
                            }
                        }
                        echo "<option value='{$car->id}'>$car->name</option>";
                    }
                break;
            case '2':

                if ($partner->cars)
                    foreach ($partner->cars as $car) {
                        $CarDepts = 0;
                        if (sizeof($car->rentings) > 0) {
                            foreach ($car->rentings as $renting) {
                                if ($renting->dept > 0) {
                                    $CarDepts += $renting->dept;
                                }
                                foreach ($renting->incomes as $income) {
                                    if ($income->incomes_type_id == 2) {
                                        $CarDepts += $income->value;
                                    }
                                }
                            }
                            if ($CarDepts >= 1)
                                echo "<option value='{$car->id}'>$car->name</option>";
                        }
                    }
                break;
        }
    }

    public function GetMonths(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);
        $partner = Partner::find($request->id);
        switch ($request->type) {

            case '1':
                $months = array();
                foreach ($partner->outcomes as $outcome) {
                    if ($request->car_id != 'all')
                        if ($outcome->car_id != $request->car_id)
                            continue;

                    $months[] = date('m', strtotime($outcome->created_at));
                }
                foreach ($partner->incomes as $income) {
                    if ($request->car_id != 'all')
                        if ($income->car_id != $request->car_id)
                            continue;

                    $months[] = date('m', strtotime($income->created_at));
                }
                $months = array_unique($months);
                foreach ($months as $month) {
                    echo "<option value='{$month}'>" . date('F', strtotime('2010' . $month . '01')) . "</option>";
                }
                break;
            case '2':
                $months = array();
                if ($partner->cars)
                    foreach ($partner->cars as $car) {
                        if ($request->car_id != 'all')
                            if ($car->id != $request->car_id)
                                continue;
                        if (sizeof($car->rentings) > 0) {
                            foreach ($car->rentings as $renting) {
                                if ($renting->dept > 0) {
                                    $months[] = date('m', strtotime($renting->created_at));
                                }
                                foreach ($renting->incomes as $income) {
                                    if ($income->incomes_type_id == 2) {
                                        $months[] = date('m', strtotime($income->created_at));
                                    }
                                }
                            }

                        }

                    }
                $months = array_unique($months);
                foreach ($months as $month) {
                    echo "<option value='{$month}'>" . date('F', strtotime('2010' . $month . '01')) . "</option>";
                }

                break;
        }


    }

    public function GetYears(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);
        $partner = Partner::find($request->id);
        switch ($request->type) {
            case '1':
                $years = array();
                foreach ($partner->outcomes as $outcome) {
                    if ($request->car_id != 'all')
                        if ($outcome->car_id != $request->car_id)
                            continue;

                    $years[] = date('Y', strtotime($outcome->created_at));
                }
                foreach ($partner->incomes as $income) {
                    if ($request->car_id != 'all')
                        if ($income->car_id != $request->car_id)
                            continue;

                    $years[] = date('Y', strtotime($income->created_at));
                }
                $years = array_unique($years);
                foreach ($years as $year) {
                    echo "<option value='{$year}'>{$year}</option>";
                }
                break;
            case '2':
                $years = array();
                if ($partner->cars)
                    foreach ($partner->cars as $car) {
                        if ($request->car_id != 'all')
                            if ($car->id != $request->car_id)
                                continue;
                        if (sizeof($car->rentings) > 0) {
                            foreach ($car->rentings as $renting) {
                                if ($renting->dept > 0) {
                                    $years[] = date('Y', strtotime($renting->created_at));
                                }
                                foreach ($renting->incomes as $income) {
                                    if ($income->incomes_type_id == 2) {
                                        $years[] = date('Y', strtotime($income->created_at));
                                    }
                                }
                            }

                        }

                    }
                $years = array_unique($years);
                foreach ($years as $year) {
                    echo "<option value='{$year}'>$year</option>";
                }
                break;
        }


    }

    private function PrintAccountantsTitles()
    {

        echo '
        <table><tr>
            <th>السيارة</th>
            <th>النوع</th>
            <th>عدد الحجوزات</th>
            <th>الاجمالي</th>
            <th>التحصيل</th>
            <th>المصاريف</th>
        </tr>
        ';
    }

    private function PrintDeptsTitles()
    {

        echo '
        <table><tr>
            <th>السيارة</th>
            <th>النوع</th>
            <th>اجمالي الديون</th>
            <th>التحصيل</th>
            <th>التاريخ</th>
        </tr>
        ';
    }

    private function PrintCarTitles()
    {
        echo '
        <table><tr>
            <th>م</th>
            <th>النوع</th>
            <th>العميل</th>
            <th>تاريخ الخروج</th>
            <th>تاريخ الاستلام</th>
            <th>اجمالي الحجز</th>
            <th>التحصيل</th>
            <th>المبلغ من الكيلومترات الزائدة</th>
            <th>التحصيل</th>
        </tr>
        ';
    }

    private function PrintCarDeptTitles()
    {
        echo '
        <table><tr>
            <th>م</th>
            <th>النوع</th>
            <th>العميل</th>
            <th>تاريخ الخروج</th>
            <th>تاريخ الاستلام</th>
            <th>اجمالي الديون</th>
            <th>التحصيل</th>
            <th>التاريخ</th>
        </tr>
        ';
    }

    public function FinalPartner(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'car_id' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        switch ($request->type) {
            case '1':
                if ($request->car_id == 'all' && $request->month == 'all' && $request->year == 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintAccountantsTitles();
                    $ExpensesTotal = 0;
                    $CommissionTotal = 0;
                    $RentingsTotal = 0;
                    $RentingsPaidTotal = 0;
                    $SalaryTotal = 0;
                    foreach ($cars as $car) {
                        $type = "";
                        $CarExpenses = 0;
                        $CarCommission = 0;
                        $CarRentingsTotal = 0;
                        $CarRentingsPaid = 0;
                        if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                            foreach ($car->outcomes as $outcome) {
                                if ($outcome->outcomes_type_id == 1) {
                                    $SalaryTotal += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 2) {
                                    $CommissionTotal += $outcome->value;
                                    $CarCommission += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 5) {
                                    $CarExpenses += $outcome->value;
                                    $ExpensesTotal += $outcome->value;
                                }

                            }
                            foreach ($car->incomes as $income) {
                                if ($income->incomes_type_id == 1) {
                                    $CarRentingsPaid += $income->value;
                                    $RentingsPaidTotal += $income->value;
                                    $CarRentingsTotal += $income->renting->total;
                                    $RentingsTotal += $income->renting->total;
                                }
                               else if ($income->incomes_type_id == 3) {
                                   $CarRentingsPaid += $income->renting->KM_Counter_Penalty_paid;
                                   $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                   $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                                   $CarRentingsTotal += $income->renting->KM_Counter_Penalty_total;
                               }

                            }

                            echo
                            "<tr>
                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                <td>{$car->rental_type->name}</td>
                <td>{$car->rentings->count()}</td>
                <td>$CarRentingsTotal</td>
                <td>$CarRentingsPaid</td>
                <td>$CarExpenses</td>
        </tr>
                        ";

                        }
                    }
                    $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                    $PartnerTotal = $CommissionTotal + $SalaryTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                } elseif ($request->car_id == 'all' && $request->month != 'all' && $request->year == 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintAccountantsTitles();
                    $ExpensesTotal = 0;
                    $CommissionTotal = 0;
                    $RentingsTotal = 0;
                    $RentingsPaidTotal = 0;
                    $SalaryTotal = 0;
                    $EmptyCars = array();
                    foreach ($cars as $car) {
                        $type = "ايجار";
                        $CarExpenses = 0;
                        $CarCommission = 0;
                        $CarRentingsTotal = 0;
                        $CarRentingsPaid = 0;
                        if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                            foreach ($car->outcomes as $outcome) {
                                if (date('m', strtotime($outcome->created_at)) == $request->month) {
                                    if ($outcome->outcomes_type_id == 1) {
                                        $SalaryTotal += $outcome->value;
                                        $type = $outcome->title;
                                    } elseif ($outcome->outcomes_type_id == 2) {
                                        $CommissionTotal += $outcome->value;
                                        $CarCommission += $outcome->value;
                                        $type = $outcome->title;
                                    } elseif ($outcome->outcomes_type_id == 5) {
                                        $CarExpenses += $outcome->value;
                                        $ExpensesTotal += $outcome->value;
                                    }
                                } else
                                    $EmptyCars[] = $outcome->car_id;

                            }
                            foreach ($car->incomes as $income) {
                                if (date('m', strtotime($income->created_at)) == $request->month) {
                                    if ($income->incomes_type_id == 1) {
                                        $CarRentingsPaid += $income->value;
                                        $RentingsPaidTotal += $income->value;
                                        $CarRentingsTotal += $income->renting->total;
                                        $RentingsTotal += $income->renting->total;
                                    }
                                    else if( $income->incomes_type_id == 3)
                                    {
                                            $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                            $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                                    }

                                } else
                                    $EmptyCars[] = $income->car_id;
                            }
                            if (!in_array($car->id, $EmptyCars)) {
                                echo
                                "<tr>
                                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                                <td>{$car->rental_type->name}</td>
                                <td>{$car->rentings->count()}</td>
                                <td>$CarRentingsTotal</td>
                                <td>$CarRentingsPaid</td>
                                <td>$CarExpenses</td>
                        </tr>
                                        ";
                            }


                        }
                    }
                    $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                    $PartnerTotal = $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                } elseif ($request->car_id == 'all' && $request->month == 'all' && $request->year != 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintAccountantsTitles();
                    $ExpensesTotal = 0;
                    $CommissionTotal = 0;
                    $RentingsTotal = 0;
                    $RentingsPaidTotal = 0;
                    $SalaryTotal = 0;
                    $EmptyCars = array();
                    foreach ($cars as $car) {
                        $type = "ايجار";
                        $CarExpenses = 0;
                        $CarCommission = 0;
                        $CarRentingsTotal = 0;
                        $CarRentingsPaid = 0;
                        if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                            foreach ($car->outcomes as $outcome) {
                                if (date('Y', strtotime($outcome->created_at)) == $request->year) {
                                    if ($outcome->outcomes_type_id == 1) {
                                        $SalaryTotal += $outcome->value;
                                        $type = $outcome->title;
                                    } elseif ($outcome->outcomes_type_id == 2) {
                                        $CommissionTotal += $outcome->value;
                                        $CarCommission += $outcome->value;
                                        $type = $outcome->title;
                                    } elseif ($outcome->outcomes_type_id == 5) {
                                        $CarExpenses += $outcome->value;
                                        $ExpensesTotal += $outcome->value;
                                    }
                                } else
                                    $EmptyCars[] = $outcome->car_id;

                            }
                            foreach ($car->incomes as $income) {
                                if (date('Y', strtotime($income->created_at)) == $request->year) {
                                    if ($income->incomes_type_id == 1) {
                                        $CarRentingsPaid += $income->value;
                                        $RentingsPaidTotal += $income->value;
                                        $CarRentingsTotal += $income->renting->total;
                                        $RentingsTotal += $income->renting->total;
                                    }
                                    else if( $income->incomes_type_id == 3)
                                    {
                                            $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                            $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                                             $CarRentingsTotal += $income->renting->KM_Counter_Penalty_paid;

                                    }

                                } else
                                    $EmptyCars[] = $income->car_id;
                            }
                            if (!in_array($car->id, $EmptyCars)) {
                                echo
                                "<tr>
                                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                                <td>{$car->rental_type->name}</td>
                                <td>{$car->rentings->count()}</td>
                                <td>$CarRentingsTotal</td>
                                <td>$CarRentingsPaid</td>
                                <td>$CarExpenses</td>
                        </tr>
                                        ";
                            }


                        }
                    }
                    $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                    $PartnerTotal = $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                } elseif ($request->car_id == 'all' && $request->month != 'all' && $request->year != 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintAccountantsTitles();
                    $ExpensesTotal = 0;
                    $CommissionTotal = 0;
                    $RentingsTotal = 0;
                    $RentingsPaidTotal = 0;
                    $SalaryTotal = 0;
                    $EmptyCars = array();
                    foreach ($cars as $car) {
                        $type = "ايجار";
                        $CarExpenses = 0;
                        $CarCommission = 0;
                        $CarRentingsTotal = 0;
                        $CarRentingsPaid = 0;
                        if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                            foreach ($car->outcomes as $outcome) {
                                if (date('Y', strtotime($outcome->created_at)) == $request->year && date('m', strtotime($outcome->created_at)) == $request->month) {
                                    if ($outcome->outcomes_type_id == 1) {
                                        $SalaryTotal += $outcome->value;
                                        $type = $outcome->title;
                                    } elseif ($outcome->outcomes_type_id == 2) {
                                        $CommissionTotal += $outcome->value;
                                        $CarCommission += $outcome->value;
                                        $type = $outcome->title;
                                    } elseif ($outcome->outcomes_type_id == 5) {
                                        $CarExpenses += $outcome->value;
                                        $ExpensesTotal += $outcome->value;
                                    }
                                } else
                                    $EmptyCars[] = $outcome->car_id;

                            }
                            foreach ($car->incomes as $income) {
                                if (date('Y', strtotime($income->created_at)) == $request->year && date('m', strtotime($income->created_at)) == $request->month) {
                                    if ($income->incomes_type_id == 1) {
                                        $CarRentingsPaid += $income->value;
                                        $RentingsPaidTotal += $income->value;
                                        $CarRentingsTotal += $income->renting->total;
                                        $RentingsTotal += $income->renting->total;
                                    }
                                    else if( $income->incomes_type_id == 3)
                                    {
                                            $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                            $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                                            $CarRentingsTotal += $income->renting->KM_Counter_Penalty_paid;
                                    }

                                } else
                                    $EmptyCars[] = $income->car_id;
                            }
                            if (!in_array($car->id, $EmptyCars)) {
                                echo
                                "<tr>
                                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                                <td>{$car->rental_type->name}</td>
                                <td>{$car->rentings->count()}</td>
                                <td>$CarRentingsTotal</td>
                                <td>$CarRentingsPaid</td>
                                <td>$CarExpenses</td>
                        </tr>
                                        ";
                            }


                        }
                    }
                    $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                    $PartnerTotal = $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                } elseif ($request->car_id != 'all' && $request->month == 'all' && $request->year == 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarTitles();
                    if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                        $type = "";
                        $ExpensesTotal = 0;
                        $CommissionTotal = 0;
                        $RentingsTotal = 0;
                        $RentingsPaidTotal = 0;
                        $SalaryTotal = 0;
                        foreach ($car->outcomes as $outcome) {

                            if ($outcome->outcomes_type_id == 1) {

                                $SalaryTotal += $outcome->value;
                                $type = $outcome->title;
                            } elseif ($outcome->outcomes_type_id == 2) {
                                $CommissionTotal += $outcome->value;
                                $type = $outcome->title;
                            } elseif ($outcome->outcomes_type_id == 5)
                                $ExpensesTotal += $outcome->value;
                        }
                        foreach ($car->incomes as $income) {
                            if ($income->incomes_type_id == 1) {
                                $RentingsPaidTotal += $income->value;
                                $RentingsTotal += $income->renting->total;
                            }
                            else if( $income->incomes_type_id == 3)
                            {
                                $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                            }
                        }

                        $counter = 1;
                        foreach ($car->rentings as $renting) {
                            echo
                            "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$renting->total</td>
                <td>$renting->paid</td>
                <td>$renting->KM_Counter_Penalty_total</td>
                <td>$renting->KM_Counter_Penalty_paid</td>
        </tr>
                        ";
                            $counter++;
                        }
                        $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                        $PartnerTotal = $CommissionTotal + $SalaryTotal;
                        echo "</table> <div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                    }
                } elseif ($request->car_id != 'all' && $request->month != 'all' && $request->year == 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarTitles();
                    if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                        $type = "";
                        $ExpensesTotal = 0;
                        $CommissionTotal = 0;
                        $RentingsTotal = 0;
                        $RentingsPaidTotal = 0;
                        $SalaryTotal = 0;
                        $EmptyRentings = array();
                        foreach ($car->outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month) {

                                if ($outcome->outcomes_type_id == 1) {
                                    $SalaryTotal += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 2) {
                                    $CommissionTotal += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 5)
                                    $ExpensesTotal += $outcome->value;
                            } else
                                $EmptyRentings[] = $outcome->renting_id;


                        }
                        foreach ($car->incomes as $income) {
                            if ($income->incomes_type_id == 1) {
                                if (date('m', strtotime($income->created_at)) == $request->month) {
                                    $RentingsPaidTotal += $income->value;
                                    $RentingsTotal += $income->renting->total;

                                    }
                                }
                            else if( $income->incomes_type_id == 3)
                            {
                                if (date('m', strtotime($income->created_at)) == $request->month) {
                                    $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                    $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                                }
                            }
                            else
                                    $EmptyRentings[] = $income->renting_id;
                            }
                        $counter = 1;

                        foreach ($car->rentings as $renting) {
                            if (!in_array($renting->id, $EmptyRentings)) {

                                echo
                                "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$renting->total</td>
                <td>$renting->paid</td>
                <td>$renting->KM_Counter_Penalty_total</td>
                <td>$renting->KM_Counter_Penalty_paid</td>
        </tr>
                        ";
                                $counter++;
                            }


                        }
                        $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                        $PartnerTotal = $CommissionTotal + $SalaryTotal;
                        echo "</table> <div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                    }
                } elseif ($request->car_id != 'all' && $request->month == 'all' && $request->year != 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarTitles();
                    $EmptyRentings = array();
                    if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                        $type = "";
                        $ExpensesTotal = 0;
                        $CommissionTotal = 0;
                        $RentingsTotal = 0;
                        $RentingsPaidTotal = 0;
                        $SalaryTotal = 0;
                        foreach ($car->outcomes as $outcome) {
                            if (date('Y', strtotime($outcome->created_at)) == $request->year) {
                                if ($outcome->outcomes_type_id == 1) {
                                    $SalaryTotal += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 2) {
                                    $CommissionTotal += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 5)
                                    $ExpensesTotal += $outcome->value;
                            } else
                                $EmptyRentings[] = $outcome->renting_id;

                        }
                        foreach ($car->incomes as $income) {
                            if ($income->incomes_type_id == 1) {
                                if (date('Y', strtotime($income->created_at)) == $request->year) {
                                    $RentingsPaidTotal += $income->value;
                                    $RentingsTotal += $income->renting->total;
                                }
                                else if( $income->incomes_type_id == 3)
                                {
                                    if (date('Y', strtotime($income->created_at)) == $request->year) {
                                        $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                        $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                                    }
                                }
                                else
                                    $EmptyRentings[] = $income->renting_id;
                            }
                        }
                        $counter = 1;
                        foreach ($car->rentings as $renting) {
                            if (!in_array($renting->id, $EmptyRentings)) {
                                echo
                                "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$renting->total</td>
                <td>$renting->paid</td>
                <td>$renting->KM_Counter_Penalty_total</td>
                <td>$renting->KM_Counter_Penalty_paid</td>
        </tr>
                        ";
                                $counter++;
                            }
                        }
                        $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                        $PartnerTotal = $CommissionTotal + $SalaryTotal;
                        echo "</table> <div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                    }
                } elseif ($request->car_id != 'all' && $request->month != 'all' && $request->year != 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarTitles();
                    $EmptyRentings = array();
                    if (sizeof($car->outcomes) > 0 || sizeof($car->incomes) > 0) {
                        $type = "";
                        $ExpensesTotal = 0;
                        $CommissionTotal = 0;
                        $RentingsTotal = 0;
                        $RentingsPaidTotal = 0;
                        $SalaryTotal = 0;
                        foreach ($car->outcomes as $outcome) {
                            if (date('Y', strtotime($outcome->created_at)) == $request->year && date('m', strtotime($outcome->created_at)) == $request->month) {
                                if ($outcome->outcomes_type_id == 1) {
                                    $SalaryTotal += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 2) {
                                    $CommissionTotal += $outcome->value;
                                    $type = $outcome->title;
                                } elseif ($outcome->outcomes_type_id == 5)
                                    $ExpensesTotal += $outcome->value;
                            } else
                                $EmptyRentings[] = $outcome->renting_id;

                        }
                        foreach ($car->incomes as $income) {
                            if ($income->incomes_type_id == 1) {
                                if (date('Y', strtotime($income->created_at)) == $request->year && date('m', strtotime($income->created_at)) == $request->month) {
                                    $RentingsPaidTotal += $income->value;
                                    $RentingsTotal += $income->renting->total;
                                }
                                else if( $income->incomes_type_id == 3)
                                {
                                    if (date('Y', strtotime($income->created_at)) == $request->year && date('m', strtotime($income->created_at)) == $request->month) {
                                        $RentingsPaidTotal += $income->renting->KM_Counter_Penalty_paid;
                                        $RentingsTotal += $income->renting->KM_Counter_Penalty_total;
                                    }
                                }
                                else
                                    $EmptyRentings[] = $income->renting_id;
                            }
                        }
                        $counter = 1;
                        foreach ($car->rentings as $renting) {
                            if (!in_array($renting->id, $EmptyRentings)) {
                                echo
                                "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$renting->total</td>
                <td>$renting->paid</td>
                <td>$renting->KM_Counter_Penalty_total</td>
                <td>$renting->KM_Counter_Penalty_paid</td>
        </tr>
                        ";
                                $counter++;
                            }
                        }
                        $CompanyTotal = $RentingsPaidTotal - $CommissionTotal;
                        $PartnerTotal = $CommissionTotal + $SalaryTotal;
                        echo "</table> <div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$RentingsPaidTotal</div>
                    <div class='title'>الدخل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                        <div class='num'>$PartnerTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red' id='Expenses'>
                    <div class='num'>$ExpensesTotal</div>
                    <div class='title'>المصاريف</div>
                </div>
            </div>
        </div>";
                    }
                }

                break;

            case '2':

                if ($request->car_id == 'all' && $request->month == 'all' && $request->year == 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintDeptsTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    foreach ($cars as $car) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                        foreach ($car->rentings as $renting) {
                            if ($renting->dept > 0)
                                $CarDepts += $renting->dept;
                            else
                                $tempDept += $renting->dept;

                            foreach ($renting->outcomes as $outcome) {
                                if ($outcome->outcomes_type_id == 7) {
                                    $CommissionTotal += $outcome->value;
                                }
                            }
                            foreach ($renting->incomes as $income) {
                                if ($income->incomes_type_id == 2) {
                                    $CarDepts += $income->value;
                                    $PaidTotal += $income->value;
                                    $CarPaid += $income->value;
                                    $date = $income->paid_date;
                                }
                            }

                        }
                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            if ($car->rental_type_id == 1)
                                $type = "ايجار";
                            else
                                $type = "عمولة";
                            echo
                            "<tr>
                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                <td>{$car->rental_type->name}</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }


                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                if ($request->car_id == 'all' && $request->month != 'all' && $request->year == 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintDeptsTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    foreach ($cars as $car) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                        foreach ($car->rentings as $renting) {
                            if ($renting->dept > 0) {
                                if (date("m", strtotime($renting->created_at)) == $request->month) {
                                    $CarDepts += $renting->dept;
                                    foreach ($renting->incomes as $income) {
                                        if (date("Y", strtotime($income->created_at)) != $request->year)
                                            if ($income->incomes_type_id == 2) {
                                                $CarDepts += $income->value;
                                            }
                                    }
                                } else
                                    $tempDept += $renting->dept;
                            }
                            foreach ($renting->outcomes as $outcome) {
                                if ($outcome->outcomes_type_id == 7) {
                                    if (date("m", strtotime($outcome->created_at)) == $request->month) {
                                        $CommissionTotal += $outcome->value;
                                    }
                                }
                            }
                            foreach ($renting->incomes as $income) {
                                if ($income->incomes_type_id == 2) {
                                    if (date("m", strtotime($income->created_at)) == $request->month) {
                                        $CarDepts += $income->value;
                                        $PaidTotal += $income->value;
                                        $CarPaid += $income->value;
                                        $date = $income->paid_date;
                                    }
                                }
                            }


                        }
                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            if ($car->rental_type_id == 1)
                                $type = "ايجار";
                            else
                                $type = "عمولة";
                            echo
                            "<tr>
                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                <td>{$car->rental_type->name}</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }


                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                if ($request->car_id == 'all' && $request->month == 'all' && $request->year != 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintDeptsTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    foreach ($cars as $car) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                        foreach ($car->rentings as $renting) {
                            if ($renting->dept > 0) {
                                if (date("Y", strtotime($renting->created_at)) == $request->year) {
                                    $CarDepts += $renting->dept;
                                    foreach ($renting->incomes as $income) {
                                        if (date("Y", strtotime($income->created_at)) != $request->year)
                                            if ($income->incomes_type_id == 2) {
                                                $CarDepts += $income->value;
                                            }
                                    }
                                } else
                                    $tempDept += $renting->dept;
                            }
                            foreach ($renting->outcomes as $outcome) {
                                if ($outcome->outcomes_type_id == 7) {
                                    if (date("Y", strtotime($outcome->created_at)) == $request->year) {
                                        $CommissionTotal += $outcome->value;
                                    }
                                }
                            }
                            foreach ($renting->incomes as $income) {
                                if ($income->incomes_type_id == 2) {
                                    if (date("Y", strtotime($income->created_at)) == $request->year) {
                                        $CarDepts += $income->value;
                                        $PaidTotal += $income->value;
                                        $CarPaid += $income->value;
                                        $date = $income->paid_date;
                                    }
                                }
                            }


                        }
                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            if ($car->rental_type_id == 1)
                                $type = "ايجار";
                            else
                                $type = "عمولة";
                            echo
                            "<tr>
                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                <td>{$car->rental_type->name}</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }


                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                if ($request->car_id == 'all' && $request->month != 'all' && $request->year != 'all') {
                    $cars = Car::withTrashed()->where('partner_id', $request->id)
                        ->get();
                    $this->PrintDeptsTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    foreach ($cars as $car) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                        foreach ($car->rentings as $renting) {
                            if ($renting->dept > 0) {
                                if (date("Y", strtotime($renting->created_at)) == $request->year && date("m", strtotime($renting->created_at)) == $request->month) {
                                    $CarDepts += $renting->dept;
                                    foreach ($renting->incomes as $income) {
                                        if (date("Y", strtotime($income->created_at)) != $request->year || date("m", strtotime($income->created_at)) != $request->month)
                                            if ($income->incomes_type_id == 2) {
                                                $CarDepts += $income->value;
                                            }
                                    }
                                } else
                                    $tempDept += $renting->dept;
                            }
                            foreach ($renting->outcomes as $outcome) {
                                if ($outcome->outcomes_type_id == 7) {
                                    if (date("Y", strtotime($outcome->created_at)) == $request->year && date("m", strtotime($outcome->created_at)) == $request->month) {
                                        $CommissionTotal += $outcome->value;
                                    }
                                }
                            }
                            foreach ($renting->incomes as $income) {
                                if ($income->incomes_type_id == 2) {
                                    if (date("Y", strtotime($income->created_at)) == $request->year && date("m", strtotime($income->created_at)) == $request->month) {
                                        $CarDepts += $income->value;
                                        $PaidTotal += $income->value;
                                        $CarPaid += $income->value;
                                        $date = $income->paid_date;
                                    }
                                }
                            }


                        }
                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            if ($car->rental_type_id == 1)
                                $type = "ايجار";
                            else
                                $type = "عمولة";
                            echo
                            "<tr>
                <td><a target='_blank' href='/car/-{$car->id}'>{$car->name}</a></td>
                <td>{$car->rental_type->name}</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }


                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                if ($request->car_id != 'all' && $request->month == 'all' && $request->year == 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarDeptTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    $counter = 1;
                    if ($car->rental_type_id == 1)
                        $type = "ايجار";
                    else
                        $type = "عمولة";
                    foreach ($car->rentings as $renting) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                    if ($renting->dept > 0)
                        $CarDepts += $renting->dept;
                    else
                        $tempDept += $renting->dept;

                    foreach ($renting->outcomes as $outcome) {
                        if ($outcome->outcomes_type_id == 7) {
                            $CommissionTotal += $outcome->value;
                        }
                    }
                    foreach ($renting->incomes as $income) {
                        if ($income->incomes_type_id == 2) {
                            $CarDepts += $income->value;
                            $PaidTotal += $income->value;
                            $CarPaid += $income->value;
                            $date = $income->paid_date;
                        }
                    }


                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            echo
                            "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }
                        $counter++;
                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                if ($request->car_id != 'all' && $request->month != 'all' && $request->year == 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarDeptTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    $counter = 1;
                    if ($car->rental_type_id == 1)
                        $type = "ايجار";
                    else
                        $type = "عمولة";
                    foreach ($car->rentings as $renting) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                        if ($renting->dept > 0) {
                            if (date("m", strtotime($renting->created_at)) == $request->month) {

                                $CarDepts += $renting->dept;
                                foreach ($renting->incomes as $income) {
                                    if (date("m", strtotime($income->created_at)) != $request->month)
                                        if ($income->incomes_type_id == 2) {
                                            $CarDepts += $income->value;
                                        }
                                }
                            } else
                                $tempDept += $renting->dept;
                        }
                        foreach ($renting->outcomes as $outcome) {
                            if ($outcome->outcomes_type_id == 7) {
                                if (date("m", strtotime($outcome->created_at)) == $request->month) {
                                    $CommissionTotal += $outcome->value;
                                }
                            }
                        }
                        foreach ($renting->incomes as $income) {
                            if ($income->incomes_type_id == 2) {
                                if (date("m", strtotime($income->created_at)) == $request->month) {
                                    $CarDepts += $income->value;
                                    $PaidTotal += $income->value;
                                    $CarPaid += $income->value;
                                    $date = $income->paid_date;
                                }
                            }
                        }
                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            echo
                            "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }
                        $counter++;
                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                if ($request->car_id != 'all' && $request->month == 'all' && $request->year != 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarDeptTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    $counter = 1;
                    if ($car->rental_type_id == 1)
                        $type = "ايجار";
                    else
                        $type = "عمولة";
                    foreach ($car->rentings as $renting) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                        if ($renting->dept > 0) {
                            if (date("Y", strtotime($renting->created_at)) == $request->year) {
                                $CarDepts += $renting->dept;
                                foreach ($renting->incomes as $income) {
                                    if (date("Y", strtotime($income->created_at)) != $request->year)
                                        if ($income->incomes_type_id == 2) {
                                            $CarDepts += $income->value;
                                        }
                                }
                            } else
                                $tempDept += $renting->dept;
                        }
                        foreach ($renting->outcomes as $outcome) {
                            if ($outcome->outcomes_type_id == 7) {
                                if (date("Y", strtotime($outcome->created_at)) == $request->year) {
                                    $CommissionTotal += $outcome->value;
                                }
                            }
                        }
                        foreach ($renting->incomes as $income) {
                            if ($income->incomes_type_id == 2) {
                                if (date("Y", strtotime($income->created_at)) == $request->year) {
                                    $CarDepts += $income->value;
                                    $PaidTotal += $income->value;
                                    $CarPaid += $income->value;
                                    $date = $income->paid_date;
                                }
                            }
                        }

                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            echo
                            "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }
                        $counter++;
                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                if ($request->car_id != 'all' && $request->month != 'all' && $request->year != 'all') {
                    $car = Car::withTrashed()->find($request->car_id);
                    $this->PrintCarDeptTitles();
                    $DeptsTotal = 0;
                    $CommissionTotal = 0;
                    $PaidTotal = 0;
                    $counter = 1;
                    if ($car->rental_type_id == 1)
                        $type = "ايجار";
                    else
                        $type = "عمولة";
                    foreach ($car->rentings as $renting) {
                        $date = "---";
                        $CarDepts = 0;
                        $tempDept = 0;
                        $CarPaid = 0;
                        if ($renting->dept > 0) {
                            if (date("Y", strtotime($renting->created_at)) == $request->year && date("m", strtotime($renting->created_at)) == $request->month) {
                                $CarDepts += $renting->dept;
                                foreach ($renting->incomes as $income) {
                                    if (date("Y", strtotime($income->created_at)) != $request->year || date("m", strtotime($income->created_at)) != $request->month)
                                        if ($income->incomes_type_id == 2) {
                                            $CarDepts += $income->value;
                                        }
                                }
                            } else
                                $tempDept += $renting->dept;
                        }
                        foreach ($renting->outcomes as $outcome) {
                            if ($outcome->outcomes_type_id == 7) {
                                if (date("Y", strtotime($outcome->created_at)) == $request->year && date("m", strtotime($outcome->created_at)) == $request->month) {
                                    $CommissionTotal += $outcome->value;
                                }
                            }
                        }
                        foreach ($renting->incomes as $income) {
                            if ($income->incomes_type_id == 2) {
                                if (date("Y", strtotime($income->created_at)) == $request->year && date("m", strtotime($income->created_at)) == $request->month) {
                                    $CarDepts += $income->value;
                                    $PaidTotal += $income->value;
                                    $CarPaid += $income->value;
                                    $date = $income->paid_date;
                                }
                            }
                        }

                        if ($CarDepts) {
                            $CarDepts += $tempDept;
                            $DeptsTotal += $CarDepts;
                            echo
                            "<tr>
                <td>$counter</td>
                <td>{$car->rental_type->name}</td>
                <td><a target='_blank' href='/client/-{$renting->client_id}'>{$renting->client->user->display_name}</a></td>
                <td>$renting->start</td>
                <td>$renting->end</td>
                <td>$CarDepts</td>
                <td>$CarPaid</td>
                <td>$date</td>
        </tr>
                        ";
                        }
                        $counter++;
                    }

                    $CompanyTotal = $PaidTotal - $CommissionTotal;
                    echo "</table>";
                    echo "<div class='statistics'>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$DeptsTotal</div>
                    <div class='title'>اجمالي الديون</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$PaidTotal</div>
                    <div class='title'>اجمالي التحصيل</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CompanyTotal</div>
                    <div class='title'>مستحقات الشركة</div>
                </div>
            </div>
            <div class='item col-md-3 col-xs-6'>
                <div class='box box-red'>
                    <div class='num'>$CommissionTotal</div>
                    <div class='title'>مستحقات المالك</div>
                </div>
            </div>
        </div>";
                }
                break;
        }


    }

}