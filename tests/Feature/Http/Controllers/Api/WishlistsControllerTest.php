<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishlistsControllerTest extends TestCase
{
    /**
     * test
     */
    public function user_can_get_wishlists_with_specified_json_structure()
    {
        Wishlist::factory()->count(5)->create();

        $response = $this->get('/api/wishlists');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'product_id',
                    'created_at',
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
    public function user_can_get_wishlist_with_specified_json_structure()
    {
        $user = User::factory()->create();
        $productID = Product::factory()->create()->id;

        $user->wishlists()->create([
            'product_id' => $productID
        ]);

        $response = $this->get("/api/wishlists/{$user->id}");

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'product_id',
                    'created_at'
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
    public function user_can_toggle_wishlists()
    {
        $userID = User::factory()->create()->id;
        $productID = Product::factory()->create()->id;

        $data = [
            'product_id' => $productID
        ];  

        $response = $this->post("/api/wishlists/{$userID}", $data);

        $response->assertSuccessful();
    }
}
