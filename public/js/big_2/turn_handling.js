//PRE: none
//POST: initialized page
function init(){
  //hand image holders
  for(var i = 1; i < 14; i++){
    $(".hand").append("<img draggable=\"false\" id=\"slot" + i.toString() + "\" class=\"card\">");
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
  $(".hand").css("background-color", "#ffffff");
}

//PRE: next_player is an int representing the id of the next player
//POST: If this player is next, sets hand background color to green
function set_turn_notifyer(next_player){

  curr_turn = next_player
  $(".p_name").removeClass("current_turn");
  if(curr_turn == my_id){
    //ASSERT: it is my turn
    $(".hand").css("background-color", "#139e06");
  }
  else{
    //ASSERT: Not my turn. showing whose turn it is
    $("#p_name_" + (curr_turn)).addClass("current_turn");
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
    $("#p_pass_" + just_passed).css("display", "grid");

}

//PRE: none
//POST: hides all "passed" notifications under player names
//      puts center card at full opacity
function hide_passes(){
  $(".pass").css("display", "none");
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
  if((curr_turn == my_id) && (played.length != 0)){
    //ASSERT: can pass now

    $(".card_selected").addClass("card");
    $(".card_selected").removeClass("card_selected");
    $(".hand").css("background-color", "#a31414");

    $.ajax({
      type:"POST",
      url:"/big_2/pass",
      data:{_token: $("#csrf").html(), current_player: my_id, game_id: game_id},
    });
  }
});

$("#test").on("click", function(){
  check_out();
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

    $.ajax({
      type:"POST",
      url:"/big_2/record_score",
      data:{_token: $("#csrf").html(), game_id: game_id, scores: get_scores()},
    });
  }

  return end_round;


}
