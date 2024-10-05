<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\ProductController;
use App\Http\Controllers\PDFController;

Route::name('products.')->group(function () {
    Route::get('/category/{category}', [ProductController::class, 'category'])->name('category');
    Route::get('/categoryList/{category}', [ProductController::class, 'categoryList'])->name('categoryList');
    Route::get('/category/{category}/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/coatings/{coating}', [ProductController::class, 'coatingShow'])->name('coatingShow');
    Route::get('/search', [ProductController::class, 'search'])->name('search');

    Route::get('/favorites', [ProductController::class, 'favorites'])->name('favorites');
    Route::post('/addToFavorites', [ProductController::class, 'addToFavorites'])->name('addToFavorites');

    Route::get('/compare', [ProductController::class, 'compare'])->name('compare');
    Route::post('/addToCompare', [ProductController::class, 'addToCompare'])->name('addToCompare');
    Route::get('/compareFlush', [ProductController::class, 'compareFlush'])->name('compareFlush');
    Route::post('/deleteCompareCoating', [ProductController::class, 'deleteCompareCoating']);

    Route::get('/viewed', [ProductController::class, 'viewed'])->name('viewed');
});



