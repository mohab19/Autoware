$(document).ready(function(){
    $("#AccountInfo-Popup form").submit(function(e){
        var button = $("#AccountInfo-Popup form button")
        button_waiting(button);

        e.preventDefault();
        $.ajax({
            url:"/user/update",
            type:"POST",
            data:$("#AccountInfo-Popup form").serialize(),
            success:function(data){
                button_done(button);
                PrintOnSelector("#AccountInfo-Popup form .alert","تم تعديل البيانات");
                $("#AccountInfo-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })
            },
            error: function (data) {
                button_done(button);
                var error = data.responseJSON;
                $("#AccountInfo-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#user_first',
                        '#user_last',
                        '#user_birthdate',
                        '#user_phone',
                        '#user_address',
                        '#user_national_id',
                        '#user_password',
                        '#user_password_confirm'

                    ],
                    [   'first_name',
                        'last_name',
                        'birthdate',
                        'phone',
                        'address',
                        'national_id',
                        'password',
                        'password_confirm'
                    ]
                );

            }
        });
    })
})
