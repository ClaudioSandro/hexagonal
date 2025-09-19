<?php

namespace Src\OrderManagement\Order\Infrastructure\Repositories;

use App\Models\Order as EloquentOrder;
use App\Models\OrderItem as EloquentOrderItem;
use Src\OrderManagement\Order\Domain\Contract\OrderContract;
use Src\OrderManagement\Order\Domain\Entities\Order;
use Src\OrderManagement\Order\Domain\Entities\OrderItem;
use Src\OrderManagement\Order\Domain\ValueObjects\OrderItemQuantity;
use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;

class EloquentOrderRepository implements OrderContract
{
    public function create(Order $order): Order
    {
        $eloquentOrder = EloquentOrder::create([
            'customer_id' => $order->customerId(),
            'total' => $order->total(),
            'status' => $order->status()->value(),
        ]);

        foreach ($order->items() as $item) {
            EloquentOrderItem::create([
                'order_id' => $eloquentOrder->id,
                'product_id' => $item->product()->id(),
                'quantity' => $item->quantity()->value(),
                'price' => $item->product()->price()->value(),
            ]);
        }

        return $order;
    }

    public function listByCustomer(int $customerId): array
    {
        $orders = EloquentOrder::with('items.product')
            ->where('customer_id', $customerId)
            ->get();

        return array_map(function ($order) {
            return [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'total' => $order->total,
                'status' => $order->status,
                'items' => $order->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'product' => $item->product ? [
                            'id' => $item->product->id,
                            'name' => $item->product->name,
                            'price' => $item->product->price,
                            'category' => $item->product->category
                        ] : null
                    ];
                })->toArray()
            ];
        }, $orders->all());
    }

    public function calculateTotalSpentByCustomer(int $customerId): float
    {
        $orders = EloquentOrder::where('customer_id', $customerId)->with('items')->get();

        $total = 0;
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $total += $item->price * $item->quantity;
            }
        }

        return $total;
    }

    public function findByCustomerId(int $customerId): array
    {
        $orders = EloquentOrder::with('items.product')
            ->where('customer_id', $customerId)
            ->get();

        return $orders->toArray();
    }
}
