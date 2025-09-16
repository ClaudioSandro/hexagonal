<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\IdentityAndAccess\User\Infrastructure\Repositories\EloquentUserRepository;
use Src\IdentityAndAccess\User\Application\RegisterUseCase;
use Src\IdentityAndAccess\User\Application\LoginUseCase;
use Src\IdentityAndAccess\User\Infrastructure\Validators\RegisterValidator;
use Src\IdentityAndAccess\User\Infrastructure\Validators\LoginValidator;

final class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = new RegisterValidator();
            $data = $validator->validate($request);

            $repository = new EloquentUserRepository();
            $useCase = new RegisterUseCase($repository);

            $user = $useCase($data);

            return response()->json([
                'message' => 'Usuario creado correctamente.',
                'data' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = new LoginValidator();
            $data = $validator->validate($request);

            $repository = new EloquentUserRepository();
            $useCase = new LoginUseCase($repository);

            $token = $useCase($data);

            return response()->json([
                'message' => 'Inicio de sesión exitoso.',
                'token' => $token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
