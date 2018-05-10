    @extends('layouts.Profile')

@section('title')
    {{$car->name}}
@endsection
@section('desc')
    السيارة : {{$car->name}}
@endsection
@section('backto')
    {{URL::route('cars')}}
@endsection
@section('contents')
    @include('layouts.Expenses_Forms')
    <div id="DeleteAttachment-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>حذف المرفق</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="DeleteEmployee" type="POST">
                <h3 class="text-red "> هل انت متأكد بأنك تريد حذف هذا المرفق؟</h3>
                {!! csrf_field() !!}

                <input type="text" class="hidden" name="id" id="IDVal">
                <input type="text" class="hidden" name="car_id" value="{{$car->id}}">
                <div class="text-center">
                    <button type="submit" class="main-btn">نعم</button>
                </div>
                <div class="alert"role="alert">

                </div>
            </form>
        </div>
    </div>
    <div id="AddAttachment-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة مرفق جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="CarAttach" type="POST">
                {!! csrf_field() !!}
                <input type="text" class="hidden" name="id" value="{{$car->id}}">
                <div class="col-md-6 col-xs-12">
                    <input type="text" name="title" placeholder="عنوان المرفق">
                    <label id="title"></label>
                </div>
                <div class=" col-md-6 col-xs-12 text-right">
                    <h5 style="float:right;margin:10px 20px;font-size:16px">اضافة صورة</h5>
                    <input type="file" name="picture[]" multiple id="car_image">
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
        <h3 class="title">بيانات السيارة</h3>
        <form method="POST" id="Update">
            {!! csrf_field() !!}
            <input class="hidden" name="id" value="{{$car->id}}">
            <table border="1">

                <tr>
                    <th>
                        الاسم
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="name" value="{{$car->name}}">
                            <label class="alert" id="type"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        الموديل
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="model" value="{{$car->model }}">
                            <label class="alert" id="model"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        اللون
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="color" value="{{$car->color}}">
                            <label class="alert" id="color"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        رقم اللوحة
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="plate" value="{{$car->plate}}">
                            <label class="alert" id="plate_number"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
رقم الموتور
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="motor" value="{{$car->motor}}">
                            <label class="alert" id="motor_number"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        رقم الشاسيه
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <input type="text" name="chassis" value="{{ $car->chassis}}">
                            <label class="alert" id="chassis_number"></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        الرخصة
                    </th>
                    <td>
                        <div class="col-xs-5">
                        <input type="text" name="licence" placeholder="رقم الرخصة" value="{{ $car->licence}}">
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="licence_owner"placeholder="مالك الرخصة" value="{{ $car->licence_owner}}">
                        </div>
                        <div class="col-xs-3">
                            <input type="text" name="licence_from" placeholder="صادرة من" value="{{ $car->licence_from}}">
                        </div>
                        <div class="col-xs-12 text-center">
                            <input type="text" name="licence_date"placeholder="بتاريخ" value="{{ $car->licence_date}}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
