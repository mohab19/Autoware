$(document).ready(function(){
  $("#AddExpense-Popup form").submit(function(e){
    var button = $("#AddExpense-Popup form button");
      button_waiting(button);
    e.preventDefault();
    $.ajax({
      url:"/expenses/general/add",
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

})
