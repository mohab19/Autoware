$(function () {
    $('#partner_register').submit(function (e) {
        var button = $("#partner_register button");
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url : '/partner/add',
            type: 'POST',
            data: $('#partner_register').serialize(),
            success: function (data) {
                button_done(button);
                empty_errors( [
                    '#partner_first',
                    '#partner_last',
                    '#partner_birth',
                    '#partner_phone',
                    '#partner_address',
                    '#partner_national_id',
                    '#partner_email'
                ]);
                if(data == 1)
                {
                    PrintOnSelector('#partner_register>.alert',"تم اضافة الشريك بنجاح");
                    $("#partner_register>.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });

                    })

                }else
                {
                    PrintOnSelector('#partner_register>.alert',"حدث خطأ ما برجاء المحاولة لاحقا");
                    $("#partner_register>.alert").removeClass("alert-success").addClass("alert-danger").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });

                    })
                }
            },
            error: function (data) {
                // alert(data['responseText'])

                button_done(button);
                var error = data.responseJSON;
                $("#partner_register label").addClass("alert alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#partner_register #partner_first',
                        '#partner_register #partner_last',
                        '#partner_register #partner_birthdate',
                        '#partner_register #partner_phone',
                        '#partner_register #partner_address',
                        '#partner_register #partner_national_id',
                    ],
                    [   'first_name',
                        'last_name',
                        'birthdate',
                        'phone',
                        'address',
                        'national_id'
                    ]
                );

            }
        });
    });
});
$("*").click(function() {
    if (this.hasAttribute('data-editPartner'))
    {
        var id = $(this).attr('data-editPartner');
        var firstname = $(this).siblings("span#firstname").text();
        var lastname = $(this).siblings("span#lastname").text();
        var birthdate = $(this).parent().siblings("td#birthday").text();
        var national_id = $(this).parent().siblings("td#national_id").text();
        var phone = $(this).parent().siblings("td#phone").text();
        var address = $(this).parent().siblings("td#address").text();
        var notes = $.trim($(this).parent().siblings("td#notes").text());
        $("#PartnerInfo-Popup form input#id").val(id);
        $("#PartnerInfo-Popup form input#first_name").val(firstname);
        $("#PartnerInfo-Popup form input#last_name").val(lastname);
        $("#PartnerInfo-Popup form input#birthdate").val(birthdate);
        $("#PartnerInfo-Popup form input#national_id").val(national_id);
        $("#PartnerInfo-Popup form input#phone").val(phone);
        $("#PartnerInfo-Popup form input#address").val(address);
        $("#PartnerInfo-Popup form textarea#notes").val(notes);
    }
})
$("#PartnerInfo-Popup form").submit(function(e){
    var button = $("#PartnerInfo-Popup form button")
    button_waiting(button);

    e.preventDefault();
    $.ajax({
        url:"/partner/update",
        type:"POST",
        data:$("#PartnerInfo-Popup form").serialize(),
        success:function(data){
            button_done(button);
            PrintOnSelector("#PartnerInfo-Popup form .alert","تم تعديل البيانات");
            $("#PartnerInfo-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })
        },
        error: function (data) {
            // alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#PartnerInfo-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error,
                [   '#EditPartnerInfo #partner_first',
                    '#EditPartnerInfo #partner_last',
                    '#EditPartnerInfo #partner_birthdate',
                    '#EditPartnerInfo #partner_phone',
                    '#EditPartnerInfo #partner_address',
                    '#EditPartnerInfo #partner_national_id',

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

var UserID;
$("*").click(function(){
    if(this.hasAttribute('data-id'))
    {
        UserID = $(this).attr('data-id');
        $("#DeletePartner-Popup #IDVal").val(UserID);
    }
});
$("#DeletePartner-Popup form").submit(function(e){

    e.preventDefault();
    $.ajax({
        url:"/partner/delete",
        type:"POST",
        data:$("#DeletePartner-Popup form").serialize(),
        success:function(data){
            //alert(data);
            if(data == 0)
            {
                PrintOnSelector("#DeletePartner-Popup form .alert","لا يمكنك مسح الشريك .. تأكد من الحجوزات و الانتظار");
                $("#DeletePartner-Popup form .alert").addClass("alert-danger").fadeIn(500);
            }
            else
            {


                PrintOnSelector("#DeletePartner-Popup form .alert","تم الحذف بنجاح");
                $("#DeletePartner-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })
            }

        },
        error:function(data){
            //alert(data['responseText']);
            PrintOnSelector("#DeletePartner-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeletePartner-Popup form .alert").addClass("alert-danger").fadeIn(500);
        }
    });
})