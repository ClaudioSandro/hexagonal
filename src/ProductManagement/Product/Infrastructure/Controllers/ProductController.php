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
        $useCase = new CreateProductUseCase($this->repository);
        $product = $useCase($request->validated());

        return response()->json(['message' => 'Producto creado correctamente', 'data' => $product], 201);
    }

    public function list(Request $request)
    {
        $useCase = new ListProductsUseCase($this->repository);

        $filters = ['category' => $request->query('category')];
        $products = $useCase($filters, $request->query('per_page', 10), $request->query('order', 'asc'));

        return response()->json($products);
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
