@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    الشركاء
@endsection
@section('tab-contents')
    <div id="DeletePartner-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>حذف الشريك</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="DeletePartner" type="POST">
                <h3 class="text-red ">سيتم حذف جميع بيانات هذا الشريك .. هل انت متأكد بأنك تريد الحذف ؟ </h3>
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

    <!-- START ADD PARTNER FORM -->
    <div id="AddPartner-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة شريك جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="partner_register">
                {!! csrf_field() !!}
                <div class="col-md-6 col-xs-12">
                    <input name="first_name" type="text" placeholder="الاسم الاول">
                    <label id="partner_first"></label>
                </div>
                <div class="col-md-6 col-xs-12 ">
                    <input name="last_name" type="text" placeholder="الاسم التانى">
                    <label id="partner_last"></label>
                </div>
                 <div class="col-md-6 col-xs-12">
                <h5 style="margin:0;margin-right:20px;margin-bottom:5px">تاريخ الميلاد</h5>    
                <input name="birthdate" placeholder="تاريخ الميلاد" type="date" style="padding:6px">
                <label id="partner_birthdate"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <h5 style="margin:0;margin-right:20px;margin-bottom:5px;opacity:0">رقم الهاتف</h5>    
                    <input name="phone" type="text" placeholder="رقم الهاتف">
                <label id="partner_phone"></label>
                </div>
                <div class="col-md-12 col-xs-12">
                    <input name="address" type="text" placeholder="العنوان">
                    <label id="partner_address"></label>
                </div>
                <div class="col-md-12 col-xs-12">
                    <input name="national_id" type="text" placeholder="رقم البطاقة">
                    <label id="partner_national_id"></label>
                </div>
                <div class="col-md-12 col-xs-12">
                    <input name="email" type="text" placeholder="البريد الالكترونى">
                    <label id="partner_email"></label>
                </div>
                <div class="clearfix"></div>
                <div class="alert"></div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <button type="submit" class="main-btn">اضافة شريك</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD PARTN FORM -->

<div role="tabpanel" class="tab-pane fade in active" id="Partners">
    <button data-popup="AddPartner-Popup" class="main-btn col-xs-3">اضافة شريك</button>
    <form class="col-xs-9">
        <div class="col-xs-12" id="Partners-Filter">

        </div>
    </form>
    <div class="clearfix"></div>
    <div class="partners box main-box">
       <table id="Partners-table" class="list-view">
            <thead>
            <tr>
                @foreach($partners_fields as $field)
                    <th>{{ $field }}</th>
                @endforeach
                <th>الخيارات</th>
            </tr>
            </thead>
            <tbody>


            @foreach($partners as $partner)
                <tr>
                    <td>
                        {{ $partner->first_name." ".$partner->last_name }}
                    </td>
                    <td id="birthday">{{ date_format( new DateTime($partner->birthdate),"Y-m-d")}}</td>

                    <td id="phone">
                        {{ $partner->phone }}
                    </td>
                    <td id="address">
                        {{ $partner->address }}
                    </td>
                    <td id="national_id">
                        {{ $partner->national_id }}
                    </td>
                    <td id="notes">
                        {{ $partner->notes }}
                    </td>
                    <td>
                        <span id="firstname" class="hidden">{{$partner->first_name}}</span>
                        <span id="lastname" class="hidden">{{$partner->last_name}}</span>
                       
                        <button class="main-btn sm-btn" id="DeletePartner-btn" data-popup="DeletePartner-Popup" data-id="{{ $partner->id }}"><i class="fa fa-remove"></i></button>
                        <a href="{{"/partner/"."-".$partner->id}}"><button class="main-btn sm-btn"><i class="fa fa-info"></i></button></a>

                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/Partners.js') }}"></script>
    <script>
        $("#Partners-Filter input").attr("placeholder","بحث عن شريك ؟");
    </script>
@endsection
