<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    /**
     * test
     */
    public function user_can_get_products_with_specified_json_structure()
    {
        Product::factory()
            ->has(Stock::factory())
            ->has(Category::factory())
            ->has(Rating::factory())
            ->count(2)
            ->create();

        $response = $this->get('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'barcode',
                    'sku',
                    'image_url',
                    'title',
                    'description',
                    'price',
                    'stock' => [
                        'id',
                        'product_id',
                        'in_stock',
                        'incoming_stock',
                        'stock_out',
                        'bad_stock',
                        'minimum_level'
                    ],
                    'categories' => [
                        [
                            'id',
                            'name',
                            'description',
                            'hex_code',
                            'category' => [
                                'product_id',
                                'category_id'
                            ]
                        ]
                    ],
                    'ratings_count',
                    'ratings_avg_value'
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
    public function user_can_get_product_with_specified_json_structure()
    {
        $product = Product::factory()
            ->has(Stock::factory())
            ->has(Category::factory())
            ->create();

        $response = $this->get('/api/products/' . $product->id);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'barcode',
                'sku',
                'image_url',
                'title',
                'description',
                'price',
                'stock' => [
                    'id',
                    'product_id',
                    'in_stock',
                    'incoming_stock',
                    'stock_out',
                    'bad_stock',
                    'minimum_level'
                ],
                'categories' => [
                    [
                        'id',
                        'name',
                        'description',
                        'hex_code',
                        'category' => [
                            'product_id',
                            'category_id'
                        ]
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
    public function user_can_create_product_with_specified_json_structure()
    {
        $categoriesIds = Category::factory()
            ->count(3)
            ->create()
            ->map 
            ->id
            ->toArray();

        $productTitle = 'product Ischsi';

        $image = UploadedFile::fake()->image($productTitle, 100, 100);

        $data = [
            'image_url' => $image->path(),
            'title' => $productTitle,
            'description' => 'The first cool product',
            'price' => 20.50,
            'in_stock' => 1,
            'category_ids' => $categoriesIds
        ];
        
        $response = $this->post('/api/products', $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'image_url',
                'title',
                'description',
                'price',
                'barcode',
                'sku',
                'id',
                'stock' => [
                    'id',
                    'product_id',
                    'in_stock',
                    'incoming_stock',
                    'stock_out',
                    'bad_stock',
                    'minimum_level'
                ],
                'categories' => [
                    [
                        'id',
                        'name',
                        'description',
                        'hex_code',
                        'category' => [
                            'product_id',
                            'category_id'
                        ]
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
    public function user_can_update_product_with_specified_json_structure()
    {
        $categoriesIds = Category::factory()
            ->count(3)
            ->create()
            ->map 
            ->id
            ->toArray();

        $product = Product::factory()
            ->has(Stock::factory())
            ->has(Category::factory())
            ->create();

        $productID = $product->id;  
        $productTitle = 'New Product ss';

        $image = UploadedFile::fake()->image($productTitle, 100, 100);

        $data = [
            'product_id' => $productID,
            'image_url' => $image->path(),
            'title' => $productTitle,
            'category_ids' => $categoriesIds
        ];
        
        $response = $this->put("/api/products/$productID", $data);

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
    public function user_can_delete_products_with_specified_json_structure()
    {
        $productOne = Product::factory()->has(Stock::factory())->create();
        $productTwo = Product::factory()->has(Stock::factory())->create();

        $data = [
           'product_ids' => [
                $productOne->id,
                $productTwo->id
           ]
        ];

        $response = $this->delete('/api/products', $data);

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
    public function user_can_restore_products_with_specified_json_structure()
    {
        $product = Product::factory()->has(Stock::factory())->create();

        $data = [
           'product_ids' => [
                $product->id
           ]
        ];

        $product->delete();

        $response = $this->put('/api/products/restore', $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}
