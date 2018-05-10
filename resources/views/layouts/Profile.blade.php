<!doctype html>
<html>

<head>
    <!-- Css Files -->
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
@yield('profile-style')

    <!-- Css Files -->
    <meta charset="utf-8">
  <title>@yield('title')</title>
</head>


<body>

<div class="background"></div>

<header>
    <div class="container">
        <div class="fl-right">
            @yield('desc')
        </div>
        @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1 ||\Illuminate\Support\Facades\Auth::user()->role_id == 3 )
        <div class="fl-left">
            <a href="@yield('backto')">العودة الي لوحة التحكم</a>
        </div>
            @else
            <div class="fl-left">
                <a href="/logout">تسجيل الخروج</a>
            </div>
        @endif
    </div>
</header>

<section class="contents">
    <div class="container">
        @yield('contents')
    </div>
</section>

<footer>
    <div class="container">
        <h5 class="fl-right">2016 | جميع الحقوق محفوظة</h5>
        <h5 class="fl-left">تصميم و تطوير <img src="{{ asset('images/aptware.png')}}" width="35"></h5>
    </div>
</footer>
@include('layouts.loading')
<!-- Js Files -->

<script src="{{ asset('js/jquery-3.1.0.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>
<script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
<script src="{{ asset('js/main.js')}}"></script>
<script src="{{ asset('AjaxRequests/ErrorHandler.js') }}"></script>
<script src="{{ asset('js/fileinput.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script>$('input[type=date]').datepicker({
        // Consistent format with the HTML5 picker
        dateFormat: 'yy-mm-dd'
    });
</script>
    @yield('script')
<!-- Js Files -->
</body>

</html>