عداد الكيلومترات
                    </th>
                    <td>
                        <input type="text" name="KM_Counter" value="{{ $car->KM_Counter}}">
                        <label class="alert" id="KM_Counter"></label>

                    </td>
                </tr>
                 <tr>
                    <th>
                 السعر في اليوم / الشهر
                    </th>
                    <td>
                        <div class="col-xs-6">
                        <input type="text" name="day_price" value="{{ $car->day_price }}">
                        <label class="alert" id="price"></label>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" name="month_price" value="{{ $car->month_price }}">
                            <label class="" id="month_price"></label>
                        </div>
                    </td>
                </tr>
                 <tr>
                    <th>
                 السعر الكلي للسيارة
                    </th>
                    <td>
                        <div class="col-xs-12">
                        <input type="text" name="car_price" value="{{ $car->car_price }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        مالك السيارة
                    </th>
                    <td>
                        @foreach($cars_register_fields as $register_field)
                            @if($register_field['type'] == 'select')
                                <div class="col-md-12 col-xs-12 ">
                                    <select name="{{ $register_field['name'] }}">
                                        @foreach($register_field['options'] as $option)
                                            <option @if($car->partner_id == $option['value']) selected @endif value="{{ $option['value'] }}">{{ $option['display_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @break
                            @endif

                            @endforeach
                    </td>
                </tr>

                <tr>
                    <th>
                        ملاحظات
                    </th>
                    <td>
                        <div class="col-xs-12">
                            <textarea type="text" name="notes">{{$car->notes}}</textarea>
                            <label class="alert" id="notes"></label>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="col-xs-12 text-left" style="margin-top:20px">
                <button type="submit" class="main-btn sm-btn">تعديل</button>
            </div>
        </form>
    </div>
    <div class="reservations box main-box">
        <h3 class="title">الحجوزات</h3>

        @if(sizeof($rentings))
        <table>
            <tr>
                <th>
                    رقم الحجز
                </th>
                <th>
                    اسم العميل
                </th>
                <th>
                    من
                </th>
                <th>
                    الي
                </th>
                <th>
                    المبلغ المطلوب
                </th>
                <th>
                    المبلغ المدفوع
                </th>
                <th>
                    المبلغ المتبقي
                </th>
            </tr>
            @foreach($rentings as $renting)
            <tr>
                <td>
                    {{$renting->id}}
                </td>
                <td>
                    <a href="/client/-{{$renting->client->id}}"> {{$renting->client->user->display_name}}</a>
                </td>
                <td>
                    {{date("Y-m-d",strtotime($renting->start_duration))}}
                </td>
                <td>
                    {{date("Y-m-d",strtotime($renting->end_duration))}}
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
            </tr>
                @endforeach
        </table>
        @else
            <h3 class="text-center text-red">لم يتم العثور علي اي حجوزات</h3>
        @endif
    </div>
    <div class="expenses box main-box">
        <h3 class="title">المصاريف</h3>
        <button data-id="{{$car->id}}" data-popup="AddExpense-Popup" id="AddCarExpense" class="main-btn">اضافة مصروف جديد</button>

    @if(sizeof($car_expenses))
            <table>
                <tr>
                    @foreach($expenses_fields as $field)
                        <th> {{ $field }} </th>
                    @endforeach
                    <th>الخيارات</th>
                </tr>
                @foreach($car_expenses as $car_expense)
                    <tr>
                        <td id="title">
                            {{$car_expense->title}}
                        </td>
                        <td id="value">
                            <div class="col-xs-12">
                                {{$car_expense->value}}
                            </div>
                        </td>
                        <td>
                            <button data-id="{{$car_expense->id}}" class="main-btn sm-btn" id="EditExpense-btn" data-popup="ExpensesInfo-Popup">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="main-btn sm-btn" data-popup="DeleteExpense-Popup"
                                    data-id="{{$car_expense->id}}">
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <h3 class="text-red text-center">لا توجد اي مصاريف بعد </h3>
        @endif
    </div>
    <div class="attachments box main-box">
        <h3 class="title">الملفات المرفقة</h3>
        <div class="col-xs-12 text-right" style="margin:5px 0">
            <button type="button" class="main-btn" data-popup="AddAttachment-Popup">اضافة مرفق جديد</button>
        </div>
        <table border="1">
            @if(sizeof($car->attachments))
            @foreach($car->attachments as $attachment)
                <?php $photos = explode("||",$attachment->value) ?>
            <tr>
                <th>
                   {{$attachment->title}}
                </th>
                <td>
                    @foreach($photos as $photo)
                        <div class="item" style="display: inline-block">
                    <img src="{{$photo}}" width="100" height="100">
                    <a style="margin-top:5px;display:block" href="{{$photo}}" download><button class="main-btn sm-btn">تحميل</button></a>
                        </div>
                      @endforeach
                </td>
                <td>
                    <button class="main-btn sm-btn" data-id ="{{$attachment->id}}"data-popup="DeleteAttachment-Popup"><i class="fa fa-remove"></i> </button>
                </td>

            </tr>
                @endforeach
            @else
                <h3 class="text-red text-center">لا توجد اي مرفقات بعد </h3>
                <div class="clearfix"></div>
            @endif
        </table>

    </div>
@endsection
@section('script')
    <script>
        $("#car_image").fileinput({
            showUpload: false,
            showCaption: false,
            browseClass: "btn main-btn",
            fileType: "any",
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
        });
    </script>
    <script src="{{ asset('AjaxRequests/Car.js') }}"></script>
    <script src="{{ asset('AjaxRequests/Expenses.js') }}"></script>

@endsection