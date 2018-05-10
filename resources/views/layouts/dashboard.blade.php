@extends('layouts.master')
@section('styles')
    <!-- Css Files -->
    <style>
        .bootstrap-select>.btn
        {
            padding:12px;
            font-size: 16px;
            background:#f5f5f5;
            border:0;
            color:#e7534b;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 5px;
            transition: .4s all ease-in-out;
            text-align: right;
            direction: rtl;
            resize:none;
        }
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn)
        {
            width:100%;
            text-align: right;
        }
        .bootstrap-select.btn-group .btn .caret
        {
            left:20px;
            right: auto;
        }
        .bootstrap-select.btn-group .btn .filter-option,
        .open>.dropdown-menu
        {
            text-align: right;
        }
        .open>.dropdown-menu
        {
            background: #f5f5f5;
            font-size:18px;
        }
        .dropdown-menu>li>a
        {
            color:#dd4c44;
        }
        .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover,.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover
        {
            color: #fff;
            text-decoration: none;
            background-color: #dd4c44 !important;
            outline: 0;
        }
        .dropdown-menu>.active>a small, .dropdown-menu>.active>a:focus small, .dropdown-menu>.active>a:hover small ,.dropdown-menu>li>a:focus small, .dropdown-menu>li>a:hover small
        {
            color: #fff !important;
        }
        small
        {
            font-size:65%;
            color:#333
        }
        input.input-block-level,
        input.input-block-level:focus
        {
            outline:0;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }
        header>.container img
        {
            width: 140px;
        }
    </style>
    @yield('tab-style')
@endsection

@section('contents')
    <div class="background">

    </div>

    <!-- START ADD Reservation FORM -->
    <div id="DeleteUser-Popup" class="popup">
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
            <form id="DeleteUser" type="POST">
                <h3 class="text-red ">سيتم حذف جميع بيانات هذا المستخدم .. هل انت متأكد بأنك تريد الحذف ؟ </h3>
                {!! csrf_field() !!}

                <input type="hidden" class="hidden" name="id" id="IDVal">
                <div class="text-center">
                    <button type="submit" class="main-btn">نعم</button>
                </div>
                <div class="alert"role="alert">

                </div>
            </form>
        </div>
    </div>
    <!-- END ADD Reservation FORM -->


    <!-- START ADD Reservation FORM -->
    <div id="AccountInfo-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>بيانات الحساب</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="EditInfo">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{$user->id}}" class="hidden">
                <div class="col-md-4 col-xs-12">
                    <label>الاسم الاول</label>
                    <input type="text" name="first_name" value="{{ $user->first_name }}">
                    <label class="viewerror" id="user_first"></label>
                </div>
                <div class="col-md-4 col-xs-12">
                    <label>الاسم الاخير</label>
                    <input type="text" name="last_name"  value="{{ $user->last_name }}">
                    <label id="user_last"></label>

                </div>
                <div class="col-md-4 col-xs-12">
                    <label>تاريخ الميلاد</label>
                    <input type="date" name="birthdate"  value="{{ date_format( new DateTime($user->birthdate),"Y-m-d")}}">
                    <label class="viewerror" id="user_birthdate"></label>

                </div>
                <div class="col-md-6 col-xs-12">
                    <label>رقم التليفون</label>
                    <input type="text" name="phone"  value="{{ $user->phone }}">
                    <label class="viewerror" id="user_phone"></label>

                </div>
                <div class="col-md-6 col-xs-12">
                    <label>رقم البطاقة</label>
                    <input type="text" name="national_id"  value="{{ $user->national_id }}">
                    <label class="viewerror" id="user_national_id"></label>
                </div>
                <div class="col-xs-12">
                    <label>العنوان</label>
                    <input type="text" name="address"  value="{{ $user->address }}">
                    <label class="viewerror" id="user_address"></label>
                </div>
                <div class="col-md-6 col-xs-12">
                    <label>كلمة المرور</label>
                    <input name="password" type="password">
                    <label class="viewerror" id="user_password"></label>

                </div>
                <div class="col-md-6 col-xs-12">
                    <label>تأكيد كلمة المرور</label>
                    <input name="password_confirmation" type="password">
                    <label class="viewerror" id="user_password_confirm"></label>

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
    <!-- END ADD Reservation FORM -->

    <div id="wrap">
        {{-- header loads here--}}
        @include('layouts.header')
        <div class="wrapper">
            {{-- side panel loads herer--}}
            @include('layouts.sidebar')
            <section class="content col-xs-12">
                <div class="container-fluid">
                    <div class="tab-content">


                        @yield('tab-contents')


                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Js Files -->

    <script src="{{ asset('js/fileinput.min.js') }}"></script>
    <script src="{{ asset('AjaxRequests/UpdateUser.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script>
        $('.list-view').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "language": {
                "zeroRecords":"للاسف لا توجد اي بيانات",
                "oPaginate": {
                    "sFirst": "الاولي", // This is the link to the first page
                    "sPrevious": "السابق", // This is the link to the previous page
                    "sNext": "التالي", // This is the link to the next page
                    "sLast": "الاخيرة" // This is the link to the last page
                }
            }
        });
    </script>

    <script>
        $("#car_image,.car_image").fileinput({
            showUpload: false,
            showCaption: false,
            browseClass: "btn main-btn",
            fileType: "any",
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
        });
    </script>

    <script>
        $(".dataTables_filter input").removeClass("form-control input-sm").
        appendTo("#Clients-Filter,#Employees-Filter,#Cars-Filter,#Reservations-Filter,#Partners-Filter");
        $(".dataTables_length select").removeClass("form-control input-sm").
        appendTo("#Clients-Length,#Employees-Length,#Cars-Length,#Reservations-Length,#Partners-Length");
        $("div.dataTables_length label , div.dataTables_filter label").remove();

    </script>
    <script>
        $('input[type=date]').datepicker({
            // Consistent format with the HTML5 picker
            dateFormat: 'yy-mm-dd'
        });
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        var DocumentWidth = $(window).width();
        $("section.content").width(DocumentWidth - 265)


        $("header i.fa-bars").click(function () {
            $(this).hide();
            $("i.fa-close").fadeIn();
            $(".SideBar").show();
            var ContentWidth = $(".content").width();
            var value = 150;
            $(".SideBar").width(value);
            $("#wrap").css("marginRight", value)
        });
        $("header i.fa-close").click(function () {
            $(this).hide();
            $("i.fa-bars").fadeIn();
            var ContentWidth = $(".content").width();
            $(".SideBar").animate({width: '0'}, 400, function () {
                $(".SideBar").delay(700).fadeOut(1);
            });
            $("#wrap").animate({marginRight: '0'}, 400);

        });
        $(".notifcation-icon").click(function(){
            $.ajax({
                url:"/notifications/read",
                success:function(data){
                    $(".notifcation-icon .number").text(0).fadeOut();
                },
                error:function(data){
                    //alert(data['responseText']);
                }
            });
        })
        $(".notifcation-body li .fa-remove").click(function(){
            var icon = $(this);
            var notif_id = $(this).attr('data-id');
            $.ajax({
                url:"/notifications/delete",
                data: { id: notif_id},
                success:function(data){

                    icon.parent().fadeOut(700);

                },
                error:function(data){
                    // alert(data['responseText']);
                }
            });
        })

    </script>
    @yield('tab-script')
    <!-- Js Files -->
    @endsection
    </body>

    </html>
