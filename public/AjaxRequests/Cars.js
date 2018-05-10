$(function () {

    $('#car_register').submit(function(e){
        var button = $("#car_register button[type='submit']");
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url: '/register/car',
            type: 'POST',
            data : new FormData(this),
            contentType: false,
            cache      : false,
            processData: false,
            success: function (data) {
                // alert(data);
                $("#car_register label").fadeOut();
                button_done(button);
                empty_errors([
                    '#cars_type',
                    '#cars_model',
                    '#cars_color',
                    '#cars_license_number',
                    '#cars_KMCounter',
                    '#cars_plate_number',
                    '#cars_motor_number',
                    '#cars_chassis_number',
                    '#cars_price',
                    '#cars_user_id',
                    '#cars_rental_type_id',
                    '#cars_renter_commission'
                ]);
                if(data == 1)
                {
                    PrintOnSelector("#car_register .alert","تم الاضافة بنجاح ");
                    $("#car_register .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                        $(this).delay(500).fadeOut(500,function(){
                            location.reload();
                        })
                    })
                }else
                {
                    PrintOnSelector("#car_register .alert","برجاء المحاولة مرة اخري");
                    $("#car_register .alert").removeClass("alert-success").addClass("alert-danger").fadeIn(500,function(){
                        $(this).delay(500).fadeOut(500,function(){
                            // location.reload();
                        } )
                    })
                }
            },
            error:function (data) {
                button_done(button);
//                alert(data['responseText']);
                var error = data.responseJSON;
                $("#car_register label").addClass("alert alert-danger").fadeIn();
                error_handler(
                    error,
                    [
                        '#cars_name',
                        '#cars_model',
                        '#cars_color',
                        '#cars_KM_Counter',
                        '#cars_plate',
                        '#cars_motor',
                        '#cars_chassis',
                        '#cars_price',
                        '#cars_user_id',
                        '#cars_rental_type_id',
                        '#cars_renter_value',
                        '#cars_picture'
                    ],
                    [
                        'name',
                        'model',
                        'color',
                        'KM_Counter',
                        'plate',
                        'motor',
                        'chassis',
                        'price',
                        'partner_id',
                        'rental_type_id',
                        'renter_value',
                        'picture'
                    ]
                );
            }
        });
    });
    var UserID;
    $("#Cars *").click(function(){
        if(this.hasAttribute('data-id'))
        {
            UserID = $(this).attr('data-id');
            $("#DeleteCar-Popup #IDVal").val(UserID);
        }
    });
    $("#DeleteCar-Popup form").submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"/car/delete",
            type:"POST",
            data:$("#DeleteCar-Popup form").serialize(),
            success:function(data){
                if(data == 2)
                {
                    PrintOnSelector("#DeleteCar-Popup form .alert","لا يمكنك مسح السيارة .. تأكد اولا من الحجوزات و الانتظار");
                    $("#DeleteCar-Popup form .alert").removeClass("alert-success").addClass("alert-danger").fadeIn(500)
                }
                else {
                    PrintOnSelector("#DeleteCar-Popup form .alert","تم الحذف بنجاح");
                    $("#DeleteCar-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                        $(this).delay(500).fadeOut(500,function(){
                            location.reload();
                        })
                    })
                }


            },
            error:function(data){
                 // alert(data['responseText']);
                PrintOnSelector("#DeleteCar-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
                $("#DeleteCar-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                    $(this).delay(1000).fadeOut(500,function(){
                        location.reload();
                    })
                })
            }
        });
    })
    $("#CheckAvailability").submit(function(e){
        var button = $("#CheckAvailability button");
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/car/availability",
            type:"POST",
            data:$("#CheckAvailability").serialize(),
            success:function(data){
                button_done(button);
               // alert(data);
                if(data == 1)
                {
                    PrintOnSelector("#CheckAvailability .alert","متاحة");
                    $("#CheckAvailability .alert").removeClass("alert-danger").removeClass("alert-info").addClass("alert-success").fadeIn(500)
                }
                else if(data == 0)
                {
                    PrintOnSelector("#CheckAvailability .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
                    $("#CheckAvailability .alert").removeClass("alert-success").removeClass("alert-info").addClass("alert-danger").fadeIn(500);
                }
                else {
                    PrintOnSelector("#CheckAvailability .alert",data);
                    $("#CheckAvailability .alert").removeClass("alert-success").removeClass("alert-danger").addClass("alert-info").fadeIn(500)

                }


            },
            error:function(data){
                button_done(button);
                //alert(data['responseText']);



            }
        });
    })

});