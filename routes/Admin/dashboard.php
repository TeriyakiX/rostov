<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\DashboardController;

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::middleware('role:admin')->group(function (){
        Route::get('/excel', [DashboardController::class, 'excelShow'])->name('excel');
        Route::get('/excelDownload', [DashboardController::class, 'excelExport'])->name('excelDownload');
        Route::post('/excelImport', [DashboardController::class, 'excelImport'])->name('excelImport');
        Route::get('/excel_order',[DashboardController::class,'excelOrder'])->name('excelOrder');
    });

});
