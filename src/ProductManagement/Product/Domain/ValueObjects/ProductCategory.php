<?php

namespace Src\ProductManagement\Product\Domain\ValueObjects;

use InvalidArgumentException;

class ProductCategory
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException("La categoría es obligatoria.");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
