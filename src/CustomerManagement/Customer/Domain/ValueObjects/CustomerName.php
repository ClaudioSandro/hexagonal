<?php

namespace Src\CustomerManagement\Customer\Domain\ValueObjects;

use InvalidArgumentException;

class CustomerName
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if (empty($value)) {
            throw new InvalidArgumentException("El nombre del cliente no puede estar vacío.");
        }
        if (strlen($value) > 255) {
            throw new InvalidArgumentException("El nombre del cliente no puede superar 255 caracteres.");
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
