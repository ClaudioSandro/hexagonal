<?php

namespace Src\OrderManagement\Order\Domain\ValueObjects;

use InvalidArgumentException;

class OrderItemQuantity
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser mayor a 0.");
        }

        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
