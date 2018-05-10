<div id="AddExpense-Popup" class="popup">
    <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
    <!--===== POPUP TITLE -=====-->
    <div class="popup-title">
        <h2>اضافة مصروف جديد</h2>
        <br>
        <hr>
        <hr>
    </div>
    <!--===== POPUP BODY ======-->
    <div class="popup-body text-center">
        <form id="ِAddNewExpense" type="POST">
            {!! csrf_field() !!}
            <input type="text" name="car_id" id="IDVal" class="hidden">
            <div class="col-md-6 col-xs-12">
                <input type="text" name="title" placeholder="عنوان المصروف">
                <label id="title"></label>
            </div>
            <div class="col-md-6 col-xs-12">
                <input type="text" name ="value" placeholder="قيمة المصروف">
                <label id="value"></label>
            </div>
            <div class="text-center">
                <button type="submit" class="main-btn">اضافة</button>
            </div>
            <div class="alert"role="alert">

            </div>
        </form>
    </div>
</div>

<div id="DeleteExpense-Popup" class="popup">
    <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
    <!--===== POPUP TITLE -=====-->
    <div class="popup-title">
        <h2>حذف المصروف</h2>
        <br>
        <hr>
        <hr>
    </div>
    <!--===== POPUP BODY ======-->
    <div class="popup-body text-center">
        <form id="DeleteExpense" type="POST">
            <h3 class="text-red "> هل انت متأكد بأنك تريد حذف هذه المصروف؟</h3>
            {!! csrf_field() !!}

            <input type="text" class="hidden" name="id" id="IDVal">
            <div class="text-center">
                <button type="submit" class="main-btn">نعم</button>
            </div>
            <div class="alert"role="alert">

            </div>
        </form>
    </div>
</div>

<div id="ExpensesInfo-Popup" class="popup">
    <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
    <!--===== POPUP TITLE -=====-->
    <div class="popup-title">
        <h2>تعديل المصروف</h2>
        <br>
        <hr>
        <hr>
    </div>
    <!--===== POPUP BODY ======-->
    <div class="popup-body">
        <form id="EditExpenseInfo">
            {!! csrf_field() !!}
            <input type="text" id="id" name="id" value="" class="hidden">
            <div class="col-md-6 col-xs-12">
                <label>العنوان</label>
                <input type="text" id="title" name="title" value="">
                <label class="viewerror" id="titleError"></label>
            </div>
            <div class="col-md-6 col-xs-12">
                <label>القيمة</label>
                <input type="text" id="value" name="value"  value="">
                <label class="viewerror" id="valueError"></label>
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