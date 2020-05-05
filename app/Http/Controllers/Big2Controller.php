<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Scores;
use App\Games;


class Big2Controller extends Controller
{

  //shows game view
  public function game($id){

    $game = Games::where("id", $id)->with("p1_name")->with("p2_name")->with("p3_name")->with("p4_name")->first();
    $my_id = Auth::user()->id;
    $game_id = $game->id;
    $owner = $my_id == $game->fkey_user_id;

    $players = [];

    $curr_id = $my_id;
    for($i = 0; $i < 4; $i++){
      array_push($players, ["id" => $game["fkey_p" . strval($curr_id) . "_id"], "name" => $game["p" . strval($curr_id) . "_name"]["name"]]);
      $curr_id += 1;
      if($curr_id > 4){
        $curr_id = 1;
      }
    }

    return view("big_2/game", compact("my_id", "game_id", "players", "owner"));
  }

  //shuffles deck of cards
  public function deal(){
    $deck = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52];
    shuffle($deck);

    //broadcast deck to 3 non-admin players
    event(new \App\Events\DealCards($deck));

    return response()->json(array("deck" => $deck));
  }

  //PRE: $current_player is the id of the current player
  //     $game_id is the id of the game
  //POST: returns an int representing the id of the next player in the game
  //      that should go
  private function get_next_player($current_player, $game_id){
    $game = Games::where("id", $game_id)->first();
    $next_player = -1;

    if($current_player == $game->fkey_p1_id){
      $next_player = $game->fkey_p2_id;
    }
    else if($current_player == $game->fkey_p2_id){
      $next_player = $game->fkey_p3_id;
    }
    else if($current_player == $game->fkey_p3_id){
      $next_player = $game->fkey_p4_id;
    }
    else if($current_player == $game->fkey_p4_id){
      $next_player = $game->fkey_p1_id;
    }

    return $next_player;
  }

  //aJax call to handle playing cards. Will proadcast cards played to other players
  public function play(Request $request){
    //get next player
    event(new \App\Events\PlayCards($request->cards_played, $request->current_player, $this->get_next_player($request->current_player, $request->game_id)));
  }

  public function command_introduction(Request $request){
    event(new \App\Events\CommandIntroduction());
  }

  public function pass(Request $request){
    event(new \App\Events\Pass($request->current_player, $this->get_next_player($request->current_player, $request->game_id)));
  }

  public function create_new_game(Request $request){
    $new_game = new Games;

    $new_game->name = $request->game_name;
    $new_game->fkey_user_id = Auth::user()->id;

    $new_game->fkey_p1_id = $request->p1;
    $new_game->fkey_p2_id = $request->p2;
    $new_game->fkey_p3_id = $request->p3;
    $new_game->fkey_p4_id = $request->p4;


    $new_game->save();

    return redirect("home");
  }

  //PRE: scores and game id have been passed
  //POST: writes the scores to the
  public function record_score($request){
    $new_scores = new Scores;

    $new_scores->fkey_game_id = $request->game_id;
    $new_scores->p1_score = $request->p1_score;
    $new_scores->p2_score = $request->p2_score;
    $new_scores->p3_score = $request->p3_score;
    $new_scores->p4_score = $request->p4_score;

    $new_scores->save();
  }

}
