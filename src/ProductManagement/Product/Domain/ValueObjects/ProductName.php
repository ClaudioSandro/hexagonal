<?php

namespace Src\ProductManagement\Product\Domain\ValueObjects;

use InvalidArgumentException;

class ProductName
{
    private string $value;

    public function __construct(string $value)
    {
        if (strlen($value) < 3) {
            throw new InvalidArgumentException("El nombre del producto debe tener al menos 3 caracteres.");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
