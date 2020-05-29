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

    $cumulative_scoring = $game->cumulative_scoring;

    $players_keys = [];
    $players = [];
    $game_name = $game->name;


    for($i = 1; $i < 5; $i++){
      array_push($players_keys, $game["fkey_p" . strval($i) . "_id"]);
    }
    // dd($players_keys);
    $curr_id = array_keys($players_keys, $my_id)[0] + 1;
    $player_number = $curr_id;
    for($i = 0; $i < 4; $i++){
      array_push($players, ["id" => $game["fkey_p" . strval($curr_id) . "_id"], "name" => $game["p" . strval($curr_id) . "_name"]["name"]]);
      $curr_id += 1;
      if($curr_id > 4){
        $curr_id = 1;
      }
    }


    return view("big_2/game", compact("my_id", "owner", "game_id", "players", "player_number", "players_keys", "game_name", "cumulative_scoring"));
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
  public function record_score(Request $request){

    $new_scores = new Scores;

    $new_scores->fkey_game_id = $request->game_id;

    for($i = 1; $i < 5; $i++){
      $new_scores["p" . strval($i) . "_score"] = $request->input("scores")[$i - 1];
    }

    $new_scores->save();
  }

  //PRE: game_id has been passed
  //POST: returns the player ID of the last player to win. If no score records
  //      are present for the game, -1 is returned
  public function get_first_player(Request $request){
    $last_score = Scores::where("fkey_game_id", $request->game_id)->orderBy("created_at", "desc")->first();

    $result = -1;

    if($last_score != null){
      //ASSERT: scores exist for game
      $last_winner = -1;
      if($last_score->p1_score == 0){
        $last_winner = 1;
      }
      else if($last_score->p2_score == 0){
        $last_winner = 2;
      }
      else if($last_score->p3_score == 0){
        $last_winner = 3;
      }
      else{
        $last_winner = 4;
      }

      $game = Games::where("id", $request->game_id)->first();
      $result = $game["fkey_p" . strval($last_winner) . "_id"];
    }
    return response()->json(array("first_player" => $result));
  }

  public function get_scores(Request $request){
    $scores = Scores::select("p1_score", "p2_score", "p3_score", "p4_score")->where("fkey_game_id", $request->game_id)->get()->toArray();

    return response()->json(array("scores" => $scores));

  }

}
