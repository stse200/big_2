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

</style>

@endsection

@section("javascript")

<script>

  $(".player").keyup(function(){

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
    $("#new_game_form").submit();
  });

</script>

@endsection

@section("content")

<form id="new_game_form" method="POST" action="{{action("Big2Controller@create_new_game")}}">
  @csrf
  <div class="container">
      <div class="input_item_wide"><label>Game Name:</label><input type="text" name="game_name" autocomplete="off" required></div>

      <div>
        <label>Player 1: <i id="p1_good" class="fas fa-check"></i><i id="p1_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p1" required>
        <input id="p1_val" type="hidden" name="p1">
      </div>
      <div>
        <label>Player 2: <i id="p2_good" class="fas fa-check"></i><i id="p2_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p2" required>
        <input id="p2_val" type="hidden" name="p2">
      </div>
      <div>
        <label>Player 3: <i id="p3_good" class="fas fa-check"></i><i id="p3_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p3" required>
        <input id="p3_val" type="hidden" name="p3">
      </div>
      <div>
        <label>Player 4: <i id="p4_good" class="fas fa-check"></i><i id="p4_bad" class="fas fa-times"></i></label>
        <input class="player" type="text" id="p4" required>
        <input id="p4_val" type="hidden" name="p4">
      </div>


    <a id="submit_form"><i class="far fa-sticky-note"></i> Create Game</a>

  </div>
</form>
@endsection
