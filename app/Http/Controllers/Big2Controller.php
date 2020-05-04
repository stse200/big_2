<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Games;


class Big2Controller extends Controller
{

  //shows game view
  public function game(Request $request){
    //game keys and names
    $keys = ["Stephen" => "botw link", "Chiming" => "chairman", "Brandon" => "front row", "Chiyung" => "papa soy", "Link" => "hero of hyrule", "Ethan" => "grab fest"];

    //check for valid game key
    if(in_array($request->input("game_key"), $keys)){
      //ASSERT: valid key
      $player_name = array_keys($keys, $request->input("game_key"))[0];
      $player_number = $request->input("player_number");
      $is_admin = ($player_number == 1);

      //set other player positions
      if($player_number == 1){
        $right_player = 2;
        $top_player = 3;
        $left_player = 4;
      }
      elseif($player_number == 2) {
        $right_player = 3;
        $top_player = 4;
        $left_player = 1;
      }
      elseif($player_number == 3) {
        $right_player = 4;
        $top_player = 1;
        $left_player = 2;
      }
      else{
        $right_player = 1;
        $top_player = 2;
        $left_player = 3;
      }
      return view("game", compact("player_name", "player_number", "is_admin", "right_player", "top_player", "left_player"));
    }
    else{
      return redirect("/");
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
    event(new \App\Events\PlayCards($request->input("played"), $request->input("player_number")));
  }

  public function introduce_myself(Request $request){
    event(new \App\Events\IntroduceMyself($request->input("my_number"), $request->input("my_name")));
  }

  public function command_introduction(Request $request){
    event(new \App\Events\CommandIntroduction());
  }

  public function pass(Request $request){
    event(new \App\Events\Pass($request->input("player_number")));
  }

  public function create_new_game(Request $request){
    $new_game = new Games;

    $new_game->name = $request->game_name;
    $new_game->fkey_user_id = Auth::user()->id;

    $new_game->fkey_p1_id = $request->p1;
    $new_game->fkey_p2_id = $request->p2;
    $new_game->fkey_p3_id = $request->p3;
    $new_game->fkey_p4_id = $request->p4;

    $new_game->p1_online = false;
    $new_game->p2_online = false;
    $new_game->p3_online = false;
    $new_game->p4_online = false;

    $new_game->save();

    return redirect("home");
  }

}
