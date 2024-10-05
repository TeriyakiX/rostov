<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\ComparisonController;

Route::prefix('comparison')->name('comparison.')->group(function () {
    Route::get('/', [ComparisonController::class, 'index'])->name('index');
});
