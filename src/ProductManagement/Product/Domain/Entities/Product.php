<?php

namespace Src\ProductManagement\Product\Domain\Entities;

use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;

class Product
{
    private ?int $id;
    private ProductName $name;
    private ProductPrice $price;
    private ProductCategory $category;

    public function __construct(
        ?int $id,
        ProductName $name,
        ProductPrice $price,
        ProductCategory $category
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function category(): ProductCategory
    {
        return $this->category;
    }
}
