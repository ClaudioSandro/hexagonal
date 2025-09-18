<?php

namespace Src\CustomerManagement\Customer\Application;

use Src\CustomerManagement\Customer\Domain\Contract\CustomerContract;

class DeleteCustomerUseCase
{
    private CustomerContract $repository;

    public function __construct(CustomerContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $id)
    {
        $customer = $this->repository->findById($id);
        
        if (!$customer) {
            return response()->json([
                'message' => "Cliente con ID {$id} no encontrado.",
                'success' => false
            ], 404);
        }

        $this->repository->delete($id);
        
        return response()->json([
            'message' => 'Cliente eliminado correctamente',
            'success' => true
        ]);
    }
}
