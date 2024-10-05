<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'sort'])->name('home');
Route::post('/storeFeedback', [HomeController::class, 'storeFeedback'])->name('storeFeedback');
