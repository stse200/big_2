@extends("layouts.template")

@section("javascript")
<script src="{{asset('js/app.js')}}"></script>
<script>
  Echo.channel('table').listen('DealCards', (e) => {
    $(".played_cards").empty();
    set_hand(e.deck);
    $(".num_cards").html(13);
    reset_turn_notifyer();
    hide_passes();
    $(".played_cards").css("opacity", "1");
  });
  Echo.channel('table').listen('PlayCards', (e) => {
    //set center cards to played cards
    set_played_cards(e.cards_played);
    hide_passes();
    reset_turn_notifyer();
    set_turn_notifyer(parseInt(e.player_number));
    played = e.cards_played;

    //set played cards notification
    var curr_num_cards = $("#p_cards_" + e.player_number.toString()).html();
    $("#p_cards_" + e.player_number.toString()).html(curr_num_cards - e.cards_played.length);
    var last_player = $("#p_name_" + e.player_number.toString()).html();
    if (last_player == null){
      $(".played_notification").html("You played:");
    }
    else{
      $(".played_notification").html(last_player + " played:");
    }
  });
  Echo.channel('table').listen('IntroduceMyself', (e) => {$("#p_name_" + e.my_number.toString()).html(e.my_name);
  });
  Echo.channel('table').listen('CommandIntroduction', (e) => {introduce_myself();
  });
  Echo.channel('table').listen('Pass', (e) => {
    set_turn_notifyer(parseInt(e.player_number));
    show_pass(e.player_number.toString());
    check_new_round(parseInt(e.player_number));
  });

</script>


<script>
var played = [];
var passes = 0;
init();

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

//PRE: just_played is an int from 1 to 4 representing the player number of
//     the player that just played
//POST: If this player is next, sets hand background color to green
function set_turn_notifyer(just_played){
  $(".p_name").removeClass("current_turn");
  if(just_played == 4){
    just_played = 0;
  }
  if((just_played + 1) == $("#player_number").html()){
    //ASSERT: it is my turn
    $(".hand").css("background-color", "#139e06");
  }
  else{
    //ASSERT: Not my turn. showing whose turn it is
    $("#p_name_" + (just_played + 1)).addClass("current_turn");
  }
}

//PRE: none
//POST: sets this player's hand background color to white
function reset_turn_notifyer(){
  $(".hand").css("background-color", "#ffffff");
}

//PRE: none
//POST: initialized page
function init(){
  for(var i = 1; i < 14; i++){
    $(".hand").append("<img draggable=\"false\" id=\"slot" + i.toString() + "\" class=\"card\">");
  }
}


$("#deal").on("click", function(){


  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:"POST",
      url:"/deal",
      data:{_token: '<?php echo csrf_token() ?>'},

    });
});

//PRE: deck is an array of ints from 1 to 52 representing a deck of cards
//POST: sets the players hands to 13 cards from teh deck
function set_hand(deck){
  var my_hand = [];
  var player_number = $("#player_number").html();

  for(var i = (((player_number - 1) * 13)); i < (13 + ((player_number - 1) * 13)); i++){
    my_hand.push(deck[i]);
  }

  my_hand.sort(function(a, b){return a - b});


  for(var i = 1; i < 14; i++){
    $("#slot" + i.toString()).attr("src", "cards/" + my_hand[i - 1].toString() + ".png");
    $("#slot" + i.toString()).attr("card", my_hand[i - 1].toString());
    $("#slot" + i.toString()).show();
  }
}


$("img").on("click", function(){
  if ($(this).hasClass("card")){
    $(this).removeClass("card");
    $(this).addClass("card_selected");
  }
  else{
    $(this).addClass("card");
    $(this).removeClass("card_selected");
  }
});


function set_played_cards(played_cards){
  played = played_cards;
  $(".played_cards").empty();
  for (var i = 0; i < played_cards.length; i++){
    $(".played_cards").append("<img draggable=\"false\" class=\"played_card\" src=\"cards/" + played_cards[i].toString() + ".png\">");
  }
}

