@extends('layouts.Profile')

@section('title')
    {{$partner->user->first_name." ".$partner->user->last_name}}
@endsection
@section('profile-style')
    <style>
        button
        {
            font-size:18px !important;
        }
        div.table-parent
        {
            background: #fff;
            padding:15px;
            border-top:5px solid #e62031;
        }
        div.partner-content
        {
            padding: 20px;
        }
    </style>
@endsection
@section('desc')
    الشريك : {{$partner->user->first_name." ".$partner->user->last_name}}
@endsection
@section('contents')
    <div class="info box main-box">
        <h3 class="title">بيانات الشريك</h3>
        <form method="POST" id="Update">
            {!! csrf_field() !!}
            <input class="hidden" name="id" value="{{$partner->id}}">
            <table border="1">

                <tr>
                    <th>
                        الاسم
                    </th>
                    <td>
                        <div class="col-xs-6">
                            <input type="text" name="first_name" value="{{$partner->user->first_name}}">
                            <label class="alert" id="partner_firstname"></label>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" name="last_name" value="{{$partner->user->last_name}}">
                            <label class="alert" id="partner_lastname"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        تاريخ الميلاد
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="date" name="birthdate" value="{{ date_format( new DateTime($partner->user->birthdate),"Y-m-d")}}">
                            <label class="alert" id="partner_birthdate"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        الرقم القومي
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="national_id" value="{{$partner->user->national_id}}">
                            <label class="alert" id="partner_national_id"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        العنوان
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="address" value="{{$partner->user->address}}">
                            <label class="alert" id="partner_address"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        رقم الموبايل
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="phone" value="{{$partner->user->phone}}">
                            <label class="alert" id="partner_phone"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        البريد الالكتروني
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="email" value="{{$partner->user->email}}">
                            <label class="alert" id="partner_email"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        ملاحظات
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <textarea name="notes">{{$partner->user->notes}}</textarea>
                            <label class="alert" id="partner_notes"></label>
                        </div>
                    </td>
                </tr>

            </table>
            <div class="col-xs-12 text-left" style="margin-top:20px">
                <button type="submit" class="main-btn sm-btn">تعديل</button>
            </div>
        </form>
    </div>
    <div class="partner-content">
        <form id="Partner">
            {!! csrf_field() !!}
            <input value="{{$partner->id}}" name="id" class="hidden">
            <div class="col-md-3">
                <select name="type">
                    <option value="">النوع</option>
                    <option value="1">الحسابات</option>
                    <option value="2">الديون</option>
                </select>
                <label id="Report_type" class="alert text-center"></label>
            </div>
            <div class="col-md-3 cars">
                <select name="car_id">
                    <option value="all">جميع السيارات</option>
                </select>
            </div>
            <div class="col-md-3 months">
                <select name="month">
                    <option value="all">جميع الشهور</option>
                </select>
            </div>
            <div class="col-md-3 years">
                <select name="year">
                    <option value="all">جميع السنين</option>
                </select>
            </div>
            <div class="col-xs-12 text-center">
                <button class="btn-red" type="submit">تقرير</button>
            </div>
        </form>
        <div class="clearfix"></div>
        <div class="table-parent">
            <h3 class="title red text-right">التقرير</h3>
            <div class="results">

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('AjaxRequests/Partner.js') }}"></script>
@endsection
