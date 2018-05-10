<!doctype html>
<html>

<head>
    <!-- Css Files -->
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }} " media='all'>
    <!-- Css Files -->
    <meta charset="utf-8">
    <title>تأكيد الحجز</title>
</head>


<body>
<div class="background"></div>
<div id="EditAmount-Popup" class="popup">
    <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
    <!--===== POPUP TITLE -=====-->
    <div class="popup-title">
        <h2>تعديل المبلغ</h2>
        <br>
        <hr>
        <hr>
    </div>
    <!--===== POPUP BODY ======-->
    <div class="popup-body text-center">
        <div class="col-xs-12">
            <input type="text" id="amount" placeholder="المبلغ">
        </div>
        <div class="text-center">
            <button class="main-btn">تأكيد</button>
        </div>
        </form>
    </div>
</div>
<div class="confirmation">
    <div  id="approval" class="approval">
        <div class="contents" style="margin-top:250px">
            <div class="col-xs-12">
                اقر انا الموقع ادناه السيد : <b>{{ $client->user->display_name }}</b>
            </div>
            <div class="col-xs-12">
                بطاقة / جواز سفر رقم : <b>{{ $client->user->national_id }}</b>
            </div>
            <div class="col-xs-12">
                المقيم : <b>{{ $client->user->address }}</b>
            </div>
            <div class="col-xs-5">
                انني استلمت السيارة رقم : <b> {{$car_user_data->plate}} </b>
            </div>
            <div class="col-xs-4">
                ماركة : <b> {{$car_user_data->name}} </b>
            </div>
            <div class="col-xs-3">
                لون : <b> {{$car_user_data->color}} </b>
            </div>
            <div class="col-xs-7">

                صادرة من :
                <b> {{$car_user_data->licence_from}} </b>
            </div>
            <div class="col-xs-5">
                تاريخ اصدارها : <b> {{$car_user_data->licence_date}} </b>
            </div>
            <div class="col-xs-12">
                ملك السيد : <b>{{$car_user_data->licence_owner }}</b>
            </div>
            <div class="col-xs-12 text-justify">
                السيارة في حالة جيدة و مستوفاة لجميع شروط العمل و أصبحت مسئولا عنها جنائيا و مدنيا عن جميع المخالفات و الحوادث و الاضرار التي تسببها هذه السيارة للغير كما أقر بأنني
                علي علم تام بالشروط القانونية و تنفيذها بدقة و ليس لي الحق بتحميلها اي بضاعة مخالفة للقانون و أصبحت مسئولا مسئولية كاملة عن هذه السيارة
                من تاريخ و ساعة استلامها لحين تسليمها و أتعهد بتعويض و إصلاح أي ضرر قد يحدث لها مني فورا و دون تأخير و ذلك بعد الرجوع للشركة المؤجرة
                كما أتعهد في حالة حدوث حادث او سرقة او فقد السيارة.
            </div>
            <div class="col-xs-12">
                دفع مبلغ و قدره : <b>  {{$car_user_data->car_price}} </b>
            </div>
            <div class="col-xs-5">
                و هذا الاقرار ساري من تاريخ :
                <b>{{$data['start_duration']}} </b>
            </div>
            <div class="col-xs-7">
                حتي تاريخ :
                <b> &nbsp;&nbsp; &nbsp; &nbsp;- &nbsp;&nbsp; &nbsp; &nbsp;- &nbsp; &nbsp;&nbsp; &nbsp;</b>

                &nbsp; &nbsp; &nbsp;
                في تمام الساعة :
                <b> </b>
            </div>
            <div class="col-xs-12" style="margin-bottom:10px">
                اذا استخدم اي شخص غير المستأجر (الطرف الثاني) في العقد تسحب السيارة منه فورا دون الرجوع للطرف الثاني و يتم تغريمه مبلغ
                500 جنيه.
            </div>
            <b class="text-center col-xs-12">
                و هذا اقرار مني بذلك للعمل بموجبه عند اللزوم
            </b>

            <div class="text-left" style="margin-top:2px">
                <span class="text-center" style="margin-bottom:5px">  امضاء المستلم</span>
                <br>
                ...................................
            </div>
        </div>
    </div>
    <div id="contractor" class="contract">
        <div class="logo col-xs-3" style="opacity: 0">
            <div>
                <img src="images/logo_ar.png" width="160">
            </div>
        </div>
        <div class="contract-title col-xs-6 text-center" style="opacity: 0">>
            <h3>عقد ايجار سيارات</h3>
            <b>س . ت : 16510</b>
        </div>
        <div class="logo col-xs-3" style="opacity: 0">>
            <img src="images/logo.png" width="110">
        </div>
        <div class="clearfix">

        </div>
        <div class="contents">
            <div class="col-xs-6 info">
                <div class="general-info">
                    انه في يوم <b>
                        @if(date("l",strtotime($data['start_duration']))=="Saturday")
                            السبت
                        @elseif(date("l",strtotime($data['start_duration']))=="Sunday")
                            الاحد
                        @elseif(date("l",strtotime($data['start_duration']))=="Monday")
                            الاثنين
                        @elseif(date("l",strtotime($data['start_duration']))=="Tuesday")
                            الثلاثاء
                        @elseif(date("l",strtotime($data['start_duration']))=="Wednesday")
                            الاربعاء
                        @elseif(date("l",strtotime($data['start_duration']))=="Thursday")
                            الخميس
                        @elseif(date("l",strtotime($data['start_duration']))=="Friday")
                            الجمعة
                        @endif
                    </b>
                    الموافق <b>{{date("Y-m-d",strtotime($data['start_duration']))}}</b>
                    الساعة <b>{{date("h:i")}}</b>
                    <span style="border-bottom:1px solid #222;display:block;width:125px;">تم الاتفاق بين كلا من</span>
                    <div class="between">
                        اولا : شركة <b class="text-red">فرســت</b> ليموزين لتأجير السيارات (طرف اول مؤجر)
                        ثانيا : السيد <b>{{ $client->user->display_name }}
                        </b> (طرف ثاني مستأجر)
                    </div>
                    <div class="client-info">
                        <table border="1" class="main-info">
                            <tr>
                                <th>
                                    الجنسية
                                </th>
                                <th>
                                    بطاقة / جواز
                                </th>
                                <th>
                                    تاريخ و جهة الاصدار
                                </th>
                                <th>
                                    تاريخ الميلاد
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    {{$client->user->nationality}}
                                </td>
                                <td>
                                    {{$client->user->national_id}}

                                </td>
                                <td>
                                    {{$client->user->id_date}}<br>
                                    {{$client->user->id_from}}

                                </td>
                                <td>
                                    {{ $client->user->birth }}
                                </td>
                            </tr>
                        </table>
                        <table border="1" class="license-info">
                            <tr>
                                <th>
                                    الرخصة
                                </th>
                                <th>
                                    نوعها
                                </th>
                                <th>
                                    جهة الاصدار
                                </th>
                                <th>
                                    صالحة حتي
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    {{$client->licence}}
                                </td>
                                <td>
                                    {{$client->licence_type}}
                                </td>
                                <td>
                                    {{$client->licence_from}}
                                </td>
                                <td>
                                    {{$client->licence_to}}
                                </td>
                            </tr>
                        </table>
                        <div class="contact-info">
                            عنوان المنزل : <b>{{ $client->user->address }}</b><br>
                            عنوان العمل : <b>{{ $client->user->office }}</b><br>
                            الموبايل : <b>{{ $client->user->phone }}</b>
                        </div>
                    </div>
                    <div class="car-info">
                        <div class="text-center" style="margin:7px 0">
                  <span class="title">
                      بيانات السيارة
                  </span>
                        </div>

                        <table border="1" class="main-info">
                            <tr>
                                <th>
                                    السيارة
                                </th>
                                <th>
                                    موديل / لون
                                </th>
                                <th>
                                    رقم اللوحة
                                </th>
                                <th>
                                    رقم الموتور
                                </th>
                                <th>
                                    رقم الشاسيه
                                </th>
                                <th>
                                    مالك السيارة
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    {{ $car_user_data->name }}
                                </td>
                                <td>
                                    {{ $car_user_data->model }}<br>
                                    {{ $car_user_data->color }}
                                </td>
                                <td>
                                    {{ $car_user_data->plate }}
                                </td>
                                <td>
                                    {{ $car_user_data->motor }}
                                </td>
                                <td>
                                    {{ $car_user_data->chassis }}
                                </td>
                                <td>
                                    {{ $car_user_data->licence_owner}}
                                </td>
                            </tr>
                        </table>
                        عداد الكيلومترات : <b>{{ $car_user_data->KM_Counter }}</b>
                        <b style="font-size:14px;margin-left:50px" class="text-red fl-left">{{$sn}}</b>
                        <table border="1" class="reservation-info">
                            <tr>
                                <th>
                                    مدة الايجار
                                </th>
                                <th>
                                    ايجار اليوم
                                </th>
                                <th>
                                    ايجار المدة
                                </th>
                                <th>
                                    المدفوع
                                </th>
                                <th>
                                    الباقي
                                </th>
                                <th>
                                    ملاحظات
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    {{ $number_of_days." يوم " }}
                                </td>
                                <td>
                                    {{ $car_user_data->day_price }}
                                </td>
                                <td>
                                    {{ $data['reservation_required_money'] }}
                                </td>
                                <td>
                                    {{ $data['paid'] }}
                                </td>
                                <td>
                                    {{ $data['reservation_required_money'] - $data['paid'] }}
                                </td>
                                <td>

                                </td>
                            </tr>
                        </table>
                        <span class="text-red">
                  مدة العقد هي المدة المدونة بصدد العقد و لا تجدد و في حالة تواجد السيارة مع غير مالكها
                  او بدون عقد ايجار بمدة سارية تسلم السيارة لاقرب قسم شرطة او جهة مرور
                </span>
                    </div>
                    <div class="approve">
                        <div class="text-center" style="margin:7px 0">
                            <span class="title">اقــــــرار</span>
                        </div>

                        <div style="font-size:10px">
                            اقر انا / .......................................................<br>
                            بانني قرأت الشروط الواردة بالعقد و انني موافق علي ذلك و اتعهد باعادة السيارة الموضحة
                            بياناتها أعلي و خلفة
                            و انهاء العقد و اعتماده و سداده و تعتبر السيارة امانة ملزمة بردها عند انتهاء مدة العقد
                            بالحالة الفنية التي كانت عليها
                            عند استلامها و ان خالفت ذلك اعتبرت مبددا و خائنا للامانة و اعتبر مسئول مسئولية مدنية و جنائية
                            الناتجةعن السيارة
                            و عنه استخدام السيارة في اي عمل غير مشروع او مخالف للقانون
                            <div class="text-left" style="margin-top:5px;">
                                <span class="">توقيع مستأجر السيارة :   .................................   </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-6 conditions" style="padding:1px;">
                <div class="text-center" style="margin-bottom:7px;">
                    <span>أقر المتعاقدين للتعاقد و التصرف قانونيا بالبنود التالية</span>
                </div>
                1 - التزام المستأجر باستخدام السيارة موضع هذا العقد في التنقلات الشخصية خلال مدة العقد فقط .
                <br>2 - في حالة رغبة المستأجر تجديد مدة العقد عليه ان يخطر الطرف الاول قبل انتهاء مدة الايجار بيوم واحدة
                علي الاقل
                و موافقة الطرف الاول كتابيا بذلك لأنه في حالة عدم الاخطار تحسب كل ساعة تأخير عن موعد التسليم ب 50 جنيه
                بحد اقصي ثمانية
                ساعات بعدها يحق للطرف الاول ابلاغ الجهات المسئولة عن فقد السيارة و تبديدها و يحسب يوم التأخير ب ثلاثة
                ايام من القيمة الايجارية .
                <br>3 - معدل استخدام السيارة لا يتعدي المائة و ثلاثون كيلو متر لليوم الواحد و الحد الادني لإيجار سيارة ثلاثة ايام و يغرم المستأجر
                مبلغ 1000 جنيه في حالة العبث في عداد الكيلو مترات .
                <br>4 - المستأجر وحده المسئول عن كافة الجرائم و المخالفات الناتجة عن استخدام السيارة في اغراض غير مشروعة
                باستخدامها و عدم تمكين
                الغير من قيادتها ما لم يكن اسمه مدون بالعقد و يحق للطرف الاول سحب السيارة من الطرف الثاني اذا وجدت
                بقيادة شخص اخر و تغريمه
                مبلغ 500 جنيه .
                <br>5 - الرجوع فورا للمؤجر في حالة اي عطل او خلل بالسيارة او بعداد الكيلومتر و في حالة الحادث قبل اي
                تصليح .
                <br>6 - تسلم السيارة للفرع المؤجر منه ما لم يتم الاتفاق خطيا علي خلاف ذلك و في حالة وقوع حادث يلتزم
                المستأجر بالنفقات
                و نقلها لمقر المؤجر و دفع تكلفة الحادث .
                <br>7 - يقر الطرف الثاني انه علي علم تام بجميع قوانين المرور و الامن العام و يتعهد باستعمال السيارة
                بطريقة لا تخالف القوانين
                و يكون مسئولا مدنيا و جنائيا عن كافة الاضرار للغير .
                <br>8 - اذا سحبت رخصة التسيير لأي سبب يكون الطرف الثاني ملزما باحضارها او دفع التعويضات اللازمة و مدة
                عطل السيارة لحين احضار
                رخصة التسيير كايجار يومي .
                <br>9 - يلتزم الطرف الثاني بسداد القيمة الايجارية عن مدة العقد بأكمله حتي اذا ما قام برد السيارة قبل
                موعد العقد لا يجوز له
                المطالبة بقيمة المدة المتبقية .
                <br>10 - يقر الطرف الثاني انه استلم السيارة المؤجرة بصفة الامانة و هي في حالة جيدة و صالحة للاستعمال و
                تعهد بالمحافظة
                عليها و ردها بالحالة التي كانت عليها قبل الاستلام و في حالة حدوث حادث يلتزم بدفع مبلغ