//play cards when click button or spacebar
$("#play").on("click", function(){play_cards();});
document.body.onkeyup = function(e){
    if(e.keyCode == 32){
        play_cards();
    }
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid single that can be played, false otherwise
function validate_single(cards_played){
  return ((played.length == 0) || (cards_played[0] > played[0]));
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid pair that can be played, false otherwise
function validate_pair(cards_played){
  valid_pair = (get_card_number(cards_played[0]) == get_card_number(cards_played[1]));

  return ((valid_pair) && ((played.length == 0) || (cards_played[1] > played[1])));
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid three of a kind that can be played, false otherwise
function validate_three(cards_played){
  valid_three = ((get_card_number(cards_played[0]) == get_card_number(cards_played[1])) &&
                 (get_card_number(cards_played[0]) == get_card_number(cards_played[2])));

  return ((valid_three) && ((played.length == 0) || (cards_played[2] > played[2])));
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid five card that can be played, false otherwise
function validate_five(cards_played){
  var type = get_five_card_type(cards_played);
  console.log(type);

}

//PRE: card is a nint from 1 to 52 representing a card in a deck of cards
//POST: returns an int from 0 to 3 representing the suite of card.
//      0=diamonds, 1=clubs, 2=hearts, 3=spades
function get_card_suit(card){
  var result = ((card - 1) % 4);
  return result;
}

//PRE: card is a nint from 1 to 52 representing a card in a deck of cards
//POST: returns a number from 0 to 12 representing card's numerical value
function get_card_number(card){
  var result = Math.floor((card - 1) / 4);
  return result;
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns an int from -1 to 4 representing the five cards hand it is
//      -1=invalid, 0=straight, 1=fluish, 2=full house, 3=4 of a kind, 5=straight flush
function get_five_card_type(cards_played){
  var result = -1;

  var numbers = [];
  var suits = [];

  for(var i = 0; i < cards_played.length; i++){
    numbers.push(get_card_number(cards_played[i]));
    suits.push(get_card_suit(cards_played[i]));
  }


  //straight test
  is_straight = true;
  var previous = numbers[0];
  var curr_card = 1
  while((is_straight) && (curr_card < cards_played.length)){

    is_straight = ((previous + 1) == numbers[curr_card]);
    previous = numbers[curr_card];
    curr_card += 1;
  }

  //flush test
  var is_flush = suits.every( (val, i, arr) => val === arr[0] );

  //full house test
  if(((numbers[0] == numbers[1]) && (numbers[0] == numbers[2]) && (numbers[3] == numbers[4])) || ((numbers[4] == numbers[3]) && (numbers[4] == numbers[2]) && (numbers[1] == numbers[0]))){
    result = 2
  }


  //four of a kind test
  if(((numbers[0] == numbers[1]) && (numbers[0] == numbers[2]) && (numbers[0] == numbers[3])) || ((numbers[4] == numbers[3]) && (numbers[4] == numbers[2]) && (numbers[4] == numbers[1]))){
    result = 3;
  }

  if((is_straight) && (is_flush)){
    //ASSERT: is stright flush
    result = 4
  }
  else if(is_straight){
    //ASSERT: is straight
    result = 0;
  }
  else if(is_flush){
    //ASSERT: is flush
    result = 1;
  }
  return result;

}

function sort_number(a, b){
  return a - b;
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true if cards_played can be played with the current cards in the center
function validate_play(cards_played){
  //convert values to int and sort
  cards_played = cards_played.map(x=>+x);
  cards_played = cards_played.sort(sort_number);

  is_valid = true;

  if((played.length == 0) || (cards_played.length == played.length)){
    if(cards_played.length == 1){
      //ASSERT: single card played
      is_valid = validate_single(cards_played);
    }
    else if(cards_played.length == 2){
      //ASSERT: pair played
      is_valid = validate_pair(cards_played);
    }
    else if(cards_played.length == 3){
      //ASSERT: 3 of a kind played
      is_valid = validate_three(cards_played);
    }
    else if(cards_played.length == 5){
      //ASSERT: 5 card played
      is_valid = validate_five(cards_played);
    }
    else{
      //ASSERT: invalid number of cards played
      is_valid = false;
    }
  }
  else{
    is_valid = false;
  }

  return is_valid;
}

//plays selected cards
function play_cards(){
  if($(".card_selected").length > 0){
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
        $(this).removeClass("card_selected");
      });
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        type:"POST",
        url:"/play",
        data:{_token: '<?php echo csrf_token() ?>', player_number: $("#player_number").html(), played: cards_played},

      });
      //change backgroun color back
      reset_turn_notifyer();
    }
  }
}


function introduce_myself(){
  //ask for players
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:"POST",
      url:"/introduce_myself",
      data:{_token: '<?php echo csrf_token() ?>', my_number: {{$player_number}}, my_name: "{{$player_name}}"},

    });
}

