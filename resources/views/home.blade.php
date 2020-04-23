@extends("layouts.template")


@section("content")

<form method="POST" action={{action("GameController@game")}}>

  @csrf
  Enter Game Key: <input type="password" name="game_key">
  <input type="submit">
</form>

@endsection
