@extends("layouts.template")

@section("javascript")
<script src="{{asset('js/app.js')}}"></script>
<script>
  Echo.channel('table').listen('DealCards', (e) => {set_hand(e.deck);
  });
  Echo.channel('table').listen('PlayCards', (e) => {set_played_cards(e.cards_played);
  });
  Echo.channel('table').listen('IntroduceMyself', (e) => {$("#p_" + e.my_number.toString()).html(e.my_name);
  });
  Echo.channel('table').listen('CommandIntroduction', (e) => {introduce_myself();
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




$("#play").on("click", function(){

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
      data:{_token: '<?php echo csrf_token() ?>', played: cards_played},

    });


});


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


</script>

@endsection

@section("css")
<style>

.hand{
  position: absolute;
  bottom: 10px;
  text-align: center;
  width: 99%;
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

</style>
@endsection

@section("head")
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section("content")
  <div id="player_number" style="display: none">{{$player_number}}</div>

  <span>Welcome to big 2 {{$player_name}}!</span>
  <button id="play">Play</button>

  @if($is_admin)
    <button id="deal">Deal</button>
    <button id="introduction">Introduce Everyone</button>
  @endif


  <a href="{{action("GameController@home")}}">Exit</a>

  <br><br>
  <div class="player_names">
    @if($player_number == 1)
      <span class="left_player" id="p_4">4</span><div class="top_player" id="p_3">3</div><span class="right_player" id="p_2">2</span>
    @elseif ($player_number == 2)
      <span class="left_player" id="p_1">1</span><div class="top_player" id="p_4">4</div><span class="right_player" id="p_3">3</span>
    @elseif ($player_number == 3)
      <span class="left_player" id="p_2">2</span><div class="top_player" id="p_1">1</div><span class="right_player" id="p_4">4</span>
    @elseif ($player_number == 4)
      <span class="left_player" id="p_3">3</span><div class="top_player" id="p_2">2</div><span class="right_player" id="p_1">1</span>
    @endif
  </div>

  <div class="played_cards">

  </div>
  <div style="text-align:center">
    <div class="hand">
      <!--Cards Here-->
    </div>
  </div>
@endsection
