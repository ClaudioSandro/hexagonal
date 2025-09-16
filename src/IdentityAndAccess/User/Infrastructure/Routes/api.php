<?php

use Illuminate\Support\Facades\Route;
use Src\IdentityAndAccess\User\Infrastructure\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
