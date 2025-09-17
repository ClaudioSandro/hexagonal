<?php

namespace Src\OrderManagement\Order\Domain\Entities;

class Order
{
    private ?int $id;
    private int $customerId;
    private array $items; 
    private float $total;

    public function __construct(?int $id, int $customerId, array $items, float $total)
    {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
        $this->total = $total;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function customerId(): int
    {
        return $this->customerId;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function total(): float
    {
        return $this->total;
    }
}
