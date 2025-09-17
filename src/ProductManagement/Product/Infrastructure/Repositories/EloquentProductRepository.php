<?php

namespace Src\ProductManagement\Product\Infrastructure\Repositories;

use App\Models\Product as EloquentProduct;
use Src\ProductManagement\Product\Domain\Contract\ProductContract;
use Src\ProductManagement\Product\Domain\Entities\Product;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductName;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductPrice;
use Src\ProductManagement\Product\Domain\ValueObjects\ProductCategory;

class EloquentProductRepository implements ProductContract
{
    public function create(Product $product): Product
    {
        $eloquent = EloquentProduct::create([
            'name' => $product->name()->value(),
            'price' => $product->price()->value(),
            'category' => $product->category()->value(),
        ]);

        return new Product(
            $eloquent->id,
            new ProductName($eloquent->name),
            new ProductPrice($eloquent->price),
            new ProductCategory($eloquent->category)
        );
    }

    public function list(array $filters, int $perPage, string $order): array
    {
        $query = EloquentProduct::query();

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        $query->orderBy('price', $order);

        $eloquents = $query->paginate($perPage);

        return $eloquents->items();
    }

    public function findById(int $id): ?Product
    {
        $eloquent = EloquentProduct::find($id);

        if (!$eloquent) return null;

        return new Product(
            $eloquent->id,
            new ProductName($eloquent->name),
            new ProductPrice($eloquent->price),
            new ProductCategory($eloquent->category)
        );
    }

    public function update(Product $product): Product
    {
        $eloquent = EloquentProduct::findOrFail($product->id());

        $eloquent->update([
            'name' => $product->name()->value(),
            'price' => $product->price()->value(),
            'category' => $product->category()->value(),
        ]);

        return new Product(
            $eloquent->id,
            new ProductName($eloquent->name),
            new ProductPrice($eloquent->price),
            new ProductCategory($eloquent->category)
        );
    }

    public function delete(int $id): void
    {
        EloquentProduct::destroy($id);
    }
}
