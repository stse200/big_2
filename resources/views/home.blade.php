@extends("layouts.template")


@section("content")

<form method="POST" action={{action("GameController@game")}}>

  @csrf
  Enter Game Key: <input type="password" name="game_key">
  Enter player number: <input type="text" name="player_number">
  <input type="submit">
</form>

@endsection
