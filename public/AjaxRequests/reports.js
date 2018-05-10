$(function () {
    function GetMonths() {
        $.ajax({
            url:"/report/GetMonths",
            type:"POST",
            data:$("#ReportFinal").serialize(),
            dataType: "html",   //expect html to be returned
            success:function(data){
                //alert(data);
                $("#ReportFinal label.alert").fadeOut();
                $("#ReportFinal select[name='month'] option[value!='all'] ,#ReportFinal select[name='year'] option[value!='all']").remove();
                $("#ReportFinal div.months select").append(data);
            },
            error:function(data){
                //alert(data['responseText']);
            }
        });
    }
    function GetYears() {
        $.ajax({
            url:"/report/GetYears",
            type:"POST",
            data:$("#ReportFinal").serialize(),
            dataType: "html",   //expect html to be returned
            success:function(data){
                 //alert(data);
                $("#ReportFinal label.alert").fadeOut();
                $("#ReportFinal select[name='year'] option[value!='all']").remove();
                $("#ReportFinal div.years select").append(data);
            },
            error:function(data){
                 //alert(data['responseText']);
            }
        });
    }
    $("#ReportFinal select[name='type']").change(function () {
        GetMonths();
        GetYears();

    });
    $("#ReportFinal select[name='month']").change(function () {
        GetYears();
    });
    $("#ReportFinal").submit(function(e){

        var button = $('#ReportFinal button');
        button_waiting(button);
        e.preventDefault();
        $.ajax({
            url:"/report/FinalReport",
            type:"POST",
            data:$("#ReportFinal").serialize(),
            success:function(data){
                 //alert(data);
                button_done(button);
                $(".results *").remove();
                $("#ReportFinal label.alert").fadeOut();
                $(".results").append(data);
                //$("div.box").fadeIn(600);
            },
            error:function(data){
//                alert(data['responseText']);
                var error = data.responseJSON;
                button_done(button);
                $("#ReportFinal label.alert").addClass("alert-danger").fadeIn();
                error_handler(
                    error,
                    [   '#ReportFinal #ReportFinal_type',
                        '#ReportFinal #ReportFinal_month',
                        '#ReportFinal #ReportFinal_year'
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
            url:"/report/update",
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
                    [   'form#Update #ReportFinal_first',
                        'form#Update #ReportFinal_last',
                        'form#Update #ReportFinal_birthdate',
                        'form#Update #ReportFinal_phone',
                        'form#Update #ReportFinal_address',
                        'form#Update #ReportFinal_national_id',

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