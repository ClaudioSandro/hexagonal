<?php

namespace Src\CustomerManagement\Customer\Application;

use Src\CustomerManagement\Customer\Domain\Contract\CustomerContract;

class ListCustomersUseCase
{
    private CustomerContract $repository;

    public function __construct(CustomerContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $filters = [], int $perPage = 10, string $order = 'asc'): array
    {
        return $this->repository->list($filters, $perPage, $order);
    }
}
