<?php

namespace Src\ProductManagement\Product\Application;

use Src\ProductManagement\Product\Domain\Contract\ProductContract;

class GenerateQrUseCase
{
    private ProductContract $repository;

    public function __construct(ProductContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $productId): string
    {
        $product = $this->repository->findById($productId);
        if (!$product) {
            throw new \Exception("Producto no encontrado.");
        }

        $targetUrl = url("/api/products/{$productId}");

        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($targetUrl);

        return $qrUrl;
    }
}
