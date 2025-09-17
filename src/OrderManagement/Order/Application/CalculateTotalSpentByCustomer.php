<?php

namespace Src\OrderManagement\Order\Application;

use Src\OrderManagement\Order\Domain\Contract\OrderContract;

class CalculateTotalSpentByCustomer
{
    private OrderContract $repository;

    public function __construct(OrderContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $customerId): float
    {
        return $this->repository->calculateTotalSpentByCustomer($customerId);
    }
}
