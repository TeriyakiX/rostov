<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\GalleryController;

Route::prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/{slug}', [GalleryController::class, 'show'])->name('show');
});
