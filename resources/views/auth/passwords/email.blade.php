@extends('layouts.app')
@section('title')
    استعادة كلمة المرور
    @endsection
@section('contents')
    <div class="container">
        <div class="col-xs-1"></div>
        <div class="col-xs-10 text-center">
            <div style="width:80%;margin:auto;margin-top: 15%">
                <div class="panel panel-default">
                    <div class="panel-heading">استعادة كلمة المرور</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="email" placeholder="البريد الالكتروني" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <button type="submit" class="btn main-btn">
                                        ارسال الرابط الي بريدك <i class="fa fa-btn fa-envelope"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

