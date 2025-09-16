<?php

namespace Src\CustomerManagement\Customer\Application;

use Src\CustomerManagement\Customer\Domain\Contract\CustomerContract;
use Src\CustomerManagement\Customer\Domain\Entities\Customer;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;
use Src\CustomerManagement\Customer\Domain\ValueObjects\UserId;

class CreateCustomerUseCase
{
    private CustomerContract $repository;

    public function __construct(CustomerContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $data): Customer
    {
        $customer = new Customer(
            new CustomerName($data['name']),
            new CustomerEmail($data['email']),
            new UserId($data['user_id'])
        );

        return $this->repository->create($customer);
    }
}
