@extends("layouts.home_template")

@section("title")
  New Game
@endsection

@section("css")

<style>

.container{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 10px;
  padding: 20px;
}

input{
  font-size: 18pt;
    width: 100%;
    outline: none;
}

label{
  font-family: "Arial";
  font-size: 14pt;
}

label:after{
  content: "\a";
  white-space: pre;
}

.input_item_wide{
  grid-column-start: 1;
  grid-column-end: 3;
}

.fa-check{
  color: rgb(48,166,74);
  display: none;
}

.fa-times{
  color: rgb(218,56,73);
  display: none;
}

.error{
  grid-column-start: 1;
  grid-column-end: 3;
  color: rgb(218,56,73);
  text-align: center;
  font-family: "Arial";
  font-size: 14pt;
  display: none;
}

</style>

@endsection

@section("javascript")

<script>

$("#game_name").keyup(function(){
  $("#name_error").css("display", "none");
});

  $(".player").keyup(function(){
    $("#player_error").css("display", "none");

    var player = $(this).attr("id");

    if($(this).val() == ""){
      //ASSERT: input is empty
      $("#" + player + "_val").val("");
      $("#" + player + "_bad").css("display", "none");
      $("#" + player + "_good").css("display", "none");
    }
    else{

      //check username
      $.ajax({
        type:"POST",
        url:"/find_username",
        data:{_token: '<?php echo csrf_token() ?>', username: $(this).val()},
        success: function(data){
          console.log(data);
          if(data.is_valid){
            //ASSERT: exist
            $("#" + player + "_val").val(data.id);
            $("#" + player + "_bad").css("display", "none");
            $("#" + player + "_good").css("display", "inline");
          }
          else{
            //ASSERT: username does not exist
            $("#" + player + "_val").val("");
            $("#" + player + "_good").css("display", "none");
            $("#" + player + "_bad").css("display", "inline");
          }
        }

      });
    }
  });

  $("#submit_form").on("click", function(){
    if($("#game_name").val() == ""){
      //ASSERT: no game name
      $("#name_error").css("display", "inline");
    }
    else if($("#p1_val").val() == ""){
      //ASSERT: no p1 entered
      $("#player_error").css("display", "inline");
      $("#p_num_error").html(1);
    }
    else if($("#p2_val").val() == ""){
      //ASSERT: no p1 entered
      $("#player_error").css("display", "inline");
      $("#p_num_error").html(2);
    }
    else if($("#p3_val").val() == ""){
      //ASSERT: no p1 entered
      $("#player_error").css("display", "inline");
      $("#p_num_error").html(3);
    }
    else if($("#p4_val").val() == ""){
      //ASSERT: no p1 entered
      $("#player_error").css("display", "inline");
      $("#p_num_error").html(4);
    }
    else{
      //ASSERT: form is complete
      $("#new_game_form").submit();
    }

  });

</script>

@endsection

@section("content")

<form id="new_game_form" method="POST" action="{{action("Big2Controller@create_new_game")}}">
  @csrf
  <div class="container">
      <div class="input_item_wide"><label>Game Name:</label><input id="game_name" type="text" name="game_name" autocomplete="off" maxlength="25"></div>

      <div>
        <label>Player 1: <i id="p1_good" class="fas fa-check"></i><i id="p1_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p1" autocomplete="off">
        <input id="p1_val" type="hidden" name="p1">
      </div>
      <div>
        <label>Player 2: <i id="p2_good" class="fas fa-check"></i><i id="p2_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p2" autocomplete="off">
        <input id="p2_val" type="hidden" name="p2">
      </div>
      <div>
        <label>Player 3: <i id="p3_good" class="fas fa-check"></i><i id="p3_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p3" autocomplete="off">
        <input id="p3_val" type="hidden" name="p3">
      </div>
      <div>
        <label>Player 4: <i id="p4_good" class="fas fa-check"></i><i id="p4_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p4" autocomplete="off">
        <input id="p4_val" type="hidden" name="p4">
      </div>


    <a id="submit_form"><i class="far fa-sticky-note"></i> Create Game</a>

    <div id="name_error" class="error">
      Please enter a game name
    </div>

    <div id="player_error" class="error">
      Enter a valid username for player <span id="p_num_error">
    </div>

  </div>
</form>
@endsection
