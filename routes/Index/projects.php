<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\ProjectController;

Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProjectController::class, 'show'])->name('show');
});
