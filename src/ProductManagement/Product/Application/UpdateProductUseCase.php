<?php

namespace Src\ProductManagement\Product\Application;

use Src\ProductManagement\Product\Domain\Contract\ProductContract;
use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;

class UpdateProductUseCase
{
    private ProductContract $repository;

    public function __construct(ProductContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $id, array $data): Product
    {
        $product = new Product(
            $id,
            new ProductName($data['name']),
            new ProductPrice($data['price']),
            new ProductCategory($data['category'])
        );

        return $this->repository->update($product);
    }
}
