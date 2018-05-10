$(document).ready(function() {
    $("ul.notifcation-body,ul.notifcation-body *").click(function(){
        $(this).show();
    })
    // $("html").niceScroll({
    //     cursorcolor: "#032237",
    //     cursorborder: "1px solid #c4c3c3",
    //     cursoropacitymin: "1",
    //     zindex: "9999",
    //     mousescrollstep: "60"
    //
    // })
    var current;
    $("#AddReservation #withdiscount").click(function () {
        $("#AddReservation #discountinput").fadeIn(400);
        current = parseInt($("#AddReservation #RequireMoney").text());

    })
    $("#AddReservation #withoutdiscount").click(function () {
        $("#AddReservation #discountinput").fadeOut(400);
    })
    $("#RenewReservation #withdiscount").click(function () {
        $("#RenewReservation #discountinput").fadeIn(400);
        current = parseInt($("#AddReservation #RequireMoney").text());

    })
    $("#RenewReservation #withoutdiscount").click(function () {
        $("#RenewReservation #discountinput").fadeOut(400);
    })
    $("#UpdateReservation #withdiscount").click(function () {
        $("#UpdateReservation #discountinput").fadeIn(400);
        current = parseInt($("#UpdateReservation #RequireMoney").text());

    })
    $("#UpdateReservation #withoutdiscount").click(function () {
        $("#UpdateReservation #discountinput").fadeOut(400);
    })



    $(".background , .popup i.fa-close").click(function () {

        $(".popup , .popup2").fadeOut(300, function () {
            $(".popup .alert").fadeOut();
            $(".background").fadeOut(300);
        })
    });


    $("*").click(function () {
        if (this.hasAttribute('data-popup')) {
            var popup = $(this).attr("data-popup");
            $(".popup").fadeOut(300, function () {
                $(".background").fadeIn(300, function () {
                    $("#" + popup).fadeIn(300);
                })
            })
        }
        else {
        }

    })
    $("#Expenses .options button").click(function () {
        var SectionID = $(this).attr('data-SectionID');
        $("#Expenses .options").fadeOut(500, function () {
            $(SectionID).fadeIn(500);
        })
    })
    $("#Expenses #back").click(function () {
        var SectionID = $(this).attr('data-SectionID');
        $(SectionID).fadeOut(500, function () {
            $("#Expenses .options").fadeIn(500);
        })
    })
$(".notifcation-icon").click(function(){
    $(".notifcation-body").fadeToggle(400);
})
});
$(window).on('load',function(){
    $(".loading img").fadeOut(800,function(){
        $(".loading").fadeOut(800,function(){
            $(this).remove();
        });
    })

});
