<?php

namespace Src\IdentityAndAccess\User\Domain\ValueObjects;

use InvalidArgumentException;

class Password
{
    private string $hashed;

    public function __construct(string $plainPassword, bool $alreadyHashed = false)
    {
        if (! $alreadyHashed) {
            if (strlen($plainPassword) < 6) {
                throw new InvalidArgumentException("La contraseña debe tener al menos 6 caracteres.");
            }
            $this->hashed = bcrypt($plainPassword);
        } else {
            $this->hashed = $plainPassword;
        }
    }

    public function value(): string
    {
        return $this->hashed;
    }
}
