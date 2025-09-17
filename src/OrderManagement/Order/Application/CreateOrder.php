<?php

namespace Src\OrderManagement\Order\Application;

use Src\OrderManagement\Order\Domain\Contract\OrderContract;
use Src\OrderManagement\Order\Domain\Entities\Order;
use Src\OrderManagement\Order\Domain\Entities\OrderItem;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemQuantity;
use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;
use App\Models\Product as EloquentProduct;

class CreateOrder
{
    private OrderContract $repository;

    public function __construct(OrderContract $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(int $customerId, array $items): Order
    {
        $orderItems = [];
        $total = 0;

        foreach ($items as $item) {
            $eloquentProduct = EloquentProduct::findOrFail($item['product_id']);

            $product = new Product(
                $eloquentProduct->id,
                new ProductName($eloquentProduct->name),
                new ProductPrice($eloquentProduct->price),
                new ProductCategory($eloquentProduct->category)
            );

            $quantity = new OrderItemQuantity($item['quantity']);
            $orderItems[] = new OrderItem($product, $quantity);

            $total += $eloquentProduct->price * $item['quantity'];
        }

        $order = new Order(null, $customerId, $orderItems, $total);

        return $this->repository->create($order);
    }

}
