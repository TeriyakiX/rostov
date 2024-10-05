<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Client\DashboardController;

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/', [DashboardController::class, 'update'])->name('update');
    Route::post('/pass', [DashboardController::class, 'passupdate'])->name('passupdate');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
});
