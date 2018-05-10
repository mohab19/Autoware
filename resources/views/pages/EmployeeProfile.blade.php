@extends('layouts.Profile')

@section('title')
    {{$employee->user->first_name." ".$employee->user->last_name}}
@endsection
@section('desc')
    الموظف : {{$employee->user->first_name." ".$employee->user->last_name}}
@endsection
@section('backto')
    {{URL::route('employees')}}
@endsection
@section('contents')
    <div id="AddPenalty-Popup" class="popup">
    <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
    <!--===== POPUP TITLE -=====-->
    <div class="popup-title">
        <h2>اضافة خصم جديد</h2>
        <br>
        <hr>
        <hr>
    </div>
    <!--===== POPUP BODY ======-->
    <div class="popup-body text-center">
        <form id="AddPenalty" type="POST">
            {!! csrf_field() !!}
            <input type="text" class="hidden" name="employee_id" value="{{$employee->id}}">
            <div class="col-md-6 col-xs-12">
                <input type="text" name="title" placeholder="سبب الخصم">
            </div>
            <div class=" col-md-6 col-xs-12 text-right">
                <input type="text" name="value" placeholder="القيمة">
                <label id="value"></label>
            </div>
            <div class="clearfix"></div>
            <div class="text-center">
                <button type="submit" class="main-btn">اضافة</button>
            </div>
            <div class="alert"role="alert">

            </div>
        </form>
    </div>
    </div>
    <div class="info box main-box">
        <h3 class="title">بيانات الموظف</h3>
        <form method="POST" id="Update">
            {!! csrf_field() !!}
            <input class="hidden" name="id" value="{{$employee->id}}">
            <table border="1">

                <tr>
                    <th>
                        الاسم
                    </th>
                    <td>
                        <div class="col-xs-6">
                            <input type="text" name="first_name" value="{{$employee->user->first_name}}">
                            <label class="alert" id="employee_firstname"></label>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" name="last_name" value="{{$employee->user->last_name}}">
                            <label class="alert" id="employee_lastname"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        تاريخ الميلاد
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="date" name="birthdate" value="{{ date_format( new DateTime($employee->user->birthdate),"Y-m-d")}}">
                            <label class="alert" id="employee_birthdate"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        الرقم القومي
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="national_id" value="{{$employee->user->national_id}}">
                            <label class="alert" id="employee_national_id"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        العنوان
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="address" value="{{$employee->user->address}}">
                            <label class="alert" id="employee_address"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        رقم الموبايل
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="phone" value="{{$employee->user->phone}}">
                            <label class="alert" id="employee_phone"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        البريد الالكتروني
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="email" value="{{$employee->user->email}}">
                            <label class="alert" id="employee_email"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        المرتب
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="salary" value="{{$employee->salary}}">
                            <label class="alert" id="employee_salary"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        ملاحظات
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <textarea name="notes">{{$employee->user->notes}}</textarea>
                            <label class="alert" id="employee_notes"></label>
                        </div>
                    </td>
                </tr>

            </table>
            <div class="col-xs-12 text-left" style="margin-top:20px">
                <button type="submit" class="main-btn sm-btn">تعديل</button>
            </div>
        </form>
    </div>
    <div class="salaries box main-box">
        {{--<div class="col-xs-12 text-right" style="margin:5px 0">--}}
            {{--<button type="button" class="main-btn" data-popup="AddPenalty-Popup">اضافة خصم </button>--}}
        {{--</div>--}}
        <h3 class="title">المرتبات</h3>

        @if(sizeof($salaries))
            <table>
                <tr>
                    <th>
                        المرتب
                    </th>
                    <th>
                        الخصومات
                    </th>
                    <th>
                        صافي المرتب
                    </th>
                    <th>
                        الشهر
                    </th>
                    <th>
                        السنة
                    </th>
                </tr>
                @foreach($salaries as $salary)
                    <?php

                            foreach ($penalties as $penalty)
                                {
                                    if(date('m-y',strtotime($penalty->created_at)) == date('m-y',strtotime($salary->created_at)))
                                        $TotalPenalty+=$penalty->value;
                                }

                            ?>
                    <tr>
                        <td>
                            {{$salary->value}}
                        </td>
                        <td>
                            {{$TotalPenalty}}
                        </td>
                        <td>
                            {{$salary->value - $TotalPenalty}}
                        </td>
                        <td>
                            {{ date_format( new DateTime($salary->created_at),"F")}}
                        </td>
                        <td>
                            {{ date_format( new DateTime($salary->created_at),"Y")}}
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <h3 class="text-center text-red">لم يتم العثور علي اي مرتبات</h3>
        @endif
    </div>
    <div class="penalties box main-box">
        <div class="col-xs-12 text-right" style="margin:5px 0">
            <button type="button" class="main-btn" data-popup="AddPenalty-Popup">اضافة خصم </button>
        </div>
        <h3 class="title">الخصومات</h3>

        @if(sizeof($penalties))
        <table>
            <tr>
                <th>
                    السبب
                </th>
                <th>
                    القيمة
                </th>
                <th>
                    التاريخ
                </th>
            </tr>
        @foreach($penalties as $penalty)
            <tr>
                <td>
                    {{$penalty->title}}
                </td>
                <td>
                    {{$penalty->value}}
                </td>
                <td>
                    {{ date_format( new DateTime($penalty->created_at),"Y-m-d")}}
                </td>
            </tr>
            @endforeach
        </table>
        @else
        <h3 class="text-center text-red">لم يتم العثور علي اي خصومات</h3>
        @endif
    </div>
    @endsection
    @section('script')
        <script src="{{ asset('AjaxRequests/Employee.js') }}"></script>

    @endsection
