<?php

namespace Src\CustomerManagement\Customer\Domain\ValueObjects;

use InvalidArgumentException;

class UserId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("UserId inválido: {$value}");
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
