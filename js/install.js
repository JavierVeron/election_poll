$(document).ready(function () {
  $("#next").click(function() {
    $("#step1").hide();
    $("#step2").show();
  });

  $("#send").click(function() {
    if ($("#name").val() == "") {
      $("#name").addClass("is-invalid");
      $("#name").focus();
      return false;
    } else {
      $("#name").removeClass("is-invalid");
    }

    if ($("#user").val() == "") {
      $("#user").addClass("is-invalid");
      $("#user").focus();
      return false;
    } else {
      $("#user").removeClass("is-invalid");
    }

    if ($("#server").val() == "") {
      $("#server").addClass("is-invalid");
      $("#server").focus();
      return false;
    } else {
      $("#server").removeClass("is-invalid");
    }

    $.ajax({
      type:'POST',
      url:'install.php',
      data:{name:$("#name").val(), user:$("#user").val(), password:$("#password").val(), server:$("#server").val()}
    })
    .done(function(data) {
      var result = JSON.parse(data);
      var output = "";

      if (result.status == "ok") {
        output+= "<p class='alert alert-success text-center' role='alert'>Excellent! The installation has been successful!</p>";
        output+= "<p>&nbsp;</p>";
        output+= "<p class='text-center'><a href='index.html' class='btn btn-success'>Start!</a></p>";
      } else {
        output+= "<p class='alert alert-danger text-center' role='alert'>Error! Please verify the connection details of your database!</p>";
        output+= "<p>&nbsp;</p>";
        output+= "<p class='text-center'><a href='install.html' class='btn btn-danger'>Go Back!</a></p>";
      }
      
      $("#result").html(output);
    });

    $("#step2").hide();
    $("#step3").show();
  });

  $("#step2").hide();
  $("#step3").hide();
});