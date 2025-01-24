<?php

use App\Modules\Cart\Http\Controller\CartController;
use App\Modules\Product\Http\Controllers\FilterProductsController;
use App\Modules\Product\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('products')
    ->name('product.')
    ->group(function (){
        Route::post('/add',[ProductController::class,'add'])->name('add');
        Route::put('/{id}/quantity',[ProductController::class,'changeQuantity'])->name('quantity.change');
        Route::put('/{id}/update',[ProductController::class,'update'])->name('update');

        //filter
        Route::get('/filter',[FilterProductsController::class,'filter'])->name('filter');
    });

Route::prefix('cart')
    ->name('cart.')
    ->group(function (){
        Route::post('/add/{id}',[CartController::class,'add'])
            ->name('add')
            ->whereNumber('id');
    });
