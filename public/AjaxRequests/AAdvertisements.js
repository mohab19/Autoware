$(function () {
    $('#AddAdvertisement-Popup form').submit(function (e) {
        var button = $("#AddAdvertisement-Popup form button[type='submit']");
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/announcement/add",
            type: 'POST',
            data : new FormData(this),
            contentType: false,
            cache      : false,
            processData: false,
            success: function (data) {
                // alert(data)
                button_done(button);
                if(data == 1)
                {
                    PrintOnSelector('#AddAdvertisement-Popup form>.alert',"تم اضافة الاعلان بنجاح");
                    $("#AddAdvertisement-Popup form >.alert").removeClass("alert-danger").addClass("alert-success").fadeIn(function(){
                        $(this).delay(1000).fadeOut(function(){
                            location.reload();
                        });

                    })

                }else
                {
                    PrintOnSelector('#AddAdvertisement-Popup form>.alert',"حدث خطأ ما برجاء المحاولة لاحقا");
                    $("#AddAdvertisement-Popup form >.alert").removeClass("alert-success").addClass("alert-danger").fadeIn(function(){
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
                $("#AddAdvertisement-Popup form label").addClass("alert alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#AddAdvertisement-Popup form #title',
                        '#AddAdvertisement-Popup form #description',
                        '#AddAdvertisement-Popup form #picture',
                        '#AddAdvertisement-Popup form #attachments',
                        '#AddAdvertisement-Popup form #price'
                    ],
                    [   'title',
                        'description',
                        'picture',
                        'attachments',
                        'price'
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
        url:"/announcement/update",
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
$(".Advertisements *").click(function(){
    if(this.hasAttribute('data-delete'))
    {
        UserID = $(this).attr('data-delete');
        $("form#DeleteAdvertisement input.id").val(UserID);
    }
    else if(this.hasAttribute('data-update'))
    {
        var id = $(this).attr('data-update');
        var title = $(this).attr('data-title');
        var description = $(this).attr('data-description');
        var price = $(this).attr('data-price');
        var notes = $(this).attr('data-notes');
        $("form#EditAdvertisementInfo input.id").val(id);
        $("form#EditAdvertisementInfo input[name='title']").val(title);
        $("form#EditAdvertisementInfo textarea[name='description']").val(description);
        $("form#EditAdvertisementInfo textarea[name='notes']").val(notes);
        $("form#EditAdvertisementInfo input[name='price']").val(price);
    }
    else if(this.hasAttribute('data-picture'))
    {
        $("#MainPicture-Popup input.id").val($(this).attr('data-picture'));
    }
    else if(this.hasAttribute('data-attachments'))
    {
        $("#Attachments-Popup input.id").val($(this).attr('data-attachments'));
    }
});
$("#DeleteAdvertisement-Popup form").submit(function(e){
    e.preventDefault();
    $.ajax({
        url:"/announcement/delete",
        type:"POST",
        data:$("#DeleteAdvertisement-Popup form").serialize(),
        success:function(data){
            // alert(data);
            if(data == 1)
            {
                PrintOnSelector("#DeleteAdvertisement-Popup form .alert","تم الحذف بنجاح");
                $("#DeleteAdvertisement-Popup form .alert").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })
            }
        },
        error:function(data){
             // alert(data['responseText']);
            PrintOnSelector("#DeleteAdvertisement-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteAdvertisement-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
    });
})
$("#AdvertisementInfo-Popup form").submit(function(e){
    var button = $("#AdvertisementInfo-Popup form button[type='submit']")
    button_waiting(button);
    e.preventDefault();
    $.ajax({
        url:"/announcement/update",
        type: 'POST',
        data : $("#AdvertisementInfo-Popup form").serialize(),
        success:function(data){
            button_done(button);
            // alert(data);
        if(data == 1)
        {
            PrintOnSelector("#AdvertisementInfo-Popup form .alert","تم تعديل البيانات");
            $("#AdvertisementInfo-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
        },
        error: function (data) {
             // alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#AdvertisementInfo-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error,
                [   '#AdvertisementInfo-Popup form #title',
                    '#AdvertisementInfo-Popup form #price',
                    '#AdvertisementInfo-Popup form #description',
                    '#AdvertisementInfo-Popup form #notes'

                ],
                [   'title',
                    'price',
                    'description',
                    'notes'
                ]
            );

        }
    });
})
$("#MainPicture-Popup form").submit(function(e){
    var button = $("#MainPicture-Popup form button[type='submit']")
    button_waiting(button);
    e.preventDefault();
    $.ajax({
        url:"/announcement/picture/update",
        type: 'POST',
        data : new FormData(this),
        contentType: false,
        cache      : false,
        processData: false,
        success:function(data){
            button_done(button);
            // alert(data);
        if(data == 1)
        {
            PrintOnSelector("#MainPicture-Popup form .alert","تم تعديل البيانات");
            $("#MainPicture-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
        },
        error: function (data) {
             // alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#MainPicture-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error[
                    '#MainPicture-Popup form #picture'
                ],
                [
                    'picture'
                ]
            );

        }
    });
})
$("#Attachments-Popup form").submit(function(e){
    var button = $("#Attachments-Popup form button[type='submit']")
    button_waiting(button);
    e.preventDefault();
    $.ajax({
        url:"/announcement/attachments/update",
        type: 'POST',
        data : new FormData(this),
        contentType: false,
        cache      : false,
        processData: false,
        success:function(data){
            button_done(button);
            // alert(data);
        if(data == 1)
        {
            PrintOnSelector("#Attachments-Popup form .alert","تم تعديل البيانات");
            $("#Attachments-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
        },
        error: function (data) {
             // alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#Attachments-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error[
                    '#Attachments-Popup form #picture'
                ],
                [
                    'picture'
                ]
            );

        }
    });
})