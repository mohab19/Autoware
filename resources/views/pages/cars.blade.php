@extends('layouts.dashboard')
@section('tab-style')

@endsection

@section('title')
    السيارات
    @endsection
@section('tab-contents')
    <div id="DeleteCar-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>حذف السيارة</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="DeleteCar" type="POST">
                <h3 class="text-red "> هل انت متأكد بأنك تريد حذف هذه السيارة؟</h3>
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
    <div id="CheckAvailability-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>معرفة حالة الاتاحة</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="CheckAvailability" type="POST">
                {!! csrf_field() !!}
                <div class="col-xs-12 ">
                    <select name="id" type="text" placeholder="اسم السيارة">
                        <option value="">اختار السيارة</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->display_name }}</option>
                        @endforeach
                    </select>
                    <label id="availability_car_id"></label>
                </div>
                <div class="text-center">
                    <button type="submit" class="main-btn">تأكيد</button>
                </div>
                <div class="alert"role="alert">

                </div>
            </form>
        </div>
    </div>
    <!-- START ADD CAR FORM -->
    <div id="AddCar-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة سيارة جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="car_register" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @foreach($cars_register_fields as $register_field)
                    @if($register_field['type'] == 'select')
                        <div class="col-md-6 col-xs-12 ">
                            <select name="{{ $register_field['name'] }}">
                                <option value="">{{ $register_field['placeholder'] }}</option>
                                @foreach($register_field['options'] as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['display_name'] }}</option>
                                @endforeach
                            </select>
                            <label id="{{ "cars_".$register_field['name'] }}"></label>
                        </div>
                    @else
                        <div class="col-md-6 col-xs-12 ">
                            <input type="{{ $register_field['type'] }}" name="{{ $register_field['name'] }}"
                                   placeholder="{{ $register_field['placeholder'] }}">
                            <label id="{{ "cars_".$register_field['name'] }}"></label>
                        </div>
                    @endif
                @endforeach
                <div class="col-xs-12">
                    <textarea name="notes" placeholder="ملاحظات"></textarea>
                </div>
                <div class="col-xs-6">
                    <h5 class="fl-right" style="margin:0;margin-left:30px;margin-top:12px;font-size:18px">الصورة الرئيسية</h5>
                    <input type="file" name="picture" id="car_image">
<label id="cars_picture"></label>
                </div>
                <div class="clearfix">
                </div>
                <div class="alert"></div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <button type="submit" class="main-btn">اضافة سيارة</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD CAR FORM -->



    <div role="tabpanel" class="tab-pane fade in active" id="Cars">
        <button data-popup="AddCar-Popup" style="margin-left:20px" class="main-btn col-md-1 col-xs-3">اضافة </button>
        <button data-popup="CheckAvailability-Popup" class="main-btn col-md-1 col-xs-3">الحالة</button>
        <form class="col-xs-9">
            <div class="col-xs-12" id="Cars-Filter">

            </div>
        </form>
        <div class="clearfix"></div>
        <div class="cars box main-box">
            <table id="Cars-table" class="list-view">
                <thead>
                <tr>
                    @foreach($cars_fields as $field)
                        <th>{{ $field }}</th>
                    @endforeach
                    <th>الخيارات</th>
                </tr>
                </thead>
                <tbody>


                @foreach($cars as $car)
                    <tr>
                        <td>
                            <img src="{{ $car->picture }}" alt="لا يوجد صورة" >
                        </td>
                        <td>
                            {{ $car->name }}
                        </td>
                        <td>
                            {{ $car->model }}
                        </td>
                        <td>
                            {{ $car->color }}
                        </td>
                        <td>
                            {{ $car->plate }}
                        </td>
                        <td>
                            {{ $car->KM_Counter }}
                        </td>
                        <td>
                            {{ $car->partner->display_name }}
                        </td>
                        <td>
                            {{ $car->day_price }}
                        </td>
                        <td>
                            {{ $car->month_price }}
                        </td>
                        <td>
                            {{ $car->notes }}
                        </td>

                        <td>
                            <button class="main-btn sm-btn" data-popup="DeleteCar-Popup" data-id="{{$car->id}}"><i class="fa fa-remove"></i></button>
                            <a href="{{"/car/"."-".$car->id}}"><button class="main-btn sm-btn"><i class="fa fa-info"></i></button></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/Cars.js') }}"></script>
    <script>
        $("#Cars-Filter input").attr("placeholder","بحث عن سيارة ؟");
    </script>
@endsection
