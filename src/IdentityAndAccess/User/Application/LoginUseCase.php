<?php

namespace Src\IdentityAndAccess\User\Application;

use Src\IdentityAndAccess\User\Domain\Contract\UserContract;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User as EloquentUser;

class LoginUseCase
{
    private UserContract $repository;

    public function __construct(UserContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $credentials): string
    {
        $user = $this->repository->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password()->value())) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales inválidas.'],
            ]);
        }

        $eloquent = EloquentUser::where('email', $credentials['email'])->first();

        return $eloquent->createToken('api-token')->plainTextToken;
    }
}
