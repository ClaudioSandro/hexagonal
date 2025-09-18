<?php

namespace Src\CustomerManagement\Customer\Application;

use Src\CustomerManagement\Customer\Domain\Contract\CustomerContract;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;

class UpdateCustomerUseCase
{
    private CustomerContract $repository;

    public function __construct(CustomerContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $id, array $data)
    {
        $customer = $this->repository->findById($id);

        if (!$customer) {
            return response()->json([
                'message' => "Cliente con ID {$id} no encontrado.",
                'success' => false
            ], 404);
        }

        $customer->update(
            new CustomerName($data['name']),
            new CustomerEmail($data['email'])
        );

        $updatedCustomer = $this->repository->update($customer);
        
        if (!$updatedCustomer) {
            return response()->json([
                'message' => "No se pudo actualizar el cliente con ID {$id}.",
                'success' => false
            ], 404);
        }

        return $updatedCustomer;
    }


}
