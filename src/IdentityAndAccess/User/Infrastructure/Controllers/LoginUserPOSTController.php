<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\IdentityAndAccess\User\Infrastructure\Repositories\EloquentUserRepository;
use Src\IdentityAndAccess\User\Application\LoginUseCase;
use Src\IdentityAndAccess\User\Infrastructure\Validators\LoginValidator;

final class LoginUserPOSTController extends Controller
{
    public function __invoke(Request $request)
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
