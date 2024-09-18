<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Http\Requests\Api\{GetProductsRequest,StoreProductRequest,UpdateProductRequest};

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(GetProductsRequest $request)
    {
        return ProductResource::collection(
            $this->productService->getProducts($request->input('term', null))
        );
    }

    public function store(StoreProductRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            return new ProductResource($this->productService->create($validated), 201);
        });
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        return DB::transaction(function () use ($request, $product) {
            $validated = $request->validated();

            return new ProductResource($this->productService->update($product, $validated));
        });
    }

    public function destroy(Product $product)
    {
        return DB::transaction(function () use ($product) {
            $this->productService->delete($product);

            return response()->noContent();
        });
    }
}
