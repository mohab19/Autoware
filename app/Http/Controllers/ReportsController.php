<?php
/**
 * Created by PhpStorm.
 * User: karim
 * Date: 01/08/16
 * Time: 09:18 م
 */

namespace App\Http\Controllers;

use App\models\Car;
use App\models\Employee;
use App\models\InCome;
use App\models\OutCome;
use App\models\Partner;
use App\models\Renting;
use Illuminate\Http\Request;
use App\models\Partners;
use App\models\Paying;
use App\User;
use App\models\Employees;
use App\models\Cars;
use App\models\Rentings;
use App\models\Expenses;

class ReportsController extends Controller
{
    public $ExpensesController;

    public function __construct()
    {
        $this->ExpensesController = new ExpensesController();
    }

    public function GetMonths(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);
        switch ($request->type) {

            case 'partners':
                $outcomes = OutCome::where('outcomes_type_id',1)->
                    orwhere('outcomes_type_id',2)->
                    orwhere('outcomes_type_id',7)->get();
                $months = array();
                foreach ($outcomes as $outcome) {
                    $months[] = date('m', strtotime($outcome->created_at));
                }
                $months = array_unique($months);
                foreach ($months as $month) {
                    echo "<option value='{$month}'>" . date('F', strtotime('2010' . $month . '01')) . "</option>";
                }
                break;
            case 'employees':
                $outcomes = OutCome::where('outcomes_type_id',3)->
                orwhere('outcomes_type_id',4)->get();
                $months = array();
                foreach ($outcomes as $outcome) {
                    $months[] = date('m', strtotime($outcome->created_at));
                }
                $months = array_unique($months);
                foreach ($months as $month) {
                    echo "<option value='{$month}'>" . date('F', strtotime('2010' . $month . '01')) . "</option>";
                }
                break;
            case 'outcomes':
                $outcomes = OutCome::withTrashed()->get();
                $months = array();
                foreach ($outcomes as $outcome) {
                    $months[] = date('m', strtotime($outcome->created_at));
                }
                $months = array_unique($months);
                foreach ($months as $month) {
                    echo "<option value='{$month}'>" . date('F', strtotime('2010' . $month . '01')) . "</option>";
                }
                break;
            case 'incomes':
                $incomes = InCome::withTrashed()->get();
                $months = array();
                foreach ($incomes as $income) {
                    $months[] = date('m', strtotime($income->created_at));
                }
                $months = array_unique($months);
                foreach ($months as $month) {
                    echo "<option value='{$month}'>" . date('F', strtotime('2010' . $month . '01')) . "</option>";
                }
                break;
            case 'depts':
                $rentings = Renting::withTrashed()->get();
                $months = array();
                foreach ($rentings as $renting) {
                    if($renting->dept>0)
                    $months[] = date('m', strtotime($renting->created_at));
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
        switch ($request->type) {

            case 'partners':
                $outcomes = OutCome::where('outcomes_type_id',1)->
                orwhere('outcomes_type_id',2)->
                orwhere('outcomes_type_id',7)->get();
                $years = array();
                foreach ($outcomes as $outcome) {
                    $years[] = date('Y', strtotime($outcome->created_at));
                }
                $years = array_unique($years);
                foreach ($years as $year) {
                    echo "<option value='{$year}'>$year</option>";
                }
                break;
            case 'employees':
                $outcomes = OutCome::where('outcomes_type_id',3)->
                orwhere('outcomes_type_id',4)->get();
                $years = array();
                foreach ($outcomes as $outcome) {
                    $years[] = date('Y', strtotime($outcome->created_at));
                }
                $years = array_unique($years);
                foreach ($years as $year) {
                    echo "<option value='{$year}'>$year</option>";
                }
                break;
            case 'outcomes':
                $outcomes = OutCome::withTrashed()->get();
                $years = array();
                foreach ($outcomes as $outcome) {
                    $years[] = date('Y', strtotime($outcome->created_at));
                }
                $years = array_unique($years);
                foreach ($years as $year) {
                    echo "<option value='{$year}'>$year</option>";
                }
                break;
            case 'incomes':
                $incomes = InCome::withTrashed()->get();
                $years = array();
                foreach ($incomes as $income) {
                    $years[] = date('Y', strtotime($income->created_at));
                }
                $years = array_unique($years);
                foreach ($years as $year) {
                    echo "<option value='{$year}'>$year</option>";
                }
                break;
            case 'depts':
                $rentings = Renting::withTrashed()->get();
                $years = array();
                foreach ($rentings as $renting) {
                    if($renting->dept>0)
                        $years[] = date('Y', strtotime($renting->created_at));
                }
                $years = array_unique($years);
                foreach ($years as $year) {
                    echo "<option value='{$year}'>$year</option>";
                }
                break;
        }

    }
    public function FinalReport(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);
        $Total = $this->GetTotal($request);
        switch ($request->type) {
            case 'partners':
                if ($request->month == 'all' && $request->year == 'all') {
                    $partners = Partner::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المبلغ</th>
<th>تاريخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    $partner_total=0;
                    foreach ($partners as $partner)
                    {
                        $partner_total=0;
                        foreach ($partner->outcomes as $outcome) {
                            $total += $outcome->value;
                            $partner_total += $outcome->value;
                            $date = $outcome->date;

                        }
                        if($partner_total > 0)
                        {
                            echo "<tr>
<td><a href='/partner/-{$partner->id}'>{$partner->display_name}</a></td>
<td>{$partner_total}</td>
<td>{$date}</td>
</tr>";
                        }

                    }

                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['partners']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month != 'all' && $request->year == 'all') {
                    $partners = Partner::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المبلغ</th>
<th>تاريخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    $partner_total=0;
                    foreach ($partners as $partner)
                    {
                        $partner_total=0;
                        foreach ($partner->outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month) {
                                $total += $outcome->value;
                                $partner_total += $outcome->value;
                                $date = $outcome->date;
                            }

                        }
                        if($partner_total > 0)
                        {
                            echo "<tr>
<td><a href='/partner/-{$partner->id}'>{$partner->display_name}</a></td>
<td>{$partner_total}</td>
<td>{$date}</td>
</tr>";
                        }
                    }

                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['partners']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month == 'all' && $request->year != 'all') {
                    $partners = Partner::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المبلغ</th>
<th>تاريخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    $partner_total=0;
                    foreach ($partners as $partner)
                    {
                        $partner_total=0;
                        foreach ($partner->outcomes as $outcome) {
                            if (date('Y', strtotime($outcome->created_at)) == $request->year) {
                                $total += $outcome->value;
                                $partner_total += $outcome->value;
                                $date = $outcome->date;
                            }

                        }
                        if($partner_total > 0)
                        {
                            echo "<tr>
<td><a href='/partner/-{$partner->id}'>{$partner->display_name}</a></td>
<td>{$partner_total}</td>
<td>{$date}</td>
</tr>";
                        }
                    }

                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['partners']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month != 'all' && $request->year != 'all') {
                    $partners = Partner::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المبلغ</th>
<th>تاريخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    $partner_total=0;
                    foreach ($partners as $partner)
                    {
                        $partner_total=0;
                        $date="---";
                        foreach ($partner->outcomes as $outcome) {
                                if (date('m', strtotime($outcome->created_at)) == $request->month&&date('Y', strtotime($outcome->created_at)) == $request->year) {
                                $total += $outcome->value;
                                $partner_total += $outcome->value;
                                $date = $outcome->date;
                            }

                        }
                        if($partner_total > 0)
                        {
                            echo "<tr>
<td><a href='/partner/-{$partner->id}'>{$partner->display_name}</a></td>
<td>{$partner_total}</td>
<td>{$date}</td>
</tr>";
                        }

                    }

                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['partners']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                break;
            case 'employees':
                if ($request->month == 'all' && $request->year == 'all') {
                    $employees = Employee::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المرتب</th>
<th>اجمالي الخصومات</th>
<th>الصافي</th>
<th>تارخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    foreach ($employees as $employee) {
                        $employee_total_salary=0;
                        $employee_total_penalty=0;
                        $net = 0;
                        $penalties = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',4)->withTrashed()->get();
                        $salaries = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',3)->withTrashed()->get();
                        foreach ($salaries as $salary) {
                            $TotalPenalty =0;
                            $date = $salary->date;
                            $employee_total_salary = $salary->value;
                            foreach ($penalties as $penalty)
                            {
                                if(date('m-y',strtotime($penalty->created_at)) == date('m-y',strtotime($salary->created_at)))
                                    $employee_total_penalty+=$penalty->value;
                                $date = $penalty->date;
                            }
                            $net = $employee_total_salary - $employee_total_penalty;
                            $total +=$net;

                            if($net>0)
                            {
                                echo "<tr>
<td><a href='/employee/-{$employee->id}'>{$employee->user->display_name}</a></td>
<td>{$employee_total_salary}</td>
<td>{$employee_total_penalty}</td>
<td>{$net}</td>
<td>{$date}</td>
</tr>";
                            }

                        }



                        }
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['employees']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";
                    }
                elseif ($request->month != 'all' && $request->year == 'all') {
                    $employees = Employee::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المرتب</th>
<th>اجمالي الخصومات</th>
<th>الصافي</th>
<th>تارخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    foreach ($employees as $employee) {
                        $employee_total_salary=0;
                        $employee_total_penalty=0;
                        $net = 0;
                        $penalties = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',4)->withTrashed()->get();
                        $salaries = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',3)->withTrashed()->get();
                        foreach ($salaries as $salary) {
                            if (date('m', strtotime($salary->created_at)) == $request->month) {
                                $TotalPenalty = 0;
                                $date = $salary->date;
                                $employee_total_salary = $salary->value;
                                foreach ($penalties as $penalty) {
                                    if (date('m-y', strtotime($penalty->created_at)) == date('m-y', strtotime($salary->created_at)))
                                        $employee_total_penalty += $penalty->value;
                                    $date = $penalty->date;
                                }
                                $net = $employee_total_salary - $employee_total_penalty;
                                $total += $net;

                                if ($net > 0) {
                                    echo "<tr>
<td><a href='/employee/-{$employee->id}'>{$employee->user->display_name}</a></td>
<td>{$employee_total_salary}</td>
<td>{$employee_total_penalty}</td>
<td>{$net}</td>
<td>{$date}</td>
</tr>";
                                }
                            }
                        }



                    }
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['employees']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month == 'all' && $request->year != 'all') {
                    $employees = Employee::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المرتب</th>
<th>اجمالي الخصومات</th>
<th>الصافي</th>
<th>تارخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    foreach ($employees as $employee) {
                        $employee_total_salary=0;
                        $employee_total_penalty=0;
                        $net = 0;
                        $penalties = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',4)->withTrashed()->get();
                        $salaries = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',3)->withTrashed()->get();
                        foreach ($salaries as $salary) {
                            if (date('Y', strtotime($salary->created_at)) == $request->year) {
                                $TotalPenalty = 0;
                                $date = $salary->date;
                                $employee_total_salary = $salary->value;
                                foreach ($penalties as $penalty) {
                                    if (date('m-y', strtotime($penalty->created_at)) == date('m-y', strtotime($salary->created_at)))
                                        $employee_total_penalty += $penalty->value;
                                    $date = $penalty->date;
                                }
                                $net = $employee_total_salary - $employee_total_penalty;
                                $total += $net;

                                if ($net > 0) {
                                    echo "<tr>
<td><a href='/employee/-{$employee->id}'>{$employee->user->display_name}</a></td>
<td>{$employee_total_salary}</td>
<td>{$employee_total_penalty}</td>
<td>{$net}</td>
<td>{$date}</td>
</tr>";
                                }
                            }
                        }



                    }
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['employees']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month != 'all' && $request->year != 'all') {
                    $employees = Employee::withTrashed()->get();
                    echo '<table><tr>
<th>الاسم</th>
<th>اجمالي المرتب</th>
<th>اجمالي الخصومات</th>
<th>الصافي</th>
<th>تارخ اخر معاملة</th>
</tr>';
                    $total = 0;
                    foreach ($employees as $employee) {
                        $employee_total_salary=0;
                        $employee_total_penalty=0;
                        $net = 0;
                        $penalties = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',4)->withTrashed()->get();
                        $salaries = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',3)->withTrashed()->get();
                        foreach ($salaries as $salary) {
                            if (date('m', strtotime($salary->created_at)) == $request->month&&date('Y', strtotime($salary->created_at)) == $request->year) {
                                $TotalPenalty = 0;
                                $date = $salary->date;
                                $employee_total_salary = $salary->value;
                                foreach ($penalties as $penalty) {
                                    if (date('m-y', strtotime($penalty->created_at)) == date('m-y', strtotime($salary->created_at)))
                                        $employee_total_penalty += $penalty->value;
                                    $date = $penalty->date;
                                }
                                $net = $employee_total_salary - $employee_total_penalty;
                                $total += $net;

                                if ($net > 0) {
                                    echo "<tr>
<td><a href='/employee/-{$employee->id}'>{$employee->user->display_name}</a></td>
<td>{$employee_total_salary}</td>
<td>{$employee_total_penalty}</td>
<td>{$net}</td>
<td>{$date}</td>
</tr>";
                                }
                            }
                        }



                    }

                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['employees']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                break;
            case 'outcomes':
                if ($request->month == 'all' && $request->year == 'all') {
                    $total_general = 0;
                    $total_cars = 0;
                    $cars = Car::withTrashed()->get();
                    $general_outcomes = OutCome::where('outcomes_type_id',6)->get();
                    if(sizeof($cars))
                    {
                        echo '<table><tr>
<th>السيارة</th>
<th>اجمالي المصاريف</th>
<th>التاريخ</th>
</tr>';
                        foreach ($cars as $car) {
                            $date = '---';
                            $total_car = 0;
                            foreach ($car->outcomes as $outcome)
                            {
                                if($outcome->outcomes_type_id == 5)
                                {
                                    $total_car += $outcome->value;
                                    $date =$outcome->date;
                                }
                            }
                            $total_cars+=$total_car;
if($total_car>0)
{

                            echo "<tr>
<td><a href='/car/-{$car->id}'>{$car->name}</a></td>
<td>{$total_car}</td>
<td>{$date}</td>
</tr>";
                        }

                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['cars']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف سيارات</h3>';
                    if(sizeof($general_outcomes)>0)
                    {

                        echo '<table><tr>
<th>العنوان</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                        foreach ($general_outcomes as $outcome) {
                            $total_general += $outcome->value;
                            echo "<tr>
<td>{$outcome->title}</td>
<td>{$outcome->value}</td>
<td>{$outcome->date}</td>
</tr>";
                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['general']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف عامة</h3>';

                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مرتبات الموظفين : <span style='color:#fff'>{$Total['employees']}</span></h4>
            ";
                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مصاريف المٌلاك : <span style='color:#fff'>{$Total['partners']}</span></h4>
            ";
                    echo
                    "
            <h4 style=\"text-align: center;background: #0B2232;color:#e7534b;padding:10px\"> الاجمالي : <span style='color:#fff'>{$Total['total']}</span></h4>
            ";
                }
                elseif ($request->month != 'all' && $request->year == 'all') {
                    $partners_total=0;
                    $employees_total=0;
                    $total=0;
$total_general = 0;
                    $cars = Car::withTrashed()->get();
                    $general_outcomes = OutCome::where('outcomes_type_id',6)->get();
                    if(sizeof($cars))
                    {
                        $total_cars = 0;
                        echo '<table><tr>
<th>السيارة</th>
<th>اجمالي المصاريف</th>
<th>التاريخ</th>
</tr>';
                        foreach ($cars as $car) {
                            $date = '---';
                            $total_car = 0;
                            foreach ($car->outcomes as $outcome)
                            {
                                if($outcome->outcomes_type_id == 5)
                                {
                                    if (date('m', strtotime($outcome->created_at)) == $request->month)
                                    {

                                    }
                                    if (date('m', strtotime($outcome->created_at)) == $request->month)
                                    {
                                        $total_car += $outcome->value;
                                        $date =$outcome->date;
                                    }


                                }
                            }
                            $total_cars+=$total_car;
if($total_car>0)
{

                            echo "<tr>
<td><a href='/car/-{$car->id}'>{$car->name}</a></td>
<td>{$total_car}</td>
<td>{$date}</td>
</tr>";
                        }

                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['cars']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف سيارات</h3>';
                    if(sizeof($general_outcomes)>0)
                    {
                        
                        echo '<table><tr>
<th>العنوان</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                        foreach ($general_outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month)
                            {
                                $total_general += $outcome->value;
                                echo "<tr>
<td>{$outcome->title}</td>
<td>{$outcome->value}</td>
<td>{$outcome->date}</td>
</tr>";
                            }

                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['general']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف عامة</h3>';
                    $partners = Partner::withTrashed()->get();

                    foreach ($partners as $partner)
                    {
                        foreach ($partner->outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month)
                            {
                                $partners_total += $outcome->value;

                            }
                        }
                    }
                    $total = 0;
                    $employees = Employee::withTrashed()->get();
                    foreach ($employees as $employee) {
                        $employee_total_salary = 0;
                        $employee_total_penalty = 0;
                        $net = 0;
                        foreach ($employee->outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month)
                            {
                                if ($outcome->outcomes_type_id == 3) {
                                    $employee_total_salary += $outcome->value;
                                } elseif ($outcome->outcomes_type_id == 4) {
                                    $employee_total_penalty += $outcome->value;
                                }
                            }

                        }
                        $net = $employee_total_salary - $employee_total_penalty;
                        $employees_total += $net;
                    }
                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مرتبات الموظفين : <span style='color:#fff'>{$Total['employees']}</span></h4>
            ";
                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مصاريف المٌلاك : <span style='color:#fff'>{$Total['partners']}</span></h4>
            ";
                    $total = $total_cars + $total_general + $employees_total + $partners_total;

                    echo
                    "
            <h4 style=\"text-align: center;background: #0B2232;color:#e7534b;padding:10px\"> الاجمالي : <span style='color:#fff'>{$Total['total']}</span></h4>
            ";
                }
                elseif ($request->month == 'all' && $request->year != 'all') {
                    $partners_total=0;
                    $employees_total=0;
                        $total_general = 0;
                    $total=0;
                    $cars = Car::withTrashed()->get();
                    $general_outcomes = OutCome::where('outcomes_type_id',6)->get();
                    if(sizeof($cars))
                    {
                        $total_cars = 0;
                        echo '<table><tr>
<th>السيارة</th>
<th>اجمالي المصاريف</th>
<th>التاريخ</th>
</tr>';
                        foreach ($cars as $car) {
                            $date = '---';
                            $total_car = 0;
                            foreach ($car->outcomes as $outcome)
                            {
                                if($outcome->outcomes_type_id == 5)
                                {
                                    if (date('Y', strtotime($outcome->created_at)) == $request->year)
                                    {

                                    }
                                    if (date('Y', strtotime($outcome->created_at)) == $request->year)
                                    {
                                        $total_car += $outcome->value;
                                        $date =$outcome->date;
                                    }


                                }
                            }
                            $total_cars+=$total_car;
if($total_car>0)
{

                            echo "<tr>
<td><a href='/car/-{$car->id}'>{$car->name}</a></td>
<td>{$total_car}</td>
<td>{$date}</td>
</tr>";
                        }

                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['cars']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف سيارات</h3>';
                    if(sizeof($general_outcomes)>0)
                    {

                        echo '<table><tr>
<th>العنوان</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                        foreach ($general_outcomes as $outcome) {
                            if (date('Y', strtotime($outcome->created_at)) == $request->year)
                            {
                                $total_general += $outcome->value;
                                echo "<tr>
<td>{$outcome->title}</td>
<td>{$outcome->value}</td>
<td>{$outcome->date}</td>
</tr>";
                            }

                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['general']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف عامة</h3>';
                    $partners = Partner::withTrashed()->get();

                    foreach ($partners as $partner)
                    {
                        foreach ($partner->outcomes as $outcome) {
                            if (date('Y', strtotime($outcome->created_at)) == $request->year)
                            {
                                $partners_total += $outcome->value;

                            }
                        }
                    }
                    $total = 0;
                    $employees = Employee::withTrashed()->get();
                    foreach ($employees as $employee) {
                        $employee_total_salary = 0;
                        $employee_total_penalty = 0;
                        $net = 0;
                        foreach ($employee->outcomes as $outcome) {
                            if (date('Y', strtotime($outcome->created_at)) == $request->year)
                            {
                                if ($outcome->outcomes_type_id == 3) {
                                    $employee_total_salary += $outcome->value;
                                } elseif ($outcome->outcomes_type_id == 4) {
                                    $employee_total_penalty += $outcome->value;
                                }
                            }

                        }
                        $net = $employee_total_salary - $employee_total_penalty;
                        $employees_total += $net;
                    }
                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مرتبات الموظفين : <span style='color:#fff'>{$Total['employees']}</span></h4>
            ";
                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مصاريف المٌلاك : <span style='color:#fff'>{$Total['partners']}</span></h4>
            ";
                    $total = $total_cars + $total_general + $employees_total + $partners_total;

                    echo
                    "
            <h4 style=\"text-align: center;background: #0B2232;color:#e7534b;padding:10px\"> الاجمالي : <span style='color:#fff'>{$Total['total']}</span></h4>
            ";
                }
                elseif ($request->month != 'all' && $request->year != 'all') {
                    $partners_total=0;
                    $employees_total=0;
                    $total=0;
                        $total_general = 0;
                    $cars = Car::withTrashed()->get();
                    $general_outcomes = OutCome::where('outcomes_type_id',6)->get();
                    if(sizeof($cars))
                    {
                        $total_cars = 0;
                        echo '<table><tr>
<th>السيارة</th>
<th>اجمالي المصاريف</th>
<th>التاريخ</th>
</tr>';
                        foreach ($cars as $car) {
                            $date = '---';
                            $total_car = 0;
                            foreach ($car->outcomes as $outcome)
                            {
                                if($outcome->outcomes_type_id == 5)
                                {
                                    if (date('m', strtotime($outcome->created_at)) == $request->month&&date('Y', strtotime($outcome->created_at)) == $request->year)
                                    {

                                    }
                                    if (date('m', strtotime($outcome->created_at)) == $request->month&&date('Y', strtotime($outcome->created_at)) == $request->year)
                                    {
                                        $total_car += $outcome->value;
                                        $date =$outcome->date;
                                    }


                                }
                            }
                            $total_cars+=$total_car;
if($total_car>0)
{

                            echo "<tr>
<td><a href='/car/-{$car->id}'>{$car->name}</a></td>
<td>{$total_car}</td>
<td>{$date}</td>
</tr>";
                        }

                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['cars']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف سيارات</h3>';
                    if(sizeof($general_outcomes)>0)
                    {

                        echo '<table><tr>
<th>العنوان</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                        foreach ($general_outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month&&date('Y', strtotime($outcome->created_at)) == $request->year)
                            {
                                $total_general += $outcome->value;
                                echo "<tr>
<td>{$outcome->title}</td>
<td>{$outcome->value}</td>
<td>{$outcome->date}</td>
</tr>";
                            }

                        }
                        echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">الاجمالي</td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['general']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>

        ";
                        echo '</table>';
                    }
                    else
                        echo '<h3 class="text-red">لا توجد مصاريف عامة</h3>';
                    $partners = Partner::withTrashed()->get();

                    foreach ($partners as $partner)
                    {
                        foreach ($partner->outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month&&date('Y', strtotime($outcome->created_at)) == $request->year)
                            {
                                $partners_total += $outcome->value;

                            }
                        }
                    }
                    $total = 0;
                    $employees = Employee::withTrashed()->get();
                    foreach ($employees as $employee) {
                        $employee_total_salary = 0;
                        $employee_total_penalty = 0;
                        $net = 0;
                        foreach ($employee->outcomes as $outcome) {
                            if (date('m', strtotime($outcome->created_at)) == $request->month&&date('Y', strtotime($outcome->created_at)) == $request->year)
                            {
                                if ($outcome->outcomes_type_id == 3) {
                                    $employee_total_salary += $outcome->value;
                                } elseif ($outcome->outcomes_type_id == 4) {
                                    $employee_total_penalty += $outcome->value;
                                }
                            }

                        }
                        $net = $employee_total_salary - $employee_total_penalty;
                        $employees_total += $net;
                    }
                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مرتبات الموظفين : <span style='color:#fff'>{$Total['employees']}</span></h4>
            ";
                        echo
                        "
            <h4 style=\"background: #0B2232;color:#e7534b;padding:10px\"> مصاريف المٌلاك : <span style='color:#fff'>{$Total['partners']}</span></h4>
            ";
                    $total = $total_cars + $total_general + $employees_total + $partners_total;

                    echo
                    "
            <h4 style=\"text-align: center;background: #0B2232;color:#e7534b;padding:10px\"> الاجمالي : <span style='color:#fff'>{$Total['total']}</span></h4>
            ";
                }
                break;
            case 'incomes':
                $outcomes = $this->GetTotal($request);
                if ($request->month == 'all' && $request->year == 'all') {
                    $incomes = InCome::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>النوع</th>
<th>المبلغ</th>
<th>المستلم</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($incomes as $income)
                    {
                            echo "<tr>
<td><a href='/client/-{$income->client->id}'>{$income->client->user->display_name}</a></td>
<td>{$income->car->name}</td>
<td>{$income->title}</td>
<td>{$income->value}</td>
<td>{$income->user->display_name}</td>
<td>{$income->date}</td>
</tr>";
                        $total +=$income->value;

                    }
$net = $total - $Total['total'];
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي المصاريف</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['total']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">صافي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$net</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month != 'all' && $request->year == 'all') {
                    $incomes = InCome::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>النوع</th>
<th>المبلغ</th>
<th>المستلم</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($incomes as $income)
                    {
                        if (date('m', strtotime($income->created_at)) == $request->month) {
                            echo "<tr>
<td><a href='/client/-{$income->client->id}'>{$income->client->user->display_name}</a></td>
<td>{$income->car->name}</td>
<td>{$income->title}</td>
<td>{$income->value}</td>
<td>{$income->user->display_name}</td>
<td>{$income->date}</td>
</tr>";
                            $total += $income->value;
                        }
                    }
$net = $total - $Total['total'];
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي المصاريف</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['total']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">صافي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$net</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month == 'all' && $request->year != 'all') {
                    $incomes = InCome::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>النوع</th>
<th>المبلغ</th>
<th>المستلم</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($incomes as $income)
                    {
                        if (date('Y', strtotime($income->created_at)) == $request->year) {
                            echo "<tr>
<td><a href='/client/-{$income->client->id}'>{$income->client->user->display_name}</a></td>
<td>{$income->car->name}</td>
<td>{$income->title}</td>
<td>{$income->value}</td>
<td>{$income->user->display_name}</td>
<td>{$income->date}</td>
</tr>";
                            $total += $income->value;
                        }
                    }
$net = $total - $Total['total'];
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي المصاريف</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['total']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">صافي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$net</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month != 'all' && $request->year != 'all') {
                    $incomes = InCome::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>النوع</th>
<th>المبلغ</th>
<th>المستلم</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($incomes as $income)
                    {
                        if (date('m', strtotime($income->created_at)) == $request->month && date('Y', strtotime($income->created_at)) == $request->year) {
                            echo "<tr>
<td><a href='/client/-{$income->client->id}'>{$income->client->user->display_name}</a></td>
<td>{$income->car->name}</td>
<td>{$income->title}</td>
<td>{$income->value}</td>
<td>{$income->user->display_name}</td>
<td>{$income->date}</td>
</tr>";
                            $total += $income->value;
                        }
                    }
$net = $total - $Total['total'];
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي المصاريف</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">{$Total['total']}</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">صافي الدخل</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$net</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                break;
            case 'depts':
                if ($request->month == 'all' && $request->year == 'all') {
                    $rentings = Renting::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($rentings as $renting)
                    {
                        if($renting->dept > 0)
                        {
                            echo "<tr>
<td><a href='/client/-{$renting->client->id}'>{$renting->client->user->display_name}</a></td>
<td>{$renting->car->name}</td>
<td>{$renting->dept}</td>
<td>{$renting->start}</td>
</tr>";
                            $total +=$renting->dept;
                        }


                    }
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي </td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month != 'all' && $request->year == 'all') {
                    $rentings = Renting::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($rentings as $renting)
                    {
                        if (date('m', strtotime($renting->created_at)) == $request->month) {
                            if ($renting->dept > 0) {
                                echo "<tr>
<td><a href='/client/-{$renting->client->id}'>{$renting->client->user->display_name}</a></td>
<td>{$renting->car->name}</td>
<td>{$renting->dept}</td>
<td>{$renting->start}</td>
</tr>";
                                $total += $renting->dept;
                            }
                        }


                    }
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي </td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month == 'all' && $request->year != 'all') {
                    $rentings = Renting::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($rentings as $renting)
                    {
                        if (date('Y', strtotime($renting->created_at)) == $request->year) {
                            if ($renting->dept > 0) {
                                echo "<tr>
<td><a href='/client/-{$renting->client->id}'>{$renting->client->user->display_name}</a></td>
<td>{$renting->car->name}</td>
<td>{$renting->dept}</td>
<td>{$renting->start}</td>
</tr>";
                                $total += $renting->dept;
                            }
                        }


                    }
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي </td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                elseif ($request->month != 'all' && $request->year != 'all') {
                    $rentings = Renting::withTrashed()->get();
                    echo '<table><tr>
<th>العميل</th>
<th>السيارة</th>
<th>المبلغ</th>
<th>التاريخ</th>
</tr>';
                    $total = 0;
                    foreach ($rentings as $renting)
                    {
                        if (date('m', strtotime($renting->created_at)) == $request->month && date('Y', strtotime($renting->created_at)) == $request->year) {
                            if ($renting->dept > 0) {
                                echo "<tr>
<td><a href='/client/-{$renting->client->id}'>{$renting->client->user->display_name}</a></td>
<td>{$renting->car->name}</td>
<td>{$renting->dept}</td>
<td>{$renting->start}</td>
</tr>";
                                $total += $renting->dept;
                            }
                        }


                    }
                    echo "
        <tr>
                    <td style=\"background: #0B2232;color:#e7534b\" class=\"text-red\">اجمالي </td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                    <td style=\"background: #0B2232;color:#e7534b\">$total</td>
                    <td style=\"background: #0B2232;color:#e7534b\"></td>
                </tr>
        ";

                }
                break;
        }


    }

    public function GetTotal($request)
    {
        $data['total'] = 0;
        $data['employees'] = 0;
        $data['partners'] = 0;
        $data['cars'] = 0;
        $data['general'] = 0;
        $outcomes = OutCome::withTrashed()->get();
        $employees = Employee::withTrashed()->get();
        $total_net_salary = 0;
        foreach ($employees as $employee) {
            $penalties = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',4)->withTrashed()->get();
            $salaries = OutCome::where('employee_id',$employee->id)->where('outcomes_type_id',3)->withTrashed()->get();
            foreach ($salaries as $salary) {
                $condition = 0;
                if($request->month=='all' && $request->year == 'all')
                    $condition = 1;
                elseif ($request->month!='all' && $request->year == 'all')
                    $condition = date('m', strtotime($salary->created_at)) == $request->month;
                elseif ($request->month=='all' && $request->year != 'all')
                    $condition = date('Y', strtotime($salary->created_at)) == $request->year;
                elseif ($request->month!='all' && $request->year != 'all')
                    $condition = date('m', strtotime($salary->created_at)&&date('Y', strtotime($salary->created_at)) == $request->year) == $request->month;
                if ($condition)
                {
                    $TotalPenalty =0;
                    foreach ($penalties as $penalty)
                    {
                        if(date('m-y',strtotime($penalty->created_at)) == date('m-y',strtotime($salary->created_at)))
                            $TotalPenalty+=$penalty->value;
                    }
                    $data['employees'] += $salary->value - $TotalPenalty;
                }

            }
        }
        foreach ($outcomes as $outcome)
        {
            if($request->month =='all' && $request->year == 'all' )
            {

                if($outcome->outcomes_type_id == 1 || $outcome->outcomes_type_id == 2 ||$outcome->outcomes_type_id == 7 )
                $data['partners'] += $outcome->value;
                elseif($outcome->outcomes_type_id == 5)
                    $data['cars'] += $outcome->value;
                elseif($outcome->outcomes_type_id == 6)
                    $data['general'] += $outcome->value;
            }


            elseif($request->month !='all' && $request->year == 'all' ) {
                if (date('m', strtotime($outcome->created_at)) == $request->month)
                {
                if ($outcome->outcomes_type_id == 1 || $outcome->outcomes_type_id == 2 || $outcome->outcomes_type_id == 7)
                    $data['partners'] += $outcome->value;
                elseif ($outcome->outcomes_type_id == 5)
                    $data['cars'] += $outcome->value;
                elseif ($outcome->outcomes_type_id == 6)
                    $data['general'] += $outcome->value;
            }
            }
            elseif($request->month =='all' && $request->year != 'all' )
            {
                if (date('Y', strtotime($outcome->created_at)) == $request->year) {
                    if ($outcome->outcomes_type_id == 1 || $outcome->outcomes_type_id == 2 || $outcome->outcomes_type_id == 7)
                        $data['partners'] += $outcome->value;
                    elseif ($outcome->outcomes_type_id == 5)
                        $data['cars'] += $outcome->value;
                    elseif ($outcome->outcomes_type_id == 6)
                        $data['general'] += $outcome->value;
                }
            }
            elseif($request->month !='all' && $request->year != 'all' )
            {
                if (date('m', strtotime($outcome->created_at)) == $request->month && date('Y', strtotime($outcome->created_at)) == $request->year)
                {
                    if ($outcome->outcomes_type_id == 1 || $outcome->outcomes_type_id == 2 || $outcome->outcomes_type_id == 7)
                        $data['partners'] += $outcome->value;
                    elseif ($outcome->outcomes_type_id == 5)
                        $data['cars'] += $outcome->value;
                    elseif ($outcome->outcomes_type_id == 6)
                        $data['general'] += $outcome->value;
                }
            }

            }

            $data['total'] = $data['general'] + $data['cars'] + $data['partners'] + $data['employees'];


        return $data;
    }
    public function OutComes(Request $request)
    {

    }
}