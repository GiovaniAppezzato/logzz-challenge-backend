<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from a external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUrl = 'https://fakestoreapi.com/products';
        $optionIds = $this->option('id');

        if($optionIds) {
            foreach ($optionIds as $id) {
                ProductService::importProductsFromExternalApi($baseUrl . '/' . $id);
            }
        } else {
            ProductService::importProductsFromExternalApi($baseUrl);
        }

        $this->info('Product(s) added to the queue for processing');
    }
}
