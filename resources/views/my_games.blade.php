@extends("layouts.home_template")

@section("title")
  My Games
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

$(".play").on("click", function(){
  console.log($(this).parent().attr("game"));
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
        <div class="buttons" game="{{$game_owned->id}}">
          <button class="btn btn-success play"><i class="fas fa-play"></i> Play</button>
          <button class="btn btn-dark view"><i class="fas fa-eye"></i> View</button>
          <button class="btn btn-primary edit"><i class="fas fa-pencil-alt"></i> Edit</button>
          <button class="btn btn-danger delete"><i class="fas fa-trash-alt"></i> Delete</button>
        </div>
      </li>
    @endforeach
  </ul>

  <div class="game_heading">Games I'm In</div>

  <ul class="list-group">
    @foreach ($games_in as $game_in)
      <li class="list-group-item game">
        {{$game_in->name}}
        <div class="buttons" game="{{$game_in->id}}">
          <button class="btn btn-success play"><i class="fas fa-play"></i> Play</button>
        </div>
      </li>
    @endforeach
  </ul>


</div>

@endsection
