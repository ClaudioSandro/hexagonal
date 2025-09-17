<?php

namespace Src\ProductManagement\Product\Domain\Contract;

use Src\ProductManagement\Product\Domain\Entities\Product;

interface ProductContract
{
    public function create(Product $product): Product;

    public function list(array $filters, int $perPage, string $order): array;

    public function findById(int $id): ?Product;

    public function update(Product $product): Product;

    public function delete(int $id): void;
}
