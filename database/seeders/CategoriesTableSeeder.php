<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'sku' => 'PROD001',
            'name' => 'Smartphone',
            'price' => 5000000,
            'stock' => 50,
            'category_id' => 1, // Assuming Electronics category has ID 1
        ]);

        Product::create([
            'sku' => 'PROD002',
            'name' => 'T-shirt',
            'price' => 50000,
            'stock' => 100,
            'category_id' => 2, // Assuming Clothing category has ID 2
        ]);
        
        Product::create([
            'sku' => 'PROD003',
            'name' => 'Dress',
            'price' => 200000,
            'stock' => 100,
            'category_id' => 3, // Assuming Dress category has ID 3
        ]);

        // Add more products as needed
    }
}
