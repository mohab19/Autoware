$(function () {
    $('#ContactUs').submit(function (e) {
        var button = $('#ContactUs button');
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url : '/contact',
            type: 'POST',
            data: $('#ContactUs').serialize(),
            success: function (data) {
                button_done(button,"ارسال رسالة");
                empty_errors( [
                    '#contact_name',
                    '#contact_phone',
                    '#contact_email',
                    '#contact_message'
                ]);
                if(data == 1)
                {
                    $(".alert-danger").fadeOut();
                    PrintOnSelector('#ContactUs>.alert',"لقد تم ارسال رسالتك شكرا لك");
                    $("#ContactUs>.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(function(){
                        $(this).delay(2000).fadeOut(function(){
                            location.reload();
                        });
                    });
                }else
                {
                    PrintOnSelector('#ContactUs>.alert',"حدث خطأ ما برجاء المحاولة مرة اخري");
                    $("#ContactUs>.alert").removeClass("alert-success").addClass("alert-danger").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                        });
                    });
                }
            },
            error: function (data) {
                 // alert(data['responseText']);
                button_done(button,"ارسال رسالة");
                var error = data.responseJSON;

                $("#ContactUs label").addClass("alert alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#contact_name',
                        '#contact_phone',
                        '#contact_email',
                        '#contact_message'
                    ],
                    [   'fullname',
                        'phone',
                        'email',
                        'message',

                    ]
                );
            }
        });
    });
});
