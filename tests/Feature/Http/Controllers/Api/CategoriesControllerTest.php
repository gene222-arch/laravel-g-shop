<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    /**
     * test
     */
    public function user_can_categories_with_specified_json_structure()
    {
        Category::factory()->create();
        Category::factory()->create();

        $response = $this->get('/api/categories');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'hex_code'
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
    public function user_can_create_a_category_with_specified_json_structure()
    {
        $data = [
            'name' => 'Happy',
            'description' => 'Happy takot',
            'hex_code' => '#FFFFFF'
        ];

        $response = $this->post('/api/categories', $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'hex_code'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_update_a_category_with_specified_json_structure()
    {
        $category = Category::factory()->create();

        $data = [
            'category_id' => $category->id,
            'name' => 'The Game'
        ];

        $response = $this->put("/api/categories/{$category->id}", $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_delete_categories_with_specified_json_structure()
    {
        $categoryOne = Category::factory()->create();
        $categoryTwo = Category::factory()->create();

        $data = [
            'category_ids' => [
                $categoryOne->id,
                $categoryTwo->id
            ]
        ];

        $response = $this->delete("/api/categories", $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_restore_categories_with_specified_json_structure()
    {
        $categoryOne = Category::factory()->create();

        $data = [
            'category_ids' => [
                $categoryOne->id,
            ]
        ];

        $categoryOne->delete();

        $response = $this->put('/api/categories/restore', $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}
