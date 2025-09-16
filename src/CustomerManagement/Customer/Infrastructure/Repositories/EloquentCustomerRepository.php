<?php

namespace Src\CustomerManagement\Customer\Infrastructure\Repositories;

use Src\CustomerManagement\Customer\Domain\Contract\CustomerContract;
use Src\CustomerManagement\Customer\Domain\Entities\Customer as DomainCustomer;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;
use Src\CustomerManagement\Customer\Domain\ValueObjects\UserId;
use App\Models\Customer as EloquentCustomer;

class EloquentCustomerRepository implements CustomerContract
{
    public function create(DomainCustomer $customer): DomainCustomer
    {
        $eloquent = EloquentCustomer::create([
            'name' => $customer->name()->value(),
            'email' => $customer->email()->value(),
            'user_id' => $customer->userId()->value(),
        ]);

        return new DomainCustomer(
            new CustomerName($eloquent->name),
            new CustomerEmail($eloquent->email),
            new UserId($eloquent->user_id),
            $eloquent->id
        );
    }

    public function list(array $filters = [], int $perPage = 10, string $order = 'asc'): array
    {
        $query = EloquentCustomer::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }

        $query->orderBy($filters['order_by'] ?? 'created_at', $filters['direction'] ?? $order);

        $results = $query->paginate($perPage);

        return $results->items(); 
    }

    public function findById(int $id): ?DomainCustomer
    {
        $eloquent = EloquentCustomer::find($id);

        if (!$eloquent) {
            return null;
        }

        return new DomainCustomer(
            new CustomerName($eloquent->name),
            new CustomerEmail($eloquent->email),
            new UserId($eloquent->user_id),
            $eloquent->id
        );
    }

    public function update(DomainCustomer $customer): DomainCustomer
    {
        $eloquent = EloquentCustomer::findOrFail($customer->id());

        $eloquent->update([
            'name' => $customer->name()->value(),
            'email' => $customer->email()->value(),
        ]);

        return new DomainCustomer(
            new CustomerName($eloquent->name),
            new CustomerEmail($eloquent->email),
            new UserId($eloquent->user_id),
            $eloquent->id
        );
    }

    public function delete(int $id): void
    {
        EloquentCustomer::destroy($id);
    }
}
