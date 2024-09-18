<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ProductService;
use App\Models\Product;
use Illuminate\Console\Command;

class StoreProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected array $product
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ProductService $productService)
    {
        // Check if the product already exists (Name is unique!)
        if (Product::whereName($this->product['title'])->exists()) {
            return Command::SUCCESS;
        }

        $productService->create([
            'name'        => $this->product['title'],
            'description' => data_get($this->product, 'description', 'No description'),
            'price'       => data_get($this->product, 'price', 0),
            'category'    => data_get($this->product, 'category', 'Uncategorized'),
            'image_url'   => data_get($this->product, 'image', null),
        ]);
    }
}
