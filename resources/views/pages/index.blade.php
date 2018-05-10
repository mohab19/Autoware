<!doctype html>
<html>

<head>
    <!-- Css Files -->
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    <!-- Css Files -->
    <meta charset="utf-8">
    <title>فرست كار</title>
    <style>
        /* Start Header */

        header {
            background: url(images/header.jpg) center;
            background-size: 100% 100%;
            text-align: center;
            height: 750px;
            width: 100%;
            overflow: hidden;
        }

        header .color {

            background: rgba(255, 255, 255, 0.8);
            background-size: cover;
            position: relative;
            height: 750px;
        }

        header .lead {
            color: #0b2233;
            line-height: 1.7;
            width: 70%;
            margin: auto;
            margin-top: 0px;
            font-size: 70px;
        }

        header .to {
            color: #0b2233;
            line-height: 1.7;
            width: 70%;
            margin: auto;
            margin-top: 0px;
            font-size: 35px;
        }

        header .info {
            padding-top: 19%
        }

        header a {
            background: none;
            border: none;
            text-decoration: none;
            color: #eee;
            font-size: 30px;
            -moz-transition: all 0.5s ease-in-out;
            -o-transition: all 0.5s ease-in-out;
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
            text-decoration: none;
            margin-top: 20px;
        }

        header a .fa {
            display: block;
            margin: 0;
        }

        header a:focus {
            outline: none;
            color: #FFF;
            text-decoration: none;
        }

        header a:hover {
            color: #fff;
            background:
        }

        header a:active {
            outline: none;
            color: #FFF;
            text-decoration: none;
        }

        .Hbtn {
            border-radius: 5px;
            color: #fff;
            font-size: 28px;
            margin-top: 29px;
            width: 17%;
            height:: 40%;
            padding: 6px;
            border: none;
            border-bottom: 10px solid #c31c2b;
            background: #e62031;
        }

        /* End Header */

    </style>
</head>


<body data-spy="scroll" data-target=".navbar" data-offset="50">
<div class="background">

</div>
<!-- start Navbar -->
@include('layouts.nav')


<!-- End Navbar -->


<!-- Start Header -->

<header id="home">
    <div class="color">
        <div class="container">
            <div class="info">
                <p class="lead">تبحث
                    <br>عن سيارة مثالية ؟</p>
                <p class="to">انت فى المكان المناسب</p>
            </div>
        </div>
    </div>
</header>

<!-- End Header -->


<!-- ABOUT -->

<section id="about" class="about">

    <div class="container">
        <div class="row">


            <div class="popup-title">
                <h2>عــن الشــركة </h2>
                <br>
                <hr>
                <hr>
                <br>
            </div>
            <div class="about-us">
                <div class="col-md-8 text-right">
                    <div class="right">
                        <p class="to">مرحبا بك فى موقعنا</p>

                        <hr class="straight">
                        <br>
                        <p class="normal">
                            <br> مفهوم السياحة الالكترونية،وتناولت العديد من المنظمات ظهر منذ سنوات قليل<br> وتناولت
                            العديد من المنظمات ظهر منذ سنوات قليلة مفهوم السياحة منظمات <br> ظهر منذ سنوات قليلة مفهوم
                            السياحة الالكترونية، وتناولت العديد من المنظمات<br> ظهر منذ سنوات قليلة مفهوم السياحة
                            الالكترونية،وتناولت العديد من المنظمات<br>


                            وتناولت العديد من المنظمات ظهر منذ سنوات قليلة مفهوم السياحة منظمات <br> ظهر منذ سنوات قليلة
                            مفهوم السياحة الالكترونية، وتناولت العديد من المنظمات<br> ظهر منذ سنوات قليلة مفهوم السياحة
                            الالكترونية،وتناولت العديد من المنظمات<br>

                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="left">
                        <div class="leftred">
                            <img src="{{ asset('images/carr1.png')}}" width="350px" height="350px">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
<!-- END ABOUT -->


<!-- Features -->

<section id="Features" class="Features">
    <div class="color">

        <div class="container">

            <div class="row">
                <br><br><br><br>

                <div class="popup-title">
                    <h2>مميــزات الشــركة </h2>
                    <br>
                    <hr>
                    <hr>
                    <p class="text-Features">
                        <br> مفهوم السياحة الالكترونية،وتناولت العديد من المنظمات ظهر منذ سنوات قليل ظهر منذ سنوات قليلة
                        مفهوممنظمات <br> ظهر منذ سنوات قليلة مفهوم السياحة الالكترونية، مفهوم السياحة
                        الالكترونية،وتناولت من المنظمات ظهر منذ سنوات قليل

                        <br> مفهوم السياحة الالكترونية،وتناولت العديد من المنظمات ظهر منذ سنوات قليل ظهر منذ سنوات قليلة
                        مفهوممنظمات
                    </p>
                </div>
                <br><br><br>
                <div class="col-xs-4">
                    <i class="fa fa-star fa-4x" aria-hidden="true">
                    </i>
                    <h3>خدمة 5 نجوم</h3>
                    <p class="text-Features">
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنواتل
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنواتل<br>
                    </p>
                </div>


                <div class="col-xs-4">
                    <i class="fa fa-cog fa-4x" aria-hidden="true"></i>
                    <h3> سيارتنا تعمل بكفائة عالية </h3>
                    <p class="text-Features">
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنواتل
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنواتل<br>
                    </p>


                </div>

                <div class="col-xs-4">
                    <i class="fa fa-users fa-4x" aria-hidden="true"></i>
                    <h3> خدكة عملاء 24 ساعة </h3>
                    <p class="text-Features">
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنواتل
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنوايل<br>
                    </p>


                </div>
            </div>
        </div>
    </div>


