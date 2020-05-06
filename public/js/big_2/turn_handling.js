//PRE: none
//POST: initialized page
function init(){
  //hand image holders
  for(var i = 1; i < 14; i++){
    $(".hand").append("<img draggable=\"false\" id=\"slot" + i.toString() + "\" class=\"my_card\">");
  }
}

//PRE: none
//POST: resets round attributes
function reset_round(){
  //reset played cards
  $(".played_cards").css("opacity", "1");
  $(".played_cards").empty();
  played = [];
  my_card_count = 0;

  //reset player notification
  $(".thinking").css("display", "none");
  passes = 0;
  $(".played").removeClass("played");
  $(".played_notification").html("");
  $(".num_cards").html(13);
  // $(".num_cards").html(1);
  curr_turn = -1;

  reset_turn_notifyer();
  hide_passes();
}

//PRE: none
//POST: sets this player's hand background color to white
function reset_turn_notifyer(){
  $("#action_buttons").css("opacity", ".2");
}

//PRE: next_player is an int representing the id of the next player
//POST: If this player is next, sets hand background color to green
function set_turn_notifyer(next_player){

  curr_turn = next_player
  $(".thinking").css("display", "none");
  if(curr_turn == my_id){
    //ASSERT: it is my turn
    $("#action_buttons").css("opacity", "1");
  }
  else{
    //ASSERT: Not my turn. showing whose turn it is
    $("#thinking_" + (curr_turn)).css("display", "inline-block");
  }

}

//PRE: just_played is an int representing the player id who just played
//POST: decreases player who just played's card count by number of cards played
function set_player_card_notification(just_played, cards_played){
  var curr_num_cards = $("#p_cards_" + just_played.toString()).html();
  $("#p_cards_" + just_played.toString()).html(curr_num_cards - cards_played.length);
}

//PRE: just_played is an int representing the player id who just played
//POST: sets text above played cards to indicate who played them
function set_cards_played_notification(just_played){
  var last_player = $("#p_name_" + just_played.toString()).html();
  if (last_player == null){
    $(".played_notification").html("You played:");
  }
  else{
    $(".played_notification").html(last_player + " played:");
  }
}

//PRE: just_passed is the player ID of the player who just passed
//POST: lightens center card is starting new round (all other players pass)
function check_new_round(just_passed){
  if(just_passed == 4){
    just_passed = 0;
  }
  if(passes == 3){
    //ASSERT: starting new round
    played = [];
    $(".played_cards").css("opacity", "0.5");
    passes = 0;
  }
}

//PRE: just_passed is the player id the player who passed
//POST: displays "passed" under the appropriate player.
function show_pass(just_passed){
    passes += 1;
    console.log("#p_pass_" + just_passed);
    $("#p_pass_" + just_passed).css("opacity", "1");

}

//PRE: none
//POST: hides all "passed" notifications under player names
//      puts center card at full opacity
function hide_passes(){
  $(".pass").css("opacity", ".2");
  $(".played_cards").css("opacity", "1");
  passes = 0;
}

//play cards when click button or spacebar
$("#play").on("click", function(){play_cards();});
document.body.onkeyup = function(e){
    if(e.keyCode == 32){
        play_cards();
    }
}

$("#pass").on("click", function(){
  if((curr_turn == my_id) && (played.length != 0) && ($(".card_selected").length == 0)){
    //ASSERT: can pass now

    $(".card_selected").addClass("card");
    $(".card_selected").removeClass("card_selected");
    $("#action_buttons").css("opacity", ".2");

    $.ajax({
      type:"POST",
      url:"/big_2/pass",
      data:{_token: $("#csrf").html(), current_player: my_id, game_id: game_id},
    });
  }
});

//PRE: none
//POST: if a player is out, shows notification on who is out. Writes scores to
//      DB if player is game owner
function check_out(){
  var end_round = false;

  var out_player = -1;

  var someone_out = false;
  $(".num_cards").each(function(){
    if(parseInt($(this).html()) == 0){
      out_player = $(this).attr("id").substring(8, $(this).attr("id").length);
      someone_out = true;
    }
  });
  //check if I am out
  if(my_card_count == 0){
    //ASSERT: I am out
    end_round = true;
    $(".played_notification").html("You went out!");
  }
  else if(someone_out){
    //ASSERT: somone who is not me is out
    end_round = true;
    $(".played_notification").html($("#p_name_" + out_player).html() + " went out!");
    curr_turn = -2;
  }

  if(end_round && owner){
    //ASSERT: Someone is out. Recording scores
    $("#action_buttons").css("opacity", ".2");
    $.ajax({
      type:"POST",
      url:"/big_2/record_score",
      data:{_token: $("#csrf").html(), game_id: game_id, scores: get_scores()},
    });
  }

  return end_round;
}



//PRE: none
//POST: returns the player id of the first player to go in the round
function get_first_player(){
  $.ajax({
    type:"POST",
    url:"/big_2/get_first_player",
    data:{_token: $("#csrf").html(), game_id: game_id},
    success: function(data){
      if(data.first_player == -1){
        //ASSERT: no previous games 3 of diamonds goes first
        curr_turn = get_three_diamonds();
        first_hand = true;
      }
      else{
        //ASSERT: found first player based off previous round
        curr_turn = data.first_player;
        first_hand = false;
      }
      if(curr_turn == my_id){
        //I go first
        console.log(curr_turn);
        $("#action_buttons").css("opacity", "1");
      }
      else{
        //ASSERT: I do not go first
        $("#thinking_" + (curr_turn)).css("display", "inline-block");
      }
    }

  });
}

//fill scores
$("#show_scorecard").on("click", function(){
  $.ajax({
    type:"POST",
    url:"/big_2/get_scores",
    data:{_token: $("#csrf").html(), game_id: game_id},
    success: function(data){
      $("#scores").empty();
      var html;
      var winner;
      var running_scores = [0,0,0,0];
      var curr_scores;
      for(var i = 0; i < data.scores.length; i++){
        curr_scores = [data.scores[i]["p1_score"], data.scores[i]["p2_score"], data.scores[i]["p3_score"],data.scores[i]["p4_score"]];
        winner = curr_scores.indexOf(0);
        html = "";
        html += "<div class=\"scorecard_entry\">";

        for(var j = 0; j < 4; j++){
          //show score on scorecard
          html += "<span>" + curr_scores[j] + "</span>";

          //subtract point
          running_scores[j] -= curr_scores[j];

          //add to winner
          running_scores[winner] += curr_scores[j];
        }
        html += "</div><hr>";

        html += "<div class=\"scorecard_entry\">";

        for(var j = 0; j < 4; j++){
          html += "<span>" + running_scores[j] + "</span>";
        }
        html += "</div>";
        $("#scores").append(html);


      }
    }
  });
});
