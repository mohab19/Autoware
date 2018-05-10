@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    نظرة عامة
@endsection
@section('tab-contents')
    <?php

    ?>
    <div role="tabpanel" class="tab-pane fade in active" id="Overview">
        <article class="statistics">
            <h2 class="title">الاحصائيات</h2>
            <div class="item col-md-3 col-xs-6">
                <a href="{{route('clients')}}">
                    <div class="box box-orange">
                        <div class="num">{{$clients->count()}}</div>
                        <div class="title">عميل </div>
                    </div>
                </a>
            </div>
            <div class="item col-md-3 col-xs-6">
                <a href="{{route('employees')}}">
                    <div class="box box-red">
                        <div class="num">{{$employees->count()}}</div>
                        <div class="title">موظف</div>
                    </div>
                </a>
            </div>
            <div class="item col-md-3 col-xs-6">
                <a href="{{route('partners')}}">
                    <div class="box box-blue">
                        <div class="num">{{$partners->count()}}</div>
                        <div class="title">مالك</div>
                    </div>
                </a>
            </div>
            <div class="item col-md-3 col-xs-6">
                <a href="{{route('reservations')}}">
                    <div class="box box-green">
                        <div class="num">{{$rentings->count()}}</div>
                        <div class="title">حجوزات</div>
                    </div>
                </a>
            </div>
            <div class="item col-md-4 col-xs-6">
                <a href="{{route('cars')}}">
                    <div class="box box-red">
                        <div class="num">{{$cars->count()}}</div>
                        <div class="title">سيارة</div>
                    </div>
                </a>
            </div>
            <div class="item col-md-4 col-xs-6">
                <a href="#available">
                    <div class="box box-orange">
                        <div class="num">{{$cars_avalible->count()}}</div>
                        <div class="title">سيارة متاحة</div>
                    </div>
                </a>
            </div>
            <div class="item col-md-4 col-xs-6">
                <a href="{{route('waiting')}}">
                    <div class="box box-blue">
                        <div class="num">{{$waitings->count()}}</div>
                        <div class="title">الانتظار</div>
                    </div>
                </a>
            </div>

            <div class="clearfix"></div>
        </article>
        <article class="Latest-Clients main-box col-md-5-5 col-xs-12">
            <h2 class="title">اخر العملاء</h2>

            @foreach($clients->take(6) as $client)
                <a href="/client/-{{$client->id}}"><div class="client">
                        <h4 class="name text-dark">{{$client->first_name." ".$client->last_name}}</h4>
                        <h5 class="date text-grey">
                            <h5 class="date text-grey">{{date_format($client->created_at,"Y-m-d")}}</h5>
                        </h5>
                    </div>
                </a>
            @endforeach
        </article>
        <article class="Latest-Employees main-box col-md-5-5 col-xs-12">
            <h2 class="title">اخر الموظفين</h2>
            <?php $employees =$employees->take(6)?>
            @foreach($employees as $employee)
                <a href="/employee/-{{$employee->id}}"><div class="employee">
                        <h4 class="name text-dark">{{$employee->first_name." ".$employee->last_name}}</h4>
                        {{--                        <h4 class="name text-dark">{{$employee->created_at}}</h4>--}}
                        <h5 class="date text-grey">{{date_format($employee->created_at,"Y-m-d")}}</h5>
                    </div></a>
            @endforeach
        </article>
        <div class="col-md-8-5 col-xs-12">
            <article class="Latest-Reservations main-box col-xs-12">
                <h2 class="title">اخر الحجوزات</h2>
                <table>
                    <tr class="title">
                        <th>
                            السيارة
                        </th>
                        <th>
                            العميل
                        </th>
                        <th>
                            وقت التسليم
                        </th>
                    </tr>
                    <?php $rentings =$rentings->take(6)?>
                    @foreach($rentings as $renting)
                        <tr>
                            <td>
                                @if($renting->car)
                                    <a href="/car/-{{$renting->car->id}}">{{$renting->car->name}}</a>
                                @else
                                    السيارة محذوفة
                                @endif
                            </td>
                            <td>
                                <a href="/client/-{{$renting->client->id}}">{{$renting->client->user->first_name . " " . $renting->client->user->last_name}}</a>
                            </td>
                            <td>
                                {{ date_format( new DateTime($renting->end_duration),"Y-m-d")}}
                            </td>
                        </tr>
                    @endforeach

                </table>
            </article>
            <article class="Latest-Reservations main-box col-xs-12">
                <h2 class="title">اخر الانتظارات</h2>
                <table>
                    <tr class="title">
                        <th>
                            السيارة
                        </th>
                        <th>
                            العميل
                        </th>
                        <th>
                            من
                        </th>
                        <th>
                            الي
                        </th>
                    </tr>
                    <?php $waitings = $waitings->take(6)?>
                    @foreach($waitings as $waiting)
                        <tr>
                            <td>
                                <a href="/car/-{{$waiting->car->id}}">{{$waiting->car->name}}</a>
                            </td>
                            <td>
                                <a href="/client/-{{$waiting->client->id}}">{{$waiting->client->user->first_name . " " . $renting->client->user->last_name}}</a>
                            </td>
                            <td>
                                {{ date_format( new DateTime($waiting->start_duration),"Y-m-d")}}
                            </td>
                            <td>
                                {{ date_format( new DateTime($waiting->end_duration),"Y-m-d")}}
                            </td>
                        </tr>
                    @endforeach

                </table>
            </article>
        </div>

        <div class="col-md-3 col-xs-12">
            <article class="Latest-Cars main-box col-xs-12">
                <h2 class="title">اخر السيارات</h2>
                <?php $cars =$cars->take(4)?>
                @foreach($cars as $car)
                    <a href="/car/-{{$car->id}}"><div class="car">
                            <div class="image fl-right">
                                <img src="{{$car->picture}}">
                            </div>
                            <div class="text fl-right">
                                <h4 style="padding-top:20px" class="text-dark">{{$car->name}}</h4>
                                <h5 class="text-grey">{{date_format($car->created_at,"Y-m-d")}}</h5>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                @endforeach

            </article>
            <article id="available" class="Latest-Cars main-box col-xs-12">
                <h2 class="title"> السيارات المتاحة</h2>
                @foreach($cars_avalible as $car)
                    <a href="/car/-{{$car->id}}"><div class="car">
                            <div class="image fl-right">
                                <img src="{{$car->picture}}">
                            </div>
                            <div class="text fl-right">
                                <h4 style="padding-top:20px" class="text-dark">{{$car->name}}</h4>
                                <h5 class="text-grey">{{date_format($car->created_at,"Y-m-d")}}</h5>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                @endforeach

            </article>
        </div>



    </div>

@endsection
@section('tab-script')

@endsection