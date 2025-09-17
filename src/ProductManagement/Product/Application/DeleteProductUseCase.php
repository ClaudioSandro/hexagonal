<?php

namespace Src\ProductManagement\Product\Application;

use Src\ProductManagement\Product\Domain\Contract\ProductContract;

class DeleteProductUseCase
{
    private ProductContract $repository;

    public function __construct(ProductContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $id): void
    {
        $this->repository->delete($id);
    }
}
