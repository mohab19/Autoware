$(function () {

    $('#register_employee').submit(function (e) {
        var button = $('#register_employee button');
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url : '/user/register/Employee',
            type: 'POST',
            data: $('#register_employee').serialize(),
            success: function (data) {
                button_done(button,"اضافة موظف");
                empty_errors( [
                    '#emp_first',
                    '#emp_last',
                    '#emp_birth',
                    '#emp_phone',
                    '#emp_address',
                    '#emp_national_id',
                    '#emp_salary',
                    '#emp_email',
                    '#emp_password',
                    '#emp_conf'
                ]);
                if(data == 1)
                {
                    PrintOnSelector('#register_employee>.alert',"تم اضافة الموظف بنجاح");
                    $("#register_employee>.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });
                    });
                }else
                {
                    PrintOnSelector('#register_employee>.alert',"حدث خطأ ما برجاء المحاولة لاحقا");
                    $("#register_employee>.alert").removeClass("alert-success").addClass("alert-danger").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });

                    })
                }
            },
            error: function (data) {
                // alert(data['responseText']);
                var error = data.responseJSON;
                button_done(button,"اضافة موظف");
                $("#register_employee label").addClass("alert alert-danger").fadeIn();

                error_handler(
                    error,
                    [   '#emp_first',
                        '#emp_last',
                        '#emp_birth',
                        '#emp_phone',
                        '#emp_address',
                        '#emp_national_id',
                        '#emp_salary',
                        '#emp_email',
                        '#emp_password',
                        '#emp_conf'
                    ],
                    [   'first_name',
                        'last_name',
                        'birthdate',
                        'phone',
                        'address',
                        'national_id',
                        'salary',
                        'email',
                        'password',
                        'password_confirmation']
                );
            }
        });
    });

});
var UserID;
$("*").click(function(){
    if(this.hasAttribute('data-id'))
    {
        UserID = $(this).attr('data-id');
        $("#DeleteEmployee-Popup #IDVal").val(UserID);
    }
});
$("#DeleteEmployee-Popup form").submit(function(e){
    e.preventDefault();
    $.ajax({
        url:"/employee/delete",
        type:"POST",
        data:$("#DeleteEmployee-Popup form").serialize(),
        success:function(data){
            PrintOnSelector("#DeleteEmployee-Popup form .alert","تم الحذف بنجاح");
            $("#DeleteEmployee-Popup form .alert").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })

        },
        error:function(data){
            // alert(data['responseText']);
            PrintOnSelector("#DeleteEmployee-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteEmployee-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
    });
})
$("#Update").submit(function(e){
    var button = $("#Update button")
    button_waiting(button);

    e.preventDefault();
    $.ajax({
        url:"/employee/update",
        type:"POST",
        data:$("#Update").serialize(),
        success:function(data){
            PrintOnSelector("#Update div>.alert","تم تعديل البيانات");
            $("#Update .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })
        },
        error: function (data) {
            // alert(data['responseText'])
            button_done(button,"تعديل");
            var error = data.responseJSON;
            $("#Update label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error,
                [   '#Update #employee_firstname',
                    '#Update #employee_lastname',
                    '#Update #employee_birthdate',
                    '#Update #employee_phone',
                    '#Update #employee_address',
                    '#Update #employee_national_id',
                    '#Update #employee_salary',

                ],
                [   'first_name',
                    'last_name',
                    'birthdate',
                    'phone',
                    'address',
                    'national_id',
                    'salary',
                ]
            );

        }
    });
})
$("#AddPenalty-Popup form").submit(function(e){
    var button = $("#AddPenalty-Popup form button")
    button_waiting(button);

    e.preventDefault();
    $.ajax({
        url:"/employee/penalty/add",
        type:"POST",
        data:$("#AddPenalty-Popup form").serialize(),
        success:function(data){
            PrintOnSelector("#AddPenalty-Popup form .alert","تم تعديل البيانات");
            $("#AddPenalty-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })
        },
        error: function (data) {
            // alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#AddPenalty-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error,
                [   '#AddPenalty #value',
                ],
                [   'value',
                ]
            );

        }
    });
    });
