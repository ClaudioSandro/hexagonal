<?php

namespace Src\IdentityAndAccess\User\Application;

use Src\IdentityAndAccess\User\Domain\Contract\UserContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User as EloquentUser;

class LoginUseCase
{
    public function __construct(private UserContract $repository) {}

    public function execute(array $credentials): string
    {
        $user = $this->repository->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->passwordHash)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales no son correctas.'],
            ]);
        }

        $eloquent = EloquentUser::where('email', $credentials['email'])->first();

        return $eloquent->createToken('api-token')->plainTextToken;
    }
}
