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

    public function __invoke(int $id): void
    {
        $this->repository->delete($id);
    }
}
