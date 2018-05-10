$(document).ready(function(){
  $(".item").click(function(){
    if(this.hasAttribute('data-id'))
    {
       var UserID = $(this).attr('data-id');
      var KMCounter = $(this).attr('data-km');
      var dept = $(this).attr('data-dept');
      $("#ReciveCar-Popup #IDVal").val(UserID);
      $("#ReciveCar-Popup span#KM_Counter").text(KMCounter);
      if(dept==0)
      {
        $("#ReciveCar-Popup input[name='dept']").val(0);
        $("#ReciveCar-Popup input[name='dept']").prop('disabled', true);
        $("#ReciveCar-Popup span#dept").text("لا يوجد");
      }
      else
      {
        $("#ReciveCar-Popup input[name='dept']").val('');
        $("#ReciveCar-Popup input[name='dept']").prop('disabled', false);
        $("#ReciveCar-Popup span#dept").text(dept);
      }

    }
  });
  $("#ReciveCar-Popup form input[name='KM_Counter']").keyup(function(){
    var KM_Counter = $(this).val();
    var id = $("#ReciveCar-Popup form input[name='id']").val();
    $.ajax({
      url: "/renting/recive/penalty",
      type: 'POST',
      data: $('#ReciveCar-Popup form').serialize(),
      success: function (data) {
        if(data == 0)
        {
          $("#ReciveCar-Popup form #Penalty").fadeOut();
        }
        else
        {
          $("#ReciveCar-Popup form #Penalty span#PenaltyValue").text(data);
          $("#ReciveCar-Popup form #Penalty").fadeIn();
        }
      },
      error:function(data){
        alert("Error");
      }
    });
  })
  $("#ReciveCar-Popup form").submit(function(e){
  var button = $("#ReciveCar-Popup form button[type='submit']");
    button_waiting(button);
    e.preventDefault();
    if($("#ReciveCar-Popup form input[type='file']").val().length==0)
      $("#ReciveCar-Popup form input[type='file']").val("");
    $.ajax({
      url:"/renting/recive",
      type: 'POST',
      data : new FormData(this),
      contentType: false,
      cache      : false,
      processData: false,
      success:function(data){
        //alert(data);
        button_done(button);
if(data == "dept")
{
        PrintOnSelector("#ReciveCar-Popup form label#dept","المبلغ غير صحيح");
$("label#dept").addClass("alert-danger").fadeIn();
}
else
{
        PrintOnSelector("#ReciveCar-Popup form .alert","تم الاستلام بنجاح ");
        $("#ReciveCar-Popup form .alert").removeClass("alert-danger").addClass("alert-success").fadeIn(500,function(){
          $(this).delay(500).fadeOut(500,function(){
            location.reload();
          })
        })
}
      },
      error:function(data){
        button_done(button);
        //alert(data['responseText']);
        var error = data.responseJSON;
        $("#ReciveCar-Popup form label").addClass("alert-danger").fadeIn();
        error_handler(
            error,
            [
              '#KMCounter',
              '#userate',
              '#payrate'


            ],
            [
              'KM_Counter',
              'userate',
              'payrate'

            ]
        );
      }
    });
  })
})
