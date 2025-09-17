<?php

namespace Src\ProductManagement\Product\Application;

use Src\ProductManagement\Product\Domain\Contract\ProductContract;

class ListProductsUseCase
{
    private ProductContract $repository;

    public function __construct(ProductContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $filters, int $perPage, string $order): array
    {
        return $this->repository->list($filters, $perPage, $order);
    }
}
