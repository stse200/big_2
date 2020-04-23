@extends("layouts.template")

@section("javascript")
<script src="{{asset('js/app.js')}}"></script>
<script>
  Echo.channel('deal_cards').listen('DealCards', (e) => {set_hand(e.deck);
  });
  Echo.channel('play_cards').listen('PlayCards', (e) => {console.log(e.cards_played);
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

  for(var i = 1; i < 14; i++){
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

</style>
@endsection

@section("head")
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section("content")

    <span>Welcome to big 2 {{$player_name}}!</span>
    <button id="play">Play</button>
    <button id="deal">Deal</button>
    <a href="{{action("GameController@home")}}">Exit</a>

    <div style="text-align:center">
      <div class="hand">
        <!--Cards Here-->
      </div>
    </div>
@endsection
