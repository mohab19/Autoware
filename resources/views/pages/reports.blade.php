@extends('layouts.dashboard')
@section('tab-style')

@endsection

@section('title')
    التقارير
@endsection
@section('tab-contents')
<div role="tabpanel" class="tab-pane fade in active" id="Reports">
    <form id="ReportFinal">
        {!! csrf_field() !!}
<div class="col-md-4">
    <select name="type">
        <option value=""> نوع التقرير</option>
        <option value="partners">الشركاء</option>
        <option value="employees">الموظفين</option>
        <option value="outcomes">المصروفات</option>
        <option value="incomes">الدخل</option>
        <option value="depts">الديون</option>
    </select>
</div>
        <div class="col-md-4 months">
            <select name="month">
                <option value="all">جميع الشهور</option>
            </select>
        </div>
        <div class="col-md-4 years">
            <select name="year">
                <option value="all">جميع السنين</option>
            </select>
        </div>
        <div class="col-xs-12 text-center">
            <button class="main-btn" type="submit">تقرير</button>
        </div>

            </form>
    <div class="clearfix"></div>
    <div class="table-parent">
        <h3 class="title red text-right">التقرير</h3>
        <div class="results">

        </div>
    </div>
</div>

@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/reports.js') }}"></script>

@endsection