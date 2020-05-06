@extends("layouts.home_template")

@section('title')
  Home
@endsection

@section("sidebar")
<a href="{{action("UsersController@new_game")}}"><i class="far fa-plus-square"></i> New game</a>
<a href="{{action("UsersController@my_games")}}"><i class="fas fa-list"></i> My Games</a>
<a href="{{action("UsersController@profile")}}"><i class="far fa-id-badge"></i> Profile</a>
@endsection

@section("css")

<style>

.container{
  padding: 20px;
}

</style>

@endsection

@section('content')
<div class="container">
  Welcome to the Tse Casino. Current games available:
  <ul>
    <li>Dai Di</li>
  </ul>
</div>
@endsection
