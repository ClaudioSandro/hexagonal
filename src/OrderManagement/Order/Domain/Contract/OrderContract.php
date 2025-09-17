<?php

namespace Src\OrderManagement\Order\Domain\Contract;

use Src\OrderManagement\Order\Domain\Entities\Order;

interface OrderContract
{
    public function create(Order $order): Order;

    public function listByCustomer(int $customerId): array;

    public function calculateTotalSpentByCustomer(int $customerId): float;
}
