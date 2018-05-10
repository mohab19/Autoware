@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    الاعلانات
@endsection
@section('tab-contents')
    <div id="AddAdvertisement-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة اعلان جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="" method="POST">
                {!! csrf_field() !!}
                <div class="col-md-6">
                    <input type="text" name="title" placeholder="عنوان الاعلان">
                    <label id="title"></label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="price" placeholder="سعر الاعلان">
                    <label id="price"></label>
                </div>
                <div class="col-xs-12">
                    <textarea name="description" rows="5" placeholder="تفاصيل الاعلان"></textarea>
                    <label id="description"></label>
                </div>
                <div class="col-xs-12">
                    <textarea name="notes" rows="2" placeholder="ملاحظات"></textarea> {{-- make it optional --}}
                </div>
                <div class="col-md-6 text-right">
                    <h5 style="margin:10px 20px;font-size:16px" class="fl-right">الصورة الريئسية</h5>
                    <input type="file" name="picture" value="0" id="car_image">
                    <label id="picture"></label>
                </div>
                <div class="col-md-6 text-right">
                    <h5 style="margin:10px 20px;font-size:16px" class="fl-right">الصور المرفقة</h5>
                    <input type="file" name="attachments[]" multiple value="0" class="car_image">
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <button type="submit" class="main-btn">اضافة</button>
                </div>
                <div class="alert">

                </div>
            </form>
        </div>
    </div>
    <div id="DeleteAdvertisement-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>حذف الاعلان</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="DeleteAdvertisement" method="POST">
                <h3 class="text-red "> هل انت متأكد بأنك تريد حذف هذا الاعلان؟</h3>
                {!! csrf_field() !!}

                    <input type="text" class="hidden id" name="id">
                <div class="text-center">
                    <button type="submit" class="main-btn">نعم</button>
                </div>
                <div class="alert"role="alert">

                </div>
            </form>
        </div>
    </div>
    <div id="AdvertisementInfo-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>تعديل بيانات الاعلان</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="EditAdvertisementInfo">
                {!! csrf_field() !!}
                <input name="id" class="hidden id">
                <div class="col-md-6">
                    <input type="text" name="title" placeholder="عنوان الاعلان">
                    <label id="title"></label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="price" placeholder="سعر الاعلان">
                    <label id="price"></label>
                </div>
                <div class="col-xs-12">
                    <textarea name="description" rows="5" placeholder="تفاصيل الاعلان"></textarea>
                    <label id="description"></label>
                </div>
                <div class="col-xs-12">
                    <textarea name="notes" rows="2" placeholder="ملاحظات"></textarea> {{-- make it optional --}}
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
    <div id="MainPicture-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>تعديل الصورة الريئسية</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="EditAdvertisementInfo">
                {!! csrf_field() !!}
                <input name="id" class="hidden id">
                <div class="col-md-6 text-right">
                    <h5 style="margin:10px 20px;font-size:16px" class="fl-right">الصورة الريئسية</h5>
                    <input type="file" name="picture" value="0" id="car_image">
                    <label id="picture"></label>
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
    <div id="Attachments-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>تعديل الصور المرفقة</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            <form id="EditAdvertisementInfo">
                {!! csrf_field() !!}
                <input name="id" class="hidden id">
                <div class="col-md-6 text-right">
                    <h5 style="margin:10px 20px;font-size:16px" class="fl-right">الصور المرفقة</h5>
                    <input type="file" name="attachments[]" multiple value="0" class="car_image">
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
    <div role="tabpanel" class="tab-pane fade in active Advertisements">
        <div class="text-center">
            <button class="main-btn"data-popup="AddAdvertisement-Popup">اضافة اعلان جديد</button>
        </div>
        <section class="reservations col-xs-12">
            @foreach($advertisements as $advertisement)
                    <div class="advertisement col-md-4">
                        <div class="back2"></div>
                        <div class="text-center image">
                            <img src="{{$advertisement->picture}}">
                            <span dir="ltr" class="price">{{$advertisement->price}} L.E</span>
                        </div>
                        <div class="caption text-center">
                            <h2 class="title">{{$advertisement->title}}</h2>
                            <a href="/announcement/{{$advertisement->id}}/{{$advertisement->title}}"><button class="main-btn sm-btn"> التفاصيل</button></a>
                            <button class="main-btn sm-btn" data-title="{{$advertisement->title}}" data-description="{{$advertisement->description}}" data-notes="{{$advertisement->notes}}" data-price="{{$advertisement->price}}" data-update="{{$advertisement->id}}" data-popup="AdvertisementInfo-Popup"><i class="fa fa-pencil"></i> </button>
                            <button class="main-btn sm-btn" data-delete="{{$advertisement->id}}" data-popup="DeleteAdvertisement-Popup"><i class="fa fa-close"></i></button>
                            <br>
                            <button class="main-btn sm-btn" data-picture="{{$advertisement->id}}" data-popup="MainPicture-Popup">تعديل الصورة الرئيسية</button>
                            <button class="main-btn sm-btn" data-attachments="{{$advertisement->id}}" data-popup="Attachments-Popup">تعديل الصور المرفقة</button>
                        </div>
                    </div>
            @endforeach
        </section>
    </div>
@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/AAdvertisements.js') }}"></script>
@endsection