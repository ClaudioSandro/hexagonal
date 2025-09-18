<?php

use Illuminate\Support\Facades\Route;
use Src\ProductManagement\Product\Infrastructure\Controllers\ProductController;
use Src\ProductManagement\Product\Infrastructure\Controllers\QrController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'create']);
    Route::get('/products', [ProductController::class, 'list']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'delete']);

    Route::get('/products/{id}/qr', [QrController::class, 'generate']);
});
