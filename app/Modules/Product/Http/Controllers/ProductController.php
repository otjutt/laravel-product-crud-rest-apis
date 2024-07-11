<?php

namespace App\Modules\Product\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Modules\Base\Traits\ApiRequest;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Service\ProductService;
use App\Modules\Product\Http\Requests\ProductCreateRequest;
use App\Modules\Product\Http\Requests\ProductUpdateRequest;
use App\Modules\Product\Http\Resources\ProductCollection;
use App\Modules\Product\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use ApiRequest;

    public function index(
        Request $request,
        ProductService $productService,
    ): ResourceCollection {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $data = Product::paginate($perPage, ['*'], 'page', $page);

        return new ProductCollection($data);
    }

    public function create(
        ProductCreateRequest $request,
        ProductService $productService,
    ): JsonResponse {
        $attributes = $this->getResourceAttributes($request);

        $product = new Product();
        $productService->handleAttributes($product, $attributes);
        $product->save();

        return response()->json([
            'data' => new ProductResource($product),
        ], 201);
    }

    public function read(
        $id
    ): JsonResponse {
        // Check if product exists.
        $product = Product::find($id);
        if ($product === null) {
            throw new AppException("Error! Product not found.", 404);
        }

        return response()->json([
            'data' => new ProductResource($product),
        ], 200);
    }

    public function update(
        $id,
        ProductUpdateRequest $request,
        ProductService $productService,
    ): JsonResponse {
        // Check if product exists.
        $product = Product::find($id);
        if ($product === null) {
            throw new AppException("Error! Product not found.", 404);
        }

        $attributes = $this->getResourceAttributes($request);
        $productService->handleAttributes($product, $attributes);
        $product->save();

        return response()->json([
            'data' => new ProductResource($product),
        ], 202);
    }

    public function delete(
        $id
    ): Response {
        // Check if product exists.
        $product = Product::find($id);
        if ($product === null) {
            throw new AppException("Error! Product not found.", 404);
        }

        $product->delete();

        return response()->noContent();
    }
}
