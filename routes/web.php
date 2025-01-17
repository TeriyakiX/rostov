<?php

use App\Http\Controllers\Admin\EntityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::name('index.')->group(function () {

    require_routes('Index/*');
});

Route::prefix('admin')->middleware('role:admin|manager')->name('admin.')->group(function () {
    require_routes('Admin/*');
});
//Route::prefix('manager')->middleware('role:manager')->name('manager.')->group(function () {
//    require_routes('Manager/*');
//});

Route::prefix('client')->middleware('role:client')->name('client.')->group(function () {
    require_routes('Client/*');
});

Route::prefix('auth')->name('auth.')->group(function () {
    require_routes('Auth/*');
});

Route::get('category-tree-view', [CategoryController::class, 'manageCategory']);
Route::post('add-category', [CategoryController::class, 'addCategory']);

Route::get('/helper',function(){

   $Payment = new \App\Sms\SmsHelper();
    return $Payment->getConfig();
});

Route::get('/change-password', function() {

    dd(request()->all());
    \DB::table('users')->where('email', 'd_mk@aaanet.ru')->update([
        'password' => bcrypt('7zfvsXjq9e7AK8ju')]);
});


//$2y$10$/mwFuYnh//tRnI7BzGi3.u78Z7D56PYonAdnjHMToxkAIOok/9wTS


Route::get('/test-error/{code}', function ($code) {
    abort($code);
});


Route::post('/admin/{entity}/{id}/copy', [EntityController::class, 'copy']);

Route::get('/admin/orders/{id}/download-pdf', [OrderController::class, 'downloadPdf']);

// Маршрут для обновления количества товара в сессии
Route::post('/favorites/updateQuantity', [\App\Http\Controllers\Index\ProductController::class, 'updateQuantity']);

// Маршрут для загрузки данных о товарах из сессии
Route::get('/favorites/loadFavorites', [\App\Http\Controllers\Index\ProductController::class, 'loadFavorites']);
