<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'guest'],function () {
    Route::match(['get', 'head'], 'login', [LoginController::class,'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class,'login'])->name('login.submit');

    Route::match(['get', 'head'], 'password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
    Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
    Route::match(['get', 'head'], 'password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');
});

Route::group(['middleware' => 'auth'],function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('logout', [LoginController::class,'logout'])->name('logout');
});