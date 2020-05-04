$(document).ready(function () {
  $.ajax({
    type:'GET',
    url:'validate.php'
  })
  .done(function(data) {
    var result = JSON.parse(data);

    if (result.status == "error") {
      location.href = "install.html";
      return false;
    } else {
      $.getScript("js/functions.js", function() {
        return false;
      });
    }
  });
});