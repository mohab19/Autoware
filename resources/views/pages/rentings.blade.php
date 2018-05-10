@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    الحجوزات
@endsection
@section('tab-contents')
    <div id="RenewReservation-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>تجديد الحجز</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="RenewReservation">
                {!! csrf_field() !!}
                <input type="hidden" name="id">
                <input type="hidden" name="renew_id" value="1">
                <input type="hidden" name="waiting_id" value="0">
                <div class="col-md-6 col-xs-12">
                    <label style="margin-right:15px;">من</label>
                    <input name="start_duration" type="date" placeholder="من">
                    <label id="reservation_start_duration"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <label style="margin-right:15px;">الي</label>
                    <input name="end_duration" type="date" placeholder="الي">
                    <label id="reservation_end_duration"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <input name="DiscountOption" value="1" id="withdiscount" type="radio">
                    <label for="withdiscount" style="display:inline-block !important;margin-right:15px;font-size:16px;" class="text-red">خصم</label>
                    <label id="reservation_DiscountOption"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <input name="DiscountOption" value="0" id="withoutdiscount" type="radio">
                    <label for="withoutdiscount" style="display:inline-block !important;margin-right:15px;font-size:16px;" class="text-red">بدون خصم</label>
                </div>
                <div class="col-xs-12" id="discountinput">
                    <input name="discount" type="text" placeholder="قيمة الخصم">
                    <label id="reservation_discount"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <label style="margin-right:15px;">المبلغ المطلوب</label>
                    <h2 id="RequireMoney" class="text-red" style="margin:0;margin-right:50px;">
                    </h2>
                    <input type="hidden" name="reservation_required_money" value="0.00">
                </div>

                <div class="col-md-6 col-xs-12">
                    <label style="margin-right:15px;">المبلغ المدفوع</label>
                    <input type="text" name="paid" >
                    <label id="reservation_payed"></label>
                </div>
                <div class="clearfix">
                </div>
                <div class="text-center">
                    <button type="submit" class="main-btn">تجديد الحجز</button>
                </div>
            </form>
        </div>
    </div>
    <div id="DeleteReservation-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>حذف الحجز</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="DeleteReservation" type="POST">
                <h3 class="text-red "> هل انت متأكد بأنك تريد حذف هذا الحجز؟</h3>
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
    <!-- START ADD Reservation FORM -->
    <div id="AddReservation-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة حجز جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            @include('layouts/reservation_form')
        </div>
    </div>
    <!-- END ADD Reservation FORM -->  
<!-- START Edit Reservation FORM -->
    <div id="UpdateReservation-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2> تعديل الحجز </h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
           <form id="UpdateReservation">
                 {!! csrf_field() !!}
                <div class="col-xs-12">
        <label style="margin-right:15px;">السيارة</label>
        <input disabled name="car_id">
    </div>
               <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">من</label>
        <input name="start_duration" type="date" placeholder="من">
        <label id="reservation_start_duration"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">الي</label>
        <input name="end_duration" type="date" placeholder="الي">
        <label id="reservation_end_duration"></label>
    </div>
               <div class="col-md-6 col-xs-12">
                   <input name="DiscountOption" value="1" id="withdiscount" type="radio">
                   <label for="withdiscount" style="display:inline-block !important;margin-right:15px;font-size:16px;" class="text-red">خصم</label>
                   <label id="reservation_DiscountOption"></label>
               </div>
               <div class="col-md-6 col-xs-12">
                   <input name="DiscountOption" value="0" id="withoutdiscount" type="radio">
                   <label for="withoutdiscount" style="display:inline-block !important;margin-right:15px;font-size:16px;" class="text-red">بدون خصم</label>
               </div>
               <div class="col-xs-12" id="discountinput">
                   <input name="discount" type="text" placeholder="قيمة الخصم">
                   <label id="reservation_discount"></label>
               </div>
               <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">المبلغ المطلوب</label>
        <h2 id="RequireMoney" class="text-red" style="margin:0;margin-right:50px;">
        </h2>
        <input type="hidden" name="reservation_required_money" value="0.00">
    </div>

    <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">المبلغ المدفوع</label>
        <input type="text" name="payed" >
        <label id="reservation_payed"></label>
    </div>
    <div class="clearfix">
    </div>
    <div class="text-center">
        <button type="submit" class="main-btn">اضافة حجز</button>
    </div>
            </form>
        </div>
    </div>
    <!-- END Edit Reservation FORM -->

<div role="tabpanel" class="tab-pane fade in active" id="Reservations">
    <button data-popup="AddReservation-Popup" class="main-btn col-xs-3">اضافة حجز</button>
    <form class="col-xs-9">
        <div class="col-xs-12" id="Reservations-Filter">

        </div>
    </form>
    <div class="clearfix"></div>
    <div class="reservations box main-box">
        <table id="Reservations-table" class="list-view">
            <thead>
            <tr>
                @foreach($rentings_fields as $field)
                    <th>{{ $field }}</th>
                @endforeach
                <th>الحالة</th>
                <th>الموظف</th>
                <th>الخيارات</th>
            </tr>
            </thead>
            <tbody>


            @foreach($rentings as $renting)
                <tr>
                    <td>
                        {{$renting->id}}
                    </td>
                    <td>
                            <a href="/client/-{{$renting->client->id}}"> {{ $renting->client->user->display_name }}</a>

                    </td>
                    <td>
@if($renting->car)
                            <a href="/car/-{{$renting->car->id}}">{{$renting->car->name}}</a>
@else
السيارة غير موجودة 
@endif
                    </td>
                    <td id="start">
                        {{ date_format( new DateTime($renting->start_duration),"Y-m-d")}}
                    </td>
                    <td id="end">
                        {{ date_format( new DateTime($renting->end_duration),"Y-m-d")}}
                    </td>
                    <td>
                        {{$renting->total}}
                    </td>
                    <td>
                        {{$renting->paid}}
                    </td>
                    <td>
                        {{$renting->dept}}
                    </td>
                    <td>
                        @if($renting->deleted_at == NULL)
                            <span style="padding:5px;" class="btn-primary btn-sm">جديد</span>
                        @else
                            <span style="padding:5px;" class="btn-danger btn-sm">منتهي</span>
                            @endif
                    </td>
                    <td>
                        {{$renting->user->display_name}}
                    </td>
                    <td>
                        @if($renting->deleted_at == NULL)
                        {{--<button class="main-btn sm-btn" id="UpdateReservation-btn" data-popup="UpdateReservation-Popup" data-id="{{ $renting->id }}" --}}
                                {{--data-car_id="{{ $renting->car_id }}"><i class="fa fa-pencil"></i></button>--}}
                        <button class="main-btn sm-btn" id="DeleteReservation-btn" data-popup="DeleteReservation-Popup" data-id="{{ $renting->id }}"><i class="fa fa-remove"></i></button>
                        <button data-renew class="main-btn sm-btn" id="RenewReservation-btn" data-popup="RenewReservation-Popup" data-id="{{ $renting->id }}"><i class="fa fa-calendar"></i></button>

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
    <script src="{{ asset('AjaxRequests/Rentings.js') }}"></script>
    <script>
        $("#Reservations-Filter input").attr("placeholder","بحث عن حجز ؟");
    </script>
@endsection
