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



Route::get("/", "GameController@home");
Route::post("game", "GameController@game");
Route::post("deal", "GameController@deal");
Route::post("play", "GameController@play");
Route::post("introduce_myself", "GameController@introduce_myself");
Route::post("command_introduction", "GameController@command_introduction");
Route::post("pass", "GameController@pass");
