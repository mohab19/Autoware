$(function () {

    var discount_option = null;

    $('#AddWaiting #RequireMoney').html("0.00");

    function GetAddDataToSend() {
        return {
            _token: $('#AddWaiting input[name="_token"]').val(),
            car_id: $('#AddWaiting select[name="car_id"]').val(),
            start_duration: $('#AddWaiting input[name="start_duration"]').val(),
            end_duration: $('#AddWaiting input[name="end_duration"]').val(),
        };
    }
    function SendAddCalculationInfo() {
        $.ajax({
            url: '/calculate/waiting',
            type: 'POST',
            data: GetAddDataToSend(),
            success: function (data) {
                if (data) {
                    $('#AddWaiting #RequireMoney').html(data);
                    $('input[name="reservation_required_money"]').val(data);
                }
            },
            error: function (data) {
                // alert(data['responseText']);
                var error = data.responseJSON;
            }
        });
    }
    function GetCarDate() {
        $.ajax({
            url: '/waiting/car/date',
            type: 'POST',
            data: $('#AddWaiting').serialize(),
            success: function (data) {
                //alert(data);
                if (data) {
                     $('input[name="start_duration"]').val(data);
                }
            },
            error: function (data) {
                 // alert(data['responseText']);
                var error = data.responseJSON;
            }
        });
    }
    $('#AddWaiting select[name="car_id"]').change(function () {
        GetCarDate();
        SendAddCalculationInfo();
    });

    $('#AddWaiting input[name="start_duration"]').change(function () {
        SendAddCalculationInfo();
    });

    $('#AddWaiting input[name="end_duration"]').change(function () {
        SendAddCalculationInfo();
    });


    $('#AddWaiting').submit(function (e) {
        e.preventDefault();
        var button = $("#AddWaiting button[type='submit']");
        button_waiting(button);
        $.ajax({
            url: '/waiting/add',
            type: 'POST',
            data: $('#AddWaiting').serialize(),
            success: function (data) {
                //alert(data);
                button_done(button);
                    PrintOnSelector("#AddWaiting-Popup form .alert","تم الاضافة بنجاح");
                    $("#AddWaiting-Popup form div.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                        $(this).delay(500).fadeOut(500,function(){
                            location.reload();
                        })
                    })
            },
            error: function (data) {
                 // alert(data);
                button_done(button);
                  // alert(data['responseText']);
                var error = data.responseJSON;
                error_handler(
                    error,
                    [
                        '#reservation_user_id',
                        '#reservation_car_id',
                        '#reservation_start_duration',
                        '#reservation_end_duration',
                    ],
                    [
                        'user_id',
                        'car_id',
                        'start_duration',
                        'end_duration',
                    ]
                );
            }
        });
    });
    $("*").click(function(){
        if(this.hasAttribute('data-end'))
        {
            $("#AddReservation-Popup form select[name='client_id']").parent().hide();
            $("#AddReservation-Popup form select[name='car_id']").parent().hide();
            var id = $(this).attr('data-waiting');
            var client = $(this).attr('data-client_id');
            var car = $(this).attr('data-car_id');
            var start = $.trim($(this).parent().siblings("td#start").text());
            var end = $.trim($(this).parent().siblings("td#end").text());
            var notes = $.trim($(this).parent().siblings("td#notes").text());
            $("#AddReservation-Popup form input[name='waiting_id']").val(id);
            $("#AddReservation-Popup form select[name='client_id']").val(client);
            $("#AddReservation-Popup form select[name='car_id']").val(car);
            $("#AddReservation-Popup form input[name='start_duration']").val(start);
            $("#AddReservation-Popup form input[name='end_duration']").val(end);
            $("#AddReservation-Popup form textarea[name='notes']").val(notes);
        }
        else if(this.hasAttribute('data-update'))
        {
            var id = $(this).attr('data-waiting');
            var car = $(this).attr('data-car_id');
            var start = $.trim($(this).parent().siblings("td#start").text());
            var end = $.trim($(this).parent().siblings("td#end").text());
            var notes = $.trim($(this).parent().siblings("td#notes").text());
            $("#UpdateWaiting-Popup form input[name='id']").val(id);
            $("#UpdateWaiting-Popup form select[name='car_id']").val(car);
            $("#UpdateWaiting-Popup form input[name='start_duration']").val(start);
            $("#UpdateWaiting-Popup form input[name='end_duration']").val(end);
            $("#UpdateWaiting-Popup form textarea[name='notes']").val(notes);
        }
        else if(this.hasAttribute('data-delete'))
        {
            var id = $(this).attr('data-id');
            $("#DeleteWaiting-Popup #IDVal").val(id);
        }

    })

});
$(function () {

    var discount_option = null;

    $('#UpdateWaiting #RequireMoney').html("0.00");
    $("*").click(function(){
        if(this.hasAttribute('data-car_id'))
        {
            $('#UpdateWaiting input[name="car_id"]').val($(this).attr('data-car_id'));
        }
    })
    function GetUpdateDataToSend() {
        return {

            _token: $('#UpdateWaiting input[name="_token"]').val(),
            car_id: $('#UpdateWaiting select[name="car_id"]').val(),
            start_duration: $('#UpdateWaiting input[name="start_duration"]').val(),
            end_duration: $('#UpdateWaiting input[name="end_duration"]').val(),
        };
    }
    function SendUpdateCalculationInfo() {
        $.ajax({
            url: '/update/calculate/waiting',
            type: 'POST',
            data: GetUpdateDataToSend(),
            success: function (data) {
                if (data) {
                    $('#UpdateWaiting #RequireMoney').html(data);
                    $('input[name="reservation_required_money"]').val(data);
                }
            },
            error: function (data) {
                // alert(data['responseText']);
                var error = data.responseJSON;
            }
        });
    }
    
    $('#UpdateWaiting select[name="car_id"]').change(function () {
        SendUpdateCalculationInfo();
    });

    $('#UpdateWaiting input[name="start_duration"]').change(function () {
        SendUpdateCalculationInfo();
    });

    $('#UpdateWaiting input[name="end_duration"]').change(function () {
        SendUpdateCalculationInfo();
    });


    $('#UpdateWaiting').submit(function (e) {
        e.preventDefault();
        var button = $("#UpdateWaiting button[type='submit']");
        button_waiting(button);
        $.ajax({
            url: '/waiting/update',
            type: 'POST',
            data: $('#UpdateWaiting').serialize(),
            success: function (data) {
                 // alert(data);
                button_done(button);
                $(".alert-danger").fadeOut();
                PrintOnSelector("#UpdateWaiting-Popup form .alert","تم التعديل بنجاح");
                $("#UpdateWaiting-Popup form div.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })

            },
            error: function (data) {
                // alert(data);
                button_done(button);
                // alert(data['responseText']);
                var error = data.responseJSON;
                error_handler(
                    error,
                    [
                        '#UpdateWaiting label#reservation_start_duration',
                        '#UpdateWaiting #reservation_end_duration',
                        '#UpdateWaiting #reservation_DiscountOption',
                        '#UpdateWaiting #reservation_discount',
                        '#UpdateWaiting #reservation_payed'
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

$("#DeleteWaiting-Popup form").submit(function(e){
    e.preventDefault();
    $.ajax({
        url:"/waiting/delete",
        type:"POST",
        data:$("#DeleteWaiting-Popup form").serialize(),
        success:function(data){
            PrintOnSelector("#DeleteWaiting-Popup form div.alert","تم الحذف بنجاح");
            $("#DeleteWaiting-Popup form div.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })

        },
        error:function(data){
            //alert(data['responseText']);
            PrintOnSelector("#DeleteWaiting-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteReservation-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
    });
})