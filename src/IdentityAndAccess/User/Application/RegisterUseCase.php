<?php

namespace Src\IdentityAndAccess\User\Application;

use Src\IdentityAndAccess\User\Domain\Entities\User;
use Src\IdentityAndAccess\User\Domain\Contract\UserContract;
use Illuminate\Support\Facades\Hash;

class RegisterUseCase
{
    public function __construct(private UserContract $repository) {}

    public function execute(array $data): User
    {
        $user = new User(
            $data['name'],
            $data['email'],
            Hash::make($data['password'])
        );

        return $this->repository->create($user);
    }
}
