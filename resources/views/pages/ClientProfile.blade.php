@extends('layouts.Profile')

@section('title')
    {{$client->user->first_name." ".$client->user->last_name}}
@endsection
@section('desc')
    العميل : {{$client->user->first_name." ".$client->user->last_name}}
@endsection
@section('backto')
    {{URL::route('clients')}}
@endsection
@section('contents')
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
                <input type="text" class="hidden" name="user_id" value="{{$client->user_id}}">
                <div class="col-md-6 col-xs-12">
                    <input type="text" name="title" placeholder="عنوان المرفق">
                    <label id="general_expense_title"></label>
                </div>
                <div class=" col-md-6 col-xs-12 text-right">
                    <h5 style="float:right;margin:10px 20px;font-size:16px">اضافة صورة</h5>
                    <input type="file" name="picture[]" multiple id="client_image">
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
    <div id="Dept-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>دفع دين</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="PayDept" type="POST">
                {!! csrf_field() !!}
                <input type="text" name="id" id="IDVal" class="hidden">
                <div class="col-xs-12">
                <input type="text" name="dept" placeholder="المبلغ الذي سيتم دفعه">
                </div>
                <div class="text-center">
                    <button type="submit" class="main-btn">تأكيد</button>
                </div>
                <div class="alert"role="alert">

                </div>
            </form>
        </div>
    </div>
    <div id="KMDept-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>دفع دين من الكيلومترات</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="PayKMDept" type="POST">
                {!! csrf_field() !!}
                <input type="text" name="id" id="IDVal" class="hidden">
                <div class="col-xs-12">
                <input type="text" name="KM_Counter_Penalty_paid" placeholder="المبلغ الذي سيتم دفعه">
                </div>
                <div class="text-center">
                    <button type="submit" class="main-btn">تأكيد</button>
                </div>
                <div class="alert"role="alert">

                </div>
            </form>
        </div>
    </div>
    <div class="info box main-box">
        <h3 class="title">بيانات العميل</h3>
        <form method="POST" id="Update">
             {!! csrf_field() !!}
            <input class="hidden" name="user_id" value="{{$client->user->id}}">
            <input class="hidden" name="id" value="{{$client->id}}">
