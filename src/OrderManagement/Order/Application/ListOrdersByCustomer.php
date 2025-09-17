<?php

namespace Src\OrderManagement\Order\Application;

use Src\OrderManagement\Order\Domain\Contract\OrderContract;

class ListOrdersByCustomer
{
    private OrderContract $repository;

    public function __construct(OrderContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $customerId): array
    {
        return $this->repository->listByCustomer($customerId);
    }
}
