@extends('layouts.dashboard')
@section('tab-style')

@endsection

@section('title')
    الاعدادات
@endsection
@section('tab-contents')
<div role="tabpanel" class="tab-pane fade in active" id="Reports">
        <h2 class="title text-center">عن الشركة</h2>
    <form id="about">
        <div class="col-xs-12">
            <label>العنوان</label>
            <input type="text" value="{{$about->title}}">
        </div>
    </form>

        {!! csrf_field() !!}

</div>

@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/reports.js') }}"></script>

@endsection