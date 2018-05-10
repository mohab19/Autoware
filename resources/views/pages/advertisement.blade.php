@extends('layouts.master')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/profile2.css') }}">
    <style>
        .image
        {
            margin: 50px auto;
            width:100%;
            height:350px;
            border:3px solid #0B2232;
            padding: 5px;
        }
        .image img
        {
            width: 100%;
            height:100%;
        }
        .carousel-indicators
        {
            display: none !important;
        }
        .carousel-inner
        {
            height:500px;
        }
        .carousel-inner .item
        {
            height: 100%;
        }
        #carousel-example-generic
        {
            height: 100%;
        }
        .carousel-inner>.item>a>img, .carousel-inner>.item>img
        {
            height: 100%;
            width:100%;
        }
    </style>
@endsection

@section('title')
    {{$advertisement->title}}
@endsection
@section('contents')
    <header>
        <div class="container">
            <div class="fl-right">
                <div class="text-red" style="font-size:22px;font-weight: 100;">
                    فرست
                    <span style="color:#aaa;font-weight: 100;">كار</span>
                </div>
            </div>
            <div class="fl-left">
                <a style="margin-right:22px;" href="/">العودة الي الصفحة الريئسية</a>
            </div>
            @if(\Illuminate\Support\Facades\Auth::check())
            @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1 ||\Illuminate\Support\Facades\Auth::user()->role_id == 3 )
                <div class="fl-left">
                    <a href="{{route('advertisements')}}">العودة الي لوحة التحكم</a>
                </div>
            @endif
            @endif
        </div>
    </header>
    <div class="clearfix"></div>
    <section style="margin: 50px 0">
        <div class="container">
            <div class="col-xs-12" style="margin-bottom:70px;">
                <div class="col-md-8">
                    <h2 class="text-center text-red">
                       - {{$advertisement->title}} -
                    </h2>
                    <h3 class="text-red" style="border-bottom:1px solid #aaaaaa;font-size: 20px;font-weight:900;width:200px;padding-bottom:5px">تفاصيل الاعلان</h3>
                    <p style="font-size:18px" class="text-grey">{{$advertisement->description}}</p>
                    @if($advertisement->notes)
                    <h3 class="text-red" style="border-bottom:1px solid #aaaaaa;font-size: 20px;font-weight:900;width:200px;padding-bottom:5px;margin-top:30px">ملاحظات</h3>
                    <p style="font-size:18px" class="text-grey">{{$advertisement->notes}}</p>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="image">
                        <img src="{{$advertisement->picture}}" alt="">
                    </div>
                </div>
            </div>
            @if($advertisement->attachments)
                <h3 class="text-red" style="border-bottom:1px solid #aaaaaa;font-size: 20px;font-weight:900;width:200px;padding-bottom:5px">الصور المرفقة</h3>
            <div class="col-xs-12 text-center">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="{{$advertisement->picture}}" alt="...">
                        </div>
                        <?php $photos = explode("||",$advertisement->attachments) ?>

                    @foreach($photos as $photo)
                        <div class="item">
                            <img src="{{$photo}}" alt="...">
                        </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
                @endif
        </div>

    </section>
@endsection
@section('scripts')

    @endsection