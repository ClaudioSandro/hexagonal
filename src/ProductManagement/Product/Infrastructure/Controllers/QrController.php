<?php

namespace Src\ProductManagement\Product\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Src\ProductManagement\Product\Application\GenerateQrUseCase;
use Src\ProductManagement\Product\Infrastructure\Repositories\EloquentProductRepository;

class QrController extends Controller
{
    private EloquentProductRepository $repository;

    public function __construct()
    {
        $this->repository = new EloquentProductRepository();
    }

    public function generate(int $id)
    {
        $useCase = new GenerateQrUseCase($this->repository);
        try {
            $qrUrl = $useCase($id);
            return response()->json([
                'message' => 'QR generado correctamente',
                'qr_url' => $qrUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
