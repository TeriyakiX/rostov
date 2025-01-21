<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\ProductController;
use App\Http\Controllers\PDFController;
use \App\Http\Controllers\Index\CartController;

Route::name('products.')->group(function () {
    Route::get('/category/{category}', [ProductController::class, 'category'])->name('category');
    Route::get('/categoryList/{category}', [ProductController::class, 'categoryList'])->name('categoryList');
    Route::get('/category/{category}/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/coatings/{coating}', [ProductController::class, 'coatingShow'])->name('coatingShow');
    Route::get('/search', [ProductController::class, 'search'])->name('search');

    Route::get('/favorites', [ProductController::class, 'favorites'])->name('favorites');
    Route::post('/addToFavorites', [ProductController::class, 'addToFavorites'])->name('addToFavorites');
    Route::get('/favorites/change', [ProductController::class, 'changeFavorite']);
    Route::post('/favorites/clear', [ProductController::class, 'clearFavorites'])->name('favorites.clear');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/favorites/deleteSelected', [ProductController::class, 'deleteSelectedFavorites'])->name('favorites.deleteSelected');
    Route::post('/moveFavoritesToCart', [ProductController::class, 'moveToCart'])->name('favorites.moveToCart');

    Route::get('/compare', [ProductController::class, 'compare'])->name('compare');
    Route::post('/addToCompare', [ProductController::class, 'addToCompare'])->name('addToCompare');
    Route::get('/compareFlush', [ProductController::class, 'compareFlush'])->name('compareFlush');
    Route::post('/deleteCompareCoating', [ProductController::class, 'deleteCompareCoating']);

    Route::get('/viewed', [ProductController::class, 'viewed'])->name('viewed');
});



