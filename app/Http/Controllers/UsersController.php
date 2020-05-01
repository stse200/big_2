<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UsersController extends Controller
{

  //Shows home screen
  public function login(){

    return view("login");
  }

  public function register(){
    return view("register");

  }

  public function check_username(Request $request){
    $result = true;
    if($request->input("username") == "stse200"){
      $result = false;
    }
    return response()->json(array("is_valid" => $result));
  }

  public function process_register(Request $request){
    echo $request->input("new_username");
    echo $request->input("new_name");
    echo $request->input("new_password");
  }

}
