<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\BrandController;

Route::prefix('brands')->name('brands.')->group(function () {
    Route::get('/{id}', [BrandController::class, 'index'])->name('index');
});
