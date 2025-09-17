<?php

namespace Src\OrderManagement\Order\Domain\Entities;

use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemQuantity;
use Src\ProductManagement\Product\Domain\Entities\Product;

class OrderItem
{
    private Product $product;
    private OrderItemQuantity $quantity;

    public function __construct(Product $product, OrderItemQuantity $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function quantity(): OrderItemQuantity
    {
        return $this->quantity;
    }
}
