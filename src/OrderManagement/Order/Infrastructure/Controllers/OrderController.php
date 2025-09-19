<?php

namespace Src\OrderManagement\Order\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\OrderManagement\Order\Application\CreateOrder;
use Src\OrderManagement\Order\Application\ListOrdersByCustomer;
use Src\OrderManagement\Order\Application\CalculateTotalSpentByCustomer;
use Src\OrderManagement\Order\Infrastructure\Repositories\EloquentOrderRepository;
use Src\OrderManagement\Order\Infrastructure\Validators\CreateOrderRequest;

class OrderController extends Controller
{
    private EloquentOrderRepository $repository;

    public function __construct()
    {
        $this->repository = new EloquentOrderRepository();
    }

    public function create(CreateOrderRequest $request)
    {
        $useCase = new CreateOrder($this->repository);
        $order = $useCase(
            $request->get('customer_id'), 
            $request->get('items'),
            $request->get('status', 'pending')  // Si no se proporciona, usa 'pending' como default
        );

        return response()->json(['message' => 'Orden creada correctamente', 'data' => $order], 201);
    }

    public function listByCustomer(int $customerId)
    {
        $useCase = new ListOrdersByCustomer($this->repository);
        $orders = $useCase($customerId);

        $cleaned = collect($orders['data'] ?? $orders)->map(function ($order) {
            $data = is_array($order) ? $order : $order->toArray();
            unset($data['created_at'], $data['updated_at']);
            
            if (isset($data['items'])) {
                $data['items'] = collect($data['items'])->map(function ($item) {
                    unset($item['created_at'], $item['updated_at']);
                    
                    if (isset($item['product'])) {
                        $product = $item['product'];
                        unset($product['created_at'], $product['updated_at']);
                        $item['product'] = $product;
                    }
                    
                    return $item;
                })->toArray();
            }
            
            return $data;
        });

        return response()->json([
            'message' => 'Lista de órdenes obtenida correctamente',
            'data' => $cleaned,
            'success' => true
        ]);
    }

    public function calculateTotal(int $customerId)
    {
        $useCase = new CalculateTotalSpentByCustomer($this->repository);
        $total = $useCase($customerId);

        return response()->json(['customer_id' => $customerId, 'total_spent' => $total]);
    }
}
