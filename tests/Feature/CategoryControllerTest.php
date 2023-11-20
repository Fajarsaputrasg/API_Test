<?php


namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_category()
    {
        $response = $this->postJson('/api/categories', ['name' => 'Test Category']);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'name', 'created_at']]);
    }

    /** @test */
    public function it_requires_name_for_category_creation()
    {
        $response = $this->postJson('/api/categories', []);

        $response->assertStatus(400)
            ->assertJsonValidationErrors(['name']);
    }
}
