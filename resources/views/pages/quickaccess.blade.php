@extends('layouts.dashboard')
@section('tab-style')

@endsection

@section('title')
    الوصول السريع
@endsection
@section('tab-contents')
<div role="tabpanel" class="tab-pane fade in active" id="QuickAccess">
    <div class="box col-md-6">
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة عميل جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            @include('layouts.clients_form')
        </div>
    </div>
    <div class="box col-md-6">
        <!--===== POPUP TITLE -=====-->
        <div class="popup-title">
            <h2>اضافة حجز جديد</h2>
            <br>
            <hr>
            <hr>
        </div>
        <!--===== POPUP BODY ======-->
        <div class="popup-body">
            @include('layouts/reservation_form')
        </div>
    </div>

</div>
@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/Clients.js') }}"></script>
    <script src="{{ asset('AjaxRequests/Rentings.js') }}"></script>
@endsection