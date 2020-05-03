<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware("auth")->group(function(){
  Route::get("home", "UsersController@home");
  Route::get("my_games", "UsersController@my_games");
  Route::get("new_game", "UsersController@new_game");
  route::get("profile", "UsersController@profile");
});

Route::get("/", "UsersController@login")->name("login");
Route::get("register", "UsersController@register");
Route::post("process_register", "UsersController@process_register");
Route::post("check_username", "UsersController@check_username");
Route::post("process_login", "UsersController@process_login");

Route::get("logout", "UsersController@logout");


Route::prefix("big_2")->group(function(){
  Route::post("game", "Big2Controller@game");
  Route::post("deal", "Big2Controller@deal");
  Route::post("play", "Big2Controller@play");
  Route::post("introduce_myself", "Big2Controller@introduce_myself");
  Route::post("command_introduction", "Big2Controller@command_introduction");
  Route::post("pass", "Big2Controller@pass");

});
