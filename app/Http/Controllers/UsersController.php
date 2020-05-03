<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Users;


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
    return view("my_games");
  }

  public function profile(){
    return view("profile");
}


}
