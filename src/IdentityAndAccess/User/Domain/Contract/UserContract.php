<?php

namespace Src\IdentityAndAccess\User\Domain\Contract;

use Src\IdentityAndAccess\User\Domain\Entities\User;

interface UserContract
{
    public function create(User $user): User;
    public function findByEmail(string $email): ?User;
}