<table border="1">
    
    <tr>
        <th>
            الاسم
        </th>
        <td>
            <div class="col-xs-6">
               <input type="text" name="first_name" value="{{$client->user->first_name}}">
               <label class="alert" id="client_first"></label>
            </div>
             <div class="col-xs-6">
               <input type="text" name="last_name" value="{{$client->user->last_name}}">
               <label class="alert" id="client_last"></label>
            </div>
        </td>
    </tr>
    <tr>
        <th>
            الرقم القومي
        </th>
        <td>
             <div class="col-xs-5">
               <input type="text" name="national_id" value="{{$client->user->national_id}}">
               <label class="alert" id="client_national_id"></label>
            </div>
            <div class="col-xs-4">
                <input type="text" name="id_from" value="{{$client->user->id_from}}">
                <label class="alert" id="client_id_from"></label>
            </div>
            <div class="col-xs-3">
                <input type="text" name="id_date" value="{{$client->user->id_date}}">
                <label class="alert" id="client_id_date"></label>
            </div>
        </td>
    </tr>
    <tr>
        <th>
    الجنسية
        </th>
        <td>
            <div class="col-xs-12">
                <input type="text" name="nationality" value="{{$client->user->nationality}}">
                <label class="alert" id="client_nationality"></label>
            </div>
        </td>
    </tr>
    <tr>
        <th>
            عنوان المنزل
        </th>
        <td>
             <div class="col-xs-12">
               <input type="text" name="address" value="{{$client->user->address}}">
               <label class="alert" id="client_address"></label>
            </div>
        </td>
    </tr>
    <tr>
        <th>
            عنوان العمل
        </th>
        <td>
            <div class="col-xs-12">
                <input type="text" name="office" value="{{$client->user->office}}">
                <label class="alert" id="client_address"></label>
            </div>
        </td>
    </tr>

    <tr>
        <th>
            رقم الموبايل
        </th>
        <td>
             <div class="col-xs-12">
               <input type="text" name="phone" value="{{$client->user->phone}}">
               <label class="alert" id="phone"></label>
            </div>
        </td>
    </tr>
    <tr>
        <th>
          البريد الالكتروني
        </th>
        <td>
             <div class="col-xs-12">
               <input type="text" name="email" value="{{$client->user->email}}">
               <label class="alert" id="client_email"></label>
            </div>
        </td>
    </tr>
        <tr>
        <th>
          تاريخ الميلاد
        </th>
        <td>
             <div class="col-xs-12">
               <input type="date" name="birthdate" value="{{ date_format( new DateTime($client->user->birthdate),"Y-m-d")}}">
               <label class="alert" id="client_birthdate"></label>
            </div>
        </td>
    </tr>
    <tr>
        <th>
             الرخصة
        </th>
        <td>
            <div class="col-xs-3">
                <input type="text" placeholder="الرخصة" name="licence" value="{{$client->licence}}">
                <label class="alert" id="client_national_id"></label>
            </div>
            <div class="col-xs-3">
                <input type="text" placeholder="نوعها" name="licence_type" value="{{$client->licence_type}}">
                <label class="alert" id="client_licence_type"></label>
            </div>
            <div class="col-xs-3">
                <input type="text" placeholder="الجهة" name="licence_from" value="{{$client->licence_from}}">
                <label class="alert" id="client_licence_from"></label>
            </div>
            <div class="col-xs-3">
                <input type="text" placeholder=" التاريخ" name="licence_to" value="{{$client->licence_to}}">
                <label class="alert" id="client_licence_to"></label>
            </div>
        </td>
    </tr>
    <tr>
    <tr>
        <th>
            الديون
        </th>
        <td>
            {{$dept}}
        </td>
    </tr>
    <tr>
        <th>
            تقييم الدفع
        </th>
        <td dir="ltr">
            @for ($i = 1; $i <= $payrate; $i++)
                <i class='fa fa-star'></i>
            @endfor
            {{--*/ $payrate = 10 - $payrate /*--}}
            @for($i = 1; $i <= $payrate; $i++)
                <i class='fa fa-star-o'></i>
            @endfor
        </td>
    </tr>
    <tr>
        <th>
            تقييم الاستهلاك
        </th>
        <td dir="ltr">
             @for ($i = 1; $i <= $userate; $i++)
                 <i class='fa fa-star'></i>
                 @endfor
                 {{--*/ $userate = 10 - $userate /*--}}
             @for($i = 1; $i <= $userate; $i++)
                <i class='fa fa-star-o'></i>
                @endfor
        </td>
    </tr>
    <tr>
        <th>
             ملاحظات
        </th>
        <td>
            <div class="col-xs-12">
                <textarea name="notes">{{$client->user->notes}}</textarea>
                <label class="alert" id="client_notes"></label>
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

    @if(sizeof($rentings)) {{----}}
    <table>
        <tr>
            <th>
                رقم الحجز
            </th>
            <th>
                السيارة
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
            <th>
الكيلومترات الزيادة
            </th>
            <th>
                المدفوع
            </th>
            <th>
                تقييم الدفع
            </th>
            <th>
                تقييم الاستهلاك
            </th>
            <th>
               ملاحظات
            </th>
        </tr>
        @foreach($rentings as $renting)
        <tr>
            <td>
{{$renting->id}}
            </td>
            <td>
                    <a href="/car/-{{$renting->car->id}}">{{$renting->car->name}}</a>
            </td>
            <td>
                {{ date_format( new DateTime($renting->start_duration),"Y-m-d")}}
            </td>
            <td>
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
                {{$renting->KM_Counter_Penalty_total}}
            </td>
            <td>
                {{$renting->KM_Counter_Penalty_paid}}
            </td>
            <td dir="ltr">
                {{--*/ $payrate = $renting->payrate /*--}}
                @for ($i = 1; $i <= $payrate; $i++)
                    <i class='fa fa-star'></i>
                @endfor
                {{--*/ $payrate = 10 - $payrate /*--}}
                @for($i = 1; $i <= $payrate; $i++)
                    <i class='fa fa-star-o'></i>
                @endfor
            </td>
            <td dir="ltr">
                {{--*/ $userate = $renting->userate /*--}}
            @for ($i = 1; $i <= $userate; $i++)
                    <i class='fa fa-star'></i>
                @endfor
                {{--*/ $userate = 10 - $userate /*--}}
                @for($i = 1; $i <= $userate; $i++)
                    <i class='fa fa-star-o'></i>
                @endfor
            </td>
            <td>
                {{$renting->notes}}
            </td>
        </tr>
            @endforeach
    </table>
        @else
   <h3 class="text-center text-red">لم يتم العثور علي اي حجوزات</h3>
        @endif
</div>
    <div class="Debts box main-box">
        <h3 class="title">الديون</h3>
    @if($dept)
        <table>
            <tr>
                <th>
                    رقم الحجز
                </th>
                <th>
                    النوع
                </th>
                <th>
                    الدين
                </th>
                <th></th>
            </tr>
            @foreach($rentings as $renting)
                @if($renting->dept)
            <tr>
                <td>
                    {{$renting->id}}
                </td>
                <td>
                    مبلغ متأخر من الحجز
                </td>

                <td>
                    {{$renting->dept}}
                </td>
                <td><button data-popup="Dept-Popup" data-id="{{$renting->id}}" class="main-btn sm-btn">دفع</button></td>
            </tr>
                @endif
                @if($renting->KM_Dept)
            <tr>
                <td>
                    {{$renting->id}}
                </td>
                <td>
                    مبلغ متأخر من الكيلومترات
                </td>

                <td>
                    {{$renting->KM_dept}}
                </td>
                <td><button data-popup="KMDept-Popup" data-KM_id="{{$renting->id}}" class="main-btn sm-btn">دفع</button></td>
            </tr>
                @endif
            @endforeach
        </table>
        @else
            <h3 class="text-center text-red">لم يتم العثور علي اي ديون</h3>
        @endif
    </div>
    <div class="attachments box main-box">
        <h3 class="title">الملفات المرفقة</h3>
        <div class="col-xs-12 text-right" style="margin:5px 0">
            <button type="button" class="main-btn" data-popup="AddAttachment-Popup">اضافة مرفق جديد</button>
        </div>
        <table border="1">
            @if(sizeof($client->user->attachments))
                @foreach($client->user->attachments as $attachment)
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
                    </tr>
                @endforeach
            @else
                <h3 class="text-red text-center">لا توجد اي مرفقات بعد </h3>
                <div class="clearfix"></div>
            @endif
        </table>

    </div>
    <div class="attachments box main-box">
        <h3 class="title">الدفعات</h3>
        <table border="1">
            @if(sizeof($client->incomes))
                    <tr>
                        <th>
                            النوع
                        </th>
                        <th>
                            رقم الحجز
                        </th>
                        <th>
                            المبلغ
                        </th>
                        <th>
                            التاريخ
                        </th>
                        <th>
                            الموظف
                        </th>
                    </tr>
                @foreach($client->incomes as $income)
                    <tr>
                    <td>
                        {{$income->title}}
                    </td>
                    <td>
                        {{$income->renting_id}}
                    </td>
                    <td>
                        {{$income->value}}
                    </td>
                    <td>
                        {{ date_format( new DateTime($income->created_at),"d-m-Y")}}
                    </td>
                    <td>
                        {{$income->user->display_name}}
                    </td>
                    </tr>
                @endforeach
            @else
                <h3 class="text-red text-center">لا توجد اي دفعات بعد </h3>
                <div class="clearfix"></div>
            @endif
        </table>

    </div>
@endsection
@section('script')
    <script>
        $("#client_image").fileinput({
            showUpload: false,
            showCaption: false,
            browseClass: "btn main-btn",
            fileType: "any",
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
        });
    </script>
<script src="{{ asset('AjaxRequests/Client.js') }}"></script>
@endsection
