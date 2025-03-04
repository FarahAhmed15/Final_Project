<?php

use Illuminate\Support\Facades\Route;
use App\HTTP\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\ProductController as UserProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
Route::get('home',[HomeController::class,'home']);

Route::controller(ProductController::class)->group(function(){
    Route::middleware('auth')->group(function(){
        Route::get('products','index')->name('all.products');
        Route::get('products/create','create')->name('create.products');
        Route::post('products','store')->name('store.products');
        Route::get('editProduct/{id}','edit')->name('edit.products');
        Route::put('products/{id}','update')->name('update.products');
        Route::delete('deleteProduct/{id}','delete')->name('delete.products');
        });
    });
});

Route::controller( UserProductController::class)->group(function () {
    Route::get('products','index')->name('user.all.products');
    Route::get('products/show/{id}','show')->name('user.show.product');
    Route::post('addtowishlist/{id}','addtowishlist')->name('user.addtowishlist');
    Route::get('mywishlist','mywishlist')->name('user.wishlist');
    
    Route::middleware('auth')->group(function(){
        Route::post('addtofav/{id}','addtofav')->name('user.addtofav');
        Route::post('addtocart/{id}','addtocart')->name('user.addtocart');
        Route::get('mycart','mycart')->name('user.cart');
        Route::post('makeorder','makeorder')->name('user.makeorder');
    });
});