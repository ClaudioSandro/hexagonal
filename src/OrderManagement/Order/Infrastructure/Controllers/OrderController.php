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
        $order = $useCase($request->get('customer_id'), $request->get('items'));

        return response()->json(['message' => 'Orden creada correctamente', 'data' => $order], 201);
    }

    public function listByCustomer(int $customerId)
    {
        $useCase = new ListOrdersByCustomer($this->repository);
        $orders = $useCase($customerId);

        return response()->json($orders);
    }

    public function calculateTotal(int $customerId)
    {
        $useCase = new CalculateTotalSpentByCustomer($this->repository);
        $total = $useCase($customerId);

        return response()->json(['customer_id' => $customerId, 'total_spent' => $total]);
    }
}
