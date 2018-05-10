@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    المديرين
@endsection
@section('tab-contents')
    <div id="DeleteAdmin-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>حذف المستخدم</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="DeleteEmployee" type="POST">
                <h3 class="text-red "> هل انت متأكد بأنك تريد حذف هذا المستخدم؟</h3>
                {!! csrf_field() !!}

                <input type="text" class="hidden" name="id" id="IDVal">
                <div class="text-center">
                    <button type="submit" class="main-btn">نعم</button>
                </div>
                <div class="alert"role="alert">

                </div>
            </form>
        </div>
    </div>
    <div id="AdminInfo-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>تعديل بيانات المدير</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="EditAdminInfo">
                {!! csrf_field() !!}
                <input type="text" id="user_id" name="user_id" value="" class="hidden">
                <input type="text" id="id" name="id" value="" class="hidden">
                <div class="col-md-4 col-xs-12">
                    <label>الاسم الاول</label>
                    <input type="text" id="first_name" name="first_name" value="">
                    <label class="viewerror" id="admin_first"></label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <label>الاسم الاخير</label>
                    <input type="text" id="last_name" name="last_name"  value="">
                    <label class="viewerror" id="admin_last"></label>

                </div>
                <div class="col-md-4 col-xs-12">
                    <label>تاريخ الميلاد</label>
                    <input type="date" id="birthdate" placeholder="تاريخ الميلاد" name="birthdate"  value="">
                    <label class="viewerror" id="admin_birthdate"></label>

                </div>
                <div class="col-md-6 col-xs-12">
                    <label>رقم التليفون</label>
                    <input type="text" id="phone" name="phone"  value="">
                    <label class="viewerror" id="admin_phone"></label>

                </div>
                <div class="col-md-6 col-xs-12">
                    <label>رقم البطاقة</label>
                    <input type="text" id="national_id" name="national_id"  value="">
                    <label class="viewerror" id="admin_national_id"></label>
                </div>
                <div class="col-xs-12">
                    <label>العنوان</label>
                    <input type="text" id="address" name="address"  value="">
                    <label class="viewerror" id="admin_address"></label>
                </div>
                <div class="clearfix">
                </div>
                <div class="text-center">
                    <button type="submit" class="main-btn">تعديل</button>
                </div>
                <div class="alert"></div>

            </form>
        </div>
    </div>
    <!-- START ADD EMPLOYEE FORM -->
    <div id="AddAdmin-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة مدير جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="AddAdmin">
                {!! csrf_field() !!}
                <div class="col-md-6 col-xs-12 "><input name="first_name" type="text" placeholder="الاسم الاول">
                    <label id="admin_first"></label>
                </div>
                <div class="col-md-6 col-xs-12 "><input name="last_name" type="text" placeholder="الاسم التانى">
                    <label id="admin_last"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <h5 style="margin:0;margin-right:20px;margin-bottom:5px">تاريخ الميلاد</h5>
                    <input name="birthdate" type="date" style="padding:6px">
                    <label id="admin_birth"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <h5 style="margin:0;margin-right:20px;margin-bottom:5px;opacity:0">رقم الهاتف</h5>
                    <input name="phone" type="text" placeholder="رقم الهاتف">
                    <label id="admin_phone"></label>
                </div>
                <div class="col-md-12 col-xs-12"><input name="address" type="text" placeholder="العنوان">
                    <label id="admin_address"></label>
                </div>
                <div class="col-md-12 col-xs-12"><input name="national_id" type="text" placeholder="رقم البطاقة">
                    <label id="admin_national_id"></label>
                </div>
                <div class="col-md-12 col-xs-12"><input name="email" type="text" placeholder="البريد الالكترونى">
                    <label id="admin_email"></label>
                </div>
                <div class="clearfix"></div>
                <div class="alert"></div>
                <div class="text-center">
                    <button type="submit" class="main-btn">اضافة مدير</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD EMPLOYEE FORM -->

    <div role="tabpanel" class="tab-pane fade in active" id="Employees">
        <button data-popup="AddAdmin-Popup" class="main-btn col-xs-3">اضافة مدير</button>
        <form class="col-xs-9">
            <div class="col-md-10 col-xs-9" id="Employees-Filter">

            </div>
        </form>
        <div class="clearfix"></div>
        <div class="employees box main-box">
            <table id="Employees-table" class="list-view">
                <thead>
                <tr>
                    @foreach($admins_fields as $field)
                        <th> {{ $field }} </th>
                    @endforeach
                    <th>الخيارات</th>
                </tr>
                </thead>
                <tbody>


                @foreach($admins as $admin)
                    <tr>
                        <td class="hidden" id="id">{{ $admin->id }}</td>

                        <td>{{ $admin->first_name." ".$admin->last_name }}</td>
                        <td id="birthday">{{ date_format( new DateTime($admin->birthdate),"Y-m-d")}}</td>
                        <td id="phone" >{{ $admin->phone }}</td>
                        <td id="address">{{ $admin->address }}</td>
                        <td id="national_id">{{ $admin->national_id }}</td>
                        <td>
                            <span id="user_id" class="hidden">{{$admin->user_id}}</span>
                            <span id="firstname" class="hidden">{{$admin->first_name}}</span>
                            <span id="lastname" class="hidden">{{$admin->last_name}}</span>
                            @if($admin->id != $user->id)
                            <button class="main-btn sm-btn" id="EditAdmin-btn" data-popup="AdminInfo-Popup" data-editAdmin="{{$admin->id}}"><i class="fa fa-pencil"></i></button>
                            <button class="main-btn sm-btn" id="DeleteAdmin-btn" data-popup="DeleteAdmin-Popup" data-id="{{ $admin->id }}"><i class="fa fa-remove"></i></button>
                                @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/Admins.js') }}"></script>
    <script>
        $("#Employees-Filter input").attr("placeholder","بحث عن مدير ؟");
    </script>
@endsection