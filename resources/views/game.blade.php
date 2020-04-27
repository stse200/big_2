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
  });
  Echo.channel('table').listen('PlayCards', (e) => {
    //set center cards to played cards
    set_played_cards(e.cards_played);
    hide_passes();
    reset_turn_notifyer();
    set_turn_notifyer(parseInt(e.player_number));

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

  });

</script>


<script>
init();

//PRE: just_passed is the player id the player who passed
//POST: displays "passed" under the appropriate player.
function show_pass(just_passed){

    $("#p_pass_" + just_passed).css("display", "grid");

}

//PRE: none
//POST: hides all "passed" notifications under player names
function hide_passes(){
  $(".pass").css("display", "none");
}

//PRE: just_played is an int from 1 to 4 representing the player number of
//     the player that just played
//POST: If this player is next, sets hand background color to green
function set_turn_notifyer(just_played){
  if(just_played == 4){
    just_played = 0;
  }
  if((just_played + 1) == $("#player_number").html()){
    //ASSERT: it is my turn
    console.log("my turn");
    $(".hand").css("background-color", "#139e06");
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
  $(".played_cards").empty();
  for (var i = 0; i < played_cards.length; i++){
    $(".played_cards").append("<img draggable=\"false\" class=\"played_card\" src=\"cards/" + played_cards[i].toString() + ".png\">");
  }
}




$("#play").on("click", function(){play_cards();});
document.body.onkeyup = function(e){
    if(e.keyCode == 32){
        play_cards();
    }
}

function play_cards(){
  if($(".card_selected").length > 0){
  //get value of cards played and hide played cards
    var cards_played = [];

    var all = $(".card_selected").map(function() {
      cards_played.push($(this).attr("card"));
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
  background-color: #2dbf17;
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
  background-color: #f0851a;
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
      <div id="p_name_{{$right_player}}">Waiting for player...</div>
      <div class="num_cards" id="p_cards_{{$right_player}}"></div>
      <div id="p_pass_{{$right_player}}" class="pass">Passed</div>
    </div>
    <div class="player top_player" id="p_{{$top_player}}">
      <div id="p_name_{{$top_player}}">Waiting for player...</div>
      <div class="num_cards" id="p_cards_{{$top_player}}"></div>
      <div id="p_pass_{{$top_player}}" class="pass">Passed</div>
    </div>
    <div class="player left_player" id="p_{{$left_player}}">
      <div id="p_name_{{$left_player}}">Waiting for player...</div>
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
