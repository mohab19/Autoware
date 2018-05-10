<!doctype html>
<html>
    <head>
        <!-- Css Files -->
        <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    @yield('styles')
    <!-- Css Files -->
        <meta charset="utf-8">
        <title>@yield('title')
        </title>
    </head>
    <body>
        @yield('contents')
        <footer>
            <div class="container">
                <h5 class="fl-right">2016 | جميع الحقوق محفوظة</h5>
                <h5 class="fl-left">تصميم و تطوير <img src="{{ asset('images/aptware.png')}}" width="35"></h5>
            </div>
        </footer>
        @extends('layouts.loading')
        <script src="{{ asset('AjaxRequests/ErrorHandler.js') }}"></script>
        <script src="{{ asset('js/jquery-3.1.0.min.js')}}"></script>
        <script src="{{ asset('js/bootstrap.js')}}"></script>
        <script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
        <script src="{{ asset('js/ui.js') }}"></script>
        @yield('scripts')
        <script src="{{ asset('js/main.js')}}"></script>
    </body>
</html>