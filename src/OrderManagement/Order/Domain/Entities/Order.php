<?php

namespace Src\OrderManagement\Order\Domain\Entities;

use Src\OrderManagement\Order\Domain\ValueObjects\OrderStatus;

class Order
{
    private ?int $id;
    private int $customerId;
    private array $items; 
    private float $total;
    private OrderStatus $status;

    public function __construct(
        ?int $id, 
        int $customerId, 
        array $items, 
        float $total, 
        ?OrderStatus $status = null
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
        $this->total = $total;
        $this->status = $status ?? new OrderStatus('pending');
    }

    public function status(): OrderStatus
    {
        return $this->status;
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
