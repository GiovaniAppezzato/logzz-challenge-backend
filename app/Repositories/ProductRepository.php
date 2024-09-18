<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;

class ProductRepository
{
    public function getProductsWithPagination(?string $term): LengthAwarePaginator
    {
        return Product::query()
            ->when($term, function ($query, $term) {
                $query->where('name', 'like', "%$term%")
                    ->orWhere('category', 'like', "%$term%");
            })
            ->paginate();
    }

    public function getProductsWithoutPagination(?string $term): Collection
    {
        return Product::query()
            ->when($term, function ($query, $term) {
                $query->where('name', 'like', "%$term%")
                    ->orWhere('category', 'like', "%$term%");
            })
            ->get();
    }

    public function getProduct(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
