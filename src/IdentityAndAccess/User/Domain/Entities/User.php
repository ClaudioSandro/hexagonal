<?php

namespace Src\IdentityAndAccess\User\Domain\Entities;

class User
{
    public function __construct(
        public string $name,
        public string $email,
        public string $passwordHash
    ) {}
}
