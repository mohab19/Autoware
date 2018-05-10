$(function () {
    function GetMonths() {
        $.ajax({
            url:"/partner/GetMonths",
            type:"POST",
            data:$("#Partner").serialize(),
            dataType: "html",   //expect html to be returned
            success:function(data){
                //alert(data);
                $("#Partner label.alert").fadeOut();
                $("#Partner select[name='month'] option[value!='all'] ,#Partner select[name='year'] option[value!='all']").remove();
                $("#Partner div.months select").append(data);
            },
            error:function(data){
                // alert(data['responseText']);
            }
        });
    }
    function GetCars() {
        $.ajax({
            url:"/partner/GetCars",
            type:"POST",
            data:$("#Partner").serialize(),
            dataType: "html",   //expect html to be returned
            success:function(data){
                // alert(data);
                $("#Partner label.alert").fadeOut();
                $("#Partner select[name='car_id'] option[value!='all'] ,#Partner select[name='year'] option[value!='all']").remove();
                $("#Partner div.cars select").append(data);
            },
            error:function(data){
                // alert(data['responseText']);
            }
        });
    }
    function GetYears() {
        $.ajax({
            url:"/partner/GetYears",
            type:"POST",
            data:$("#Partner").serialize(),
            dataType: "html",   //expect html to be returned
            success:function(data){
                // alert(data);
                $("#Partner label.alert").fadeOut();
                $("#Partner select[name='year'] option[value!='all']").remove();
                $("#Partner div.years select").append(data);
            },
            error:function(data){
                // alert(data['responseText']);
            }
        });
    }
    $("#Partner select[name='type']").change(function () {
            GetCars();
            GetMonths();
            GetYears();

    });
    $("#Partner select[name='month']").change(function () {
            GetYears();
    });
    $("#Partner select[name='car_id']").change(function () {
            GetMonths();
            GetYears();
    });
    $("#Partner").submit(function(e){

        var button = $('#Partner button');
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/partner/FinalPartner",
            type:"POST",
            data:$("#Partner").serialize(),
            success:function(data){
                  // alert(data);
                button_done(button);
                $(".results *").remove();
                $("#Partner label.alert").fadeOut();
                $(".results").append(data);
                //$("div.box").fadeIn(600);
            },
            error:function(data){
                    //alert(data['responseText']);
                var error = data.responseJSON;
                button_done(button);
                $("#Partner label.alert").addClass("alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#Partner #Partner_type',
                       '#Partner #Partner_month',
                        '#Partner #Partner_year'
                    ],
                    [   'type',
                       'month',
                        'year'
                    ]
                );
            }
        });
    })
    $("form#Update").submit(function(e){
        var button = $("form#Update button")
        button_waiting(button);

        e.preventDefault();
        $.ajax({
            url:"/partner/update",
            type:"POST",
            data:$("form#Update").serialize(),
            success:function(data){
                button_done(button);
                PrintOnSelector("form#Update .alert","تم تعديل البيانات");
                $("form#Update .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                    $(this).delay(500).fadeOut(500,function(){
                        location.reload();
                    })
                })
            },
            error: function (data) {
                // alert(data['responseText'])
                button_done(button);
                var error = data.responseJSON;
                $("form#Update label.viewerror").addClass("alert alert-danger").fadeIn();
                error_handler(
                    error,
                    [   'form#Update #partner_first',
                        'form#Update #partner_last',
                        'form#Update #partner_birthdate',
                        'form#Update #partner_phone',
                        'form#Update #partner_address',
                        'form#Update #partner_national_id',

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
});