<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /// tests/Feature/ProductControllerTest.php

/** @test */
public function it_can_get_a_single_product()
{
    // Create a product
    $product = Product::factory()->create();

    $response = $this->getJson("/api/products/{$product->id}");

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => ['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]);
}

/** @test */
public function it_returns_404_for_nonexistent_product()
{
    $response = $this->getJson('/api/products/nonexistent-id');

    $response->assertStatus(404);
}

/** @test */
public function it_can_update_a_product()
{
    // Create a product
    $product = Product::factory()->create();

    $response = $this->putJson("/api/products/{$product->id}", [
        'sku' => 'UPDATED001',
        'name' => 'Updated Product',
        'price' => 75,
        'stock' => 20,
        'category_id' => $product->category_id,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => ['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]);
}

/** @test */
public function it_can_delete_a_product()
{
    // Create a product
    $product = Product::factory()->create();

    $response = $this->deleteJson("/api/products/{$product->id}");

    $response->assertStatus(204);

    // Ensure the product has been deleted from the database
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
}

/** @test */
public function it_can_list_all_products()
{
    // Create multiple products
    Product::factory()->count(3)->create();

    $response = $this->getJson('/api/products');

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'sku', 'name', 'price', 'stock', 'category', 'created_at']]]);
}
}