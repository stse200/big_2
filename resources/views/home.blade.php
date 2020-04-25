@extends("layouts.template")


@section("javascript")

<script>

$(".player_number_option").on("click", function(){
  $(".player_number_option").removeClass("selected");
  $(this).addClass("selected");

  $("#player_number").val($(this).html());
});

$("#submit_form").on("click", function(){
  if($.trim($("#player_number").val()) != ""){
    $("#login_form").submit();
  }
});

</script>

@endsection

@section("css")
<style>

.title{
  font-size: 25pt;
  text-align: center;
  width: 98%;
  margin-top: 15%;
}

.container{
  display: grid;
  grid-gap: 10px;
  width: 98%;
  text-align: center;
  margin-top: 10px;
  justify-items: center;
}

#submit_form{
  margin-top: 25px;
  width: 15%;
  background-color: #22ab24;
  font-size: 14pt;
  cursor: pointer;
}

.player_number_select{
  display: grid;
  grid-template-columns: repeat(4, 1fr);
    grid-gap: 5px;
}

.player_number_option{
  background-color: #235191;
  padding: 10px;
  color: #ffffff;
  cursor: pointer;
  font-size: 20pt;
}

.player_number_option:hover{
  background-color: #8b33a3;
}

.selected{
  background-color: #8b33a3;
}

.game_key{
  outline: none;
  font-size: 18pt;
}

</style>
@endsection

@section("content")

<div class="title">
  Welcome to Dai Di!
</div>

<form id="login_form" method="POST" action={{action("GameController@game")}}>
  @csrf

  <div class="container">
    <span class="game_key">Enter Game Key: <input class="game_key" type="password" name="game_key" required></span>
    <input id="player_number" type="hidden" name="player_number">
    Select Player Number:
    <div class="player_number_select">
      <div class="player_number_option">
        1
      </div>
      <div class="player_number_option">
        2
      </div>
      <div class="player_number_option">
        3
      </div>
      <div class="player_number_option">
        4
      </div>
    </div>
    <button type="button" id="submit_form">Enter Game</button>
  </div>
</form>

@endsection
