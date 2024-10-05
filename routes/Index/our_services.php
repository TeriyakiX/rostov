<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\OurServiceController;

Route::prefix('services')->name('services.')->group(function () {
    Route::get('/{slug}', [OurServiceController::class, 'show'])->name('show');
});
