<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Guest\ContactUsController;
use \App\Http\Controllers\Guest\JobControllrt;

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

Route::post("contact-us/send-message",[ContactUsController::class,"SendMessage"]);

Route::post("job/submit",[JobControllrt::class,"submit_job"]);
