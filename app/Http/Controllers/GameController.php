<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class GameController extends Controller
{

  //Shows home screen
  public function home(){

    return view("home", compact("test"));
  }
  //shows game view
  public function game(Request $request){
    $test += 1;
    $keys = ["Stephen" => "hero of trains", "Chiming" => "chairman", "Brandon" => "front row", "Chiyung" => "papa soy", "Link" => "hero of hyrule"];

    if(in_array($request->input("game_key"), $keys)){
      //ASSERT: valid key
      $player_name = array_keys($keys, $request->input("game_key"))[0];
      $player_number = $request->input("player_number");
      $is_admin = ($player_number == 1);
      return view("game", compact("player_name", "player_number", "is_admin"));
    }
    else{
      return redirect("home", compact("test"));
    }
  }

  //shuffles deck of cards
  public function deal(){
    $deck = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52];
    shuffle($deck);

    //broadcast deck to 3 non-admin players
    event(new \App\Events\DealCards($deck));

    return response()->json(array("deck" => $deck));
  }

  //aJax call to handle playing cards. Will proadcast cards played to other players
  public function play(Request $request){
    event(new \App\Events\PlayCards($request->input("played")));
  }

  public function introduce_myself(Request $request){
    event(new \App\Events\IntroduceMyself($request->input("my_number"), $request->input("my_name")));
  }

  public function respond_introduction(Request $request){
    event(new \App\Events\RespondIntroduction($request->input("my_number"), $request->input("my_name")));
  }

}
