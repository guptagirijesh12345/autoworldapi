<?php

use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\api\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('userSignup',[UserController::class,'userSignup']);
Route::post('userLogin',[UserController::class,'userLogin']);
Route::post('social_login',[UserController::class,'social_login']);
Route::get('getcountry',[UserController::class,'getcountry']);
Route::get('getstate',[UserController::class,'getstate']);
Route::get('getcity',[UserController::class,'getcity']);

Route::middleware('auth:api')->group(function(){

    Route::post('user_logout',[UserController::class,'user_logout']);
    Route::post('update_profile',[UserController::class,'update_profile']);
    Route::get('service_category',[ServiceController::class,'service_category']);
    Route::get('getservice',[ServiceController::class,'getservice']);
    Route::post('addportfolio',[PortfolioController::class,'addportfolio']);
    Route::get('getportfolio',[PortfolioController::class,'getportfolio']);
    Route::post('add_message',[ChatController::class,'add_message']);
    Route::get('message_list',[ChatController::class,'message_list']);
    route::post('user_block',[ChatController::class,'user_block']);
});

Route::get('getData',[ChatController::class,'getData']);