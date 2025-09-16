<?php

namespace Src\CustomerManagement\Customer\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\CustomerManagement\Customer\Application\CreateCustomerUseCase;
use Src\CustomerManagement\Customer\Application\ListCustomersUseCase;
use Src\CustomerManagement\Customer\Application\UpdateCustomerUseCase;
use Src\CustomerManagement\Customer\Application\DeleteCustomerUseCase;
use Src\CustomerManagement\Customer\Infrastructure\Validators\CreateCustomerRequest;
use Src\CustomerManagement\Customer\Infrastructure\Validators\UpdateCustomerRequest;
use Src\CustomerManagement\Customer\Infrastructure\Repositories\EloquentCustomerRepository;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    private EloquentCustomerRepository $repository;

    public function __construct()
    {
        $this->repository = new EloquentCustomerRepository();
    }

    public function index(Request $request)
    {
        $useCase = new ListCustomersUseCase($this->repository);

        $filters = [
            'name' => $request->query('name'),
        ];

        $customers = $useCase(
            $filters,
            $request->query('per_page', 10),
            $request->query('order', 'asc')
        );

        return response()->json($customers);
    }


    public function store(CreateCustomerRequest $request)
    {
        $useCase = new CreateCustomerUseCase($this->repository);

        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $customer = $useCase($data);

        return response()->json([
            'message' => 'Cliente creado correctamente',
            'data' => $customer
        ], 201);
    }


    public function update(UpdateCustomerRequest $request, int $id)
    {
        $useCase = new UpdateCustomerUseCase($this->repository);

        $customer = $useCase($id, $request->validated());

        return response()->json([
            'message' => 'Cliente actualizado correctamente',
            'data' => $customer
        ]);
    }

    public function destroy(int $id)
    {
        $useCase = new DeleteCustomerUseCase($this->repository);

        $useCase($id);

        return response()->json([
            'message' => 'Cliente eliminado correctamente'
        ]);
    }
}
