@extends("layouts.game_template")

@section("javascript")
<script src="{{asset('js/app.js')}}"></script>
<script src="/js/big_2/listeners.js"></script>
<script src="/js/big_2/card_handling.js"></script>
<script src="/js/big_2/turn_handling.js"></script>
<script src="/js/big_2/play_validation.js"></script>

<script>
//global variables
var my_id = {{$my_id}};
var game_id = {{$game_id}};
var curr_turn = -1;
var played = [];
var passes = 0;
var suit_sort = false;
var my_card_count = 0;
var owner = {{$owner}}
init();

$("img").on("click", function(){
  if ($(this).hasClass("my_card")){
    $(this).removeClass("my_card");
    $(this).addClass("card_selected");
  }
  else{
    $(this).addClass("my_card");
    $(this).removeClass("card_selected");
  }
});

//PRE: none
//POST: returns an array of the current card cound of each player
function get_scores(){
  var scores = [];

  scores.push($("#p_cards_" + {{$players[0]["id"]}}).html());
  scores.push($("#p_cards_" + {{$players[1]["id"]}}).html());
  scores.push($("#p_cards_" + {{$players[2]["id"]}}).html());
  scores.push($("#p_cards_" + {{$players[3]["id"]}}).html());

  for(var i = 0; i < 4; i++){
    if(scores[i] == null){
      scores[i]= my_card_count;
    }
  }
  return scores;
}

</script>

@endsection

@section("head")
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" type="text/css" href="/css/big_2/big_2.css">
  <link rel="stylesheet" type="text/css" href="/css/big_2/slider_button.css">
@endsection

@section("content")
<span style="display: none" id="csrf">{{ csrf_token() }}</span>

<!--Top toolpar on screen-->
<div class="top_bar">
  @if($owner)
    <button id="deal" class="btn btn-success">Deal</button>
  @else
    <div></div>
  @endif
  <div  id="switch_box">
    <label class="switch">
      <input type="checkbox">
      <span id="toggle_sort" class="slider round"></span>
    </label>
  </div>
  <span id="sort_label">Sort by Suit</span>
  <button class="btn btn-primary" id="show_scorecard">Scorecard</button>
  <a id="exit" class="btn btn-danger" href="{{action("UsersController@home")}}">Exit</a>
</div>

<!--Area showing info for other players-->
<div id="other_players">
  <div class="player player_box_{{$players[1]["id"]}}" id="left_player">
    <div class="p_name" id="p_name_{{$players[1]["id"]}}">{{$players[1]["name"]}}</div>
    <div class="num_cards" id="p_cards_{{$players[1]["id"]}}">-</div>
    <div id="p_pass_{{$players[1]["id"]}}" class="pass">Passed</div>
  </div>
  <div class="player player_box_{{$players[2]["id"]}}" id="center_player">
    <div class="p_name" id="p_name_{{$players[2]["id"]}}">{{$players[2]["name"]}}</div>
    <div class="num_cards" id="p_cards_{{$players[2]["id"]}}">-</div>
    <div id="p_pass_{{$players[2]["id"]}}" class="pass">Passed</div>
  </div>
  <div class="player player_box_{{$players[3]["id"]}}" id="right_player">
    <div class="p_name" id="p_name_{{$players[3]["id"]}}">{{$players[3]["name"]}}</div>
    <div class="num_cards" id="p_cards_{{$players[3]["id"]}}">-</div>
    <div id="p_pass_{{$players[3]["id"]}}" class="pass">Passed</div>
  </div>
</div>

<!--Played cards-->
<div id="table_center">
  <div class="played_notification">You played:</div>
  <div class="played_cards">
    <img class="played_card" src="/cards/1.png">
    <img class="played_card" src="/cards/1.png">
    <img class="played_card" src="/cards/1.png">
    <img class="played_card" src="/cards/1.png">
    <img class="played_card" src="/cards/1.png">



  </div>
</div>

<!--My hand-->
<div id="my_area">
  <div class="hand">
    <!--Cards Here-->

  </div>
  <div id="action_buttons">
    <button id="play">Play</button>
    <button id="pass">Pass</button>
  </div>
</div>


<div style="display: none">



  <br><br>
  <div class="player_names">
    <div class="player right_player">
      <div class="p_name" id="p_name_{{$players[1]["id"]}}">{{$players[1]["name"]}}</div>
      <div class="num_cards" id="p_cards_{{$players[1]["id"]}}"></div>
      <div id="p_pass_{{$players[1]["id"]}}" class="pass">Passed</div>
    </div>
    <div class="player top_player">
      <div class="p_name" id="p_name_{{$players[2]["id"]}}">{{$players[2]["name"]}}</div>
      <div class="num_cards" id="p_cards_{{$players[2]["id"]}}"></div>
      <div id="p_pass_{{$players[2]["id"]}}" class="pass">Passed</div>
    </div>
    <div class="player left_player">
      <div class="p_name" id="p_name_{{$players[3]["id"]}}">{{$players[3]["name"]}}</div>
      <div class="num_cards" id="p_cards_{{$players[3]["id"]}}"></div>
      <div id="p_pass_{{$players[3]["id"]}}" class="pass">Passed</div>
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

</div>
@endsection
