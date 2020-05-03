$(document).ready(function () {
  function getStates() {
    $.ajax({
      type:'GET',
      url:'get_states.php'
    })
    .done(function(data) {
      var result = JSON.parse(data);
      var output = "";
      
      $.each(result, function (i, value) {
        output+= "<option value='" + value.id + "'>" + value.name + "</option>";
      });

      $("#user_state").append(output);
    });
  }

  function getCandidates() {
    $.ajax({
      type:'GET',
      url:'get_candidates.php'
    })
    .done(function(data) {
      var result = JSON.parse(data);
      
      $.each(result, function (i, value) {
        $("#candidate" + value.id).val(value.id);
        $("#candidate" + value.id).html("<img src='images/" + value.image + "' border='0' alt='" + value.name + "' width='160'><br><b style='color:#FFFFFF;'>" + value.name + "</b>");
      });
    });
  }

  function userVote() {
    $.ajax({
      type:'POST',
      url:'user_vote.php',
      data:{user_state:sessionStorage.getItem('user_state'), user_candidate:sessionStorage.getItem('user_candidate')}
    })
    .done(function(data) {
    });
  }

  function showResults() {
    $.ajax({
      type:'GET',
      url:'get_stats.php'
    })
    .done(function(data) {
      var result = JSON.parse(data);
      var output = "<h1 class='text-center'>National Results</h1>";
      
      $.each(result.national, function (i, value) {
        output+= "<div class='row' style='padding-bottom:20px;'>";
        output+= "<div class='col'>";
        output+= "<image src='images/" + value.image + "' border='0' width='80'> <b style='color:#FFFFFF;'>" + value.name + " " + value.total + "%</b><br>";
        output+= "<div class='progress'><div class='progress-bar' role='progressbar' style='width:" + value.total + "%' aria-valuenow='" + value.total + "' aria-valuemin='0' aria-valuemax='100'></div></div>";
        output+= "</div>";
        output+= "</div>";
      });

      output+= "<p>&nbsp;</p>";
      output+= "<h2 class='text-center'>States Results</h2>";

      $.each(result.states, function (i, value) {
        output+= "<div class='row' style='padding-bottom:20px;'>";
        output+= "<div class='col'>";
        output+= "<h4>" + value.state_name + "</h4>";

        $.each(value.results, function (j, value2) {        
          output+= "<div class='row' style='padding-bottom:10px;'>";
          output+= "<div class='col'>";
          output+= "<image src='images/" + value2.image + "' border='0' width='32'> <b style='color:#FFFFFF;'>" + value2.name + " " + value2.total + "%</b><br>";
          output+= "<div class='progress'><div class='progress-bar' role='progressbar' style='width:" + value2.total + "%' aria-valuenow='" + value2.total + "' aria-valuemin='0' aria-valuemax='100'></div></div>";
          output+= "</div>";
          output+= "</div>";
        });

        output+= "</div>";
        output+= "</div>";
      });

      $("#results").html(output);
    });
  }

  $("#user_state").change(function() {
    sessionStorage.setItem("user_state", $("#user_state").val());
    $("#button_next1").show();
  });

  $("button").click(function() {
    $("#candidate1").removeClass("btn-dark");
    $("#candidate2").removeClass("btn-dark");
    $("#candidate3").removeClass("btn-dark");
    sessionStorage.setItem("user_candidate", $(this).val());
    $(this).addClass("btn-dark");
    $("#button_next3").show();
  });

  $("#button_next1").click(function() {
    $("#step1").hide();
    $("#step2").show();
    $("#button_next2").hide();
  });

  $("#button_prev2").click(function() {
    $("#step2").hide();
    $("#step1").show();
  });

  $("#button_next2").click(function() {
    $("#step2").hide();
    $("#step3").show();
    $("#button_next3").hide();
  });

  $("#button_results").click(function() {
    $("#step2").hide();
    $("#results").show();
    showResults();
  });

  $("#button_prev3").click(function() {
    $("#step3").hide();
    $("#step2").show();
  });

  $("#button_next3").click(function() {
    $("#step3").hide();
    userVote();
    $("#results").show();
    showResults();
  });

  $("#vote_yes").click(function() {
    $("#vote_yes").removeClass("btn-success");
    $("#vote_yes").addClass("btn-dark");
    $("#vote_no").removeClass("btn-dark");
    $("#vote_no").addClass("btn-danger");
    $("#button_next2").show();
    getCandidates();
  });

  $("#vote_no").click(function() {
    $("#vote_no").removeClass("btn-danger");
    $("#vote_no").addClass("btn-dark");
    $("#vote_yes").removeClass("btn-dark");
    $("#vote_yes").addClass("btn-success");
    $("#button_results").show();
  });

  $("#button_next1").hide();
  $("#button_next2").hide();
  $("#button_results").hide();
  $("#button_next3").hide();
  $("#step2").hide();
  $("#step3").hide();
  $("#results").hide();
  getStates();
});