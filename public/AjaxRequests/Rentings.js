$(function () {

    var discount_option = null;

    $('#AddReservation #RequireMoney').html("0.00");
    $('#RenewReservation #RequireMoney').html("0.00");

    function GetAddDataToSend() {
        return {
            _token: $('#AddReservation input[name="_token"]').val(),
            car_id: $('#AddReservation select[name="car_id"]').val(),
            start_duration: $('#AddReservation input[name="start_duration"]').val(),
            end_duration: $('#AddReservation input[name="end_duration"]').val(),
            DiscountOption: discount_option,
            discount: $('#AddReservation input[name="discount"]').val()
        };
    }
    function SendAddCalculationInfo() {
        $.ajax({
            url: '/calculate/reservation',
            type: 'POST',
            data: GetAddDataToSend(),
            success: function (data) {
                if (data) {
                    $('#AddReservation #RequireMoney').html(data);
                    $('input[name="reservation_required_money"]').val(data);
                }
            },
            error: function (data) {
                // alert(data['responseText']);
                var error = data.responseJSON;
            }
        });
    }
    function GetRenewDataToSend() {
        return {
            _token: $('#RenewReservation input[name="_token"]').val(),
            id: $('#RenewReservation input[name="id"]').val(),
            start_duration: $('#RenewReservation input[name="start_duration"]').val(),
            end_duration: $('#RenewReservation input[name="end_duration"]').val(),
            DiscountOption: discount_option,
            discount: $('#RenewReservation input[name="discount"]').val()
        };
    }
    function SendRenewCalculationInfo() {
        $.ajax({
            url: '/calculate/reservation/renew',
            type: 'POST',
            data: GetRenewDataToSend(),
            success: function (data) {
                if (data) {
                    $('#RenewReservation #RequireMoney').html(data);
                    $('input[name="reservation_required_money"]').val(data);
                }
            },
            error: function (data) {
                // alert(data['responseText']);
                var error = data.responseJSON;
            }
        });
    }

    $('#AddReservation input[name="DiscountOption"]').change(function () {
        discount_option = this.value;
        if (this.value == 0) {
            SendAddCalculationInfo();
        }
    });
    $('#RenewReservation input[name="DiscountOption"]').change(function () {
        discount_option = this.value;
        if (this.value == 0) {
            SendRenewCalculationInfo();
        }
    });

    $('#AddReservation input[name="discount"]').change(function () {
        SendAddCalculationInfo();
    });
    $('#RenewReservation input[name="discount"]').change(function () {
        SendRenewCalculationInfo();
    });

    $('#AddReservation select[name="car_id"]').change(function () {
        SendAddCalculationInfo();
    });

    $('#AddReservation input[name="start_duration"]').change(function () {
        SendAddCalculationInfo();
    });

    $('#AddReservation input[name="end_duration"]').change(function () {
        SendAddCalculationInfo();
    });
    $('#RenewReservation input[name="start_duration"]').change(function () {
        SendRenewCalculationInfo();
    });
    $('#RenewReservation input[name="end_duration"]').change(function () {
        SendRenewCalculationInfo();
    });

    $('#RenewReservation input[name="DiscountOption"]').change(function () {
        discount_option = this.value;
        if (this.value == 0) {
            SendAddCalculationInfo();
        }
    });

    $('#RenewReservation input[name="discount"]').change(function () {
        SendAddCalculationInfo();
    });

    $('#AddReservation').submit(function (e) {
        e.preventDefault();
        var button = $("#AddReservation button[type='submit']");
        button_waiting(button);
        $.ajax({
            url: '/rent/car',
            type: 'POST',
            data: $('#AddReservation').serialize(),
            success: function (data) {
                button_done(button);
                empty_errors([
                    '#AddReservation #reservation_user_id',
                    '#AddReservation #reservation_car_id',
                    '#AddReservation #reservation_start_duration',
                    '#AddReservation #reservation_end_duration',
                    '#AddReservation #reservation_DiscountOption',
                    '#AddReservation #reservation_discount',
                    '#AddReservation #reservation_payed'
                ]);
                if(data)
                {
                    location.href = data;
                }
            },
            error: function (data) {
                w = window.open('','newwinow','width=800,height=600,menubar=1,status=0,scrollbars=1,resizable=1');
                d = w.document.open("text/html","replace");
                d.writeln(data['responseText']);
                // alert(data);
                button_done(button);
                 // alert(data['responseText']);
                $("#AddReservation label.alert").addClass("alert-danger").fadeIn();
                var error = data.responseJSON;
                error_handler(
                    error,
                    [
                        '#AddReservation #reservation_client_id',
                        '#AddReservation #reservation_car_id',
                        '#AddReservation #reservation_start_duration',
                        '#AddReservation #reservation_end_duration',
                        '#AddReservation #reservation_DiscountOption',
                        '#AddReservation #reservation_discount',
                        '#AddReservation #reservation_paid'
                    ],
                    [
                        'client_id',
                        'car_id',
                        'start_duration',
                        'end_duration',
                        'DiscountOption',
                        'discount',
                        'paid'
                    ]
                );
            }
        });
    });
    $('#RenewReservation').submit(function (e) {
        e.preventDefault();
        var button = $("#RenewReservation button[type='submit']");
        button_waiting(button);
        $.ajax({
            url: '/rent/car/renew',
            type: 'POST',
            data: $('#RenewReservation').serialize(),
            success: function (data) {
                button_done(button);
                if(data)
                {
                    location.href = data;
                }
            },
            error: function (data) {
                w = window.open('','newwinow','width=800,height=600,menubar=1,status=0,scrollbars=1,resizable=1');
                d = w.document.open("text/html","replace");
                d.writeln(data['responseText']);
                // alert(data);
                button_done(button);
                 // alert(data['responseText']);
                $("#AddReservation label.alert").addClass("alert-danger").fadeIn();
                var error = data.responseJSON;
                error_handler(
                    error,
                    [
                        '#RenewReservation #reservation_start_duration',
                        '#RenewReservation #reservation_end_duration',
                        '#RenewReservation #reservation_DiscountOption',
                        '#RenewReservation #reservation_discount',
                        '#RenewReservation #reservation_paid'
                    ],
                    [
                        'start_duration',
                        'end_duration',
                        'DiscountOption',
                        'discount',
                        'paid'
                    ]
                );
            }
        });
    });

    $('#End_Print').click(function () {
        var contract;
        $.ajax({
            url: '/Reserve',
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val()
            },
            success:function (data) {
//                alert(data);
                if(data == -1)
                {
                    $("#back_print").hide(1);
                    // session expired
                    HideItems();
                    print();
                    ShowItems();
                    $("#back_print").show(1);
                }else if (data == 0)
                {
                    // something went wrong
                }else if(data == 1)
                {
                    $("#back_print").hide(1);
                    HideItems();
                    print();
                    ShowItems();
                    $("#back_print").show(1);
                }
                $("#End_Print2").fadeIn();
            },
            error:function (data) {
                w = window.open('','newwinow','width=800,height=600,menubar=1,status=0,scrollbars=1,resizable=1');
                d = w.document.open("text/html","replace");
                d.writeln(data['responseText']);
                 // alert(data['responseText']);
            }
        });
    });
    $('#End_Print2').click(function () {
        $("#back_print").hide(1);
        HideItems2();
        print();
        ShowItems2();
        $("#back_print").show(1);

    });
    function HideItems() {
        HideElement('#End_Print');
        HideElement('#End_Print2');
        HideElement('#back_print');
        HideElement('.nicescroll-rails');
        HideElement('#footer');
        document.title = "";
    }

    function ShowItems() {
        ShowElement('#End_Print');
        ShowElement('#End_Print2');
        ShowElement('#back_print');
        ShowElement('.nicescroll-rails');
        ShowElement('#footer');
        document.title = "تأكيد الحجز";
    }
    function HideItems2() {
        ShowElement('.approval');
        HideElement('#End_Print');
        HideElement('#End_Print2');
        HideElement('#back_print');
        HideElement('#contractor');
        HideElement('#footer');
        document.title = "";
    }

    function ShowItems2() {
        HideElement('.approval');
        ShowElement('#End_Print');
        ShowElement('#End_Print2');
        ShowElement('#back_print');
        ShowElement('#contractor');
        ShowElement('#footer');
        document.title = "تأكيد الحجز";
    }
});
$(function () {

    var discount_option = null;

    $('#UpdateReservation #RequireMoney').html("0.00");
    $("*").click(function(){
        if(this.hasAttribute('data-car_id') && this.hasAttribute('data-renting_id'))
        {
            $('#UpdateReservation input[name="car_id"]').val($(this).attr('data-car_id'));
            $('#UpdateReservation input[name="renting_id"]').val($(this).attr('data-renting_id'));
        }
    })
    function GetUpdateDataToSend() {
        return {

            _token: $('#UpdateReservation input[name="_token"]').val(),
            car_id: $('#UpdateReservation input[name="car_id"]').val(),
            start_duration: $('#UpdateReservation input[name="start_duration"]').val(),
            end_duration: $('#UpdateReservation input[name="end_duration"]').val(),
            DiscountOption: discount_option,
            discount: $('#UpdateReservation input[name="discount"]').val()
        };
    }
    function SendUpdateCalculationInfo() {
        $.ajax({
            url: '/update/calculate/reservation',
            type: 'POST',
            data: GetUpdateDataToSend(),
            success: function (data) {
                if (data) {
                    $('#UpdateReservation #RequireMoney').html(data);
                    $('input[name="reservation_required_money"]').val(data);
                }
            },
            error: function (data) {
                // alert(data['responseText']);
                var error = data.responseJSON;
            }
        });
    }

    $('#UpdateReservation input[name="DiscountOption"]').change(function () {
        discount_option = this.value;
        if (this.value == 0) {
            SendUpdateCalculationInfo();
        }
    });

    $('#UpdateReservation input[name="discount"]').change(function () {
        SendUpdateCalculationInfo();
    });

    $('#UpdateReservation select[name="car_id"]').change(function () {
        SendUpdateCalculationInfo();
    });

    $('#UpdateReservation input[name="start_duration"]').change(function () {
        SendUpdateCalculationInfo();
    });

    $('#UpdateReservation input[name="end_duration"]').change(function () {
        SendUpdateCalculationInfo();
    });


    $('#UpdateReservation').submit(function (e) {
        e.preventDefault();
        var button = $("#UpdateReservation button[type='submit']");
        button_waiting(button);
        $.ajax({
            url: '/reservation/update',
            type: 'POST',
            data: $('#UpdateReservation').serialize(),
            success: function (data) {
 //                alert(data);
                button_done(button);
                $(".alert-danger").fadeOut();
                if(data)
                {
                    PrintOnSelector("#UpdateReservation .alert","تم التعديل بنجاح");
                    $("#DeleteReservation-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                        $(this).delay(500).fadeOut(500,function(){
                            location.reload();
                        })
                    })
                }
            },
            error: function (data) {
                // alert(data);
                button_done(button);
//                alert(data['responseText']);
                error = data.responseJSON;
                error_handler(
                    error,
                    [
                        '#UpdateReservation label#reservation_start_duration',
                        '#UpdateReservation #reservation_end_duration',
                        '#UpdateReservation #reservation_DiscountOption',
                        '#UpdateReservation #reservation_discount',
                        '#UpdateReservation #reservation_payed'
                    ],
                    [
                        'start_duration',
                        'end_duration',
                        'DiscountOption',
                        'discount',
                        'payed'
                    ]
                );
            }
        });
    });

});
var CarID;
$("#Reservations *").click(function(){
    if(this.hasAttribute('data-id'))
    {
        CarID = $(this).attr('data-id');
        $("#DeleteReservation-Popup #IDVal").val(CarID);
    }
    if(this.hasAttribute('data-renew'))
    {
        var id = $(this).attr('data-id');
        var end = $.trim($(this).parent().siblings("td#end").text());
        $("#RenewReservation-Popup form input[name='id']").val(id);
        $("#RenewReservation-Popup form input[name='start_duration']").val(end);
    }
});
$("#DeleteReservation-Popup form").submit(function(e){
    e.preventDefault();
    $.ajax({
        url:"/reservation/delete",
        type:"POST",
        data:$("#DeleteReservation-Popup form").serialize(),
        success:function(data){
            PrintOnSelector("#DeleteReservation-Popup form .alert","تم الحذف بنجاح");
            $("#DeleteReservation-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })

        },
        error:function(data){
            //alert(data['responseText']);
            PrintOnSelector("#DeleteReservation-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteReservation-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
    });
})