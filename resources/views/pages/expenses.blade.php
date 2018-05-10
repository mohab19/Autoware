@extends('layouts.dashboard')
@section('tab-style')

@endsection
@section('title')
    مصاريف عامة
@endsection
@section('tab-contents')
    @include('layouts.Expenses_Forms')
    <div role="tabpanel" class="tab-pane fade in active" id="Expenses">
        <section id="General" class="general">
            <button data-popup="AddExpense-Popup" id="AddExpense" class="main-btn">اضافة مصروف جديد</button>
            <div class="expenses box main-box">
                @if(sizeof($general_expenses))
            <table>
                <tr>
                    @foreach($expenses_fields as $field)
                        <th> {{ $field }} </th>
                    @endforeach
                    <th>التاريخ</th>
                    <th>الموظف</th>
                    <th>الخيارات</th>
                </tr>
                @foreach($general_expenses as $general_expense)
                <tr>
                    <td id="title">
                        {{$general_expense->title}}
                    </td>
                    <td id="value">
                        <div class="col-xs-12">
                            {{$general_expense->value}}
                        </div>
                    </td>
                    <td>
                        <div class="col-xs-12">
                            {{date_format( new DateTime($general_expense->created_at),"d-m-Y")}}
                        </div>
                    </td>
                    <td>
                        <div class="col-xs-12">
                            {{$general_expense->user->display_name}}
                        </div>
                    </td>
                    <td>
                        <button class="main-btn sm-btn" id="EditExpense-btn" data-popup="ExpensesInfo-Popup">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="main-btn sm-btn" data-popup="DeleteExpense-Popup"
                                data-id="{{$general_expense->id}}">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </table>
                    @else
                <h3 class="text-red text-center">لا توجد اي مصاريف بعد </h3>
                    @endif
            </div>
            </section>

    </div>

@endsection
@section('tab-script')
    <script src="{{ asset('AjaxRequests/Expenses.js') }}"></script>
    <script src="{{ asset('AjaxRequests/GeneralExpenses.js') }}"></script>
@endsection