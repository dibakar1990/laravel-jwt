<?php

use App\Http\Controllers\Api\Auth\JwtAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [JwtAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'],function () {
    Route::post('logout', [JWTAuthController::class,'logout']);
    Route::post('refresh', [JWTAuthController::class,'refresh']);
    Route::post('me', [JWTAuthController::class,'me']);
    Route::get('profile', [JWTAuthController::class,'profile']);

});