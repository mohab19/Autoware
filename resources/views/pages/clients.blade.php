@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    العملاء
@endsection
@section('tab-contents')

    <!--======= ADD CLIENT FORM ===-->
    <div id="AddClient-Popup" class="popup">
        <i class="fa fa-close text-danger" data-toggle="tooltip" data-placement="left" title="اغلاق"></i>
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
    <!-- END ADD CLIENT FORM -->

    <div role="tabpanel" class="tab-pane fade in active" id="Clients">
        <button data-popup="AddClient-Popup" class="main-btn col-xs-3">اضافة عميل</button>
        <form class="col-xs-9">
            <div class="col-xs-12" id="Clients-Filter">

            </div>
        </form>
        <div class="clearfix"></div>
        <div class="clients box main-box">
            <table id="Clients-table" class="list-view">
                <thead>
                <tr>
                    @foreach($clients_fields as $field)
                        <th><span>{{ $field }}</span></th>
                    @endforeach
                  <th>الخيارات</th>
                </tr>
                </thead>
                <tbody>


                @foreach($clients as $client)
                    <tr>
                        <td>
                            {{ $client->first_name." ".$client->last_name }}
                        </td>
                        <td>

                            {{ date_format( new DateTime($client->birthdate),"Y-m-d")}}
                        </td>
                        <td>
                            {{ $client->phone }}
                        </td>
                        <td>
                            {{ $client->address }}
                        </td>
                        <td>
                            {{ $client->national_id }}
                        </td>
                        <td>
                            {{ $client->notes }}
                        </td>
                        <td>
                           <button class="main-btn sm-btn" id="DeleteUser-btn" data-popup="DeleteUser-Popup" data-id="{{ $client->id }}"><i class="fa fa-remove"></i></button>
                            <a href="{{"/client/"."-".$client->id}}"><button class="main-btn sm-btn"><i class="fa fa-info"></i></button></a>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>




    </div>

@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/Clients.js') }}"></script>
    <script>
                $("#Clients-Filter input").attr("placeholder","بحث عن عميل ؟");
    </script>
@endsection
