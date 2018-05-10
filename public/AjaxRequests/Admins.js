$(function () {

    $('#AddAdmin').submit(function (e) {
        var button = $('#AddAdmin button');
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url : '/admin/add',
            type: 'POST',
            data: $('#AddAdmin').serialize(),
            success: function (data) {
                button_done(button);
                $("#AddAdmin label.alert-danger").fadeOut();
                if(data == 1)
                {
                    PrintOnSelector('#AddAdmin>.alert',"تم اضافة المدير بنجاح");
                    $("#AddAdmin>.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });
                    });
                }else
                {
                    PrintOnSelector('#AddAdmin>.alert',"حدث خطأ ما برجاء المحاولة لاحقا");
                    $("#AddAdmin>.alert").removeClass("alert-success").addClass("alert-danger").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });

                    })
                }
            },
            error: function (data) {
                // alert(data['responseText']);
                var error = data.responseJSON;
                button_done(button);
                $("#AddAdmin label").addClass("alert alert-danger").fadeIn();

                error_handler(
                    error,
                    [   '#AddAdmin #admin_first',
                        '#AddAdmin #admin_last',
                        '#AddAdmin #admin_birth',
                        '#AddAdmin #admin_phone',
                        '#AddAdmin #admin_address',
                        '#AddAdmin #admin_national_id',
                        '#AddAdmin #admin_email',
                    ],
                    [   'first_name',
                        'last_name',
                        'birthdate',
                        'phone',
                        'address',
                        'national_id',
                        'email',]
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
        $("#DeleteAdmin-Popup #IDVal").val(UserID);
    }
});
$("#DeleteAdmin-Popup form").submit(function(e){
    e.preventDefault();
    $.ajax({
        url:"/admin/delete",
        type:"POST",
        data:$("#DeleteAdmin-Popup form").serialize(),
        success:function(data){
            PrintOnSelector("#DeleteAdmin-Popup form .alert","تم الحذف بنجاح");
            $("#DeleteAdmin-Popup form .alert").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })

        },
        error:function(data){
            // alert(data['responseText']);
            PrintOnSelector("#DeleteAdmin-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteAdmin-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
    });
})
$("*").click(function() {
    if (this.hasAttribute('data-editAdmin')) {
        var user_id = $(this).siblings("span#user_id").text();
        var id = $(this).parent().siblings("td#id").text();
        var firstname = $(this).siblings("span#firstname").text();
        var lastname = $(this).siblings("span#lastname").text();
        var birthdate = $(this).parent().siblings("td#birthday").text();
        var national_id = $(this).parent().siblings("td#national_id").text();
        var phone = $(this).parent().siblings("td#phone").text();
        var address = $(this).parent().siblings("td#address").text();
        var salary = $(this).parent().siblings("td#salary").text();
        $("#AdminInfo-Popup form input#id").val(id);
        $("#AdminInfo-Popup form input#user_id").val(user_id);
        $("#AdminInfo-Popup form input#first_name").val(firstname);
        $("#AdminInfo-Popup form input#last_name").val(lastname);
        $("#AdminInfo-Popup form input#birthdate").val(birthdate);
        $("#AdminInfo-Popup form input#national_id").val(national_id);
        $("#AdminInfo-Popup form input#phone").val(phone);
        $("#AdminInfo-Popup form input#address").val(address);
        $("#AdminInfo-Popup form input#salary").val(salary);
    }
})
$("#AdminInfo-Popup form").submit(function(e){
    var button = $("#AdminInfo-Popup form button")
    button_waiting(button);

    e.preventDefault();
    $.ajax({
        url:"/admin/update",
        type:"POST",
        data:$("#AdminInfo-Popup form").serialize(),
        success:function(data){

            PrintOnSelector("#AdminInfo-Popup form .alert","تم تعديل البيانات");
            $("#AdminInfo-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })
        },
        error: function (data) {
            // alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#AdminInfo-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error,
                [   '#AdminInfo-Popup form #admin_first',
                    '#AdminInfo-Popup form #admin_last',
                    '#AdminInfo-Popup form #admin_birthdate',
                    '#AdminInfo-Popup form #admin_phone',
                    '#AdminInfo-Popup form #admin_address',
                    '#AdminInfo-Popup form #admin_national_id',

                ],
                [   'first_name',
                    'last_name',
                    'birthdate',
                    'phone',
                    'address',
                    'national_id',
                ]
            );

        }
    });
})