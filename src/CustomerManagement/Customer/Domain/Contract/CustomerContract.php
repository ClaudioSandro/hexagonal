<?php

namespace Src\CustomerManagement\Customer\Domain\Contract;

use Src\CustomerManagement\Customer\Domain\Entities\Customer;

interface CustomerContract
{
    public function create(Customer $customer): Customer;

    public function list(array $filters = [], int $perPage = 10, string $order = 'asc'): array;

    public function findById(int $id): ?Customer;

    public function update(Customer $customer): ?Customer;

    public function delete(int $id): void;
}
