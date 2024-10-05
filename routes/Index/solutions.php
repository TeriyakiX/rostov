<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\TurnkeySolutionsController;

Route::prefix('solutions')->name('solutions.')->group(function () {
    Route::get('/{id}', [TurnkeySolutionsController::class, 'index'])->name('index');
});
