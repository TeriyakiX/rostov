<?php

use App\Http\Controllers\Index\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('documents')->name('documents.')->group(function () {
    Route::get('/{id}', [HomeController::class, 'documents'])->name('documents');
});

