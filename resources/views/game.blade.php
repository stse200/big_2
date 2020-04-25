@extends("layouts.template")

@section("javascript")
<script src="{{asset('js/app.js')}}"></script>
<script>
  Echo.channel('table').listen('DealCards', (e) => {set_hand(e.deck);$(".num_cards").html(13);
  });
  Echo.channel('table').listen('PlayCards', (e) => {
    set_played_cards(e.cards_played);
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
    var last_player = $("#p_name_" + e.player_number.toString()).html();
    if (last_player == null){
      $(".played_notification").html("You passed:");
    }
    else{
      $(".played_notification").html(last_player + " passed:");
    }
  });

</script>


<script>



for(var i = 1; i < 14; i++){
  $(".hand").append("<img draggable=\"false\" id=\"slot" + i.toString() + "\" class=\"card\">");
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
  bottom: 60px;
  text-align: center;
  width: 99%;
}

#play{
  position: absolute;
  bottom: 0px;
  width: 50%;
  left: 0px;
  background-color: #2dbf17;
  height: 50px;
  font-size: 20pt;
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
  width: 98%;
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
  left: 50%;
  text-align: center;
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
    @if($player_number == 1)
      <div class="right_player" id="p_2">
        <div id="p_name_2">Waiting for player...</div>
        <div class="num_cards" id="p_cards_2"></div>
      </div>
      <div class="top_player" id="p_3">
        <div id="p_name_3">Waiting for player...</div>
        <div class="num_cards" id="p_cards_3"></div>
      </div>
      <div class="left_player" id="p_4">
        <div id="p_name_4">Waiting for player...</div>
        <div class="num_cards" id="p_cards_4"></div>
      </div>
    @elseif ($player_number == 2)
      <div class="right_player" id="p_3">
        <div id="p_name_3">Waiting for player...</div>
        <div class="num_cards" id="p_cards_3"></div>
      </div>
      <div class="top_player" id="p_4">
        <div id="p_name_4">Waiting for player...</div>
        <div class="num_cards" id="p_cards_4"></div>
      </div>
      <div class="left_player" id="p_1">
        <div id="p_name_1">Waiting for player...</div>
        <div class="num_cards" id="p_cards_1"></div>
      </div>
    @elseif ($player_number == 3)
      <div class="right_player" id="p_4">
        <div id="p_name_4">Waiting for player...</div>
        <div class="num_cards" id="p_cards_4"></div>
      </div>
      <div class="top_player" id="p_1">
        <div id="p_name_1">Waiting for player...</div>
        <div class="num_cards" id="p_cards_1"></div>
      </div>
      <div class="left_player" id="p_2">
        <div id="p_name_2">Waiting for player...</div>
        <div class="num_cards" id="p_cards_2"></div>
      </div>
    @elseif ($player_number == 4)
      <div class="right_player" id="p_1">
        <div id="p_name_1">Waiting for player...</div>
        <div class="num_cards" id="p_cards_1"></div>
      </div>
      <div class="top_player" id="p_2">
        <div id="p_name_2">Waiting for player...</div>
        <div class="num_cards" id="p_cards_2"></div>
      </div>
      <div class="left_player" id="p_3">
        <div id="p_name_3">Waiting for player...</div>
        <div class="num_cards" id="p_cards_3"></div>
      </div>
    @endif
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
