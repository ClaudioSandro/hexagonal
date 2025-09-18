<?php

namespace Src\ProductManagement\Product\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\ProductManagement\Product\Application\CreateProductUseCase;
use Src\ProductManagement\Product\Application\ListProductsUseCase;
use Src\ProductManagement\Product\Application\UpdateProductUseCase;
use Src\ProductManagement\Product\Application\DeleteProductUseCase;
use Src\ProductManagement\Product\Infrastructure\Repositories\EloquentProductRepository;
use Src\ProductManagement\Product\Infrastructure\Validators\CreateProductRequest;
use Src\ProductManagement\Product\Infrastructure\Validators\UpdateProductRequest;

class ProductController extends Controller
{
    private EloquentProductRepository $repository;

    public function __construct()
    {
        $this->repository = new EloquentProductRepository();
    }

    public function create(CreateProductRequest $request)
    {
        try {
            $useCase = new CreateProductUseCase($this->repository);
            $product = $useCase($request->validated());

            return response()->json([
                'message' => 'Producto creado correctamente',
                'data' => $product,
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function list(Request $request)
    {
        $useCase = new ListProductsUseCase($this->repository);

        $filters = ['category' => $request->query('category')];
        $products = $useCase($filters, $request->query('per_page', 10), $request->query('order', 'asc'));

        $cleaned = collect($products['data'] ?? $products)->map(function ($product) {
            unset($product['created_at'], $product['updated_at']);
            return $product;
        });

         return response()->json([
            'message' => 'Lista de productos obtenida correctamente',
            'data' => $cleaned,
        ]);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $useCase = new UpdateProductUseCase($this->repository);
        $product = $useCase($id, $request->validated());

        return response()->json(['message' => 'Producto actualizado', 'data' => $product]);
    }

    public function delete(int $id)
    {
        $useCase = new DeleteProductUseCase($this->repository);
        $useCase($id);

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
