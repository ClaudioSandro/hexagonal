<?php

use Illuminate\Support\Facades\Route;
use Src\CustomerManagement\Customer\Infrastructure\Controllers\CustomerController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
});