<b>  {{$car_user_data->car_price}} </b>
                <div class="client">
                    <div  style="font-size:10px;margin:7px 0">
                        <span class="title">التزامات المؤجر</span>
                    </div>
                    يمكن تمديد العقد بناء علي رغبة المستأجر و بموافقة المؤجر خطبا. <br>
                    استلام السيارة المؤجرة التي يقع عليها حادث مباشر مع اعتبار تاريخ وقوع الحادث هوا نهاية عقد التأجير و
                    علي المستأجر
                    ابلاغ المؤجر في الحال بارسال مندوب و انهاء الحادث فورا من قبل الطرفين و اذا لم يبلغ فهو المسئول عن
                    تصرفه

                </div>
                <div class="general-cond" style="font-size:9px;">
                    <div style="margin:7px 0">
                        <span class="title">شروط و اسس عامة</span>
                    </div>
                    في حالة استئجار السيارة بسائق تكون مدة عمل السائق 8 ساعات يوميا يتم دفع مبلغ
                    <span style="cursor: pointer;" data-popup="EditAmount-Popup" data-amount="">( &nbsp;  &nbsp;  )</span>
                    عن كل ساعة اضافية و يلزم المستأجر بتأمين المسكن و المعيشة للسائق في حالة السفر خارج المدينة المستأجر
                    فيه السيارة
                </div>
                <div class="sign" style="
    font-size: 10px;margin-top:17px;
