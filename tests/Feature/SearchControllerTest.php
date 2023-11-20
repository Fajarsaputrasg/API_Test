<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_search_products_by_sku()
    {
        // Create products
        $products = Product::factory()->count(3)->create();

        $response = $this->getJson('/api/search?sku=' . $products->pluck('sku')->implode('&sku='));

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]]);
    }

    /** @test */
    public function it_can_search_products_by_name()
    {
        // Create products
        Product::factory()->create(['name' => 'Laptop']);
        Product::factory()->create(['name' => 'Phone']);
        Product::factory()->create(['name' => 'Tablet']);

        $response = $this->getJson('/api/search?name=Lap&name=Pho');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]]);
    }

    /** @test */
    public function it_can_search_products_by_price_range()
    {
        // Create products
        Product::factory()->create(['price' => 200]);
        Product::factory()->create(['price' => 500]);
        Product::factory()->create(['price' => 1000]);

        $response = $this->getJson('/api/search?price.start=300&price.end=800');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]]);
    }

   // tests/Feature/SearchControllerTest.php

/** @test */
public function it_can_search_products_by_stock_range()
{
    // Create products
    Product::factory()->create(['stock' => 50]);
    Product::factory()->create(['stock' => 100]);
    Product::factory()->create(['stock' => 200]);

    $response = $this->getJson('/api/search?stock.start=75&stock.end=150');

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]]);
}

/** @test */
public function it_can_search_products_by_category_id()
{
    // Create products with categories
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();
    $category3 = Category::factory()->create();

    Product::factory()->create(['category_id' => $category1->id]);
    Product::factory()->create(['category_id' => $category2->id]);
    Product::factory()->create(['category_id' => $category3->id]);

    $response = $this->getJson('/api/search?category.id=' . $category1->id . '&category.id=' . $category2->id);

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]]);
}

/** @test */
public function it_can_search_products_by_category_name()
{
    // Create products with categories
    Category::factory()->create(['name' => 'Electronics']);
    Category::factory()->create(['name' => 'Clothing']);
    Category::factory()->create(['name' => 'Books']);

    Product::factory()->create(['category_id' => 1]); // Assuming Electronics category has ID 1
    Product::factory()->create(['category_id' => 2]); // Assuming Clothing category has ID 2
    Product::factory()->create(['category_id' => 3]); // Assuming Books category has ID 3

    $response = $this->getJson('/api/search?category.name=Electronics&category.name=Clothing');

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]]);
}

}
