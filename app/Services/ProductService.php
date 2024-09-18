<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\ProductRepository;
use App\Jobs\StoreProductJob;
use App\Models\Product;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function getProducts(?string $term): LengthAwarePaginator
    {
        return $this->productRepository->getProductsWithPagination($term);
    }

    public function getProduct(int $id): Product
    {
        return $this->productRepository->getProduct($id);
    }

    public function create(array $data): Product
    {
        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->productRepository->update($product, $data);
    }

    public function delete(Product $product): void
    {
        $this->productRepository->delete($product);
    }

    public static function importProductsFromExternalApi(string $url): void
    {
        try {
            $response = Http::get($url);

            foreach ($response->json() as $product) {
                StoreProductJob::dispatch($product);
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to import products from the external API.');
        }
    }
}
