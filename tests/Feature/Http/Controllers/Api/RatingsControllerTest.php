<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatingsControllerTest extends TestCase
{
    /**
     * test
     */
    public function user_can_create_a_rating_with_specified_json_structure()
    {
        $product = Product::factory()
            ->has(Stock::factory())
            ->has(Category::factory())
            ->create();

        $user = User::factory()->create();

        $data = [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'value' => 3.5
        ];

        $response = $this->post('/api/ratings', $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'product' => [
                    'id',
                    'barcode',
                    'sku',
                    'image_url',
                    'title',
                    'description',
                    'price'
                ],
                'user' => [
                    'id',
                    'name',
                    'email'
                ]
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_update_a_rating_with_specified_json_structure()
    {
        $rating = Rating::factory()->create();
        $product = Product::factory()
            ->has(Stock::factory())
            ->has(Category::factory())
            ->create();

        $user = User::factory()->create();

        $data = [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'value' => 4.0
        ];

        $response = $this->put("/api/ratings/{$rating->id}", $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}
