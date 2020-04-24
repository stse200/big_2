@extends("layouts.template")


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

#submit{
  margin-top: 25px;
  width: 15%;
  background-color: #22ab24;
  font-size: 14pt;
  cursor: pointer;
}

</style>
@endsection

@section("content")

<div class="title">
  Welcome to Dai Di!
</div>

<form method="POST" action={{action("GameController@game")}}>
  @csrf

  <div class="container">
    <span>Enter Game Key: <input type="password" name="game_key" required></span>
    <span>Enter Player Number: <input type="number" name="player_number" required></span>
    <input id="submit" type="submit" value="Enter Game">
  </div>
</form>

@endsection
