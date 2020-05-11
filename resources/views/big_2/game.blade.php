@extends("layouts.game_template")

@section("javascript")
<script src="{{asset('js/app.js')}}"></script>
<script src="/js/big_2/listeners.js"></script>
<script src="/js/big_2/card_handling.js"></script>
<script src="/js/big_2/turn_handling.js"></script>
<script src="/js/big_2/play_validation.js"></script>
<script src="/js/big_2/thinking.js"></script>


<script>
//global variables
var curr_deck = [];
var my_id = {{$my_id}};
var game_id = {{$game_id}};
var curr_turn = -1;
var played = [];
var passes = 0;
var suit_sort = false;
var my_card_count = 0;
var player_number = {{$player_number}};
@if ($owner)
  var owner = true;
@else
  var owner = false;
@endif
var first_hand = false;

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

//PRE: none
//POST: returns the player id who is holding the 3 of diamonds
function get_three_diamonds(){


  var index = curr_deck.indexOf(1);
  console.log("card " + index);
  index = Math.floor((index - 1) / 13);
  var players_temp = [{{$players_keys[0]}},{{$players_keys[1]}},{{$players_keys[2]}},{{$players_keys[3]}}];
  console.log("index " + index);
  console.log("diamonds " + players_temp[index]);
  return players_temp[index];
}

</script>

@endsection

@section("head")
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" type="text/css" href="/css/big_2/big_2.css">
  <link rel="stylesheet" type="text/css" href="/css/big_2/slider_button.css">
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet">
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
  <button class="btn btn-primary" data-toggle="modal" data-target="#scorecard" id="show_scorecard">Scorecard</button>
  <a id="exit" class="btn btn-danger" href="{{action("UsersController@home")}}">Exit</a>
</div>

<!--Area showing info for other players-->
<div id="other_players">
  <div class="player player_box_{{$players[3]["id"]}}" id="left_player">
    <div class="p_name" id="p_name_{{$players[3]["id"]}}">
      <span class="thinking" id="thinking_{{$players[3]["id"]}}">
        <i class="fas fa-hourglass-start thinking_1"></i>
        <i class="fas fa-hourglass-half thinking_2"></i>
        <i class="fas fa-hourglass-end thinking_3"></i>
      </span>
      {{$players[3]["name"]}}
    </div>
    <div class="num_cards" id="p_cards_{{$players[3]["id"]}}">-</div>
    <div id="p_pass_{{$players[3]["id"]}}" class="pass"><i class="far fa-hand-point-left"></i> Passed</div>
  </div>

  <div class="player player_box_{{$players[2]["id"]}}" id="center_player">
    <div class="p_name" id="p_name_{{$players[2]["id"]}}">
      <span class="thinking"  id="thinking_{{$players[2]["id"]}}">
        <i class="fas fa-hourglass-start thinking_1"></i>
        <i class="fas fa-hourglass-half thinking_2"></i>
        <i class="fas fa-hourglass-end thinking_3"></i>
      </span>
      {{$players[2]["name"]}}
    </div>
    <div class="num_cards" id="p_cards_{{$players[2]["id"]}}">-</div>
    <div id="p_pass_{{$players[2]["id"]}}" class="pass"><i class="far fa-hand-point-left"></i> Passed</div>
  </div>


  <div class="player player_box_{{$players[1]["id"]}}" id="right_player">
    <div class="p_name" id="p_name_{{$players[1]["id"]}}">
      <span class="thinking"  id="thinking_{{$players[1]["id"]}}">
        <i class="fas fa-hourglass-start thinking_1"></i>
        <i class="fas fa-hourglass-half thinking_2"></i>
        <i class="fas fa-hourglass-end thinking_3"></i>
      </span>
      {{$players[1]["name"]}}
    </div>
    <div class="num_cards" id="p_cards_{{$players[1]["id"]}}">-</div>
    <div id="p_pass_{{$players[1]["id"]}}" class="pass"><i class="far fa-hand-point-left"></i> Passed</div>
  </div>
</div>



<!--Played cards-->
<div id="table_center">
  <div class="played_notification"></div>
  <div class="played_cards">
    <!--Cards played in center-->
  </div>
</div>

<!--My hand-->
<div id="my_area">
  <div class="hand">
    <!--Cards Here-->

  </div>
  <div id="action_buttons">
    <button id="play"> <i class="fas fa-arrow-circle-up"></i> Play</button>
    <button id="pass"><i class="fas fa-times"></i> Pass</button>
  </div>
</div>


<!--Scorecard modal-->
<div class="modal fade" id="scorecard" tabindex="-1" role="dialog" aria-labelledby="scorecard_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="change_name_label">Scorecard: {{$game_name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <div id="scorecard_body">
            <div class="scorecard_entry">
              @foreach ($players_keys as $id)
                @if($players[0]["id"] == $id)
                  <span>{{$players[0]["name"]}}</span>
                @elseif ($players[1]["id"] == $id)
                  <span>{{$players[1]["name"]}}</span>
                @elseif ($players[2]["id"] == $id)
                  <span>{{$players[2]["name"]}}</span>
                @elseif ($players[3]["id"] == $id)
                  <span>{{$players[3]["name"]}}</span>
                @endif
              @endforeach
          </div>

          <div id="scores">

          </div>




        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@endsection
