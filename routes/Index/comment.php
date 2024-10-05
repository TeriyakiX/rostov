<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index\CommentController;


Route::post('/comment/store', [CommentController::class, 'store'])->name('comment_store');