">
                    امضاء المستلم : ......................................................
                    توقيع المستلم : .................................................
                </div>

            </div>
            <div class="clearfix">
            </div>
        </div>
        <div class="text-center" style="opacity:0;font-size:14px;margin-top:10px;">
            6 اكتوبر- الحي السابع - سنتر المختار - مكتب ( 53 )<br>
            6 أكتوبر - الحي الثاني - ميدان الحصري - أمام البنك العربي
            <br>
            01200070025 - 01061616081 - 01112539699 <br>
            Email : firstcar2013@yahoo.com - www.facebook.com/alaa.abueldahab
        </div>
    </div>
    <div class="text-center" style="margin:20px;">
        {!! csrf_field() !!}
        <button id="End_Print" class="main-btn">تأكيد و طباعة</button>
        <button id="End_Print2" class="main-btn">طباعة الاقرار</button>
        <a id="back_print" href="{{ URL::route('dashboard') }}"><button class="main-btn">الرجوع الي لوحة التحكم</button></a>
    </div>
</div>
<footer id="footer">
    <div class="container">
        <h5 class="fl-right">2016 | جميع الحقوق محفوظة</h5>
        <h5 class="fl-left">تصميم و تطوير <img src="{{ asset('images/aptware.png')}}" width="35"></h5>
    </div>
</footer>


<!-- Js Files -->
<script src="{{ asset('js/jquery-3.1.0.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>
<script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
<script src="{{ asset('AjaxRequests/ErrorHandler.js') }}"></script>
<script src="{{ asset('js/print.js')}}"></script>
<script src="{{ asset('AjaxRequests/Rentings.js') }}"></script>
<script>
    $('document').ready(function(){
        var Amount ;
        $('span').click(function(){
            if(this.hasAttribute('data-amount'))
            {
                Amount = $(this);
            }
            $("#EditAmount-Popup button").click(function(){
                Amount.text($("#EditAmount-Popup input").val());
                $("#EditAmount-Popup").fadeOut(600,function(){
                    $("#EditAmount-Popup input").val("");
                    $(".background").fadeOut(600);
                })
            })

        });
    })
</script>
<!-- Js Files -->

<!------------------------------------------------------------------------------------------------------------------->

</body>

</html>

