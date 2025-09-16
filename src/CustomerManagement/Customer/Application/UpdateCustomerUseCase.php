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
            throw new \Exception("Cliente con ID {$id} no encontrado.");
        }

        $customer->update(
            new CustomerName($data['name']),
            new CustomerEmail($data['email'])
        );

        return $this->repository->update($customer);
    }
}
