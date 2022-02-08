<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\DestroyRestoreRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Services\ProductService;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Manage Categories')
            ->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::with([
            'stock',
            'categories'
        ])
            ->withAvg('rating', 'value')
            ->withCount('rating', 'user_id')
            ->get();

        return $this->success("OK", $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\StoreRequest  $request
     * @param  \App\Services\ProductService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request, ProductService $service)
    {
        $result = $service->storeProduct(
            $request->image_url,
            $request->title,
            $request->description,
            $request->price,
            $request->in_stock,
            $request->category_ids
        );

        return !($result instanceof Product) 
            ? $this->error($result)
            : $this->success("Product created successfully.", $result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        $product = Product::with([
            'stock',
            'categories'
        ])
            ->find($product->id);

        return $this->success("OK", $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Product\UpdateRequest  $request
     * @param  \App\Models\Product  $product
     * @param  \App\Services\ProductService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Product $product, ProductService  $service)
    {
        $result = $service->updateProduct(
            $product,
            $request->image_url,
            $request->title,
            $request->description,
            $request->price,
            $request->in_stock,
            $request->category_ids
        );

        return (gettype($result) === "string")
            ? $this->error($result)
            : $this->success("Product updated successfully.");
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param  \App\Http\Requests\Product\DestroyRestoreRequest  $request
     * @param  \App\Services\ProductService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRestoreRequest $request, ProductService $service)
    {
        $result = $service->destroyProducts(
            $request->product_ids,
        );

        return (gettype($result) === "string")
            ? $this->error($result)
            : $this->success("Product(s) deleted successfully.");
    }

     /**
     * Restore the specified resources from storage.
     *
     * @param  \App\Http\Requests\Product\DestroyRestoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(DestroyRestoreRequest $request) 
    {
        Product::onlyTrashed()
            ->whereIn('id', $request->product_ids)
            ->restore();
            
        return $this->success("Product\s restored successfully.");
    }
}
