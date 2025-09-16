<?php

namespace Src\CustomerManagement\Customer\Domain\ValueObjects;

use InvalidArgumentException;

class CustomerEmail
{
    private string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido: {$value}");
        }
        $this->value = strtolower($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
