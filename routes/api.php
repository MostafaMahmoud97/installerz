<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\User\AuthController;
use \App\Http\Controllers\User\UserController;
use \App\Http\Controllers\User\SocialMediaController;
use \App\Http\Controllers\User\HomePageController;
use \App\Http\Controllers\User\StandOutSectionController;
use \App\Http\Controllers\User\FactsSectionController;
use \App\Http\Controllers\User\EcologicalWaySectionController;
use \App\Http\Controllers\User\OurTeamController;
use \App\Http\Controllers\User\AboutMeController;
use \App\Http\Controllers\User\LicenseController;
use \App\Http\Controllers\User\ContactUsController;
use \App\Http\Controllers\User\ProjectPageController;
use \App\Http\Controllers\User\ProjectController;
use \App\Http\Controllers\User\JobController;
use \App\Http\Controllers\User\PublishRequestController;

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

    Route::post("forgot-password",[AuthController::class,"forgot_password"]);
    Route::get("callback-reset-password",[AuthController::class,"callback_reset_password"]);
    Route::post("reset-password",[AuthController::class,"reset_password"]);
});


Route::group(["prefix" => "user","middleware" => "auth:api"],function (){
    Route::get("show",[UserController::class,"show"]);
    Route::put("update",[UserController::class,"update"]);
    Route::put("change-password",[UserController::class,"change_password"]);
});

Route::group(["prefix" => "social-media","middleware" => "auth:api"],function (){
    Route::get("get-icons",[SocialMediaController::class,"get_media_icons"]);
    Route::get("/",[SocialMediaController::class,"index"]);
    Route::post("store",[SocialMediaController::class,"store"]);
    Route::put("update/{id}",[SocialMediaController::class,"update"]);
    Route::delete("delete/{id}",[SocialMediaController::class,"destroy"]);
});

Route::group(["prefix" => "home-page","middleware" => "auth:api"],function (){
    Route::get("show",[HomePageController::class,"showHomePage"]);
    Route::post("store",[HomePageController::class,"store"]);
    Route::put("update",[HomePageController::class,"update"]);
    Route::group(["prefix" => "stand-out-section"],function (){
        Route::get("/",[StandOutSectionController::class,"index"]);
        Route::post("store",[StandOutSectionController::class,"store"]);
        Route::get("show/{id}",[StandOutSectionController::class,"show"]);
        Route::put("update/{id}",[StandOutSectionController::class,"update"]);
        Route::delete("delete/{id}",[StandOutSectionController::class,"destroy"]);
    });
    Route::group(["prefix" => "facts-section"],function (){
        Route::get("/",[FactsSectionController::class,"index"]);
        Route::post("store",[FactsSectionController::class,"store"]);
        Route::get("show/{id}",[FactsSectionController::class,"show"]);
        Route::put("update/{id}",[FactsSectionController::class,"update"]);
        Route::delete("delete/{id}",[FactsSectionController::class,"destroy"]);
    });
    Route::group(["prefix" => "ecological-section"],function (){
        Route::get("/",[EcologicalWaySectionController::class,"index"]);
        Route::post("store",[EcologicalWaySectionController::class,"store"]);
        Route::get("show/{id}",[EcologicalWaySectionController::class,"show"]);
        Route::put("update/{id}",[EcologicalWaySectionController::class,"update"]);
        Route::delete("delete/{id}",[EcologicalWaySectionController::class,"destroy"]);
    });
});

Route::group(["prefix" => "our-team","middleware" => "auth:api"],function (){
    Route::get("/",[OurTeamController::class,"index"]);
    Route::post("store",[OurTeamController::class,"store"]);
    Route::get("show/{id}",[OurTeamController::class,"show"]);
    Route::put("update/{id}",[OurTeamController::class,"update"]);
    Route::delete("delete/{id}",[OurTeamController::class,"destroy"]);
});

Route::group(["prefix" => "about-me","middleware" => "auth:api"],function (){
    Route::get("show",[AboutMeController::class,"index"]);
    Route::post("store",[AboutMeController::class,"store"]);
    Route::post("store-info-about-me",[AboutMeController::class,"store_info_about_me"]);
    Route::post("store-sub-info-about-me",[AboutMeController::class,"store_sub_info_about_me"]);
    Route::post("store",[AboutMeController::class,"store"]);
    Route::put("update-about-me",[AboutMeController::class,"update_about_me"]);
    Route::put("update-info/{id}",[AboutMeController::class,"update_info_about_me"]);
    Route::put("update-sub-info/{id}",[AboutMeController::class,"update_sub_info_about_me"]);
    Route::delete("delete-info/{id}",[AboutMeController::class,"destroy_info_about_me"]);
    Route::delete("delete-sub-info/{id}",[AboutMeController::class,"destroy_sub_info_about_me"]);
});


Route::group(["prefix" => "license","middleware" => "auth:api"],function (){
    Route::get("show",[LicenseController::class,"show"]);
    Route::post("store",[LicenseController::class,"store"]);
    Route::put("update",[LicenseController::class,"update"]);
});


Route::group(["prefix" => "contact-us","middleware" => "auth:api"],function (){
    Route::get("index",[ContactUsController::class,"index"]);
});


Route::group(["prefix" => "project-page","middleware" => "auth:api"],function (){
    Route::get("show",[ProjectPageController::class,"show"]);
    Route::post("store",[ProjectPageController::class,"store"]);
    Route::put("update",[ProjectPageController::class,"update"]);
});

Route::group(["prefix" => "project","middleware" => "auth:api"],function (){
    Route::get("index",[ProjectController::class,"index"]);
    Route::post("store",[ProjectController::class,"store"]);
    Route::post("store-gallery",[ProjectController::class,"store_gallery"]);
    Route::get("show/{id}",[ProjectController::class,"show"]);
    Route::put("update/{id}",[ProjectController::class,"update"]);
    Route::delete("delete/{id}",[ProjectController::class,"destroy"]);
    Route::delete("delete-gallery",[ProjectController::class,"destroy_gallery"]);
});


Route::group(["prefix" => "jobs","middleware" => "auth:api"],function (){
    Route::get("/",[JobController::class,"index"]);
    Route::get("show/{id}",[JobController::class,"show"]);
});

Route::group(["prefix" => "publish-request","middleware" => "auth:api"],function (){
    Route::get("/",[PublishRequestController::class,"index"]);
    Route::post("send",[PublishRequestController::class,"sendPublishRequest"]);
});
