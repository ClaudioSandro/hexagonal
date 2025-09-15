<?php

namespace Src\IdentityAndAccess\User\Domain\Entities;

use Src\IdentityAndAccess\User\Domain\ValueObjects\Email;
use Src\IdentityAndAccess\User\Domain\ValueObjects\Password;

class User
{
    private string $name;
    private Email $email;
    private Password $password;

    public function __construct(string $name, Email $email, Password $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): Password
    {
        return $this->password;
    }
}
