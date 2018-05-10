$(function () {
    $('#client_register').submit(function (e) {
        var button = $('#client_register button');
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url : '/client/add',
            type: 'POST',
            data: $('#client_register').serialize(),
            success: function (data) {
                button_done(button);
                empty_errors( [
                    '#client_first',
                    '#client_last',
                    '#client_birth',
                    '#client_phone',
                    '#client_address',
                    '#client_national_id',
                    '#client_email'
                ]);
                $("#client_register label.alert-danger").fadeOut();
                if(data == 1)
                {
                    PrintOnSelector('#client_register>.alert',"تم اضافة العميل بنجاح");
                    $("#client_register>.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });
                    });
                }else
                {
                    PrintOnSelector('#client_register>.alert',"حدث خطأ ما برجاء المحاولة مرة اخري");
                    $("#client_register>.alert").removeClass("alert-success").addClass("alert-danger").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });
                    });
                }
            },
            error: function (data) {
//                alert(data['responseText']);
                button_done(button);
                var error = data.responseJSON;
                $("#client_register label").addClass("alert alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#client_first',
                        '#client_last',
                        '#client_birth',
                        '#client_phone',
                        '#client_address',
                        '#client_national_id',
                        '#client_id_from',
                        '#client_id_date',
                        '#licence',
                        '#licence_type',
                        '#licence_from',
                        '#licence_to',
                        '#client_email'
                    ],
                    [   'first_name',
                        'last_name',
                        'birthdate',
                        'phone',
                        'address',
                        'national_id',
                        'id_from',
                        'id_date',
                        'licence',
                        'licence_type',
                        'licence_from',
                        'licence_to',
                        'email']
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
        $("#DeleteUser-Popup #IDVal").val(UserID);
    }
});
$("#DeleteUser-Popup form").submit(function(e){

    e.preventDefault();
    $.ajax({
        url:"/client/delete",
        type:"POST",
        data:$("#DeleteUser-Popup form").serialize(),
        success:function(data){
            //alert(data);
            if(data == 2)
            {
                PrintOnSelector("#DeleteUser-Popup form .alert","لا يمكنك مسح العميل لانه حاجز سيارة");
                $("#DeleteUser-Popup form .alert").removeClass("alert-success").addClass("alert-danger").fadeIn(500)
            }
            else
            {
                PrintOnSelector("#DeleteUser-Popup form .alert","تم الحذف بنجاح");
                $("#DeleteUser-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })
            }


        },
        error:function(data){
            // alert(data['responseText']);
            // alert(data);
            PrintOnSelector("#DeleteUser-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteUser-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
    });
})
