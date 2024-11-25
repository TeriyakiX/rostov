<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\EntityController;

Route::prefix('entity')->name('entity.')->group(function () {
    Route::get('/{entity}/create', [EntityController::class, 'create'])->name('create');
    Route::post('/{entity}/create', [EntityController::class, 'store'])->name('store');
    Route::post('/{entity}/delete/{id}', [EntityController::class, 'delete'])->name('delete');

    Route::get('/{entity}/{id}', [EntityController::class, 'show'])->name('show');
    Route::post('/{entity}/{id}', [EntityController::class, 'update'])->name('update');
    Route::post('{entity}/copy/{id}', [EntityController::class, 'copy'])->name('copy');

    Route::get('/{entity}', [EntityController::class, 'index'])->name('index');

    Route::post('/photoUpload', [EntityController::class, 'photoUpload'])->name('photoUpload');

    Route::post('/deleteSummernotePhoto', [EntityController::class, 'deleteSummernotePhoto'])->name('deleteSummernotePhoto');

    Route::post('/photo/{id}/delete', [EntityController::class, 'photoDelete'])->name('photoDelete');

    Route::post('/file/{id}/delete', [EntityController::class, 'fileDelete'])->name('fileDelete');

    Route::post('/attribute/{id}/getOptions', [EntityController::class, 'getAttributeOptions'])->name('getAttributeOptions');
    Route::post('/multiselectTags', [EntityController::class, 'multiselectTags'])->name('multiselectItems');
    Route::post('/multiselectItems', [EntityController::class, 'multiselectItems'])->name('multiselectItems');
    Route::post('/check-all-products', [EntityController::class, 'checkAllProducts']);
});
