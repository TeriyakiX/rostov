<?php

use App\Http\Controllers\Index\BrandController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Index\PostController;
use Illuminate\Support\Facades\Mail;

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [PostController::class, 'category'])->name('category');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
    Route::get('/stati/{slug}',[PostController::class,'getReviewById'])->name('by_id');
    Route::get('/kalkulyatory/{slug}',[PostController::class,'getCalculator'])->name('kalkulyator');
    Route::get('/spravochnik-stroitelya/{word}',[PostController::class,'getWordInfo'])->name('word');
});
Route::post('/send/mail',[PostController::class,'sendMail'])->name('send_mail');
Route::post('/send/oneClickMail',[PostController::class,'sendOneClickMail'])->name('send_one_click_mail');
Route::post('/send/documentMail',[PostController::class,'sendDocumentMail'])->name('send_document_mail');
