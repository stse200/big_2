@extends("layouts.home_template")

@section('title')
  Home
@endsection

@section("sidebar")
<a href="{{action("UsersController@new_game")}}"><i class="far fa-plus-square"></i> New game</a>
<a href="{{action("UsersController@my_games")}}"><i class="fas fa-list"></i> My Games</a>
<a href="{{action("UsersController@profile")}}"><i class="far fa-id-badge"></i> Profile</a>
@endsection

@section('content')
  home
@endsection
