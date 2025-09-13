<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Controllers;

use Illuminate\Http\Request;
use Src\IdentityAndAccess\User\Application\RegisterUseCase;
use Src\IdentityAndAccess\User\Application\LoginUseCase;

class AuthController
{
    public function __construct(
        private RegisterUseCase $registerUseCase,
        private LoginUseCase $loginUseCase
    ) {}

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = $this->registerUseCase->execute($data);

        return response()->json(['message' => 'Usuario registrado con éxito'], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $token = $this->loginUseCase->execute($data);

        return response()->json(['token' => $token]);
    }
}
