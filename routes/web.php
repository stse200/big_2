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



Route::get("/", "UsersController@login");
Route::get("register", "UsersController@register");
Route::post("process_register", "UsersController@process_register");
Route::post("check_username", "UsersController@check_username");
Route::post("process_login", "UsersController@process_login");
Route::get("home", "UsersController@home");
Route::get("logout", "UsersController@logout");


Route::post("game", "GameController@game");
Route::post("deal", "GameController@deal");
Route::post("play", "GameController@play");
Route::post("introduce_myself", "GameController@introduce_myself");
Route::post("command_introduction", "GameController@command_introduction");
Route::post("pass", "GameController@pass");
