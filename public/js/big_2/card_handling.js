//Deal all player's cards
$("#deal").on("click", function(){

  curr_turn = -1;
  $(".current_turn").removeClass("current_turn");

    $.ajax({
      type:"POST",
      url:"/big_2/deal",
      data:{_token: $("#csrf").html()},
    });
});

//PRE: deck is an array of ints from 1 to 52 representing a deck of cards
//POST: sets the players hands to 13 cards from teh deck
function set_hand(deck){
  my_card_count = 13;
  var my_hand = [];
  var player_number = my_id;

  for(var i = (((player_number - 1) * 13)); i < (13 + ((player_number - 1) * 13)); i++){
    my_hand.push(deck[i]);
  }


  //FOR TESTING
  // my_hand = [5,9,13,17,21,52,6,10,14,18,22]; straight test
  // my_hand = [6,7,8,18,19,52,14,15,16,25,26]; full house test
  // my_hand = [5,6,7,8,38,52,17,18,19,20,49]; four of a kind test
  // my_hand = [17,29,33,37,41,52,10,30,34,38,42]; flush check
  // my_hand = [18,22,26,30,34,52,20,24,28,32,36];
  if(my_id == 2){
    my_hand = [1];
    my_card_count = 1;
  }


  var slots = ["#slot1", "#slot2", "#slot3", "#slot4", "#slot5", "#slot6", "#slot7", "#slot8", "#slot9", "#slot10", "#slot11", "#slot12", "#slot13"];

  display_cards(my_hand, slots);
}

//PRE: hand is an array of integer between 1 and 52 of length between 1 and 13
//     slots is an array of strings representing the slots the cards should go in. Its length should match hand
//POST: rets the values of hand to the hand of the player
function display_cards(hand, slots){

  hand.sort(function(a, b){return a - b});

  if(suit_sort){
    hand.sort(function(a, b){return get_card_suit(a) - get_card_suit(b)});
  }

  for(var i = 0; i < hand.length; i++){
    $(slots[i]).attr("src", "/cards/" + hand[i].toString() + ".png");
    $(slots[i]).attr("card", hand[i].toString());
    $(slots[i]).show();
  }

}

function set_played_cards(played_cards){
  played = played_cards;
  $(".played_cards").empty();
  for (var i = 0; i < played_cards.length; i++){
    $(".played_cards").append("<img draggable=\"false\" class=\"played_card\" src=\"/cards/" + played_cards[i].toString() + ".png\">");
  }
}

//Toggle hand sort
$("#toggle_sort").on("click", function(){
  suit_sort = !suit_sort;

  $(".card_selected").addClass("card");
  $(".card_selected").removeClass("card_selected");

  var hand = [];
  var slots = [];

  $(".card").map(function() {
    if(!$(this).hasClass("played")){
      hand.push(parseInt($(this).attr("card")));
      slots.push("#" + $(this).attr("id"));
    }
  });

  display_cards(hand, slots);

});

//plays selected cards
function play_cards(){

  if((curr_turn == my_id || (curr_turn == -1)) && ($(".card_selected").length > 0)) {
    //ASSERT: can play cards

    //get value of cards played and hide played cards
    var cards_played = [];

    //get all cards selected
    $(".card_selected").map(function() {
      cards_played.push($(this).attr("card"));
    });
    if(validate_play(cards_played)){
      //ASSERT: cards_played is a valid play
      $(".card_selected").map(function() {
        $(this).hide();
        $(this).addClass("card");
        $(this).addClass("played");
        $(this).removeClass("card_selected");
      });

      my_card_count -= cards_played.length;

      $.ajax({
        type:"POST",
        url:"/big_2/play",
        data:{_token: $("#csrf").html(), cards_played: cards_played, current_player: my_id, game_id: game_id},

      });
      //change backgroun color back
      reset_turn_notifyer();
    }
  }
}
