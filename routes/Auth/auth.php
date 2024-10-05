<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\LoginController;

Route::get('login', [LoginController::class, 'loginForm'])->name('loginForm');
Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'registerForm'])->name('registerForm');
Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('forgot', [\App\Http\Controllers\Auth\LoginController::class, 'forgotForm'])->name('forgotForm');
Route::post('forgot', [\App\Http\Controllers\Auth\LoginController::class, 'forgot'])->name('forgot');
Route::get('reset_password', [\App\Http\Controllers\Auth\LoginController::class, 'resetPassForm'])->name('resetPassForm');
Route::post('reset_password', [\App\Http\Controllers\Auth\LoginController::class, 'resetPass'])->name('resetPass');