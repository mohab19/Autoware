<form id="AddReservation" >
    {!! csrf_field() !!}
    <input type="hidden" name="waiting_id" value="0">
    <input type="hidden" name="renew_id" value="0">
    <div class="col-xs-12 ">
        <select name="client_id"  class="selectpicker" data-show-subtext="false" data-live-search="true">
            <option disabled selected value="">اختار العميل</option>
        @foreach($users as $user)
                <option value="{{ $user->id }}" data-subtext="{{$user->user->phone}}">{{ $user->user->display_name}}</option>
            @endforeach
        </select>
        <label class="alert" id="reservation_client_id"></label>
    </div>
    <div class="col-xs-12 ">
        <select name="car_id" class="selectpicker" data-show-subtext="false" data-live-search="true">
            <option disabled selected value="">اختار السيارة</option>
            @foreach($cars as $car)d
                @if($car->available)
                <option value="{{ $car->id }}" data-subtext="{{$car->plate}}">{{ $car->name }}</option>
                @endif
            @endforeach
        </select>
        <label class="alert" id="reservation_car_id"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">من</label>
        <input name="start_duration" type="date" placeholder="من">
        <label class="alert" id="reservation_start_duration"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">الي</label>
        <input name="end_duration" type="date" placeholder="الي">
        <label class="alert" id="reservation_end_duration"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <input name="DiscountOption" value="1" id="withdiscount" type="radio">
        <label for="withdiscount" style="display:inline-block !important;margin-right:15px;font-size:16px;" class="text-red">خصم</label><br>
        <label class="alert" id="reservation_DiscountOption"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <input name="DiscountOption" value="0" id="withoutdiscount" type="radio">
        <label for="withoutdiscount" style="display:inline-block !important;margin-right:15px;font-size:16px;" class="text-red">بدون خصم</label>
    </div>
    <div class="col-xs-12" id="discountinput">
        <input name="discount" type="text" placeholder="قيمة الخصم">
        <label class="alert" id="reservation_discount"></label>
    </div>

    <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">المبلغ المطلوب</label>
        <h2 id="RequireMoney" class="text-red" style="margin:0;margin-right:50px;">
            190
        </h2>
        <input type="hidden" name="reservation_required_money" value="0.00">
    </div>

    <div class="col-md-6 col-xs-12">
        <label style="margin-right:15px;">المبلغ المدفوع</label>
        <input type="text" name="paid" >
        <label class="alert" id="reservation_paid"></label>
    </div>
    <div class="clearfix">
    </div>
    <div class="text-center">
        <button type="submit" class="main-btn">اضافة حجز</button>
    </div>
</form>
