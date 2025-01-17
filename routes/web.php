<?php

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
    });
