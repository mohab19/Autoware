@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    الانتظار
@endsection
@section('tab-contents')
    <div id="DeleteWaiting-Popup" class="popup">
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
            <form id="DeleteWaiting" type="POST">
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
    <div id="AddWaiting-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة حجز علي الانتظار</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="AddWaiting" >
                {!! csrf_field() !!}
                <div class="col-xs-12 ">
                    <select name="client_id"  class="selectpicker" data-show-subtext="false" data-live-search="true">
                        <option disabled selected value="">اختار العميل</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-subtext="{{$user->user->phone}}">{{ $user->user->display_name}}</option>
                        @endforeach
                    </select>
                    <label id="reservation_user_id"></label>
                </div>
                <div class="col-xs-12 ">
                    <select name="car_id" class="selectpicker" data-show-subtext="false" data-live-search="true">
                        <option disabled selected value="">اختار السيارة</option>
                        @foreach($cars as $car)
                            @if(!$car->available)
                                <option value="{{ $car->id }}" data-subtext="{{$car->plate}}">{{ $car->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label id="reservation_car_id"></label>
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
                    <label style="margin-right:15px;">المبلغ المطلوب</label>
                    <h2 id="RequireMoney" class="text-red" style="margin:0;margin-right:50px;">
                        190
                    </h2>
                    <input type="hidden" name="reservation_required_money" value="0.00">
                </div>
                <div class="col-xs-12">
                    <textarea name="notes" placeholder="ملاحظات"></textarea>
                </div>

                <div class="clearfix">
                </div>
                <div class="alert text-center"></div>
                <div class="clearfix">
                </div>
                <div class="text-center">
                    <button type="submit" class="main-btn">اضافة حجز</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD Reservation FORM -->  
<!-- START Edit Reservation FORM -->
    <div id="UpdateWaiting-Popup" class="popup">
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
           <form id="UpdateWaiting">
                 {!! csrf_field() !!}
               <input type="hidden" name="id">
               <div class="col-xs-12 ">
                   <select name="car_id" type="text" placeholder="اسم السيارة">
                       <option value="">اختار السيارة</option>
                       @foreach($cars as $car)
                           @if(!$car->available)
                               <option value="{{ $car->id }}">{{ $car->display_name }}</option>
                           @endif
                       @endforeach
                   </select>
                   <label id="reservation_car_id"></label>
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
        <label style="margin-right:15px;">المبلغ المطلوب</label>
        <h2 id="RequireMoney" class="text-red" style="margin:0;margin-right:50px;">

        </h2>
        <input type="hidden" name="reservation_required_money" value="0.00">
    </div>
               <div class="col-xs-12">
                   <textarea name="notes" placeholder="ملاحظات"></textarea>
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
    <!-- END Edit Reservation FORM -->

<div role="tabpanel" class="tab-pane fade in active" id="Waitings">
    <button data-popup="AddWaiting-Popup" class="main-btn col-xs-3">اضافة حجز</button>
    <form class="col-xs-9">
        <div class="col-xs-12" id="Reservations-Filter">

        </div>
    </form>
    <div class="clearfix"></div>
    <div class="reservations box main-box">
        <table id="Reservations-table" class="list-view">
            <thead>
            <tr>
                @foreach($waitings_fields as $field)
                    <th>{{ $field }}</th>
                @endforeach
                <th>الخيارات</th>
            </tr>
            </thead>
            <tbody>


            @foreach($waitings as $waiting)
                <tr>
                    <td id="client">
                            <a href="/client/-{{$waiting->client->id}}"> {{ $waiting->client->user->display_name }}</a>

                    </td>
                    <td id="car">
                            <a href="/car/-{{$waiting->car->id}}">{{$waiting->car->name}}</a>
                    </td>
                    <td id="start">
                        {{ date_format( new DateTime($waiting->start_duration),"Y-m-d")}}
                    </td>
                    <td id="end">
                        {{ date_format( new DateTime($waiting->end_duration),"Y-m-d")}}
                    </td>
                    <td>
                        {{$waiting->total}}
                    </td>
                    <td id="notes">
                        {{$waiting->notes}}
                    </td>
                    <td>
                        {{date('Y-m-d',strtotime($waiting->created_at))}}
                    </td>
                    <td>
                        {{$waiting->user->display_name}}
                    </td>
                    <td>
                        <button class="main-btn sm-btn" id="UpdateWaiting-btn" data-popup="UpdateWaiting-Popup" data-update data-waiting="{{$waiting->id}}"  data-client_id="{{$waiting->client_id}}"  data-car_id="{{$waiting->car_id}}"
                                data-car_id="{{ $waiting->car_id }}"><i class="fa fa-pencil"></i></button>
                        <button class="main-btn sm-btn" id="DeleteWaiting-btn" data-popup="DeleteWaiting-Popup" data-delete data-id="{{ $waiting->id }}"><i class="fa fa-remove"></i></button>
                        @if($waiting->car->available)
                            <button class="main-btn sm-btn" id="EndWaiting" data-end data-waiting="{{$waiting->id}}"  data-client_id="{{$waiting->client_id}}"  data-car_id="{{$waiting->car_id}}" data-popup="AddReservation-Popup">
                                    حجز الآن</button>
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
    <script src="{{ asset('AjaxRequests/Waitings.js') }}"></script>
    <script>
        $("#Reservations-Filter input").attr("placeholder","بحث عن حجز ؟");
    </script>
@endsection
