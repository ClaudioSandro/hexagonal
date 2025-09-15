<?php

use Illuminate\Support\Facades\Route;
use Src\IdentityAndAccess\User\Infrastructure\Controllers\CreateUserPOSTController;
use Src\IdentityAndAccess\User\Infrastructure\Controllers\LoginUserPOSTController;

Route::post('/register', CreateUserPOSTController::class);
Route::post('/login', LoginUserPOSTController::class);
