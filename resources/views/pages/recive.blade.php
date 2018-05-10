@extends('layouts.dashboard')
@section('tab-style')
<style>
    div#Penalty
    {
        display:none;
    }
</style>
@endsection
@section('title')
    استلام سيارة
@endsection
@section('tab-contents')
    <div id="ReciveCar-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>استلام السيارة</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body text-center">
            <form id="" type="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input class="hidden" name="id" id="IDVal">
                <div class="col-xs-12">
                    <h5 style="float:right;margin:10px 20px;font-size:16px">الدين : <span class="text-red" id="dept"></span></h5>
                    <input type="text" name="dept" placeholder="">
                    <label for="" id="dept"></label>
                </div>
                <div class="col-xs-12">
                    <h5 style="float:right;margin:10px 20px;font-size:16px">عداد الكيلومترات : <span class="text-red" id="KM_Counter"></span></h5>
                    <input type="text" name="KM_Counter" placeholder="">
                    <label for="" id="KMCounter"></label>
                </div>
                <div class="col-xs-12" id="Penalty">
                    <h5 style="float:right;margin:10px 20px;font-size:16px"> عليه دفع غرامة قدرها <span class="text-red" id="PenaltyValue"></span>  جنيه </h5>
                    <div class="col-xs-12">
                        <input type="text" name="KM_Counter_Penalty_paid" placeholder="المبلغ">
                        <label id="KM_Counter_Penalty"></label>
                    </div>
                </div>
                <div class="col-xs-12 text-right">
                    <h5 style="margin:10px 20px;font-size:16px">اضافة صور</h5>
                    <input type="file" name="picture[]" value="0" multiple id="car_image">
                </div>
                <div class="col-xs-12">
                    <h5 style="float:right;margin:10px 20px;font-size:16px"> ملاحظات </h5>
                    <textarea type="text" name="notes" rows="5" placeholder=""></textarea> {{-- make it optional --}}

                </div>
                <div class="col-xs-6">
                    <h5 style="float:right;margin:10px 20px;font-size:16px"> تقييم الاستهلاك (/10) </h5>
                    <input type="number" name="userate" placeholder="">
                    <label for="" id="userate"></label>
                </div>
                <div class="col-xs-6">
                    <h5 style="float:right;margin:10px 20px;font-size:16px"> تقييم الدفع (/10) </h5>
                    <input type="number" name="payrate" placeholder="">
                    <label for="" id="payrate"></label>
                </div>
                <div class="text-center">
                    <button type="submit" class="main-btn">استلام</button>
                </div>
                <div class="alert">

                </div>
            </form>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane fade in active" id="Recive">
        <section class="reservations col-xs-12">
            @foreach($rentings as $renting)
                @if($renting->deleted_at==NULL)
            <div class=" item col-md-3" data-popup="ReciveCar-Popup" data-dept="{{$renting->dept}}" data-km="{{$renting->car->KM_Counter}}" data-id="{{$renting->id}}">
                <div class="image">
                    <img src="{{$renting->car->picture}}">
                </div>
                <div class="text text-center">
               <h4 class="text-red">
                   {{$renting->car->name}}
               </h4>
                    <h5>{{$renting->client->user->display_name}}</h5>
                    <h6>{{date_format( new DateTime($renting->end_duration),"Y-m-d")}}</h6>
                </div>
            </div>
                @endif
            @endforeach
        </section>
    </div>
@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/Recive.js') }}"></script>
@endsection