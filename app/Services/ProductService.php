<?php

namespace App\Services;

use Illuminate\Support\Collection;
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

    public function getProducts(?string $term): LengthAwarePaginator|Collection
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
        $response = Http::get($url);

        if($response->successful()) {
            $json = $response->json();

            // Check if the response is a single product or multiple products
            if (isset($json['id'])) {
                StoreProductJob::dispatch($json);
            } else {
                foreach ($json as $product) {
                    StoreProductJob::dispatch($product);
                }
            }
        }
    }
}