$("#introduction").on("click", function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:"POST",
      url:"/command_introduction",
      data:{_token: '<?php echo csrf_token() ?>'},
    });
});

$("#pass").on("click", function(){
  $(".hand").css("background-color", "#a31414");

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    $.ajax({
      type:"POST",
      url:"/pass",
      data:{_token: '<?php echo csrf_token() ?>', player_number: $("#player_number").html()},
    });
});


</script>

@endsection

@section("css")
<style>

.hand{
  position: absolute;
  bottom: 50px;
  text-align: center;
  padding-top: 10px;
  padding-bottom: 10px;
  left: 0px;
}

#play{
  position: absolute;
  bottom: 0px;
  width: 50%;
  left: 0px;
  background-color: #139e06;
  height: 50px;
  font-size: 20pt;
  padding: 0px;
}

.card{
  cursor: pointer;
  width: 7.5%;
}

.played_card{
  width: 7.5%;
}

.played_cards{
  position: absolute;
  text-align: center;
  top: 25%;
  width: 97%;
  padding: 10px;
}

.card:hover{
  position: relative;
  top: -10px;
}

.card_selected{
  max-width: 100%;
  max-height: 100%;
  cursor: pointer;
  width: 7.5%;
  position: relative;
  top: -50px;
}



.left_player{
  position: absolute;
  top: 50%;
}

.right_player{
  position: absolute;
  top: 50%;
  right: 0px;
}

.top_player{
  position: absolute;
  text-align: center;
  left: 50%;
  margin-left: -50px;
}

.num_cards{
  text-align: center;
}

.played_notification{
  position: absolute;
  text-align: center;
  top: 20%;
  width: 98%;
}

#deal{
  background-color: #128c25;
  font-size: 14pt;
}

#introduction{
  background-color: #12418c;
  font-size: 14pt;
  color: #ffffff;
}

#exit{
  text-decoration: none;
  color: #ffffff;
  background-color: #d9182b;
  font-size: 14pt;
  padding: 3px;
}

button{
  border: none;
  text-decoration: none;
  outline: none;
  cursor: pointer;
}

#pass{
  position: absolute;
  bottom: 0px;
  width: 50%;
  right: 0px;
  background-color: #a31414;
  color: #ffffff;
  height: 50px;
  font-size: 20pt;
}

.player{
  width: auto;
  display: grid;
  grid-gap: 5px;
}

.pass{
  display: none;
  padding: 5px;
  color: #ffffff;
  background-color: #a31414;
  text-align: center;
}
.current_turn{
  background-color: #139e06;
}

</style>
@endsection

@section("head")
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section("content")
  <div id="player_number" style="display: none">{{$player_number}}</div>

  @if($is_admin)
    <button id="deal">Deal</button>
    <button id="introduction">Introduce Everyone</button>
  @endif


  <a id="exit" style="position: absolute;right: 5px;" href="{{action("GameController@home")}}">Exit</a>

  <br><br>
  <div class="player_names">
    <div class="player right_player" id="p_{{$right_player}}">
      <div class="p_name" id="p_name_{{$right_player}}">Waiting for player...</div>
      <div class="num_cards" id="p_cards_{{$right_player}}"></div>
      <div id="p_pass_{{$right_player}}" class="pass">Passed</div>
    </div>
    <div class="player top_player" id="p_{{$top_player}}">
      <div class="p_name" id="p_name_{{$top_player}}">Waiting for player...</div>
      <div class="num_cards" id="p_cards_{{$top_player}}"></div>
      <div id="p_pass_{{$top_player}}" class="pass">Passed</div>
    </div>
    <div class="player left_player" id="p_{{$left_player}}">
      <div class="p_name" id="p_name_{{$left_player}}">Waiting for player...</div>
      <div class="num_cards" id="p_cards_{{$left_player}}"></div>
      <div id="p_pass_{{$left_player}}" class="pass">Passed</div>
    </div>
  </div>

  <div class="played_notification"></div>
  <div class="played_cards">

  </div>

  <div style="text-align:center">
    <div class="hand">
      <!--Cards Here-->
    </div>
    <button id="play">Play</button>
    <button id="pass">Pass</button>
  </div>
@endsection
