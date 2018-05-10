<form id="client_register"> {!! csrf_field() !!}
    <div class="col-md-6 col-xs-12 ">
        <input name="first_name" type="text" placeholder="الاسم الاول">
        <label id="client_first"></label>
    </div>
    <div class="col-md-6 col-xs-12 ">
        <input name="last_name" type="text" placeholder="الاسم الاخير">
        <label id="client_last"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <h5 style="margin:0;margin-right:20px;margin-bottom:5px">تاريخ الميلاد</h5>
        <input name="birthdate" placeholder="تاريخ الميلاد" type="date" style="padding:6px">
        <label id="client_birth"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <h5 style="margin:0;margin-right:20px;margin-bottom:5px;opacity:0">رقم الهاتف</h5>
        <input name="phone" type="text" placeholder="رقم الهاتف">
        <label id="client_phone"></label>
    </div>
    <div class="col-md-12 col-xs-12">
        <input name="email" type="text" placeholder="البريد الالكترونى">
        <label id="client_email"></label>
    </div>
    <div class="col-md-6 col-xs-12">
        <input name="address" type="text" placeholder="عنوان المنزل">
    </div>
    <div class="col-md-6 col-xs-12">
        <input name="office" type="text" placeholder="عنوان العمل">
    </div>
    <div class="col-md-6 col-xs-12">
        <input name="national_id" type="text" placeholder="رقم البطاقة">
        <label id="client_national_id"></label>
    </div>
    <div class="col-md-3 col-xs-6">
        <input name="id_from" type="text" placeholder="جهة الاصدار">
        <label id="client_id_from"></label>
    </div>
    <div class="col-md-3 col-xs-6">
        <input name="id_date" type="text" placeholder="تاريخ الاصدار">
        <label id="client_id_date"></label>
    </div>
    <div class="col-xs-12">
        <input name="nationality" value="مصري" type="text" placeholder="الجنسية">
        <label id="client_nationality"></label>
    </div>
    <div class="col-md-3 col-xs-6">
        <input name="licence" type="text" placeholder="الرخصة">
        <label id="licence"></label>
    </div>
    <div class="col-md-3 col-xs-6">
        <input name="licence_type" type="text" placeholder="نوعها">
        <label id="licence_type"></label>
    </div>
    <div class="col-md-3 col-xs-6">
        <input name="licence_from" type="text" placeholder="جهة الاصدار">
        <label id="licence_from"></label>
    </div>
    <div class="col-md-3 col-xs-6">
        <input name="licence_to" type="text" placeholder="صالحة حتي">
        <label id="licence_to"></label>
    </div>

    <div class="col-md-12 col-xs-12">
        <textarea name="notes" type="text" placeholder="ملاحظات"></textarea>
    </div>
    <div class="clearfix"></div>
    <div class="alert"></div>
    <div class="clearfix"></div>
    <div class="text-center">
        <button type="submit" class="main-btn">اضافة عميل</button>
    </div>
</form>