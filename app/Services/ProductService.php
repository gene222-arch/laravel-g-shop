<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function storeProduct(
        string $imageUrl, 
        string $title, 
        string $description, 
        float $price, 
        ?int $inStock,
        array $categories
    ): Product|string
    {
        try {
            $result = DB::transaction(function () use ($imageUrl, $title, $description, $price, $inStock, $categories): Product 
            {
                $product = Product::create([
                    'image_url' => $imageUrl,
                    'title' => $title,
                    'description' => $description,
                    'price' => $price
                ]);

                $product->categories()->attach($categories);

                if ($product && $inStock) 
                {
                    $product->stock()->create([
                        'in_stock' => $inStock
                    ]);
                }

                return Product::with(['stock', 'categories'])->find($product->id);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $result;
    }

    public function updateProduct(
        Product $product, 
        ?string $imageUrl, 
        ?string $title, 
        ?string $description, 
        ?float $price, 
        ?int $inStock,
        ?array $categories
    ): bool|string
    {
        try {
            $result = DB::transaction(function () use ($product, $imageUrl, $title, $description, $price, $inStock, $categories): bool
            {
                if ($inStock) 
                {
                    $product->stock()->update([
                        'in_stock' => $inStock
                    ]);
                }

                $isUpdated = $product->update([
                    'image_url' => $imageUrl ?? $product->image_url,
                    'title' => $title ?? $product->title,
                    'description' => $description ?? $product->description,
                    'price' => $price ?? $product->price
                ]);

                $product->categories()->sync($categories);

                return $isUpdated;
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $result;
    }

    public function destroyProducts(array $productIDs): bool|string
    {   
        try {
            $result = DB::transaction(function () use ($productIDs): bool
            {
                $productBuilder = Product::whereIn('id', $productIDs);

                if ($productBuilder->count()) 
                {
                    $productBuilder
                        ->get()
                        ->map
                        ->stock()
                        ->map
                        ->delete();

                    return $productBuilder->delete();
                }

                return false;
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $result;
    }
}