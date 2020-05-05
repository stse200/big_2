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
init();

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

  <span style="display: none" id="csrf">{{ csrf_token() }}</span>

  @if($owner)
    <button id="deal">Deal</button>
    <button id="introduction">Introduce Everyone</button>
  @endif
  <input type="checkbox" id="toggle_sort">Sort by suit


  <a id="exit" style="position: absolute;right: 5px;" href="{{action("UsersController@home")}}">Exit</a>

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
@endsection
