<?php

namespace Src\IdentityAndAccess\User\Application;

use Src\IdentityAndAccess\User\Domain\Entities\User;
use Src\IdentityAndAccess\User\Domain\Contract\UserContract;
use Src\IdentityAndAccess\User\Domain\ValueObjects\Email;
use Src\IdentityAndAccess\User\Domain\ValueObjects\Password;

class RegisterUseCase
{
    private UserContract $repository;

    public function __construct(UserContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $data): User
    {
        $user = new User(
            $data['name'],
            new Email($data['email']),
            new Password($data['password'])
        );

        return $this->repository->create($user);
    }
}
