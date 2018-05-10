$(document).ready(function(){
    $("#Update").submit(function(e){
        var button = $("#Update button")
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/client/update",
            type:"POST",
            data:$("#Update").serialize(),
            success:function(data){
                button_done(button);

                PrintOnSelector("#Update .alert","تم تعديل البيانات");
                $("#Update .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })
            },
            error: function (data) {
                // alert(data['responseText'])
                button_done(button);
                var error = data.responseJSON;
                $("#Update label").addClass("alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#client_first',
                        '#client_last',
                        '#client_birthdate',
                        '#client_phone',
                        '#client_address',
                        '#client_national_id',
                        '#client_office',
                        '#client_nationality',
                        '#client_id_from',
                        '#client_id_date',
                        '#client_licence',
                        '#client_licence_type',
                        '#client_licence_to',
                        '#client_licence_from',

                    ],
                    [   'first_name',
                        'last_name',
                        'birthdate',
                        'phone',
                        'address',
                        'national_id',
                        'office',
                        'nationality',
                        'id_from',
                        'id_date',
                        'licence',
                        'licence_type',
                        'licence_to',
                        'licence_from',
                    ]
                );

            }
        });
    });
    $(".Debts *").click(function(){
        if(this.hasAttribute('data-id'))
        {
            var RentingID = $(this).attr('data-id');
            $("#Dept-Popup #IDVal").val(RentingID);
        }
        else if(this.hasAttribute('data-KM_id'))
        {
            var RentingID = $(this).attr('data-KM_id');
            $("#KMDept-Popup #IDVal").val(RentingID);
        }
    });
    $("#PayDept").submit(function(e){
        var button = $("#PayDept button")
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/client/dept/pay",
            type:"POST",
            data:$("#PayDept").serialize(),
            success:function(data){
                button_done(button);
                if(data==2)
                {
                    PrintOnSelector("#PayDept>.alert","برجاء ادخال المبلغ بشكل صحيح");
                    $("#PayDept .alert").removeClass("alert-success").addClass("alert-danger").fadeIn(500);
                }
                else {
                    PrintOnSelector("#PayDept>.alert", "تم دفع الدين بنجاح");
                    $("#PayDept .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500, function () {
                        $(this).delay(500).fadeOut(500, function () {
                            location.reload();
                        })
                    })
                }
            },
            error: function (data) {
               // alert(data['responseText'])
                button_done(button);
                PrintOnSelector("#PayDept>.alert","حدث خطأ ما . برجاء المحاولة لاحقا");
                $("#PayDept .alert").removeClass("alert-success").addClass("alert-danger").fadeIn(500);
                var error = data.responseJSON;
                $("#PayDept label").addClass("alert-danger").fadeIn();
                error_handler(
                    error,[
                        '#PayDept #dept'
                    ],
                    [
                        'dept'
                    ]
                );

            }
        });
    });
    $("#PayKMDept").submit(function(e){
        var button = $("#PayKMDept button")
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/client/penalty/pay",
            type:"POST",
            data:$("#PayKMDept").serialize(),
            success:function(data){
                //alert(data);
                button_done(button);
                if(data==2)
                {
                    PrintOnSelector("#PayKMDept>.alert","برجاء ادخال المبلغ بشكل صحيح");
                    $("#PayKMDept .alert").removeClass("alert-success").addClass("alert-danger").fadeIn(500);
                }
                else {
                    PrintOnSelector("#PayKMDept>.alert", "تم دفع الدين بنجاح");
                    $("#PayKMDept .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500, function () {
                        $(this).delay(500).fadeOut(500, function () {
                            location.reload();
                        })
                    })
                }
            },
            error: function (data) {
                 //alert(data['responseText'])
                button_done(button);
                PrintOnSelector("#PayKMDept>.alert","حدث خطأ ما . برجاء المحاولة لاحقا");
                $("#PayKMDept .alert").removeClass("alert-success").addClass("alert-danger").fadeIn(500);
                var error = data.responseJSON;
                $("#PayKMDept label").addClass("alert-danger").fadeIn();
                error_handler(
                    error,[
                        '#PayKMDept #dept'
                    ],
                    [
                        'KM_Counter_Penalty_paid'
                    ]
                );

            }
        });
    });
    $("#AddAttachment-Popup form").submit(function(e){
        var button = $("#AddAttachment-Popup form button[type='submit']");
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/client/attachment",
            type: 'POST',
            data : new FormData(this),
            contentType: false,
            cache      : false,
            processData: false,
            success:function(data){
                button_done(button);
                PrintOnSelector("#AddAttachment-Popup form .alert","تم الاضافة بنجاح ");
                $("#AddAttachment-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })

            },
            error:function(data){
                button_done(button);
                // alert(data['responseText']);
                var error = data.responseJSON;
                $("#AddAttachment-Popup form label").addClass("alert-danger").fadeIn();
                error_handler(
                    error,
                    [
                        '#title',
                        '#value'

                    ],
                    [
                        'title',
                        'value'
                    ]
                );
            }
        });
    })
})
