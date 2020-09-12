@extends("layouts.home_template")

@section("title")
  My Games
@endsection

@section("head")
<link rel="stylesheet" type="text/css" href="/css/fancy_check_box.css">
@endsection

@section("css")

<style>

.container{
  padding: 10px;
}

.game_heading{
  text-align: center;
  font-family: "Arial";
  font-size: 24pt;
}

.game{
  display: grid;
  grid-template-columns: 20% 80%;
}

.buttons{
  text-align: right;
}


</style>

@endsection

@section("javascript")

<script>

$(".edit").on("click", function(){
  $("#edit_game_id").val($(this).data("id"));
  $("#edit_game_name").html(($(this).data("name")));
  $("#cumulative_scoring").prop("checked", "");
  if($(this).data("cumulative_scoring") == 1){
    //ASSERT: Not using cumulative scoring
    $("#cumulative_scoring").prop("checked", "checked");
  }
});

$(".delete").on("click", function(){
  $("#delete_game_id").val($(this).data("id"));
  $("#delete_game_name").html(($(this).data("name")));
});

</script>

@endsection

@section("content")

<div class="container">
  <div class="game_heading">Games I Own</div>

  <ul class="list-group">
    @foreach ($games_owned as $game_owned)
      <li class="list-group-item game">
        {{$game_owned->name}}
        <div class="buttons">
          <a href="{{action("Big2Controller@game", ["id" => $game_owned->id])}}" class="btn btn-success play"><i class="fas fa-play"></i> Play</a>
          <button class="btn btn-dark view"><i class="fas fa-eye"></i> View</button>
          <button class="btn btn-primary edit" data-id="{{$game_owned->id}}" data-name="{{$game_owned->name}}" data-cumulative_scoring="{{$game_owned->cumulative_scoring}}" data-toggle="modal" data-target="#edit_game"><i class="fas fa-pencil-alt"></i> Edit</button>
          <button class="btn btn-danger delete" data-id="{{$game_owned->id}}" data-name="{{$game_owned->name}}" data-toggle="modal" data-target="#delete_game"><i class="fas fa-trash-alt"></i> Delete</button>
        </div>
      </li>
    @endforeach
  </ul>

  <div class="game_heading">Games I'm In</div>

  <ul class="list-group">
    @foreach ($games_in as $game_in)
      <li class="list-group-item game">
        {{$game_in->name}}
        <div class="buttons">
          <a href="{{action("Big2Controller@game", ["id" => $game_in->id])}}" class="btn btn-success play"><i class="fas fa-play"></i> Play</a>
        </div>
      </li>
    @endforeach
  </ul>


</div>

@include("partials.edit_game_modal")
@include("partials.delete_game_modal");

@endsection
