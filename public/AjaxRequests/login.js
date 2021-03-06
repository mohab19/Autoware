
$(function () {
    $('#login').submit(function (e) {
        var button = $("#login button");
        button_waiting(button);
        e.preventDefault();
        var jsoner = {
            _token: $('input[name="_token"]').val(),
            email : $('.email1').val(),
            password : $('.password1').val(),
            remember : $('#rememeber').val()
        };
        $.ajax({
            url: '/user/login',
            type: 'POST',
            dataType: 'Json',
            data: jsoner,
            success:function (data) {
                // alert(data);
                button_done(button);
                var auth = data.auth;
                var to_go = data.intended;
                if(auth == true) {
                    PrintOnSelector('#login>.alert', "تم تسجيل الدخول بنجاح");
                    $("#login>.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(function () {
                        $(this).delay(1000).fadeOut(function () {
                            location.href = to_go;
                        });
                    });
                }
                else {
                    PrintOnSelector('#login>.alert', "هناك خطأ في البريد الالكتروني او كلمة المرور");
                    $("#login>.alert").removeClass("alert-success").addClass("alert-danger").fadeIn(function () {
                    });
                }
            },
            error:function (data) {
                button_done(button,"تسجيل الدخول");
                $("#login label.alert").addClass("alert-danger").fadeIn();
                 // alert(data['responseText']);
                var error = data.responseJSON;
                error_handler(
                    error,
                    ['#email_error','#password_error'],
                    ["email","password"]
                );
            }
        });
    })
});
