<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Users;
use App\Games;


class UsersController extends Controller
{

  //Shows home screen
  public function login(){

    return view("login");
  }

  public function process_login(Request $request){
    $credentials = $request->only("username", "password");
    if(Auth::attempt($credentials)){
      //ASSERT: Valid login
      return redirect("home");
    }
    else{
      return redirect("/");
    }
  }

  public function logout(){
    Auth::logout();
    return redirect("/");
  }

  public function register(){
    return view("register");

  }

  public function check_username(Request $request){
    $username_check = Users::where("username", $request->username)->first();

    $result = true;
    if($username_check != null){
      //ASSERT: username is taken
      $result = false;
    }
    return response()->json(array("is_valid" => $result));
  }

  public function find_username(Request $request){
    $username_check = Users::where("username", $request->username)->first();

    if($username_check == null){
      //ASSERT: username does not exist
      return response()->json(array("is_valid" => false));
    }
    return response()->json(array("is_valid" => true, "id" => $username_check->id));
  }

  public function process_register(Request $request){

    $new_user = new Users;
    $new_user->username = $request->input("new_username");
    $new_user->name = $request->input("new_name");
    $new_user->password = Hash::make($request->input("new_password"));

    $new_user->save();

    return redirect("/");
  }

  public function home(){
    return view("home");
  }

  public function new_game(){
    return view("new_game");
  }

  public function my_games(){
    $games_owned = Games::where("fkey_user_id", Auth::user()->id)->get();


    $games_in = Games::where("fkey_p1_id", Auth::user()->id)->orWhere("fkey_p2_id", Auth::user()->id)->orWhere("fkey_p3_id", Auth::user()->id)->orWhere("fkey_p4_id", Auth::user()->id)->get();

    $games_in = $games_in->where("fkey_user_id", "<>", Auth::user()->id);

    return view("my_games", compact("games_owned", "games_in"));
  }

  public function profile(){
    $data = Users::where("id", Auth::user()->id)->first();
    return view("profile", compact("data"));
  }

  public function change_password(Request $request){
    $user = Users::where("id", Auth::user()->id)->first();
    $user->password = Hash::make($request->input("new_password"));
    $user->save();

    return redirect("profile");
  }

  public function change_name(Request $request){
    $user = Users::where("id", Auth::user()->id)->first();
    $user->name = $request->input("new_name");
    $user->save();

    return redirect("profile");
  }


}
