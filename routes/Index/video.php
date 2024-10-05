<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\VideoYoutubeController;

Route::prefix('video')->name('video.')->group(function () {
    Route::get('/{id}', [VideoYoutubeController::class, 'index'])->name('index');
});
