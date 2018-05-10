@extends('layouts.master')
@section('styles')
    <style>
        body
        {
            background: #0B2232;
        }
        .login , .popup-title{

            border-top-right-radius:0.4em;
            border-top-left-radius: 0.4em;

        }
        .popup-title
        {
            padding: 7px;
            color:#e62031;
            text-align: center;
        }
        .login
        {

            width:70%;
            margin:6% auto;
            padding:30px;
            padding-bottom: 0;
            display: block !important;
            background: #eee;
        }
        .inner-addon
        {
            margin-bottom: 20px !important;
        }
    </style>
    @endsection
@section('title')
    تسجيل الدخول
    @endsection
@section('contents')

    <div class="login">
        <!--==== POPUP TITLE ====-->
        <div class="popup-title">
            <h2>تسجيل الدخول</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--==== POPUP BODY ====-->
        <div class="popup-body">

            <form id="login" class="text-center" >
                {!! csrf_field() !!}
                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-user"></i>
                    <input type="text" class="email1" placeholder="البريد الالكترونى"><br>
                    <label class="alert" id="email_error"></label>
                </div>

                <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-lock"></i>
                    <input type="password" class="password1" placeholder="كلمة المرور"><br>
                    <label class="alert"  id="password_error"></label>
                </div>

                <div class="remember-me">

                    <div class="col-md-4 text-right" style="margin-right: 80px;">
                        <input name="remember" id="rememeber" type="checkbox">
                        <label for="rememeber" style="display:inline-block !important;margin-right:15px;font-size:16px;" class="text-red">تذكرني</label>
                    </div>
                    <div class="col-md-6 text-left">
                        <div class="line"><a href="/password/email" class="text-red">نسيت كلمة المرور ؟</a></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 text-center">
                    <button type="submit" class="main-btn">تسجيل الدخول</button>

                </div>
                <div class="clearfix"></div>
                <div class="alert"></div>
            </form>
        </div>
        <!--====== POPUP CONTENT ====-->

        <div class="popup-content"></div>

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('AjaxRequests/login.js') }}"></script>
@endsection