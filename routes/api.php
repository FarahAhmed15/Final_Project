<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::controller(ApiProductController::class)->group(function () {
//     Route::get('products', 'index')->name('all.products');
//     Route::get('products/{id}', 'show')->name('show.product');
    
    
//     Route::middleware('api_auth')->group(function () {
//         Route::post('products', 'store')->name('store.products');
//         Route::put('products/{id}', 'update')->name('update.products');
//         Route::delete('products/{id}', 'delete')->name('delete.products');
//     });
// });

Route::controller(ApiAuthController::class)->group(function () {
    Route::post('apiregister', 'register')->name('apiregister');
    Route::post('apilogin', 'login')->name('apilogin');
    Route::post('apilogout', 'logout')->name('apilogout');
});
