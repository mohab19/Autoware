$("#AddCarExpense").click(function(){
    $("#AddExpense-Popup #IDVal").val($(this).attr("data-id"));
})
$("#AddExpense-Popup form").submit(function(e){
    var button = $("#AddExpense-Popup form button");
    button_waiting(button);
    e.preventDefault();
    $.ajax({
        url:"/expenses/car/add",
        type:"POST",
        data:$("#AddExpense-Popup form").serialize(),
        success:function(data) {
            button_done(button);
            PrintOnSelector("#AddExpense-Popup form .alert", "تم الاضافة بنجاح");
            $("#AddExpense-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500, function () {
                $(this).delay(500).fadeOut(500, function () {
                    location.reload();
                })
            })
        },
        error: function (data) {
            //alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#AddExpense-Popup form label").addClass("alert alert-danger").fadeIn();
            error_handler(
                error,
                [   '#title',
                    '#value',

                ],
                [   'title',
                    'value',
                ]
            );

        }
    });
})
$("#Update").submit(function(e){
    var button = $("#Update button")
    button_waiting(button);
    e.preventDefault();
    $.ajax({
        url:"/car/update",
        type:"POST",
        data:$("#Update").serialize(),
        success:function(data){
alert(data);
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
                [   '#type',
                    '#model',
                    '#color',
                    '#plate_number',
                    '#motor_number',
                    '#chassis_number',
                    '#license_number',
                    '#price'


                ],
                [   'type',
                    'model',
                    'color',
                    'plate_number',
                    'motor_number',
                    'chassis_number',
                    'license_number',
                    'price'

                ]
            );

        }
    });
})

$("#AddAttachment-Popup form").submit(function(e){
    var button = $("#AddAttachment-Popup form button[type='submit']");
    button_waiting(button);
    e.preventDefault();
    $.ajax({
        url:"/car/attachment",
        type: 'POST',
        data : new FormData(this),
        contentType: false,
        cache      : false,
        processData: false,
        success:function(data){
            //alert(data);
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
                    '#AddAttachment-Popup form #title',
                    '#AddAttachment-Popup form #value'

                ],
                [
                    'title',
                    'value'
                ]
            );
        }
    });
})
var UserID;
$("*").click(function(){
    if(this.hasAttribute('data-id'))
    {
        UserID = $(this).attr('data-id');
        $("#DeleteAttachment-Popup #IDVal").val(UserID);
    }
});
$("#DeleteAttachment-Popup form").submit(function(e){

    e.preventDefault();
    $.ajax({
        url:"/car/attachment/delete",
        type:"POST",
        data:$("#DeleteAttachment-Popup form").serialize(),
        success:function(data){
            // alert(data);
            PrintOnSelector("#DeleteAttachment-Popup form .alert","تم الحذف بنجاح");
            $("#DeleteAttachment-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })
        },
        error:function(data){
            // alert(data['responseText']);
            PrintOnSelector("#DeleteAttachment-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteAttachment-Popup form .alert").addClass("alert-danger").fadeIn(500);
        }
    });
})