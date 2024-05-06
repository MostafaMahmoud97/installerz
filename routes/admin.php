<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\AuthController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\SocialMediaController;
use \App\Http\Controllers\Admin\PublishRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["prefix" => "auth"],function (){
    Route::post("login",[AuthController::class,"login"]);
});

Route::group(["prefix" => "users","middleware" => "auth:admin"],function (){
    Route::get("/",[UserController::class,"index"]);
    Route::post("store",[UserController::class,"store"]);
    Route::put("change-activation-status/{id}",[UserController::class,"change_activation_status"]);
    Route::put("change-publish-status/{id}",[UserController::class,"change_publish_status"]);
});

Route::group(["prefix" => "social-media","middleware" => "auth:admin"],function (){
    Route::get("/",[SocialMediaController::class,"index"]);
    Route::post("store",[SocialMediaController::class,"store"]);
    Route::get("show/{id}",[SocialMediaController::class,"show"]);
    Route::put("update/{id}",[SocialMediaController::class,"update"]);
    Route::delete("delete/{id}",[SocialMediaController::class,"destroy"]);
});


Route::group(["prefix" => "publish-request","middleware" => "auth:admin"],function (){
    Route::get("/",[PublishRequestController::class,"index"]);
    Route::put("change-status/{id}",[PublishRequestController::class,"changeRequestStatus"]);
});
