$(document).ready(function(){
    var ExpenseID;
$(".expenses *").click(function(){
    if(this.hasAttribute('data-id'))
    {
        ExpenseID = $(this).attr('data-id');
        $("#DeleteExpense-Popup #IDVal").val(ExpenseID);
    }
});
$("#DeleteExpense-Popup form").submit(function(e){
    e.preventDefault();
    $.ajax({
        url:"/expenses/delete",
        type:"POST",
        data:$("#DeleteExpense-Popup form").serialize(),
        success:function(data){
            PrintOnSelector("#DeleteExpense-Popup form .alert","تم الحذف بنجاح");
            $("#DeleteExpense-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })

        },
        error:function(data){
            //alert(data['responseText']);
            PrintOnSelector("#DeleteExpense-Popup form .alert","حدث خطأ ما . برجاء المحاولة لاحقا");
            $("#DeleteExpense-Popup form .alert").addClass("alert-danger").fadeIn(500,function(){
                $(this).delay(1000).fadeOut(500,function(){
                    location.reload();
                })
            })
        }
    });
})

$("#EditExpense-btn").click(function(){
    var id = $(this).siblings(".main-btn").attr("data-id");
    var title = $.trim($(this).parent().siblings("td#title").text());
    var value = $.trim($(this).parent().siblings("td#value").text());
    $("#ExpensesInfo-Popup form input#id").val(id);
    $("#ExpensesInfo-Popup form input#title").val(title);
    $("#ExpensesInfo-Popup form input#value").val(value);

})
$("#ExpensesInfo-Popup form").submit(function(e){
    var button = $("#ExpensesInfo-Popup form button")
    button_waiting(button);
    e.preventDefault();
    $.ajax({
        url:"/expenses/update",
        type:"POST",
        data:$("#ExpensesInfo-Popup form").serialize(),
        success:function(data){
            button_done(button);
            PrintOnSelector("#ExpensesInfo-Popup form .alert","تم تعديل البيانات");
            $("#ExpensesInfo-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
                $(this).delay(500).fadeOut(500,function(){
                    location.reload();
                })
            })
        },
        error: function (data) {
            //alert(data['responseText'])
            button_done(button);
            var error = data.responseJSON;
            $("#ExpensesInfo-Popup form label.viewerror").addClass("alert alert-danger").fadeIn();
            error_handler(
                error,
                [   '#titleError',
                    '#valueError',

                ],
                [   'title',
                    'value',

                ]
            );

        }
    });
});
})