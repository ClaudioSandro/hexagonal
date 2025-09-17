<?php

use Illuminate\Support\Facades\Route;
use Src\OrderManagement\Order\Infrastructure\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'create']);
    Route::get('/orders/customer/{customerId}', [OrderController::class, 'listByCustomer']);
    Route::get('/orders/customer/{customerId}/total', [OrderController::class, 'calculateTotal']);
});
