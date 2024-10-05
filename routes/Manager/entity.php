<?php

use App\Http\Controllers\Manager\ManagerEntityController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\EntityController;

Route::prefix('entity')->name('entity.')->group(function () {
    Route::get('/{entity}/create', [ManagerEntityController::class, 'create'])->name('create');
    Route::post('/{entity}/create', [ManagerEntityController::class, 'store'])->name('store');
    Route::post('/{entity}/delete/{id}', [ManagerEntityController::class, 'delete'])->name('delete');

    Route::get('/{entity}/{id}', [ManagerEntityController::class, 'show'])->name('show');
    Route::post('/{entity}/{id}', [ManagerEntityController::class, 'update'])->name('update');

    Route::get('/{entity}', [ManagerEntityController::class, 'index'])->name('index');

    Route::post('/photoUpload', [ManagerEntityController::class, 'photoUpload'])->name('photoUpload');

    Route::post('/deleteSummernotePhoto', [ManagerEntityController::class, 'deleteSummernotePhoto'])->name('deleteSummernotePhoto');

    Route::post('/photo/{id}/delete', [ManagerEntityController::class, 'photoDelete'])->name('photoDelete');

    Route::post('/file/{id}/delete', [ManagerEntityController::class, 'fileDelete'])->name('fileDelete');

    Route::post('/attribute/{id}/getOptions', [ManagerEntityController::class, 'getAttributeOptions'])->name('getAttributeOptions');
    Route::post('/multiselectTags', [ManagerEntityController::class, 'multiselectTags'])->name('multiselectItems');
    Route::post('/multiselectItems', [ManagerEntityController::class, 'multiselectItems'])->name('multiselectItems');
    Route::post('/check-all-products', [ManagerEntityController::class, 'checkAllProducts']);
});