</section>
<!-- END Features -->


<!-- cars-->

<section id="cars" class="cars-view">
    <div class="color">

    </div>
    <div class="container">
        <div class="popup-title" >
            <h2>الســــيارات  </h2>
            <br><hr><hr>
        </div>
        <div id="owl-cars" class="owl-carousel" dir="ltr">
            <?php $cars = \App\models\Car::orderBy('created_at','desc')->get() ?>
            @foreach($cars as $car)
                <div class="item">
                    <div class="back2"></div>
                    <div class="back">
                        <div class="info" style="color:#ec1a25">
                            <h2 style="color:#eee;">{{ $car->name }}</h2>
                            <h3 dir="ltr">
                                <span>في اليوم</span>  {{$car->day_price}}<br>
                                <span>في الشهر</span>  {{$car->month_price}}<br>
                            </h3>
                            <h3 dir="rtl">
                                لون :  <span>{{ $car->color }}</span><br>
                            </h3>
                            <h3>
                                موديل :  <span>{{ $car->model }}</span><br>

                            </h3>
                        </div>
                    </div>
                    <img src="{{ $car->picture }}" alt="لا يوجد صورة" >
                </div>
            @endforeach
        </div>
    </div>
</section>
<section id="advertisements" style="background: #eee;" >
    <div class="container">
        <div class="popup-title" >
            <h2>الاعــلانات  </h2>
            <br><hr><hr>
        </div>
        <div id="owl-advertisements" class="owl-carousel" dir="ltr">
            <?php $advertisements = \App\models\Advertisement::orderBy('created_at','desc')->get() ?>
            @foreach($advertisements as $advertisement)
                <div class="advertisement" style="width:95%">
                        <div class="back2"></div>
                        <div class="text-center image">
                            <img src="{{$advertisement->picture}}">
                            <span dir="ltr" class="price">{{$advertisement->price}} L.E</span>
                        </div>
                        <div class="caption text-center">
                            <h2 class="title">{{$advertisement->title}}</h2>
                            <a href="/announcement/{{$advertisement->id}}/{{$advertisement->title}}"><button class="main-btn sm-btn"> التفاصيل</button></a>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
</section>




<!-- start section contact -->


<footer id="contact">
    <div class="color">
        <div class="container">
            <!-- start container -->
            <div class="row">
                <!-- start row -->

                <div class="popup-title">
                    <h2>تواصــل معنا</h2>
                    <br><br>
                    <hr>
                    <hr>
                </div>


                <br><br>

                <div class="col-xs-4">
                    <i class="fa fa-envelope fa-2x" style="color:#fff;">
                    </i>
                    <p class="text-Features">
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنوات
                    </p>
                </div>


                <div class="col-xs-4">
                    <i class="fa fa-mobile fa-2x" style="color:#fff; "></i>
                    <p class="text-Features">
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنوات
                    </p>


                </div>

                <div class="col-xs-4">
                    <i class="fa fa-map-marker fa-2x" style="color:#fff;"></i>
                    <p class="text-Features">
                        <br> مفهوم السياحة الالكترونية،وتناولت <br>العديد من المنظمات ظهر منذ سنوات
                    </p>


                </div>
                <br>
                <!--  contact-form  -->
                <form id="ContactUs" class="col-lg-12 text-center contact-form ">
                    {!! csrf_field() !!}
                    <div class="col-md-7 col-xs-12">
                        <input type="text" name="fullname" placeholder="الاسم كاملاً" id="name">
                        <label id="contact_name"></label>

                    </div>
                    <div class="col-md-5 col-xs-12">
                        <input type="text" name="phone" placeholder=" رقم الهاتف" id="phone">
                        <label id="contact_phone"></label>
                    </div>
                    <div class="col-xs-12">
                        <input type="text" name="email" placeholder="البريد الالكتروني" id="email">
                        <label id="contact_email"></label>
                    </div>
                    <div class="col-xs-12">
                        <textarea type="text" name="message" placeholder="الرسالة .." class="textarea-edit"
                                  id="message"></textarea>
                        <label id="contact_message"></label>
                    </div>
                    <div class="clearfix"></div>
                    <div class="alert"></div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <button name="submit" class="main-btn">ارسال الرساله</button>
                    </div>

                </form>

                <!-- end  contact-form -->

            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- end container -->
</footer>
<!-- end section contact -->


<!-- start copyright -->
<section class="copyright">
    <div class="container">
        <h4 class="text-blue fl-right" style="margin-top:21px;">
            2016 | جميع الحقوق محفوظة
        </h4>
        <h4 class="text-blue fl-left">
            تصميم و تطوير
            <a href="http://apt-ware.com">
                <img src="{{ asset('images/aptware.png') }}" width="50">
            </a>
        </h4>
    </div>
</section>
<!-- end copyright-->

@include('layouts.loading')

<!--==== END  LOGIN FORM ==========->


    <!-- Js Files -->

<script src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('AjaxRequests/ErrorHandler.js') }}"></script>
<script src="{{ asset('AjaxRequests/login.js') }}"></script>
<script src="{{ asset('AjaxRequests/Contact.js') }}"></script>

<script>
    new WOW().init();
    var CarSlider= $("#owl-cars");
    var AdvertisementsSlider= $("#owl-advertisements");

    CarSlider.owlCarousel({
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [600,1], //2 items between 600 and 0
        paginationNumbers:true
    });
    AdvertisementsSlider.owlCarousel({
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [600,1], //2 items between 600 and 0
        paginationNumbers:true
    });
</script>
<!-- Js Files -->

<!------------------------------------------------------------------------------------------------------------------->

</body>

</html>
