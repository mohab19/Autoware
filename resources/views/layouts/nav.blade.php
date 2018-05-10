<nav class="navbar navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better ile display -->
        <div class="navbar-header fl-right">
            <button type="button" class="navbar-toggle collapsed text-left" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="text-red" style="font-size:28px">
                فرست
                <span style="color:#aaa">كار</span>
            </div>

        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="#home">الرئيسية</a></li>
                <li><a href="#about">عن الشركة </a></li>
                <li><a href="#Features">مميزاتنا</a></li>
                <li><a href="#cars">السيارات</a></li>
                <li><a href="#advertisements">الاعلانات</a></li>
                <li><a href="#contact">تواصل معنا</a></li>
                @if(Auth::check())
                    <li><a href="{{ URL::route('dashboard') }}">لوحة التحكم</a></li>
                    <li><a href="{{ URL::route('logout') }}">تسجيل الخروج</a></li>
                @else
                    <li><a href="{{ URL::route('login') }}" data-popup="test-popup">تسجيل الدخول</a></li>
                @endif

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>