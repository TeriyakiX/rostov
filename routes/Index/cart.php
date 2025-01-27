<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\CartController;

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('/change', [CartController::class, 'change']);
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/do', [CartController::class, 'checkoutDo'])->name('checkout.do');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::get('/send_order/tomail',[CartController::class,'send_order_toMail'])->name('send_toMail');
    Route::get('print_order',[CartController::class, 'print_order'])->name('print_order');
    Route::post('pay',[CartController::class, 'pay'])->name('pay');

    Route::post('/deleteSelected', [CartController::class, 'deleteSelectedCart'])->name('cart.deleteSelected');
});
