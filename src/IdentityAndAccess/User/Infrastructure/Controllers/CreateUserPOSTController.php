<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\IdentityAndAccess\User\Application\RegisterUseCase;
use Src\IdentityAndAccess\User\Infrastructure\Repositories\EloquentUserRepository;
use Src\IdentityAndAccess\User\Infrastructure\Validators\RegisterValidator;
use Illuminate\Validation\ValidationException;

final class CreateUserPOSTController extends Controller
{
    public function __invoke(Request $request)
    {
        try{
            $validator = new RegisterValidator();
            $data = $validator->validate($request);

            $repository = new EloquentUserRepository();

            $useCase = new RegisterUseCase($repository);

            $user = $useCase($data);

            return response()->json(['Se creo el usuario correctamente'], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Datos inválidos.',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
